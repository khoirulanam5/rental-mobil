<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kepuasan extends CI_Controller {

  public function __construct(){
    parent::__construct();
  }

  public function index(){
    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/kepuasan');
    $this->load->view('template/footer');
  }

  public function addKepuasan(){
    $this->load->view('template/header');
    $this->load->view('template/sidebar');
    $this->load->view('pages/addkepuasan');
    $this->load->view('template/footer');
  }

  public function getAllData(){
    $this->db->select('*');
    $this->db->from('tb_penilaian_kepuasan'); 
    $this->db->order_by('id_penilaian','desc');         
    $data['data'] = $this->db->get()->result(); 

    echo json_encode($data);
  }

  public function getTiket(){
    $data['data'] = $this->db->query("
      SELECT id_ketersediaan, tujuan, id_kategori, DATE(A.tgl) tgl FROM `tb_ketersediaan` A
      INNER JOIN tb_mobil_sewa B ON A.id_mobil_sewa = B.id_mobil_sewa
      WHERE A.id_ketersediaan NOT IN(
        SELECT id_ketersediaan FROM tb_penilaian_kepuasan
      )
    ")->result(); 

    echo json_encode($data);
  }

  public function getNilaiKepuasan(){
    $id_ketersediaan = $this->input->post('id_ketersediaan');
    
    $html="";
    $tot_sevqual=0;
    $parameter = $this->db->query("
      SELECT id_parameter FROM tb_parameter ORDER BY id_parameter
    ")->result_array();

    foreach($parameter as $param){
      
      $id_parameter = $param['id_parameter'];

      $indikator = $this->db->query("
        SELECT id_indikator_kepuasan, indikator_kepuasan, nilai FROM tb_indikator_kepuasan ORDER BY id_indikator_kepuasan DESC
      ")->result_array();

      $tr="";
      $total_persepsi=0;
      $tot_frekuensi=0;
      foreach($indikator as $ind){
        $id_indikator = $ind['id_indikator_kepuasan'];
        $indikator_kepuasan = $ind['indikator_kepuasan'];
        $nilai = $ind['nilai'];

        $frekuensi = $this->db->query("
          SELECT COUNT(*) frekuensi FROM tb_item_penilaian WHERE id_ketersediaan IN (
            SELECT id_ketersediaan FROM tb_ketersediaan WHERE id_ketersediaan='".$id_ketersediaan."'
          )
          AND id_parameter='".$id_parameter."' and id_indikator='".$id_indikator."'
        ")->row()->frekuensi;

        $nilai_persepsi = $nilai * $frekuensi;
        $tot_frekuensi = $tot_frekuensi + $frekuensi;
        
        $total_persepsi = $total_persepsi + $nilai_persepsi;

        $tr .= "<tr>
                    <td>".$indikator_kepuasan."</td>
                    <td>".$frekuensi."</td>
                    <td>".$nilai." X ".$frekuensi."</td>
                    <td>".$nilai_persepsi."</td>
                  </tr>
                ";

      }

      $nilai_max = $tot_frekuensi * 5;
      if($nilai_max == 0){
        $sevqual = 0;
      }else{
        $sevqual = ($total_persepsi / $nilai_max) * 100;
      }
      
      $tot_sevqual = $tot_sevqual + $sevqual;

      $html .= "<table border='1'>
                  <thead>
                    <tr>
                      <th>Respon Pelanggan</th>
                      <th>Frekuensi</th>
                      <th>Persepsi</th>
                      <th>Nilai</th>
                    </tr>
                  </thead>
                  <tbody>
                  ".$tr."
                  </tbody>
                  <tfoot>
                    <tr>
                      <td>Total</td>
                      <td>".$tot_frekuensi."</td>
                      <td></td>
                      <td>".$total_persepsi."</td>
                    </tr>
                  </tfoot>
                </table><br>
                Nilai servqual: ".$total_persepsi." / ".$nilai_max." x 100% = ".$sevqual."
                ";
    }

    $jml_pertanyaan = count($parameter);
    $nilai_sevqual = $tot_sevqual / $jml_pertanyaan;

    $dt = $this->db->query("
      SELECT B.id_kategori, A.tujuan, Date(A.tgl) tgl, a.tujuan FROM tb_ketersediaan A
      INNER JOIN tb_mobil_sewa B ON A.id_mobil_sewa = B.id_mobil_sewa
      WHERE A.id_ketersediaan='".$id_ketersediaan."'
    ")->result_array();

    $ket = "<br>Nilai Servqual = ".number_format($nilai_sevqual)."%<br>
            <b>Hasil Penilaian Kepuasan Pelanggan pada ".$dt[0]['id_kategori'].", Tujuan ".$dt[0]['tujuan'].", Tanggal Keberangkatan ".$dt[0]['tgl']." mendapatkan hasil nilai: </b><h3>".number_format($nilai_sevqual)."% dari 100%</h3>";
    $input = "<input type='hidden' name='nilai_sevqual' value='".number_format($nilai_sevqual)."' >";
    echo $html.$ket.$input;

  }

  public function generateId(){
    $unik = "N".date('Ym');
    $query = $this->db->query("SELECT MAX(id_penilaian) LAST_NO FROM tb_penilaian_kepuasan WHERE id_penilaian LIKE '".$unik."%'");
    if ($query->num_rows() > 0) {
        $kode = $query->row()->LAST_NO;
        $urutan = (int) substr($kode, 7, 5);
        $urutan++;
    } else {
        $urutan = 1;  // Jika tidak ada data sebelumnya, mulai dari 1
    }
    $kode = $unik . sprintf("%05s", $urutan);
    return $kode;
  }

  public function saveData(){
    
    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_ketersediaan', 'id ketersediaan', 'required');
    $this->form_validation->set_rules('nilai_kepuasan', 'nilai kepuasan', 'required');

    if($this->form_validation->run() == FALSE){
      $output = array("status" => "error", "message" => validation_errors());
      echo json_encode($output);
      return false;
    }

    $id = $this->generateId();
    
    $data = array(
              "id_penilaian" => $id,
              "id_ketersediaan" => $this->input->post('id_ketersediaan'),
              "nilai_kepuasan"  => $this->input->post('nilai_kepuasan'),
            );

    if ($this->db->insert('tb_penilaian_kepuasan', $data)) {
        $output = array("status" => "success", "message" => "Data Berhasil Disimpan, ID: " . $id);
    } else {
        $error = $this->db->error();  // Pengecekan error dari database
        $output = array("status" => "error", "message" => "Error: " . $error['message']);
    }

    echo json_encode($output);
  }

  public function deleteData(){
    $this->db->where('id_penilaian', $this->input->post('id_penilaian'));
    $this->db->delete('tb_penilaian_kepuasan');

    $output = array("status" => "success", "message" => "Data Berhasil di Hapus");
    echo json_encode($output);
  }
}