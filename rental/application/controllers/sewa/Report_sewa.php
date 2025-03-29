<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_sewa extends CI_Controller {

  public function __construct(){
    parent::__construct();
  }

  public function kepuasan(){
    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/report_kepuasan');
    $this->load->view('template/footer');
  }

  public function pelanggan(){
    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/report_pelanggan');
    $this->load->view('template/footer');
  }

  public function penyewaan(){
    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/sewa/report_sewa');
    $this->load->view('template/footer');
  }

  public function kepuasanPeriod(){
    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/report_kepuasan_period');
    $this->load->view('template/footer');
  }

  public function getPenyewaan() {
    $startDate = $this->input->post('start_date');
    $endDate = $this->input->post('end_date');

    $data['data'] = $this->db->query("
        SELECT 
            A.id_penyewaan, 
            A.id_ketersediaan, 
            B.tujuan, 
            DATE_FORMAT(A.tgl_penyewaan, '%d %b %Y %H:%i') AS tgl_penyewaan,   
            C.nm_pelanggan, 
            DATE_FORMAT(A.tgl_pembelian, '%d %b %Y %H:%i') AS tgl_pembelian, 
            B.harga, 
            A.jumlah_sewa, 
            DATE_FORMAT(A.tgl_pengembalian, '%d %b %Y %H:%i') AS tgl_pengembalian,
            A.total_pembayaran AS nominal,
            A.jenis_penyewaan 
        FROM 
            tb_penyewaan A
        INNER JOIN 
            tb_ketersediaan B ON A.id_ketersediaan = B.id_ketersediaan 
        INNER JOIN 
            tb_pelanggan C ON A.id_pelanggan = C.id_pelanggan
        WHERE
            A.tgl_pembelian >= '".$startDate."'
            AND A.tgl_pembelian < DATE(DATE_ADD('".$endDate."', INTERVAL 1 DAY))
        ORDER BY 
            A.tgl_penyewaan, A.tgl_pengembalian, A.tgl_pembelian
    ")->result_array();

    echo json_encode($data);
  }

  public function ctkPelanggan(){
    $data['data'] = $this->db->query("SELECT * FROM tb_pelanggan ORDER BY nm_pelanggan")->result_array();
    $html = $this->load->view('print/ctkPelanggan',$data);
  }

  public function ctkPenyewaan() {
    $startDate = $this->input->post('start_date');
    $endDate = $this->input->post('end_date');

    $data['data'] = $this->db->query("
        SELECT 
            A.id_penyewaan, 
            A.id_ketersediaan, 
            B.tujuan, 
            DATE_FORMAT(A.tgl_penyewaan, '%d %b %Y %H:%i') AS tgl_penyewaan,
            DATE_FORMAT(A.tgl_pengembalian, '%d %b %Y %H:%i') AS tgl_pengembalian,
            C.nm_pelanggan, 
            DATE_FORMAT(A.tgl_pembelian, '%d %b %Y %H:%i') AS tgl_pembelian, 
            B.harga, 
            A.jumlah_sewa, 
            A.total_pembayaran AS nominal,
            A.jenis_penyewaan 
        FROM 
            tb_penyewaan A
        INNER JOIN 
            tb_ketersediaan B ON A.id_ketersediaan = B.id_ketersediaan 
        INNER JOIN 
            tb_pelanggan C ON A.id_pelanggan = C.id_pelanggan
        WHERE
            A.tgl_pembelian >= '".$startDate."'
            AND A.tgl_pembelian <= DATE(DATE_ADD('".$endDate."', INTERVAL 1 DAY))
        ORDER BY 
            A.tgl_penyewaan, A.tgl_pembelian
    ")->result_array();

    $data['period_start'] = $startDate;
    $data['period_end'] = $endDate;
    $this->load->view('print/ctkSewa',$data);
  }
}