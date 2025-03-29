<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mobil_sewa extends CI_Controller {

  public function __construct(){
    parent::__construct();
  }

  public function index(){
    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/sewa/mobil_sewa');
    $this->load->view('template/footer');
  }

  public function getAllData(){
    $data['data'] = $this->db->query("SELECT b.id_mobil_sewa, a.nm_jenis_mobil, b.kapasitas, 
    b.jumlah_mobil, b.foto, b.deskripsi 
    FROM tb_jenis_mobil a
    inner JOIN tb_mobil_sewa b ON a.id_jenis_mobil = b.id_jenis_mobil")->result(); 

  	echo json_encode($data);
  }

  public function getJenisMobil(){
    $data['data'] = $this->db->query("SELECT * from tb_jenis_mobil")->result(); 

  	echo json_encode($data);
  }

  public function getKategori(){
    $data['data'] = $this->db->query("SELECT * from tb_kategori ORDER BY nm_kategori")->result(); 

    echo json_encode($data);
  }

  private function _do_upload($field_name){
    $config['upload_path']          = 'assets/images/';
    $config['allowed_types']        = 'gif|jpg|jpeg|png';
    $config['max_size']             = 5000; // set max size allowed in Kilobyte
    $config['max_width']            = 4000; // set max width image allowed
    $config['max_height']           = 4000; // set max height allowed
    $config['file_name']            = round(microtime(true) * 1000); // just milisecond timestamp for unique name

    $this->load->library('upload', $config);

    if(!$this->upload->do_upload($field_name)) // upload and validate
    {
        $data['inputerror'] = $field_name;
        $data['message'] = 'Upload error: '.$this->upload->display_errors('', ''); // show ajax error
        $data['status'] = FALSE;
        echo json_encode($data);
        exit();
    }
    return $this->upload->data('file_name');
}

  public function generateId(){
    $unik = 'BS';
    $kode = $this->db->query("SELECT MAX(id_mobil_sewa) LAST_NO FROM tb_mobil_sewa WHERE id_mobil_sewa LIKE '".$unik."%'")->row()->LAST_NO;
    // mengambil angka dari kode barang terbesar, menggunakan fungsi substr
    // dan diubah ke integer dengan (int)
    $urutan = (int) substr($kode, 2, 3);
    
    // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
    $urutan++;
    
    // membentuk kode barang baru
    // perintah sprintf("%03s", $urutan); berguna untuk membuat string menjadi 3 karakter
    // misalnya perintah sprintf("%03s", 15); maka akan menghasilkan '015'
    // angka yang diambil tadi digabungkan dengan kode huruf yang kita inginkan, misalnya BRG 
    $huruf = $unik;
    $kode = $huruf . sprintf("%03s", $urutan);
    return $kode;
  }

  public function saveData(){
    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_jenis_mobil', 'Jenis Mobil', 'required');
    $this->form_validation->set_rules('id_kategori', 'Kategori', 'required');
    $this->form_validation->set_rules('jumlah_mobil', 'Jumlah', 'required');
    $this->form_validation->set_rules('kapasitas', 'kapasitas', 'required');
    $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');

    if($this->form_validation->run() == FALSE){
        $output = array("status" => "error", "message" => validation_errors());
        echo json_encode($output);
        return false;
    }

    $id = $this->generateId();
    $data = array(
        "id_mobil_sewa" => $id,
        "id_jenis_mobil" => $this->input->post('id_jenis_mobil'),
        "kapasitas" => $this->input->post('kapasitas'),
        "jumlah_mobil" => $this->input->post('jumlah_mobil'),
        "deskripsi" => $this->input->post('deskripsi'),
        "id_kategori" => $this->input->post('id_kategori'),
    );

    if(!empty($_FILES['foto']['name'])){
        $upload = $this->_do_upload('foto');
        $data['foto'] = $upload;
    }

    $this->db->insert('tb_mobil_sewa', $data);
    $output = array("status" => "success", "message" => "Data Berhasil Disimpan, ID: ".$id);
    echo json_encode($output);
}

public function updateData($id){
  $this->load->library('form_validation');
  $this->form_validation->set_rules('id_jenis_mobil', 'Jenis Mobil', 'required');
  $this->form_validation->set_rules('id_kategori', 'Kategori', 'required');
  $this->form_validation->set_rules('kapasitas', 'Kapasitas', 'required');
  $this->form_validation->set_rules('jumlah_mobil', 'Jumlah Mobil', 'required');
  $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');

  if($this->form_validation->run() == FALSE){
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
  }

  $data = array(
      "id_jenis_mobil" => $this->input->post('id_jenis_mobil'),
      "kapasitas" => $this->input->post('kapasitas'),
      "jumlah_mobil" => $this->input->post('jumlah_mobil'),
      "deskripsi" => $this->input->post('deskripsi'),
      "id_kategori" => $this->input->post('id_kategori'),
  );

  if(!empty($_FILES['foto']['name'])){
      $upload = $this->_do_upload('foto');
      $data['foto'] = $upload;
  }

  $this->db->where('id_mobil_sewa', $id);
  $this->db->update('tb_mobil_sewa', $data);
  if($this->db->error()['message'] != ""){
      $output = array("status" => "error", "message" => $this->db->error()['message']);
      echo json_encode($output);
      return false;
  }
  $output = array("status" => "success", "message" => "Data Berhasil di Update");
  echo json_encode($output);
}

  public function deleteData(){

    $this->db->where('id_mobil_sewa', $this->input->post('id_mobil_sewa'));
    $this->db->delete('tb_mobil_sewa');

    $output = array("status" => "success", "message" => "Data Berhasil di Hapus");
    echo json_encode($output);
  }

}