<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Front extends CI_Controller {

  public function __construct(){
    parent::__construct();
  }

  public function index(){
    
    $this->load->view('pelanggan/header');
    if($this->session->userdata('level') == "pelanggan"){
      $this->load->view('pelanggan/sewa/home1');
    }else{
      $this->load->view('pelanggan/sewa/home');
    }
    $this->load->view('pelanggan/footer');
  }

  public function ketersediaan() {
    $this->load->view('pelanggan/header');
    $this->load->view('pelanggan/sewa/home');
    $this->load->view('pelanggan/footer');
  }

  public function feedback(){
    
    $this->load->view('pelanggan/header');
    $this->load->view('pelanggan/feedback');
    $this->load->view('pelanggan/footer');
  }

  public function gallery(){
    
    $this->load->view('pelanggan/header');
    $this->load->view('pelanggan/gallery');
    $this->load->view('pelanggan/footer');
  }

  public function detail($id){

    $data['data'] = $this->db->query("SELECT b.id_mobil_sewa, a.id_jenis_mobil, a.nm_jenis_mobil, 
    b.foto, b.deskripsi FROM tb_jenis_mobil a
    inner JOIN tb_mobil_sewa b ON a.id_jenis_mobil = b.id_jenis_mobil
    WHERE b.id_mobil_sewa='".$id."'")->result_array();
    
    $this->load->view('pelanggan/header');
    $this->load->view('pelanggan/detail',$data);
    $this->load->view('pelanggan/footer');
  }

  public function history(){
    
    $this->load->view('pelanggan/header');
    $this->load->view('pelanggan/sewa/history');
    $this->load->view('pelanggan/footer');
  }

  public function login(){
    $this->load->view('login');
  }

  public function getJadwal(){
    $data['data'] = $this->db->query("SELECT DISTINCT tujuan from tb_ketersediaan 
    WHERE DATE(tgl) = '".$this->input->post('tgl')."' 
    AND tipe_sewa='".$this->input->post('tipe_sewa')."'")->result(); 

  	echo json_encode($data);
  }

  public function getParameter(){

    $dataIndikator = $this->db->query("
      SELECT id_indikator_kepuasan ,indikator_kepuasan, nilai FROM `tb_indikator_kepuasan` ORDER BY nilai DESC
    ")->result();

    $thIndikator="";
    
    foreach ($dataIndikator as $list) {
      $thIndikator .= "<th>".$list->indikator_kepuasan."</th>";
    }

    $dataParameter = $this->db->query("
      SELECT id_parameter, parameter FROM `tb_parameter` ORDER BY id_parameter
    ")->result(); 

    $no=1;
    $trIndikator="";$i=0;
    foreach ($dataParameter as $row) {
      $td = "";
      
      foreach ($dataIndikator as $list) {
        $td .= "<td><input type='radio' name='".$row->id_parameter."' value='".$list->id_indikator_kepuasan."' ></td>";
        
      }
      $i++;
      $trIndikator .= "<tr>
                          <td>".$no++."</td>
                          <td style='text-align:left;'>".$row->parameter."</td>
                          ".$td."
                      </tr>";
    }

    $html = "<thead>
              <th>No</th>
              <th>Pertanyaan</th>
              ".$thIndikator."
            </thead>
            <tbody>
              ".$trIndikator."
            </tbody>";
    echo $html;
  }

  public function generateId(){
    $unik = date('Ym');
    $kode = $this->db->query("SELECT MAX(id_item_penilaian) LAST_NO FROM tb_item_penilaian WHERE id_item_penilaian LIKE '".$unik."%'")->row()->LAST_NO;
    // mengambil angka dari kode barang terbesar, menggunakan fungsi substr
    // dan diubah ke integer dengan (int)
    $urutan = (int) substr($kode, 6, 5);
    
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
    foreach($this->input->post() as $key => $val)
    {
      if($key != "id_ketersediaan" and $key != "saran"){
        $id = $this->generateId();
      
        $data = array(
                  "id_item_penilaian" => $id,
                  "id_ketersediaan" => $this->input->post('id_ketersediaan'),
                  "id_parameter" => $key,
                  "id_indikator" => $val,
                );

        // Insert into tb_item_penilaian
        $this->db->insert('tb_item_penilaian', $data);
      }
    }

    // Generate id_saran
    $id_saran = $this->generateIdSaran();

    // Data for tb_saran
    $data = array(
      "id_saran" => $id_saran,
      "id_ketersediaan" => $this->input->post('id_ketersediaan'),
      "saran" => $this->input->post('saran'),
    );
    
    // Insert into tb_saran
    $this->db->insert('tb_saran', $data);

    // Output response
    $output = array("status" => "success", "message" => "Data Berhasil Disimpan, Terima Kasih telah meluangkan waktu ");
    echo json_encode($output);
}

// Function to generate id_saran
private function generateIdSaran() {
    // Query to get the last id_saran
    $query = $this->db->select('id_saran')
                      ->order_by('id_saran', 'DESC')
                      ->limit(1)
                      ->get('tb_saran');
    
    // Check if there is any result
    if ($query->num_rows() > 0) {
        // Get the last id_saran
        $last_id = $query->row()->id_saran;
        
        // Extract the numeric part and increment it
        $last_num = (int)substr($last_id, 3) + 1;
        
        // Format the new id_saran
        $new_id = 'SRN' . str_pad($last_num, 6, '0', STR_PAD_LEFT);
    } else {
        // If no rows found, start with SRN000001
        $new_id = 'SRN000001';
    }
    
    return $new_id;
}

  public function getKetersediaan(){
    $data = $this->db->query("
      SELECT B.kapasitas, C.nm_jenis_mobil, A.tujuan, A.tgl, 
      A.harga, A.jumlah_mobil
      from tb_ketersediaan A
      inner join tb_mobil_sewa B ON A.id_mobil_sewa = B.id_mobil_sewa
      INNER JOIN tb_jenis_mobil C ON B.id_jenis_mobil = C.id_jenis_mobil
      WHERE A.tipe_sewa = '".$this->input->post('tipe_sewa')."'
      AND A.tujuan = '".$this->input->post('tujuan')."'
      AND DATE(A.tgl) = '".$this->input->post('tgl')."'
    ")->result();

    $tr="";
    
    foreach ($data as $list) {
      $tr .= '<tr class="">
                <td class="product-name">
                  <h3>Kapasitas: '.$list->kapasitas.'</h3>
                  <p class="mb-0 rated">Jenis: '.$list->nm_jenis_mobil.'</p>
                </td>

                <td class="price">
                  <div class="price-name">
                    <span class="subheading">'.$list->tgl.'</span>
                  </div>
                </td>
                
                <td class="price">
                  <div class="price-name">
                    <h3>
                      <span class="num"><small class="currency" style="left:-25px;">Rp. </small> '.number_format($list->harga,0,',','.').',-</span>
                    </h3>
                  </div>
                </td>

                <td class="price">
                  <div class="price-name">
                    <span class="subheading">'.$list->jumlah_mobil.'</span>
                  </div>
                </td>
              </tr>';
    }

    echo $tr;
  }
}