<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penyewaan extends CI_Controller {

  public function __construct(){
    parent::__construct();
  }

  public function index(){
    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/sewa/penyewaan');
    $this->load->view('template/footer');
  }

  public function updateReturnDate() {
      $id_penyewaan = $this->input->post('id_penyewaan');
      $tgl_pengembalian = $this->input->post('tgl_pengembalian');

      $this->db->set('tgl_pengembalian', $tgl_pengembalian);
      $this->db->where('id_penyewaan', $id_penyewaan);
      $this->db->update('tb_penyewaan');

      $output = array("status" => "success", "message" => "Penyewaan Berhasil di Perpanjang.");
      echo json_encode($output);
  }

  public function getAllData(){
      
    $dataList['data'] = $this->db->query("SELECT A.id_penyewaan, DATE_FORMAT(A.tgl_pembelian, \"%d %b %Y <br> %H:%i\") tgl_pembelian, A.id_ketersediaan, B.tujuan, DATE_FORMAT(A.tgl_penyewaan, \"%d %b %Y <br> %H:%i\") tgl_penyewaan, DATE_FORMAT(A.tgl_pengembalian, \"%d %b %Y <br> %H:%i\") tgl_pengembalian, A.jumlah_sewa, A.jaminan
    FROM tb_penyewaan A
    INNER JOIN tb_ketersediaan B ON A.id_ketersediaan=B.id_ketersediaan
    INNER JOIN tb_mobil_sewa C ON B.id_mobil_sewa=C.id_mobil_sewa
    ORDER BY tgl_pembelian DESC")->result(); 
    
    echo json_encode($dataList);
  }

  public function getPenyewaanByID(){
    $data = $this->db->query("SELECT A.id_penyewaan, A.tgl_pembelian, A.id_ketersediaan, B.tujuan, 
    DATE(A.tgl_penyewaan) tgl_penyewaan,
    A.jumlah_sewa, A.jenis_penyewaan, C.kapasitas, D.id_jenis_mobil,
    A.id_pelanggan, A.nm_pelanggan, A.no_pelanggan
    FROM tb_penyewaan A
    INNER JOIN tb_ketersediaan B ON A.id_ketersediaan=B.id_ketersediaan
    INNER JOIN tb_mobil_sewa C ON B.id_mobil_sewa=C.id_mobil_sewa
    LEFT JOIN tb_jenis_mobil D ON C.id_jenis_mobil = D.id_jenis_mobil
    WHERE A.id_penyewaan = '".$this->input->post('id_penyewaan')."'
    ")->result(); 

  	echo json_encode($data);
  }

  public function getTujuan(){
    $data['data'] = $this->db->query("SELECT DISTINCT tujuan from tb_ketersediaan 
    WHERE DATE(tgl) = '".$this->input->post('tgl')."'")->result(); 

  	echo json_encode($data);
  }

  public function getJenisMobil(){
    $data['data'] = $this->db->query("
    select * from tb_jenis_mobil tjb where id_jenis_mobil in(
      select id_jenis_mobil from tb_mobil_sewa tb where id_mobil_sewa IN(
        select id_mobil_sewa from tb_ketersediaan where upper(tujuan) = upper('".$this->input->post('tujuan')."') AND DATE(tgl) = '".$this->input->post('tgl')."'
      )
    )
    ")->result(); 

  	echo json_encode($data);
  }

  public function getMobil(){
    $data['data'] = $this->db->query("
      select A.id_ketersediaan, B.kapasitas from tb_ketersediaan A
      inner join tb_mobil_sewa B on A.id_mobil_sewa = B.id_mobil_sewa 
      inner join tb_jenis_mobil C on B.id_jenis_mobil = C.id_jenis_mobil  
      where DATE(A.tgl) = '".$this->input->post('tgl')."'
      and C.id_jenis_mobil = '".$this->input->post('id_jenis_mobil')."'
      order by kapasitas
    ")->result(); 

  	echo json_encode($data);
  }

  public function getPelanggan(){
    $data['data'] = $this->db->query("SELECT id_pelanggan, no_pelanggan, nm_pelanggan from tb_pelanggan ORDER BY id_pelanggan")->result(); 

  	echo json_encode($data);
  }

  public function getNamaPelanggan(){
    $data['data'] = $this->db->query("
      SELECT nm_pelanggan, no_pelanggan FROM `tb_pelanggan`
      WHERE id_pelanggan = '".$this->input->post('id_pelanggan')."'
    ")->result(); 

  	echo json_encode($data);
  }

  public function getHarga() {
    $data['data'] = $this->db->query("SELECT harga, jumlah_mobil 
    FROM tb_ketersediaan 
    WHERE id_ketersediaan = '".$this->input->post('id_ketersediaan')."'")->result();

    echo json_encode($data);
  }

  public function generateId() {
    $unik = "PM".date('Ym'); // Membuat prefix dengan format SBYYYYMM
    $result = $this->db->query("SELECT MAX(id_penyewaan) AS LAST_NO FROM tb_penyewaan WHERE id_penyewaan LIKE '".$unik."%'")->row();

    // Mengambil nomor urut terakhir dari hasil query, jika ada
    if ($result && $result->LAST_NO) {
        $kode = $result->LAST_NO;
        // Mengambil angka urut terakhir dari hasil query
        $urutan = (int) substr($kode, 8, 5); // 8 adalah posisi mulai substring dari urutan
        $urutan++;
    } else {
        // Jika tidak ada hasil dari query, mulai dengan urutan 1
        $urutan = 1;
    }

    // Membentuk kode baru dengan format SBYYYYMMXXXXX
    $kode = $unik . sprintf("%05s", $urutan);
    return $kode;
}

  public function saveData(){
    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_ketersediaan', 'ID Ketersediaan', 'required');
    $this->form_validation->set_rules('id_pelanggan', 'Pelanggan', 'required');
    $this->form_validation->set_rules('nm_pelanggan', 'Nama Pelanggan', 'required');
    $this->form_validation->set_rules('no_pelanggan', 'No Pelanggan', 'required');
    $this->form_validation->set_rules('jumlah_sewa', 'Jumlah Sewa', 'required');

    if($this->form_validation->run() == FALSE){
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $id = $this->generateId();

    $TGL_BERANGKAT = $this->db->query("select tgl as TGL_BERANGKAT from tb_ketersediaan 
    where id_ketersediaan = '".$this->input->post('id_ketersediaan')."'")->row()->TGL_BERANGKAT;
    
    $data = array(
              "id_penyewaan" => $id,
              "id_ketersediaan" => $this->input->post('id_ketersediaan'),
              "id_pelanggan" => $this->input->post('id_pelanggan'),
              "nm_pelanggan" => $this->input->post('nm_pelanggan'),
              "no_pelanggan" => $this->input->post('no_pelanggan'),
              "tgl_pembelian" => date('Y-m-d H:i:s'),
              "tgl" => $TGL_BERANGKAT,
              "jumlah_sewa" => $this->input->post('jumlah_sewa'),
              "jenis_penyewaan" => 'OFFLINE',
              "status_tiket" => 'BELUM SCAN',
            );


    $this->db->insert('tb_penyewaan', $data);

    if($this->input->post('bayar') == "true"){
      $id_pembayaran = $this->generatePembayaranId();
      
      $dataBayar = array(
                "id_pembayaran" => $id_pembayaran,
                "id_penyewaan" => $id,
                "nominal" => $this->input->post('nominal'),
                "bukti_pembayaran" => "CASH",
                "status_validasi" => "TERVALIDASI",
                "tgl_bayar" => date('Y-m-d H:i:s'),
              );
      $this->db->insert('tb_pembayaran', $dataBayar);
    }

    $output = array("status" => "success", "message" => "Data Berhasil Disimpan, ID: ".$id);
    echo json_encode($output);

  }

  public function updateData(){
    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_ketersediaan', 'ID Ketersediaan', 'required');
    $this->form_validation->set_rules('id_pelanggan', 'Pelanggan', 'required');
    $this->form_validation->set_rules('nm_pelanggan', 'Nama Pelanggan', 'required');
    $this->form_validation->set_rules('no_pelanggan', 'No Pelanggan', 'required');
    $this->form_validation->set_rules('jumlah_pembelian', 'Jumlah Pembelian', 'required');

    if($this->form_validation->run() == FALSE){
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $TGL_BERANGKAT = $this->db->query("select tgl as TGL_BERANGKAT from tb_ketersediaan 
    where id_ketersediaan = '".$this->input->post('id_ketersediaan')."'")->row()->TGL_BERANGKAT;

    $data = array(
      "id_ketersediaan" => $this->input->post('id_ketersediaan'),
      "id_pelanggan" => $this->input->post('id_pelanggan'),
      "nm_pelanggan" => $this->input->post('nm_pelanggan'),
      "no_pelanggan" => $this->input->post('no_pelanggan'),
      "tgl_pembelian" => date('Y-m-d H:i:s'),
      "tgl" => $TGL_BERANGKAT,
      "jumlah_sewa" => $this->input->post('jumlah_sewa'),
    );


    $this->db->where('id_penyewaan', $this->input->post('id_penyewaan'));
    $this->db->update('tb_penyewaan', $data);
    if($this->db->error()['message'] != ""){
      $output = array("status" => "error", "message" => $this->db->error()['message']);
      echo json_encode($output);
      return false;
    }
    $output = array("status" => "success", "message" => "Data Berhasil di Update");
    echo json_encode($output);

  }

  public function deleteData(){

    $this->db->where('id_penyewaan', $this->input->post('id_penyewaan'));
    $this->db->delete('tb_penyewaan');

    $output = array("status" => "success", "message" => "Data Berhasil di Hapus");
    echo json_encode($output);
  }

  public function getTujuanMobil(){
    $data['data'] = $this->db->query("SELECT DISTINCT tujuan from tb_ketersediaan 
    WHERE DATE(tgl) = '".$this->input->post('tgl')."' 
    AND tipe_sewa='".$this->input->post('tipe_sewa')."'")->result(); 

  	echo json_encode($data);
  }

  public function getHistory(){
    $data['data'] = $this->db->query("
        SELECT A.id_penyewaan, 
               B.id_ketersediaan, 
               DATE_FORMAT(A.tgl_pembelian, '%d %b %Y <br> %H:%i') AS tgl_pembelian, 
               DATE_FORMAT(A.tgl_penyewaan, '%d %b %Y <br> %H:%i') AS tgl_penyewaan,
               DATE_FORMAT(A.tgl_pengembalian, '%d %b %Y <br> %H:%i') AS tgl_pengembalian,
               B.tujuan, 
               A.jumlah_sewa, 
               C.kapasitas, 
               D.nm_jenis_mobil, 
               A.total_pembayaran, 
               E.total_pembayaran AS dp_total_pembayaran, 
               A.jaminan, 
               E.status_validasi
        FROM tb_penyewaan A
        LEFT JOIN tb_pembayaran E ON A.id_penyewaan = E.id_penyewaan
        LEFT JOIN tb_ketersediaan B ON A.id_ketersediaan = B.id_ketersediaan 
        LEFT JOIN tb_mobil_sewa C ON B.id_mobil_sewa = C.id_mobil_sewa 
        LEFT JOIN tb_jenis_mobil D ON C.id_jenis_mobil = D.id_jenis_mobil 
        WHERE A.id_pelanggan IN (
            SELECT id_pelanggan FROM tb_pelanggan WHERE ID_USER = '".$this->session->userdata('id_user')."'
        )
    ")->result(); 

    echo json_encode($data);
}
  
  public function saveDataFront() {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_ketersediaan', 'ID Ketersediaan', 'required');
    $this->form_validation->set_rules('nm_pelanggan', 'Nama Pelanggan', 'required');
    $this->form_validation->set_rules('no_pelanggan', 'No Pelanggan', 'required');
    $this->form_validation->set_rules('jumlah_sewa', 'Jumlah Sewa', 'required');
    $this->form_validation->set_rules('tgl', 'Tanggal Penyewaan', 'required');
    $this->form_validation->set_rules('tgl_pengembalian', 'Tanggal Pengembalian', 'required');
    $this->form_validation->set_rules('jumlah_hari', 'Jumlah Hari Sewa', 'required');

    if ($this->form_validation->run() == FALSE) {
        $output = array("status" => "error", "message" => validation_errors());
        echo json_encode($output);
        return false;
    }

    // Generate unique ID for this booking
    $id = $this->generateId();

    // Fetch departure date from the database
    $TGL_BERANGKAT = $this->db->query("SELECT tgl as TGL_BERANGKAT FROM tb_ketersediaan 
        WHERE id_ketersediaan = '".$this->input->post('id_ketersediaan')."'")->row()->TGL_BERANGKAT;

    // Fetch customer ID based on user session
    $ID_PELANGGAN = $this->db->query("SELECT id_pelanggan as ID_PELANGGAN FROM tb_pelanggan 
        WHERE id_user = '".$this->session->userdata('id_user')."'")->row()->ID_PELANGGAN;

    $harga_per_hari = $this->input->post('harga');
    $jumlah_sewa = $this->input->post('jumlah_sewa');
    $tgl = new DateTime($this->input->post('tgl'));
    $tgl_pengembalian = new DateTime($this->input->post('tgl_pengembalian'));
    $interval = $tgl->diff($tgl_pengembalian);
    $rentalDays = $interval->days + 1; // Include the departure day
    $jumlah_hari = $this->input->post('jumlah_hari');

    $total_pembayaran = $harga_per_hari * $jumlah_sewa * $rentalDays;

    // Konfigurasi upload
    $config['allowed_types'] = 'gif|jpg|png|jpeg';
    $config['max_size'] = '2048';
    $config['upload_path'] = './assets/images/jaminan/';
    $this->load->library('upload', $config);
    $this->upload->do_upload('jaminan');
    $image = $this->upload->data('file_name');

    $data = array(
        "id_penyewaan" => $id,
        "id_ketersediaan" => $this->input->post('id_ketersediaan'),
        "id_pelanggan" => $ID_PELANGGAN,
        "nm_pelanggan" => $this->input->post('nm_pelanggan'),
        "no_pelanggan" => $this->input->post('no_pelanggan'),
        "tgl_pembelian" => date('Y-m-d H:i:s'),
        "tgl_penyewaan" => $TGL_BERANGKAT,
        "tgl_pengembalian" => $this->input->post('tgl_pengembalian'),
        "jumlah_hari" => $jumlah_hari,
        "jumlah_sewa" => $jumlah_sewa,
        "jenis_penyewaan" => 'ONLINE',
        "total_pembayaran" => $total_pembayaran,
        "jaminan" => $image
    );

    // Start transaction
    $this->db->trans_start();

    // Save booking data
    $this->db->insert('tb_penyewaan', $data);

    // Reduce the number of buses available
    $this->db->set('jumlah_mobil', 'jumlah_mobil - ' . intval($jumlah_sewa), FALSE);
    $this->db->where('id_ketersediaan', $this->input->post('id_ketersediaan'));
    $this->db->update('tb_ketersediaan');

    // Complete transaction
    $this->db->trans_complete();

    // Check transaction status
    if ($this->db->trans_status() === FALSE) {
        // If failed
        $output = array("status" => "error", "message" => 'Penyewaan gagal.');
    } else {
        // If successful
        $output = array("status" => "success", "message" => "Data Berhasil Disimpan, lakukan pembayaran Nomor Sewa: ".$id);
    }

    // Send response to the client
    echo json_encode($output);
}

  public function cekPembayaran(){
    $data = $this->db->query("SELECT status_validasi from tb_pembayaran
    WHERE id_penyewaan = '".$this->input->post('id_penyewaan')."'")->result_array();

    // print_r($nominal);
    

    if(count($data) > 0){
      if($data[0]['status_validasi'] == "TERUPLOAD"){
        $output = array("status" => "error", "message" => "Pembayaran Anda belum terverifikasi, silahkan hubungi Admin kami");
      }else{
        $output = array("status" => "success", "message" => "Data Oke");
      }
      
    }else{
      $output = array("status" => "error", "message" => "Anda belum mengunggah Bukti Pembayaran");
    }

    echo json_encode($output);
  }

}