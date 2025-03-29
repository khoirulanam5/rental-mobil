<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

  public function __construct(){
    parent::__construct(); 
  }

  public function index(){
    if($this->session->userdata('id_user'))
      redirect('home', 'refresh');

    $this->load->view('login');
  }

  public function login(){
    $this->db->where('username', $this->input->post('username'));  
    $this->db->where('password', $this->input->post('password'));  
    $query = $this->db->get('tb_user');   
    if($query->num_rows() > 0){  
      foreach ($query->result() as $row)
      {   
        $arrdata = array(
          'id_user'=>$row->id_user,
          'level'=>$row->level,
          'username'=>$row->username,
          'nm_pengguna'=>$row->nm_pengguna
        );  
          $this->session->set_userdata($arrdata);
      }

      $output = array("status" => "success", "message" => "Login Berhasil");
    }else{  
      $output = array("status" => "error", "message" => "Login Gagal");  
    }

    echo json_encode($output);
  }

  function logout(){
    $this->session->unset_userdata('id_user');
    $this->session->sess_destroy();
    redirect('/', 'refresh');
  }

  public function register(){
    $this->load->view('register');
  }

  public function generateUserId(){
    $unik = 'U'.date('y');
    $kode = $this->db->query("SELECT MAX(id_user) LAST_NO FROM tb_user WHERE id_user LIKE '".$unik."%'")->row()->LAST_NO;
    // mengambil angka dari kode barang terbesar, menggunakan fungsi substr
    // dan diubah ke integer dengan (int)
    $urutan = (int) substr($kode, 3, 5);
    
    // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
    $urutan++;
    
    // membentuk kode barang baru
    // perintah sprintf("%03s", $urutan); berguna untuk membuat string menjadi 3 karakter
    // misalnya perintah sprintf("%03s", 15); maka akan menghasilkan '015'
    // angka yang diambil tadi digabungkan dengan kode huruf yang kita inginkan, misalnya BRG 
    $huruf = $unik;
    $kode = $huruf . sprintf("%05s", $urutan);
    return $kode;
  }

  public function generatePelangganId(){
    $unik = 'P'.date('y');
    $kode = $this->db->query("SELECT MAX(id_pelanggan) LAST_NO FROM tb_pelanggan WHERE id_pelanggan LIKE '".$unik."%'")->row()->LAST_NO;
    // mengambil angka dari kode barang terbesar, menggunakan fungsi substr
    // dan diubah ke integer dengan (int)
    $urutan = (int) substr($kode, 3, 5);
    
    // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
    $urutan++;
    
    // membentuk kode barang baru
    // perintah sprintf("%03s", $urutan); berguna untuk membuat string menjadi 3 karakter
    // misalnya perintah sprintf("%03s", 15); maka akan menghasilkan '015'
    // angka yang diambil tadi digabungkan dengan kode huruf yang kita inginkan, misalnya BRG 
    $huruf = $unik;
    $kode = $huruf . sprintf("%05s", $urutan);
    return $kode;
  }

  public function signUp(){
    $this->load->library('form_validation');
    $this->form_validation->set_rules('nm_pelanggan', 'Nama', 'required');
    $this->form_validation->set_rules('alamat_pelanggan', 'Alamat', 'required');
    $this->form_validation->set_rules('no_pelanggan', 'No Telphone', 'required|numeric');
    $this->form_validation->set_rules('username', 'Username', 'required|is_unique[tb_user.username]');
    $this->form_validation->set_rules('password', 'Password', 'required');

    if($this->form_validation->run() == FALSE){
      // echo validation_errors();
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $id_user = $this->generateUserId();

    $dataUser = array(
              "id_user" => $id_user,
              "username" => $this->input->post('username'),
              "password" => $this->input->post('password'),
              "nm_pengguna" => $this->input->post('nm_pelanggan'),
              "level" => "PELANGGAN",
            );
    $this->db->insert('tb_user', $dataUser);

    $id_pelanggan = $this->generatePelangganId();

    $data = array(
              "id_pelanggan" => $id_pelanggan,
              "id_user" => $id_user,
              "nm_pelanggan" => $this->input->post('nm_pelanggan'),
              "no_pelanggan" => $this->input->post('no_pelanggan'),
              "alamat_pelanggan" => $this->input->post('alamat_pelanggan'),
            );
    $this->db->insert('tb_pelanggan', $data);

    $output = array("status" => "success", "message" => "Data Berhasil Disimpan");
    echo json_encode($output);
  }

}