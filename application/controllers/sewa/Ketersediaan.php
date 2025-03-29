<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ketersediaan extends CI_Controller {

  public function __construct(){
    parent::__construct();
  }

  public function index(){
    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/sewa/ketersediaan');
    $this->load->view('template/footer');
  }

  public function getJadwalByDate(){
    $data['data'] = $this->db->query("
      select a.id_ketersediaan, a.tipe_sewa, c.nm_jenis_mobil, b.waktu_keberangkatan, a.tujuan, a.tgl, a.tiket_scanned from tb_ketersediaan a
      inner join tb_mobil_sewa b on a.id_mobil_sewa = b.id_mobil_sewa 
      inner join tb_jenis_mobil c on b.id_jenis_mobil = c.id_jenis_mobil
      where DATE(a.tgl) = '".$this->input->post('tgl_berangkat')."'
    ")->result();

    echo json_encode($data);
  }

  public function getAllData(){
    $query = $this->db->query("
        SELECT 
            C.id_ketersediaan, 
            A.nm_jenis_mobil, 
            B.id_mobil_sewa, 
            B.kapasitas,
            C.tujuan, 
            DATE_FORMAT(C.tgl, '%d %b %Y %H:%i') AS tgl, 
            C.jumlah_mobil, 
            C.harga, 
            C.tipe_sewa, 
            A.id_jenis_mobil
        FROM tb_jenis_mobil A
        INNER JOIN tb_mobil_sewa B ON A.id_jenis_mobil = B.id_jenis_mobil
        INNER JOIN tb_ketersediaan C ON B.id_mobil_sewa = C.id_mobil_sewa
    ");
      
      if ($query->num_rows() > 0) {
          $dataList = $query->result();
          $data['data'] = [];

          foreach ($dataList as $key => $list) {
              $data['data'][$key]['id_ketersediaan'] = $list->id_ketersediaan;
              $data['data'][$key]['nm_jenis_mobil'] = $list->nm_jenis_mobil;
              $data['data'][$key]['id_mobil_sewa'] = $list->id_mobil_sewa;
              $data['data'][$key]['kapasitas'] = $list->kapasitas;
              $data['data'][$key]['tujuan'] = $list->tujuan;
              $data['data'][$key]['tgl'] = $list->tgl;
              $data['data'][$key]['jumlah_mobil'] = $list->jumlah_mobil;
              $data['data'][$key]['harga'] = $list->harga;
              $data['data'][$key]['tipe_sewa'] = $list->tipe_sewa;
              $data['data'][$key]['id_jenis_mobil'] = $list->id_jenis_mobil;
          }

          echo json_encode($data);
      } else {
          $data['data'] = [];
          echo json_encode($data);
      }
  }

  public function getIdMobil(){
    $data['data'] = $this->db->query("SELECT id_mobil_sewa, kapasitas, jumlah_mobil from tb_mobil_sewa WHERE id_jenis_mobil = '".$this->input->post('id_jenis_mobil')."'")->result(); 

  	echo json_encode($data);
  }

  public function getJumlahMobil(){
    $data['data'] = $this->db->query("SELECT id_mobil_sewa, kapasitas, jumlah_mobil from tb_mobil_sewa WHERE id_mobil_sewa = '".$this->input->post('id_mobil_sewa')."'")->result(); 

  	echo json_encode($data);
  }

  public function generateId(){
    // Get the current year and month in 'YYYYMM' format
    $unik = date('Ym');
    $prefix = 'KT';

    // Query to get the maximum existing ID with the same prefix and date
    $kode = $this->db->query("SELECT MAX(id_ketersediaan) AS LAST_NO FROM tb_ketersediaan WHERE id_ketersediaan LIKE '".$prefix.$unik."%'")->row()->LAST_NO;

    // Extract the sequence number from the existing ID
    $urutan = (int) substr($kode, 9, 5);
    
    // Increment the sequence number by 1 for the new ID
    $urutan++;
    
    // Form the new ID
    $kode = $prefix . $unik . sprintf("%05s", $urutan);
    return $kode;
}

public function saveData(){
    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_mobil_sewa', 'Pilih Mobil', 'required');
    $this->form_validation->set_rules('tujuan', 'tujuan', 'required');
    $this->form_validation->set_rules('tgl', 'Waktu Keberangkatan', 'required');
    $this->form_validation->set_rules('jumlah_mobil', 'Maksimal Mobil', 'required');
    $this->form_validation->set_rules('harga', 'Harga Tiket', 'required');
    $this->form_validation->set_rules('tipe_sewa', 'Tipe Sewa', 'required');

    if($this->form_validation->run() == FALSE){
        $output = array("status" => "error", "message" => validation_errors());
        echo json_encode($output);
        return false;
    }

    // Generate a unique ID for the new record
    $id = $this->generateId();

    $data = array(
        "id_ketersediaan" => $id,
        "id_mobil_sewa" => $this->input->post('id_mobil_sewa'),
        "tujuan" => $this->input->post('tujuan'),
        "tgl" => $this->input->post('tgl'),
        "jumlah_mobil" => $this->input->post('jumlah_mobil'),
        "harga" => $this->input->post('harga'),
        "tipe_sewa" => $this->input->post('tipe_sewa'),
        "tiket_scanned" => 0
    );

    // Insert the data into the database
    $insert = $this->db->insert('tb_ketersediaan', $data);

    if ($insert) {
        $output = array("status" => "success", "message" => "Data Berhasil Disimpan, ID: ".$id);
    } else {
        $output = array("status" => "error", "message" => "Data Gagal Disimpan");
    }
    echo json_encode($output);
  }

  public function updateData(){
    
    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_mobil_sewa', 'Pilih Bus', 'required');
    $this->form_validation->set_rules('tujuan', 'tujuan', 'required');
    $this->form_validation->set_rules('tgl', 'Waktu Keberangkatan', 'required');
    $this->form_validation->set_rules('jumlah_mobil', 'Maksimal Bus', 'required');
    $this->form_validation->set_rules('harga', 'Harga Tiket', 'required');
    $this->form_validation->set_rules('tipe_sewa', 'Tipe Tiket', 'required');

    if($this->form_validation->run() == FALSE){
      echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $data = array(
      "id_mobil_sewa" => $this->input->post('id_mobil_sewa'),
      "tujuan" => $this->input->post('tujuan'),
      "tgl" => $this->input->post('tgl'),
      "jumlah_mobil" => $this->input->post('jumlah_mobil'),
      "harga" => $this->input->post('harga'),
      "tipe_sewa" => $this->input->post('tipe_sewa')
    );


    $this->db->where('id_ketersediaan', $this->input->post('id_ketersediaan'));
    $this->db->update('tb_ketersediaan', $data);
    if($this->db->error()['message'] != ""){
      $output = array("status" => "error", "message" => $this->db->error()['message']);
      echo json_encode($output);
      return false;
    }
    $output = array("status" => "success", "message" => "Data Berhasil di Update");
    echo json_encode($output);

  }

  public function deleteData(){

    $this->db->where('id_ketersediaan', $this->input->post('id_ketersediaan'));
    $this->db->delete('tb_ketersediaan');

    $output = array("status" => "success", "message" => "Data Berhasil di Hapus");
    echo json_encode($output);
  }

}