<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends CI_Controller {

  public function __construct(){
    parent::__construct();
  }

  public function index(){
    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/pelanggan');
    $this->load->view('template/footer');
  }

  public function getAllData(){        
    $data['data'] = $this->db->query("SELECT A.id_pelanggan, B.id_user, A.nm_pelanggan, A.alamat_pelanggan,
    A.no_pelanggan, B.username, B.password FROM tb_pelanggan A
    INNER JOIN tb_user B ON A.id_user=B.id_user
    WHERE B.`level`='PELANGGAN'
    ORDER BY A.nm_pelanggan")->result(); 

  	echo json_encode($data);
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

  public function saveData(){
    
    $this->load->library('form_validation');
    $this->form_validation->set_rules('nm_pelanggan', 'Nama', 'required');
    $this->form_validation->set_rules('no_pelanggan', 'Telphone', 'required|numeric');
    $this->form_validation->set_rules('alamat_pelanggan', 'Alamat', 'required');

    $this->form_validation->set_rules('username', 'Username', 'required|is_unique[tb_user.username]');
    $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

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
              "nm_pelanggan" => $this->input->post('nm_pelanggan'),
              "no_pelanggan" => $this->input->post('no_pelanggan'),
              "alamat_pelanggan" => $this->input->post('alamat_pelanggan'),
              "id_user" => $id_user,
            );
    $this->db->insert('tb_pelanggan', $data);
    $output = array("status" => "success", "message" => "Data Berhasil Disimpan ID: ".$id_pelanggan);
    echo json_encode($output);

  }

  public function updateData(){
    
    $this->load->library('form_validation');
    $this->form_validation->set_rules('nm_pelanggan', 'Nama', 'required');
    $this->form_validation->set_rules('no_pelanggan', 'Telphone', 'required|numeric');
    $this->form_validation->set_rules('alamat_pelanggan', 'Alamat', 'required');

    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

    if($this->form_validation->run() == FALSE){
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $dataUser = array(
      "username" => $this->input->post('username'),
      "password" => $this->input->post('password'),
      "nm_pengguna" => $this->input->post('nm_pelanggan'),
      "level" => "PELANGGAN",
    );

    $this->db->where('id_user', $this->input->post('id_user'));
    $this->db->update('tb_user', $dataUser);
    
    $data = array(
        "nm_pelanggan" => $this->input->post('nm_pelanggan'),
        "no_pelanggan" => $this->input->post('no_pelanggan'),
        "alamat_pelanggan" => $this->input->post('alamat_pelanggan'),
      );

    $this->db->where('id_pelanggan', $this->input->post('id_pelanggan'));
    $this->db->update('tb_pelanggan', $data);
    if($this->db->error()['message'] != ""){
      $output = array("status" => "error", "message" => $this->db->error()['message']);
      echo json_encode($output);
      return false;
    }
    $output = array("status" => "success", "message" => "Data Berhasil di Update");
    echo json_encode($output);

  }

  public function deleteData(){

    $id_user = $this->db->query("SELECT id_user FROM tb_pelanggan 
                            WHERE id_pelanggan='".$this->input->post('id_pelanggan')."' 
                            LIMIT 1")->row()->id_user;

    $this->db->where('id_pelanggan', $this->input->post('id_pelanggan'));
    $this->db->delete('tb_pelanggan');

    $this->db->where('id_user', $id_user);
    $this->db->delete('tb_user');

    $output = array("status" => "success", "message" => "Data Berhasil di Hapus");
    echo json_encode($output);
  }



}