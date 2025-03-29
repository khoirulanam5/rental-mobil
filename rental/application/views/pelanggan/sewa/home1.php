<link rel="stylesheet" href="<?= base_url('/assets/adminlte/plugins/flatpickr/flatpickr.css'); ?>">
<div class="hero-wrap" style="background-image: url('<?= base_url('/assets/front/images/') ?>rental.jpg ');" data-stellar-background-ratio="0.5">
<div class="overlay"></div>
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
<!-- sidebar -->
<div class="container">
  <div class="row no-gutters  justify-content-start align-items-center" style="padding-top: 100px;">
    <div class="col-lg-12 col-md-12">
      <div class="row">
        <div class="col-md-3" style="background-color: #0C2F91;padding: 20px;">
          <div class="d-flex flex-md-column list-group" id="list-tab" role="tablist">
            <a class="list-group-item active" id="list-ticket-list" data-toggle="list" href="#list-ticket" role="tab" aria-controls="ticket" aria-selected="false">
              <i class="fas fa-ticket-alt"></i>
              <span style="font-size:14px;">Penyewaan</span>
            </a>
            <a class="list-group-item list-group-item-action" id="bayar" href="<?= base_url('front/history')?>" role="tab" aria-controls="bayar">
              <i class="fas fa-receipt"></i>
              <span style="font-size:14px;">Pembayaran</span>
            </a>
          </div>
        </div>
        <!-- endsidebar -->

        <!-- reservasi tiket -->
        <div class="col-md-9" style="background-color: #fff;padding: 20px;">
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade bordered show active" id="list-ticket" role="tabpanel" aria-labelledby="list-ticket-list">
              <form id="FRM_ORDER" enctype="multipart/form-data">
                <?php
                  $nm_pelanggan = $this->db->query("SELECT nm_pelanggan FROM `tb_pelanggan` 
                  WHERE id_user = '".$this->session->userdata('id_user')."'")->row()->nm_pelanggan;
                  $no_pelanggan = $this->db->query("SELECT no_pelanggan FROM `tb_pelanggan` 
                  WHERE id_user = '".$this->session->userdata('id_user')."'")->row()->no_pelanggan;
                ?>
                <div class="d-md-flex">
                  <div class="form-group col-12 col-md-4">
                    <label for="" class="label">Tipe</label>
                    <input name="tipe_sewa" class="form-control" value="SEWA MOBIL" readonly>
                  </div>
                  <div class="form-group col-12 col-md-4">
                    <label for="" class="label">Nama Pelanggan</label>
                    <input type="text" class="form-control" name="nm_pelanggan" value="<?= $nm_pelanggan ?>" >
                  </div>
                  <div class="form-group col-12 col-md-4">
                    <label for="" class="label">No. Telp</label>
                    <input type="text" class="form-control" name="no_pelanggan" value="<?= $no_pelanggan ?>">
                  </div>
                </div>
                <div class="d-md-flex mt-2">
                  <div class="form-group col-12 col-md-6">
                    <label for="" class="label">Tanggal Penyewaan</label>
                    <input type="text" name="tgl" 
                      onChange="ISI_KATEGORI()" class="form-control date" placeholder="Cek Ketersediaan">
                  </div>
                  <div class="form-group col-12 col-md-6">
                    <label for="" class="label">ID Kategori Penyewaan</label>
                    <select class="form-control select2" name="tujuan" onChange="ISI_JENISMOBIL()"></select>
                  </div>
                </div>
                <div class="d-md-flex">
                  <div class="form-group col-12 col-md-6">
                    <label for="" class="label">Jenis Mobil</label>
                    <select class="form-control" name="id_jenis_mobil" onChange="ISI_MOBIL()"></select>
                  </div>
                  <div class="form-group col-12 col-md-6">
                    <label for="" class="label">Kapasitas</label>
                    <select class="form-control" name="id_ketersediaan" onChange="ISI_HARGA()"></select>
                  </div>
                </div>
                <div class="d-md-flex">
                  <div class="form-group col-12 col-md-6">
                    <label for="" class="label">Tanggal Pengembalian</label>
                    <input type="text" class="form-control date" name="tgl_pengembalian" placeholder="Tanggal Pengembalian">
                  </div>
                  <div class="form-group col-12 col-md-6">
                    <label for="" class="label">Jumlah Mobil</label>
                    <input type="text" class="form-control" name="jumlah_sewa" placeholder="Masukan Jumlah Mobil">
                  </div>
                </div>
                <div class="d-md-flex">
                  <div class="form-group col-12 col-md-6">
                    <label for="" class="label">Jumlah Mobil Tersedia</label>
                    <input type="text" class="form-control" name="jumlah_mobil" readonly placeholder="Jumlah Mobil Tersedia">
                  </div>
                  <div class="form-group col-12 col-md-6">
                      <label for="jumlah_hari">Jumlah Hari Penyewaan</label>
                      <input type="text" name="jumlah_hari" class="form-control" readonly>
                  </div>
                </div>
                <div class="d-md-flex">
                  <div class="form-group col-12 col-md-6">
                    <label for="" class="label">Harga Sewa/Hari</label>
                    <input type="text" class="form-control" name="harga" readonly placeholder="Harga Sewa/Hari">
                  </div>
                  <div class="form-group col-12 col-md-6">
                    <label for="" class="label">Total Pembayaran</label>
                    <input type="text" class="form-control" name="nominal" readonly placeholder="Total Pembayaran">
                  </div>
                </div>
                <div class="d-md-flex">
                  <div class="form-group col-12 col-md-6">
                    <label for="" class="label">Jaminan</label>
                    <input type="file" class="form-control" name="jaminan" accept="image/png, image/jpg, image/jpeg" required>
                  </div>
                </div>
                <div class="d-md-flex">
                  <div class="form-group col-12 col-md-12" style="text-align: right;">
                    <button type="button" id="btnOrder" class="btn btn-info py-3 px-4"><i class="fas fa-search"></i> Order Sewa</button>
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
<script src="<?= base_url('/assets/front/js/jquery.min.js'); ?>"></script>
<script src="<?= base_url('/assets/adminlte/plugins/flatpickr/flatpickr.js'); ?>"></script>
<!-- endfooter -->

<!-- proses logika -->
<script>
var timer = null
  timer = setInterval(function() {
    zenziva_api()
  }, 5000);

  function zenziva_api(){
    $.ajax({
      url: "<?= site_url('sewa/front/zenziva_api') ?>",
      type: "POST",
      dataType: "JSON",
      success: function(data){
        console.log(data)
        if(data.status == "selesai"){
          clearInterval(timer);
          timer = null
        }
      }
    })
  }

  $(".date").flatpickr({
      dateFormat: "Y-m-d",
  });

  function ISI_KATEGORI(){
    $.ajax({
      url: "<?= site_url('sewa/penyewaan/getTujuanMobil') ?>",
      type: "POST",
      data: {
        tgl: $("[name='tgl']").val(),
        tipe_sewa: $("[name='tipe_sewa']").val()
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

  function ISI_JENISMOBIL(){
    $.ajax({
      url: "<?= site_url('sewa/penyewaan/getJenisMobil') ?>",
      type: "POST",
      data: {
        tujuan: $("[name='tujuan']").val(),
        tgl: $("[name='tgl']").val()
      },
      dataType: "JSON",
      success: function(data){
        var row = "<option></option>"
        $.map( data['data'], function( val, i ) {
          row += "<option value='"+val.id_jenis_mobil+"'>"+val.nm_jenis_mobil+"</option>"
          
        });
        $("[name='id_jenis_mobil']").html(row)
      }
    })
  }

  function ISI_MOBIL(){
    $.ajax({
      url: "<?= site_url('sewa/penyewaan/getMobil') ?>",
      type: "POST",
      data: {
        tujuan: $("[name='tujuan']").val(),
        id_jenis_mobil: $("[name='id_jenis_mobil']").val(),
        tgl: $("[name='tgl']").val()
      },
      dataType: "JSON",
      success: function(data){
        var row = "<option></option>"
        $.map( data['data'], function( val, i ) {
          row += "<option value='"+val.id_ketersediaan+"'>"+val.kapasitas+"</option>"
          
        });
        $("[name='id_ketersediaan']").html(row)
      }
    })
  }

  function ISI_HARGA() {
    $.ajax({
        url: "<?= site_url('sewa/penyewaan/getHarga') ?>",
        type: "POST",
        data: {
            id_ketersediaan: $("[name='id_ketersediaan']").val()
        },
        dataType: "JSON",
        success: function(data) {
            if (data.data.length > 0) {
                var harga = data.data[0].harga;
                var jumlah_mobil = data.data[0].jumlah_mobil;

                $("[name='harga']").val(harga);
                $("[name='jumlah_mobil']").val(jumlah_mobil);

                // Recalculate total price
                hitungTotalHarga();
            }
        }
    });

    $("[name='jumlah_sewa'], [name='tgl'], [name='tgl_pengembalian']").change(function() {
        hitungTotalHarga();
    });

    $("#btnOrder").click(function(event) {
    event.preventDefault();
    
    // Ambil elemen form
    var form = $("#FRM_ORDER")[0]; 

    // Gunakan FormData untuk menangani file
    var formData = new FormData(form);

    var urlPost = "<?= site_url('sewa/penyewaan/saveDataFront') ?>";
    
    ACTION(urlPost, formData);
});
}

function hitungTotalHarga() {
    var jumlah_sewa = parseInt($("[name='jumlah_sewa']").val());
    var harga_per_hari = parseInt($("[name='harga']").val());
    var tgl = new Date($("[name='tgl']").val());
    var tgl_pengembalian = new Date($("[name='tgl_pengembalian']").val());

    if (!isNaN(jumlah_sewa) && !isNaN(harga_per_hari) && !isNaN(tgl) && !isNaN(tgl_pengembalian)) {
        // Menghitung jumlah hari penyewaan, termasuk hari keberangkatan
        var rentalDays = Math.ceil((tgl_pengembalian - tgl) / (1000 * 60 * 60 * 24)) + 1;
        var totalPrice = jumlah_sewa * harga_per_hari * rentalDays;

        // Set total price
        $("[name='nominal']").val(totalPrice);

        // Set rental days to the form input field
        $("[name='jumlah_hari']").val(rentalDays);

        // Validate the number of buses available
        var jumlah_mobil = parseInt($("[name='jumlah_mobil']").val());
        if (jumlah_pembelian > jumlah_mobil) {
            alert('Penyewaan melampaui Jumlah Mobil Yang Tersedia');
            $("[name='jumlah_sewa']").val(''); // Reset kolom jumlah_pembelian
            $("#btnOrder").attr('disabled', true);
            return;
        }
        $("#btnOrder").attr('disabled', false);
    }
}

function ACTION(urlPost, formData) {
    $.ajax({
        url: urlPost,
        type: "POST",
        data: formData,
        processData: false, // Jangan proses data (karena ini FormData)
        contentType: false, // Jangan set content-type (biarkan FormData menangani)
        dataType: "JSON",
        success: function(data) {
            if (data.status == "success") {
                toastr.info(data.message);
                $('#FRM_ORDER')[0].reset();
            } else {
                toastr.error(data.message);
            }
        },
        error: function(err) {
            console.error(err);
        }
    });
}


$("#FRM_UPLOAD").on('submit', function(event) {
    event.preventDefault();
    let formData = new FormData(this);

    urlPost = "<?= site_url('sewa/pembayaran/saveDataFront') ?>";

    $.ajax({
        url: urlPost,
        type: "POST",
        data: formData,
        processData: false,
        cache: false,
        contentType: false,
        success: function(data) {
            data = JSON.parse(data);
            if (data.status == "success") {
                toastr.info(data.message);
            } else {
                toastr.error(data.message);
            }
        },
        error: function(err) {
            console.log(err);
        }
    });
});
</script>