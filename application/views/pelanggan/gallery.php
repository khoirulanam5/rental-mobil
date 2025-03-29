<!-- HEAD -->
<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('<?= base_url('/assets/front/images/') ?>rental.jpg');" data-stellar-background-ratio="0.5">
  <div class="overlay"></div>
  <div class="container">
    <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
      <div class="col-md-9 ftco-animate pb-5">
        <p class="breadcrumbs"><span class="mr-2"><a href="<?= base_url() ?>">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Tentang Kami <i class="ion-ios-arrow-forward"></i></span></p>
        <h1 class="mb-3 bread">Pilih Mobil keinginan Anda</h1>
      </div>
    </div>
  </div>
</section>
<!-- ENDHEAD -->
  
<!-- CONTENT -->
<section class="ftco-section">
  <div class="container">
  <div class="row justify-content-center">
      <?php
        $data = $this->db->query("SELECT b.id_mobil_sewa, a.id_jenis_mobil, a.nm_jenis_mobil,  
        b.foto, b.deskripsi FROM tb_jenis_mobil a
        INNER JOIN tb_mobil_sewa b ON a.id_jenis_mobil = b.id_jenis_mobil")->result();        
        foreach($data as $row){
      ?>
        <div class="col-md-3">
          <div class="car-wrap ftco-animate">
            <div class="img d-flex align-items-end" style="background-image: url('<?= base_url('/assets/images/'.$row->foto) ?>');">
            </div>
            <div class="text p-4 text-center">
              <span><a href="<?= base_url("front/detail/".$row->id_mobil_sewa)?>">Lihat Detail<br><?= $row->nm_jenis_mobil ?></a></span>
            </div>
          </div>
        </div>
      <?php
        }
      ?>
    </div>
  </div>
</section>
<!-- END CONTENT -->