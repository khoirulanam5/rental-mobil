<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url('/assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css'); ?>">
<style>
  .form-control{
    font-size: 12px;
    height: unset!important;
  }
</style>
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
<!-- head -->
<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('<?= base_url('/assets/front/images/') ?>rental.jpg');" data-stellar-background-ratio="0.5">
  <div class="overlay"></div>
  <div class="container">
    <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
      <div class="col-md-9 ftco-animate pb-5">
        <p class="breadcrumbs"><span class="mr-2"><a href="<?= base_url('front') ?>">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>History Sewa<i class="ion-ios-arrow-forward"></i></span></p>
        <h1 class="mb-3 bread">History Penyewaan Mobil</h1>
      </div>
    </div>
  </div>
</section>
<!-- endhead -->
  
<!-- tabel -->
<section class="ftco-section">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <table class="table table-bordered" id="tb_history" style="font-size:12px;min-width:800px!important;width:100%;">
          <thead>
            <tr>
              <th style="width:70px;">ID</th>
              <th>No.<br>Sewa</th>
              <!-- <th>Tanggal<br>Pembelian</th> -->
              <th>Tanggal<br>Penyewaan</th>
              <th>Tanggal<br>Pengembalian</th>
              <th>Jumlah Mobil<br>Disewa</th>
              <th>Tipe Mobil</th>
              <th style="width:50px;">Total<br>Bayar</th>
              <th>Jaminan</th>
              <th>Status<br>Pembayaran</th>
              <th>Perpanjang</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
<!-- endtabel -->

<!-- tabel content -->
  <div class="modal fade" id="modal_add">
    <div class="modal-dialog ">
      <div class="modal-content">
      <form id="FRM_UPLOAD" method="POST" enctype="multipart/form-data">
        <div class="modal-header">
            <h4 class="modal-title">Data</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="d-md-flex mt-2">
                <div class="form-group col-6 col-md-6">
                    <label for="" class="label">Nomor Sewa</label>
                    <input type="text" class="form-control" name="id_penyewaan" readonly>
                </div>
                <div class="form-group col-6 col-md-6">
                    <label for="" class="label">Bukti Pembayaran</label>
                    <input type="file" class="form-control" name="bukti_pembayaran" accept="image/png, image/gif, image/jpeg" required>
                </div>
            </div>
            <div class="d-md-flex mt-2">
                <div class="form-group col-6 col-md-6">
                    <label for="" class="label">Jumlah Pembayaran</label>
                    <input type="text" class="form-control" name="total_pembayaran" readonly>
                </div>
            </div>
            <div class="d-md-flex mt-2">
                <div class="form-group col-12">
                    <label for="" class="label">Jenis Pembayaran</label><br>
                    <input type="radio" id="dp" name="jenis_pembayaran" value="dp">
                    <label for="dp">DP</label><br>
                    <input type="radio" id="lunas" name="jenis_pembayaran" value="lunas">
                    <label for="lunas">Lunas</label>
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
            <button type="submit" class="btn btn-info" id="BTN_SAVE">Kirim</button>
        </div>
    </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <div class="modal fade" id="extendRentalModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Perpanjang Masa Sewa</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="extendRentalForm">
                    <input type="hidden" id="rental_id" name="id_penyewaan">
                    <div class="form-group">
                        <label for="new_return_date">Tanggal Pengembalian Baru</label>
                        <input type="datetime-local" class="form-control" id="new_return_date" name="tgl_pengembalian" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>


</section>
<script src="<?= base_url('/assets/front/js/jquery.min.js'); ?>"></script>
<!-- DataTables  & Plugins -->
<script src="<?= base_url('/assets/adminlte/plugins/datatables/jquery.dataTables.min.js');?>"></script>
<script src="<?= base_url('/assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js');?>"></script>
<script src="<?= base_url('/assets/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js');?>"></script>
<script src="<?= base_url('/assets/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js');?>"></script>

