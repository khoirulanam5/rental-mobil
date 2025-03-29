<style>
    .btn {
              /* Menggunakan background gradient dari atas ke bawah dan background-size */
              background-image: linear-gradient(180deg, black 50%, transparent 50%);
              background-size: 200% 200%;
              background-position: bottom;
              /* Transisi halus pada background-position */
              transition: background-position 0.3s;
          }
          /* Efek ketika hover */
          .btn:hover {
              /* Menggeser background untuk memunculkan warna dari bawah */
              background-position: top;
          }
  </style>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/templatemag/flaticon/flaticon.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="<?= base_url('/assets/adminlte/plugins/flatpickr/flatpickr.css'); ?>">
<div class="hero-wrap" style="background-image: url('<?= base_url('/assets/front/images/') ?>rental.jpg ');" data-stellar-background-ratio="0.5">
<div class="overlay"></div>

    <!-- cek jadwal keberangkatan -->
    <div class="container">
      <div class="row no-gutters  justify-content-start align-items-center" style="padding-top: 100px;">
        <div class="col-lg-12 col-md-12">
          <div class="row">
            <div class="col-md-3" style="background-color: #0C2F91;padding: 20px;">
              <div class="d-flex flex-md-column list-group" id="list-tab" role="tablist">
                <a class="list-group-item active" id="list-ticket-list" data-toggle="list" href="#list-ticket" role="tab" aria-controls="ticket" aria-selected="false">
                  <i class="fas fa-ticket-alt"></i>
                  <span style="font-size:14px;">Ketersediaan Mobil</span>
                </a>
              </div>
            </div>
            <div class="col-md-9" style="background-color: #fff;padding: 20px;">
              <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade bordered show active" id="list-ticket" role="tabpanel" aria-labelledby="list-ticket-list">
                  <form >
                    <div class="d-md-flex mt-2">
                      <div class="form-group col-12 col-md-4">
                        <label for="" class="label">Tipe</label>
                        <input name="tipe_sewa" class="form-control" value="SEWA MOBIL" readonly>
                      </div>
                      <div class="form-group col-12 col-md-4">
                        <label for="" class="label">Tanggal Penyewaa</label>
                        <input type="text" class="form-control date" name="tgl" onChange="ISI_TANGGAL()" placeholder="Masukan Tanggal">
                      </div>
                      <div class="form-group col-12 col-md-4">
                        <label for="" class="label">ID Kategori</label>
                        <select class="form-control select2" name="tujuan" ></select>
                      </div>
                    </div>
                    <div class="d-md-flex">
                      <div class="form-group col-12 col-md-12" style="text-align: right;">
                        <button type="button" id="btnCekAntarKota" class="btn btn-info py-3 px-4"><i class="fas fa-search"></i> Cek Jadwal</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- info jadwal -->
  <section class="ftco-section ftco-cart" id="colData" style="display:none;">
    <div class="container">
      <div class="row">
        <div class="col-md-12 ftco-animate">
          <div class="car-list">
            <table class="table">
              <thead class="thead-primary">
                <tr class="text-center">
                  <th>&nbsp;</th>
                  <th class="bg-primary heading">Tanggal</th>
                  <th class="bg-dark heading">Harga Penyewaan / Hari</th>
                  <th class="bg-black heading">Jumlah Mobil</th>
                </tr>
              </thead>
              <tbody id="tbData">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>

    <!-- footer -->
    <section class="ftco-section services-section ftco-no-pt ftco-no-pb">
    <div class="container">
      <div class="row justify-content-center mb-5">
        <div class="col-md-12 heading-section text-center ftco-animate mb-5">
          <span class="subheading">Layanan</span>
          <h2 class="mb-2">Layanan Kami</h2>
        </div>
      </div>
      <div class="row d-flex">
        <div class="col-md-3 d-flex align-self-stretch ftco-animate">
          <div class="media block-6 services">
            <div class="media-body py-md-4">
              <div class="d-flex mb-3 align-items-center">
                <div class="icon"><span class="flaticon-customer-support"></span></div>
                <h3 class="heading mb-0 pl-3">Layanan 24/7</h3>
              </div>
            </div>
          </div>      
        </div>
        <div class="col-md-3 d-flex align-self-stretch ftco-animate">
          <div class="media block-6 services">
            <div class="media-body py-md-4">
              <div class="d-flex mb-3 align-items-center">
                <div class="icon"><span class="flaticon-route"></span></div>
                <h3 class="heading mb-0 pl-3">Banyak Pilihan Mobil</h3>
              </div>
            </div>
          </div>      
        </div>
        <div class="col-md-3 d-flex align-self-stretch ftco-animate">
          <div class="media block-6 services">
            <div class="media-body py-md-4">
              <div class="d-flex mb-3 align-items-center">
                <div class="icon"><span class="flaticon-rent"></span></div>
                <h3 class="heading mb-0 pl-3">Sewa Mobil</h3>
              </div>
            </div>
          </div>      
        </div>
        <div class="col-md-3 d-flex align-self-stretch ftco-animate">
          <div class="media block-6 services">
            <div class="media-body py-md-4">
              <div class="d-flex mb-3 align-items-center">
              <div class="icon"><span class="fas fa-shield-alt"></span></div>
                <h3 class="heading mb-0 pl-3">Asuransi Perjalanan</h3>
              </div>
            </div>
          </div>      
        </div>
      </div>
    </div>
  </section>

    <!-- footer -->
    <section class="ftco-section services-section ftco-no-pt ftco-no-pb">
    <div class="container">
      <div class="row justify-content-center mb-5">
        <div class="col-md-12 heading-section text-center ftco-animate mb-5">
          <span class="subheading">Fasilitas</span>
          <h2 class="mb-2">Fasilitas Kami</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3">
          <div class="car-wrap ftco-animate text-center" style="padding: 30px;">
          <div class="icon mb-3"><i class="fas fa-snowflake"></i></div> <!-- Pendingin Ruangan -->
            <h5 class="mb-0">Pendingin Ruangan</h5>
          </div>
        </div>
        <div class="col-md-3">
          <div class="car-wrap ftco-animate text-center" style="padding: 30px;">
          <div class="icon mb-3"><i class="fas fa-map-marker-alt"></i></div> <!-- GPS Navigasi -->
            <h5 class="mb-0">GPS Navigasi</h5>
          </div>
        </div>
        <div class="col-md-3">
          <div class="car-wrap ftco-animate text-center" style="padding: 30px;">
          <div class="icon mb-3"><i class="fas fa-tv"></i></div> <!-- LCD TV -->
            <h5 class="mb-0">LCD TV</h5>
          </div>
        </div>
        <div class="col-md-3">
          <div class="car-wrap ftco-animate text-center" style="padding: 30px;">
          <div class="icon mb-3"><i class="fas fa-couch"></i></div> <!-- Tempat Duduk Nyaman -->
            <h5 class="mb-0">Tempat Duduk Nyaman</h5>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="ftco-section services-section img" style="background-image: url(<?= base_url('/assets/front/images/') ?>rental.jpg);">
    <div class="overlay"></div>
    <div class="container">
      <div class="row justify-content-center mb-5">
        <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
          <span class="subheading">Penyewaan</span>
          <h2 class="mb-3">Alur Penyewaan Mobil</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3 d-flex align-self-stretch ftco-animate">
          <div class="media block-6 services services-2">
            <div class="media-body py-md-4 text-center">
              <div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-route"></span></div>
              <h3>Pilih Tanggal Penyewaan</h3>
            </div>
          </div>      
        </div>
        <div class="col-md-3 d-flex align-self-stretch ftco-animate">
          <div class="media block-6 services services-2">
            <div class="media-body py-md-4 text-center">
              <div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-select"></span></div>
              <h3>Pilih Jenis Mobil</h3>
            </div>
          </div>      
        </div>
        <div class="col-md-3 d-flex align-self-stretch ftco-animate">
          <div class="media block-6 services services-2">
            <div class="media-body py-md-4 text-center">
              <div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-rent"></span></div>
              <h3>Isi Form Penyewaan</h3>
            </div>
          </div>      
        </div>
        <div class="col-md-3 d-flex align-self-stretch ftco-animate">
          <div class="media block-6 services services-2">
            <div class="media-body py-md-4 text-center">
              <div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-review"></span></div>
              <h3>Lakukan Pembayaran</h3>
            </div>
          </div>      
        </div>
      </div>
    </div>
  </section>

  <section class="ftco-section ftco-no-pt ftco-no-pb">
    <div class="container">
      <div class="row no-gutters">
        <div class="col-md-6 p-md-5 img img-2 d-flex justify-content-center align-items-center" style="background-image: url(<?= base_url('/assets/front/images/') ?>rental.jpg);">
        </div>
        <div class="col-md-6 wrap-about py-md-5 ftco-animate">
          <div class="heading-section mb-5 pl-md-5">
            <span class="subheading">Tentang kami</span>
            <h2 class="mb-4">Pilihan Mobil Terbaik untuk Anda</h2>
            <p>Ingin bepergian dengan nyaman dan aman? Kami menyediakan layanan penyewaan mobil dengan berbagai pilihan kendaraan terbaik untuk memenuhi kebutuhan perjalanan Anda.</p>
            <p>Kami adalah tempat penyewaan mobil terpercaya yang berlokasi di Kota Kudus, Jawa Tengah. Dengan berbagai jenis kendaraan yang nyaman dan berkualitas, kami siap menjadi solusi transportasi terbaik bagi Anda.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- footer -->
