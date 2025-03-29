<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_Nilai extends CI_Controller {

  public function __construct(){
    parent::__construct();
  }

  public function index(){
    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/kategori_nilai');
    $this->load->view('template/footer');
  }

  public function getAllData(){
        
    $this->db->select('*');
    $this->db->from('tb_indikator_kepuasan'); 
    $this->db->order_by('indikator_kepuasan','asc');         
    $data['data'] = $this->db->get()->result(); 

  	echo json_encode($data);
  }

  public function generateId(){
    $unik = 'IK';
    $kode = $this->db->query("SELECT MAX(id_indikator_kepuasan) LAST_NO FROM tb_indikator_kepuasan WHERE id_indikator_kepuasan LIKE '".$unik."%'")->row()->LAST_NO;
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
    $this->form_validation->set_rules('indikator_kepuasan', 'Indikator kepuasan', 'required|is_unique[tb_indikator_kepuasan.indikator_kepuasan]');
    $this->form_validation->set_rules('nilai', 'Nilai', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $id = $this->generateId();
    
    $data = array(
              "id_indikator_kepuasan" => $id,
              "indikator_kepuasan" => $this->input->post('indikator_kepuasan'),
              "nilai" => $this->input->post('nilai'),
            );

    $this->db->insert('tb_indikator_kepuasan', $data);
    $output = array("status" => "success", "message" => "Data Berhasil Disimpan, ID: ".$id);
    echo json_encode($output);

  }

  public function updateData(){
    
    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_indikator_kepuasan', 'ID indikator kepuasan', 'required');
    $this->form_validation->set_rules('indikator_kepuasan', 'Indikator kepuasan', 'required');
    $this->form_validation->set_rules('nilai', 'Nilai', 'required');

    if($this->form_validation->run() == FALSE){
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $data = array(
      "indikator_kepuasan" => $this->input->post('indikator_kepuasan'),
      "nilai" => $this->input->post('nilai'),
    );

    $this->db->where('id_indikator_kepuasan', $this->input->post('id_indikator_kepuasan'));
    $this->db->update('tb_indikator_kepuasan', $data);
    if($this->db->error()['message'] != ""){
      $output = array("status" => "error", "message" => $this->db->error()['message']);
      echo json_encode($output);
      return false;
    }
    $output = array("status" => "success", "message" => "Data Berhasil di Update");
    echo json_encode($output);

  }

  public function deleteData(){

    $this->db->where('id_indikator_kepuasan', $this->input->post('id_indikator_kepuasan'));
    $this->db->delete('tb_indikator_kepuasan');

    $output = array("status" => "success", "message" => "Data Berhasil di Hapus");
    echo json_encode($output);
  }

}