<!-- proses logika -->
<script>

  REFRESH_DATA()

  function REFRESH_DATA(){
    $('#tb_history').DataTable().destroy();
    var tb_data = $("#tb_history").DataTable({
      "order": [[ 0, "desc" ]],
      "autoWidth": false,
      "responsive": true,
      "pageLength": 10,
      "ajax": {
          "url": "<?= site_url('sewa/penyewaan/getHistory') ?>",
          "type": "GET"
      },
      "columns": [
          { "data": "id_penyewaan", className: "text-center" },
          { "data": "id_ketersediaan", className: "text-center" },
          // { "data": "tgl_pembelian", className: "text-center" },
          { "data": "tgl_penyewaan", className: "text-center" },
          { "data": "tgl_pengembalian", className: "text-center" },
          { "data": "jumlah_sewa", className: "text-center" },
          { "data": null,
            "render" : function(data){
              return data.nm_jenis_mobil
            },
            className: "text-center" 
          },
          { "data": "total_pembayaran", className: "text-center" },
          { 
            "data": "jaminan", 
            "className": "text-center",
            "render": function(data) {
                if (data) {
                    var imgUrl = "<?= base_url('assets/images/jaminan/') ?>" + data;
                    return `<a href="${imgUrl}" target="_blank">
                                <img src="${imgUrl}" width="100" height="100" class="img-thumbnail" />
                            </a>`;
                } else {
                    return "<span class='text-muted'>No Image</span>";
                }
            }
          },
          { 
            "data": null, 
            "render": function(data) {
              var row;
              if (!data.status_validasi) {
                row = "<button class='btn btn-sm btn-info' onclick='editData("+JSON.stringify(data)+");'><i class='fas fa-upload'></i> Bukti DP</button>";
              } else if (data.status_validasi === 'DP_UPLOAD') {
                row = "<span class='text-success'>DP Sukses</span><br><button class='btn btn-sm btn-info' onclick='editData("+JSON.stringify(data)+");'><i class='fas fa-upload'></i> Bukti Lunas</button>";
              } else if (data.status_validasi === 'LUNAS_UPLOAD') {
                row = "<span class='text-success'>Pembayaran Lunas</span>";
              } else if (data.status_validasi === 'LUNAS_VALIDATED') {
                row = "<span class='text-success'>Pembayaran Tervalidasi</span>"
              }
              return row;
            },
            className: "text-center" 
          },
          {
              "data": null,
              "render": function(data) {
                  return `<button class="btn btn-sm btn-warning" onclick='openExtendModal(${JSON.stringify(data)})'><i class='fas fa-edit'></i> Perpanjang</button>`;
              },
              "className": "text-center"
          }
      ]
    })
}

function openExtendModal(data) {
    $('#rental_id').val(data.id_penyewaan);
    $('#new_return_date').val(data.tgl_pengembalian);
    $('#extendRentalModal').modal('show');
}

// Fungsi untuk menghitung tambahan harga berdasarkan selisih tanggal pengembalian lama dan baru
function hitungTotalHarga() {
    var harga_per_hari = parseInt($("[name='harga']").val()) || 0;
    var tgl_pengembalian_lama = new Date($("[name='tgl_pengembalian_lama']").val());
    var tgl_pengembalian_baru = new Date($("[name='tgl_pengembalian']").val());

    if (!isNaN(tgl_pengembalian_lama) && !isNaN(tgl_pengembalian_baru)) {
        // Hitung selisih hari antara tanggal pengembalian lama dan baru
        var tambahanHari = Math.ceil((tgl_pengembalian_baru - tgl_pengembalian_lama) / (1000 * 60 * 60 * 24));

        if (tambahanHari > 0) {
            var tambahanHarga = tambahanHari * harga_per_hari;
            $("[name='nominal']").val(tambahanHarga);
            $("[name='jumlah_hari']").val(tambahanHari);
        } else {
            $("[name='nominal']").val(0);
            $("[name='jumlah_hari']").val(0);
        }
    }
}

// Event listener untuk update harga otomatis saat tanggal pengembalian diubah
$("[name='tgl_pengembalian']").on("change", hitungTotalHarga);

// Submit form perpanjangan sewa dengan AJAX
$('#extendRentalForm').submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: "<?= site_url('sewa/penyewaan/updateReturnDate') ?>",
        type: "POST",
        data: $(this).serialize(),
        success: function(data) {
            data = JSON.parse(data);
            if (data.status === "success") {
                toastr.info(data.message);
                $("#extendRentalModal").modal('hide');
                setTimeout(function() {
                    location.reload(); 
                }, 2000);
            } else {
                toastr.error(data.message);
            }
        },
        error: function(err) {
            console.log(err);
        }
    });
});


  function editData(data, index) {
    console.log(data);
    save_method = "edit";
    id_edit = data.id_penyewaan;

    // Set modal title and input values based on status
    if (data.status_validasi === 'DP_UPLOAD') {
        $("#modal_add .modal-title").text('Upload Bukti Lunas');
        $("input[name='jenis_pembayaran'][value='lunas']").prop('checked', true);
        $("input[name='jenis_pembayaran'][value='dp']").prop('disabled', true);
    } else {
        $("#modal_add .modal-title").text('Upload Bukti Pembayaran');
        $("input[name='jenis_pembayaran'][value='dp']").prop('checked', true);
        $("input[name='jenis_pembayaran']").prop('disabled', false);
    }
    
    $("[name='id_penyewaan']").val(data.id_penyewaan);
    $("[name='total_pembayaran']").val(data.total_pembayaran);
    $("#modal_add").modal('show');
}

$("#FRM_UPLOAD").on('submit', function(event) {
    event.preventDefault();
    
    let formData = new FormData(this);
    
    // Append jenis_pembayaran dari radio button yang dipilih
    let jenisPembayaran = $("input[name='jenis_pembayaran']:checked").val();
    formData.append('jenis_pembayaran', jenisPembayaran);

    $.ajax({
        url: "<?= site_url('sewa/pembayaran/saveDataFront') ?>",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
            data = JSON.parse(data);
            if (data.status === "success") {
                toastr.info(data.message);
                $("#modal_add").modal('hide');
                setTimeout(function() {
                    location.reload(); 
                }, 2000);
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