<footer class="ftco-footer ftco-bg-dark ftco-section">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
            	<h2 class="ftco-heading-2">Kontak Kami?</h2>
            	<div class="block-23 mb-3">
	              <ul>
	                <li><span class="icon icon-map-marker"></span><span class="text">Desa Honggosoco RT 04 / RW 04, Kecamatan Jekulo, Kabupaten Kudus, Jawa Tengah</span></li>
	                <li><a href="#"><span class="icon icon-phone"></span><span class="text">+XXXXXXXX</span></a></li>
	                <li><a href="#"><span class="icon icon-envelope"></span><span class="text">penyumobil@gmail.com</span></a></li>
	              </ul>
	            </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">
            <p>
              Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Penyu Mobil <i aria-hidden="true"></i>
            </p>
          </div>
        </div>
      </div>
    </footer>
<!-- endfooter -->
<script src="<?= base_url('/assets/front/js/jquery.min.js'); ?>"></script>
<script src="<?= base_url('/assets/adminlte/plugins/flatpickr/flatpickr.js'); ?>"></script>
<!-- endfooter -->

<!-- proses logika -->
<script>
  $(".date").flatpickr({
      dateFormat: "Y-m-d",
  });
  $(document).ready(function (){
      $("#btnCekAntarKota").click(function (){
          $('html, body').animate({
              scrollTop: $("#colData").offset().top
          }, 1500);
          ISI_TABLE()
          $("#colData").css("display","")
      });
  });

  function ISI_TANGGAL(){
    $.ajax({
      url: "<?= site_url('front/getJadwal') ?>",
      type: "POST",
      data: {
        tgl: $("[name='tgl']").val(),
        tipe_sewa: $("[name='tipe_sewa']").val(),
      },
      dataType: "JSON",
      success: function(data){
        var row = "<option></option>"
        $.map( data['data'], function( val, i ) {
          row += "<option value='"+val.tujuan+"'>"+val.tujuan+"</option>"
        });
        $("[name='tujuan']").html(row)
      }
    })
  }

  function ISI_TABLE(){
    $.ajax({
      url: "<?= site_url('front/getKetersediaan') ?>",
      type: "POST",
      dataType: "HTML",
      data:{
        tgl: $("[name='tgl']").val(),
        tujuan: $("[name='tujuan']").val(),
        tipe_sewa: $("[name='tipe_sewa']").val(),
      },
      success: function(data){
        $("#tbData").html(data)
      }
    })
  }
</script>