<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran extends CI_Controller {

  public function __construct(){
    parent::__construct();
  }

  public function index(){
    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/sewa/pembayaran');
    $this->load->view('template/footer');
  }

  public function getAllData(){   
    $data['data'] = $this->db->query("SELECT B.id_pembayaran, DATE_FORMAT(B.tgl_bayar, \"%d %b %Y <br> %H:%i\") tgl_bayar, A.id_penyewaan, A.jumlah_sewa, C.harga, 
    A.total_pembayaran, B.bukti_pembayaran, B.status_validasi, A.notif_wa
    FROM tb_penyewaan A
    INNER JOIN tb_pembayaran B ON A.id_penyewaan = B.id_penyewaan
    INNER JOIN tb_ketersediaan C ON A.id_ketersediaan = C.id_ketersediaan
    ORDER BY B.tgl_bayar Desc")->result(); 

  	echo json_encode($data);
  }

  public function getPenyewaan(){
    $data['data'] = $this->db->query("
      SELECT id_penyewaan, nm_pelanggan FROM `tb_penyewaan`
      WHERE id_penyewaan NOT IN(
        SELECT id_penyewaan FROM tb_ketersediaan
      )
      ORDER BY id_penyewaan
    ")->result(); 

  	echo json_encode($data);
  }

  public function getPenyewaanById(){
    $data['data'] = $this->db->query("
      SELECT id_penyewaan, nm_pelanggan FROM `tb_penyewaan`
      WHERE id_penyewaan IN(
        SELECT id_penyewaan FROM tb_ketersediaan WHERE id_pembayaran='".$this->input->post('id_pembayaran')."'
      )
      ORDER BY id_penyewaan
    ")->result(); 

  	echo json_encode($data);
  }

  public function getDtlPenyewaan(){
    $data['data'] = $this->db->query("
      SELECT A.jumlah_sewa, (A.jumlah_sewa * B.harga) as nominal FROM tb_penyewaan A
      INNER JOIN tb_ketersediaan B ON A.id_ketersediaan=B.id_ketersediaan
      WHERE id_penyewaan='".$this->input->post('id_penyewaan')."'
    ")->result(); 

  	echo json_encode($data);
  }

  private function _do_upload(){
		$config['upload_path']          = 'assets/images/bukti/';
    $config['allowed_types']        = 'gif|jpg|jpeg|png';
    $config['max_size']             = 5000; //set max size allowed in Kilobyte
    $config['max_width']            = 4000; // set max width image allowed
    $config['max_height']           = 4000; // set max height allowed
    $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

    $this->load->library('upload', $config);

    if(!$this->upload->do_upload('bukti_pembayaran')) //upload and validate
    {
      $data['inputerror'] = 'bukti_pembayaran';
			$data['message'] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		return $this->upload->data('file_name');
	}

  public function generateId() {
    $unik = "PS".date('Ym'); // Membuat prefix dengan format SBYYYYMM
    $result = $this->db->query("SELECT MAX(id_pembayaran) AS LAST_NO FROM tb_pembayaran WHERE id_pembayaran LIKE '".$unik."%'")->row();

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
    $this->form_validation->set_rules('id_penyewaan', 'ID Penyewaan', 'required|is_unique[tb_penyewaan.id_penyewaan]');
    $this->form_validation->set_rules('nominal', 'Nominal Bayar', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $id = $this->generateId();
      
    $data = array(
              "id_pembayaran" => $id,
              "id_penyewaan" => $this->input->post('id_penyewaan'),
              "nominal" => $this->input->post('nominal'),
              "status_validasi" => "TERVALIDASI",
              "tgl_bayar" => date('Y-m-d H:i:s'),
            );
    

    if(!empty($_FILES['bukti_pembayaran']['name'])){
      $upload = $this->_do_upload();
      $data['bukti_pembayaran'] = $upload;
    }

    $this->db->insert('tb_pembayaran', $data);
    $output = array("status" => "success", "message" => "Data Berhasil Disimpan, ID: ".$id);
    echo json_encode($output);

  }

  public function saveDataFront() {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_penyewaan', 'ID Penyewaan', 'required');
    $this->form_validation->set_rules('total_pembayaran', 'Total Bayar', 'required');
    $this->form_validation->set_rules('jenis_pembayaran', 'Jenis Pembayaran', 'required');

    if ($this->form_validation->run() == FALSE) {
        $output = array("status" => "error", "message" => validation_errors());
        echo json_encode($output);
        return false;
    }

    $id_penyewaan = $this->input->post('id_penyewaan');
    $total_pembayaran = $this->input->post('total_pembayaran');
    $jenis_pembayaran = $this->input->post('jenis_pembayaran');

    $status_validasi = '';
    $tgl_bayar = date('Y-m-d H:i:s');
    $bukti_pembayaran = '';

    if (!empty($_FILES['bukti_pembayaran']['name'])) {
        $bukti_pembayaran = $this->_do_upload();
    }

    // Cek apakah sudah ada pembayaran
    $this->db->select('*');
    $this->db->from('tb_pembayaran');
    $this->db->where('id_penyewaan', $id_penyewaan);
    $existing_payment = $this->db->get()->row();

    if ($existing_payment) {
        // Jika sudah ada pembayaran DP
        if ($existing_payment->status_validasi == 'DP_UPLOAD' && $jenis_pembayaran == 'lunas') {
            $status_validasi = 'LUNAS_UPLOAD';
        } else {
            $status_validasi = 'DP_UPLOAD';
        }

        // Update data yang ada
        $data = array(
            "total_pembayaran" => $total_pembayaran,
            "status_validasi" => $status_validasi,
            "tgl_bayar" => $tgl_bayar,
        );
        if ($bukti_pembayaran) {
            $data['bukti_pembayaran'] = $bukti_pembayaran;
        }

        $this->db->where('id_penyewaan', $id_penyewaan);
        $this->db->update('tb_pembayaran', $data);
    } else {
        // Jika belum ada pembayaran
        if ($jenis_pembayaran == 'dp') {
            $status_validasi = 'DP_UPLOAD';
        } elseif ($jenis_pembayaran == 'lunas') {
            $status_validasi = 'LUNAS_UPLOAD';
        }

        $data = array(
            "id_pembayaran" => $this->generateId(),
            "id_penyewaan" => $id_penyewaan,
            "total_pembayaran" => $total_pembayaran,
            "status_validasi" => $status_validasi,
            "tgl_bayar" => $tgl_bayar,
            "bukti_pembayaran" => $bukti_pembayaran
        );
        $this->db->insert('tb_pembayaran', $data);
    }

    $output = array("status" => "success", "message" => "Data Berhasil Disimpan.");
    echo json_encode($output);
}

  public function updateData($id_pembayaran){
    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_penyewaan', 'ID Penyewaan', 'required');
    $this->form_validation->set_rules('total_pembayaran', 'Nominal Bayar', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $data = array(
      "id_penyewaan" => $this->input->post('id_penyewaan'),
      "total_pembayaran" => $this->input->post('total_pembayaran'),
      "status_validasi" => $this->input->post('status_validasi'),
      "tgl_bayar" => date('Y-m-d H:i:s'),
    );

    if(!empty($_FILES['bukti_pembayaran']['name'])){
      $this->db->select('bukti_pembayaran');
      $this->db->from('tb_pembayaran');
      $this->db->where('id_pembayaran', $id_pembayaran);
      $files = $this->db->get()->row();

      if($files->bukti_pembayaran){
        if(file_exists('assets/images/bukti/'.$files->foto) && $files->foto)
          unlink('assets/images/bukti/'.$files->foto);
      }
			$upload = $this->_do_upload();
			$data['bukti_pembayaran'] = $upload;
		}


    $this->db->where('id_pembayaran', $id_pembayaran);
    $this->db->update('tb_pembayaran', $data);
    if($this->db->error()['message'] != ""){
      $output = array("status" => "error", "message" => $this->db->error()['message']);
      echo json_encode($output);
      return false;
    }
    $output = array("status" => "success", "message" => "Data Berhasil di Update");
    echo json_encode($output);

  }

  public function deleteData(){

    $this->db->where('id_pembayaran', $this->input->post('id_pembayaran'));
    $this->db->delete('tb_pembayaran');

    $output = array("status" => "success", "message" => "Data Berhasil di Hapus");
    echo json_encode($output);
  }

  public function verifyData(){
    $id_pembayaran = $this->input->post('id_pembayaran');

    $data = array(
      "status_validasi" => "LUNAS_VALIDATED",
      "tgl_bayar" => date('Y-m-d H:i:s'),
    );

    $this->db->where('id_pembayaran', $id_pembayaran);
    $this->db->update('tb_pembayaran', $data);
    if($this->db->error()['message'] != ""){
      $output = array("status" => "error", "message" => $this->db->error()['message']);
      echo json_encode($output);
      return false;
    }
    $output = array("status" => "success", "message" => "Data Berhasil di Verifikasi");
    echo json_encode($output);
  }
}