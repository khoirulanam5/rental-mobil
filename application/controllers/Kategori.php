<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {

  public function __construct(){
    parent::__construct();
  }

  public function index(){
    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/kategori');
    $this->load->view('template/footer');
  }

  public function getAllData(){
    $this->db->select('*');
    $this->db->from('tb_kategori'); 
    $this->db->order_by('nm_kategori','asc');         
    $data['data'] = $this->db->get()->result(); 

  	echo json_encode($data);
  }

  public function generateId(){
    $unik = 'KB';
    $kode = $this->db->query("SELECT MAX(id_kategori) LAST_NO FROM tb_kategori WHERE id_kategori LIKE '".$unik."%'")->row()->LAST_NO;
    // mengambil angka dari kode barang terbesar, menggunakan fungsi substr
    // dan diubah ke integer dengan (int)
    $urutan = (int) substr($kode, 3, 6);
    
    // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
    $urutan++;
    
    // membentuk kode barang baru
    // perintah sprintf("%03s", $urutan); berguna untuk membuat string menjadi 3 karakter
    // misalnya perintah sprintf("%03s", 15); maka akan menghasilkan '015'
    // angka yang diambil tadi digabungkan dengan kode huruf yang kita inginkan, misalnya BRG 
    $huruf = $unik;
    $kode = $huruf . sprintf("%06s", $urutan);
    return $kode;
  }

  public function saveData(){
    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_kategori', 'ID Kategori Bus', 'required|is_unique[tb_kategori.id_kategori]');
    $this->form_validation->set_rules('nm_kategori', 'kategori Bus', 'required|is_unique[tb_kategori.nm_kategori]');

    if($this->form_validation->run() == FALSE){
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }
    
    $data = array(
              "id_kategori" => $this->input->post('id_kategori'),
              "nm_kategori" => $this->input->post('nm_kategori'),
            );

    $this->db->insert('tb_kategori', $data);
    $output = array("status" => "success", "message" => "Data Berhasil Disimpan");
    echo json_encode($output);

  }

  public function updateData(){
    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_kategori', 'ID Jenis', 'required');
    $this->form_validation->set_rules('nm_kategori', 'Jenis Bus', 'required');

    if($this->form_validation->run() == FALSE){
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $data = array(
      "nm_kategori" => $this->input->post('nm_kategori'),
    );
    $this->db->where('id_kategori', $this->input->post('id_kategori'));
    $this->db->update('tb_kategori', $data);
    if($this->db->error()['message'] != ""){
      $output = array("status" => "error", "message" => $this->db->error()['message']);
      echo json_encode($output);
      return false;
    }
    $output = array("status" => "success", "message" => "Data Berhasil di Update");
    echo json_encode($output);

  }

  public function deleteData(){

    $this->db->where('id_kategori', $this->input->post('id_kategori'));
    $this->db->delete('tb_kategori');

    $output = array("status" => "success", "message" => "Data Berhasil di Hapus");
    echo json_encode($output);
  }

}