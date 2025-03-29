<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

  public function __construct(){
    parent::__construct();
    if(!$this->session->userdata('id_user'))
      redirect('login', 'refresh');
  }

  public function index(){
    $this->db->select('tb_user.*');
    $this->db->from('tb_user');
    $this->db->where('tb_user.id_user', $this->session->userdata('id_user'));
    $data['val'] = $this->db->get()->row();

    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/profile', $data);
    $this->load->view('template/footer');
  }

  public function update($id_user){
    $this->db->set('username', $this->input->post('username'));
    $this->db->set('password', $this->input->post('password'));
    $this->db->set('nm_pengguna', $this->input->post('nm_pengguna'));
    $this->db->where('id_user', $id_user);
    $this->db->update('tb_user');

    $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Berhasil', text:'Update Profile Berhasil', icon:'success'})</script>");
    redirect('profile');
  }
}