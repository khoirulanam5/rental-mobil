<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_mobil extends CI_Controller {

  public function __construct(){
    parent::__construct();
  }

  public function index(){
    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/sewa/jenis_mobil');
    $this->load->view('template/footer');
  }

  public function getAllData(){
    $this->db->select('*');
    $this->db->from('tb_jenis_mobil'); 
    $this->db->order_by('nm_jenis_mobil','asc');         
    $data['data'] = $this->db->get()->result(); 

  	echo json_encode($data);
  }

  public function generateId(){
    $unik = 'JBS';
    $kode = $this->db->query("SELECT MAX(id_jenis_mobil) LAST_NO FROM tb_jenis_mobil WHERE id_jenis_mobil LIKE '".$unik."%'")->row()->LAST_NO;
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
    $this->form_validation->set_rules('nm_jenis_mobil', 'Jenis Bus', 'required|is_unique[tb_jenis_mobil.nm_jenis_mobil]');

    if($this->form_validation->run() == FALSE){
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $id = $this->generateId();
    
    $data = array(
              "id_jenis_mobil" => $id,
              "nm_jenis_mobil" => $this->input->post('nm_jenis_mobil'),
            );


    $this->db->insert('tb_jenis_mobil', $data);
    $output = array("status" => "success", "message" => "Data Berhasil Disimpan, ID: ".$id);
    echo json_encode($output);

  }

  public function updateData(){
    
    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_jenis_mobil', 'ID Jenis', 'required');
    $this->form_validation->set_rules('nm_jenis_mobil', 'Jenis Bus', 'required');

    if($this->form_validation->run() == FALSE){
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $data = array(
      "nm_jenis_mobil" => $this->input->post('nm_jenis_mobil'),
    );

    $this->db->where('id_jenis_mobil', $this->input->post('id_jenis_mobil'));
    $this->db->update('tb_jenis_mobil', $data);
    if($this->db->error()['message'] != ""){
      $output = array("status" => "error", "message" => $this->db->error()['message']);
      echo json_encode($output);
      return false;
    }
    $output = array("status" => "success", "message" => "Data Berhasil di Update");
    echo json_encode($output);

  }

  public function deleteData(){

    $this->db->where('id_jenis_mobil', $this->input->post('id_jenis_mobil'));
    $this->db->delete('tb_jenis_mobil');

    $output = array("status" => "success", "message" => "Data Berhasil di Hapus");
    echo json_encode($output);
  }

}