<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url('/assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/adminlte/plugins/flatpickr/flatpickr.css'); ?>">
<style>
  .flatpickr-day {
    max-width: 33px;
    height: 33px;
  }
</style>

<div class="content-wrapper">  
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card" style="margin-top: 1rem">
            <div class="card-header">
              <h3 class="card-title">Data Ketersediaan</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <button class="btn btn-sm btn-info" style="margin-bottom: 10px;" id="add_data"><i class="fas fa-plus-circle"></i> Tambah</button>
              <table id="tb_data" class="table table-bordered table-hover" style="font-size: 12px">
                <thead>
                <tr>
                  <th>ID Sewa</th>
                  <th>Tipe Penyewaan</th>
                  <th>ID Kategori Penyewaan</th>
                  <th style="min-width: 60px;">Tipe Mobil</th>
                  <th>Jumlah Kursi</th>
                  <th>Tanggal Keberangkatan</th>
                  <th>Maksimal Mobil</th>
                  <th>Harga</th>
                  <th style="min-width: 40px;">Aksi</th>
                </tr>
                </thead>
                <tbody>
                
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
    </div>

    <!-- Modal Add/Edit Data -->
    <div class="modal fade" id="modal_add">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form id="FRM_DATA">
            <div class="modal-header">
              <h4 class="modal-title">Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>ID Kategori Penyewaan</label>
                    <select class="form-control" name="tujuan">
                      <option value="SED2025020001">SED2025020001</option>
                      <option value="MBL2025020002">MBL2025020002</option>
                      <option value="CC2025020003">CC2025020003</option>
                      <option value="MVP2025020004">MPV2025020004</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Tipe</label>
                    <input name="tipe_sewa" class="form-control" value="SEWA MOBIL" readonly>
                  </div>
                </div>
              </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Tipe Mobil</label>
                      <select name="id_jenis_mobil" class="form-control" onChange="ISI_KAPASITAS()"></select>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Kapasitas</label>
                      <select name="id_mobil_sewa" class="form-control" onChange="ISI_MAX()"></select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Tanggal</label>
                      <input type="text" class="form-control datetime" name="tgl" readonly="false">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Harga Sewa / Hari</label>
                      <select type="text" class="form-control" name="harga">
                        <option value="300000">300000</option>
                        <option value="800000">800000</option>
                        <option value="1000000">1000000</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Maksimal Mobil</label>
                      <input type="text" class="form-control" name="jumlah_mobil" readonly>
                    </div>
                  </div>
                </div>
              </div>
            <div class="modal-footer justify-content">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="BTN_SAVE">Save</button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
  </section>
</div>

<!-- jQuery -->
<script src="<?= base_url('/assets/adminlte/plugins/jquery/jquery.min.js'); ?>"></script>
<script src="<?= base_url('/assets/adminlte/plugins/flatpickr/flatpickr.js'); ?>"></script>	
<script>
  var save_method;
  var id_edit;
  var id_user;

  // Initialize date-time picker
  $(".datetime").flatpickr({
      enableTime: true,
      time_24hr: true,
      dateFormat: "Y-m-d H:i:S",
  });	
  
  $(function () {
    // Initialize data on page load
    REFRESH_DATA();
    ISI_SELECT();
    
    // Event Handler for Add Data button
    $("#add_data").click(function(){
      $("#FRM_DATA")[0].reset();
      save_method = "save";
      $("#modal_add .modal-title").text('Add Data');
      $("#modal_add").modal('show');
    });

    // Event Handler for Save Data button
    $("#BTN_SAVE").click(function(){
      event.preventDefault();
      var formData = $("#FRM_DATA").serialize();
      
      if(save_method === 'save') {
          urlPost = "<?= site_url('sewa/ketersediaan/saveData') ?>";
      } else {
          urlPost = "<?= site_url('sewa/ketersediaan/updateData') ?>";
          formData += "&id_ketersediaan=" + id_edit;
      }
      
      // Call AJAX function to handle form submission
      ACTION(urlPost, formData);
      $("#modal_add").modal('hide');
    });
  });

  // Function to populate Jenis Bus dropdown
  function ISI_SELECT(){
    $.ajax({
      url: "<?= site_url('sewa/mobil_sewa/getJenisMobil') ?>",
      type: "GET",
      dataType: "JSON",
      success: function(data){
        var options = "<option></option>";
        $.each(data.data, function(index, value) {
          options += "<option value='" + value.id_jenis_mobil + "'>" + value.nm_jenis_mobil + "</option>";
        });
        $("[name='id_jenis_mobil']").html(options);
      }
    });
  }

  // Function to populate Nomor Polisi dropdown based on Jenis Bus selection
  function ISI_KAPASITAS(){
    $.ajax({
      url: "<?= site_url('sewa/ketersediaan/getIdMobil') ?>",
      type: "POST",
      data: {
        id_jenis_mobil: $("[name='id_jenis_mobil']").val()
      },
      dataType: "JSON",
      success: function(data){
        var options = "<option></option>";
        $.each(data.data, function(index, value) {
          options += "<option value='" + value.id_mobil_sewa + "'>" + value.kapasitas + "</option>";
        });
        $("[name='id_mobil_sewa']").html(options);
      }
    });
  }

  // Function to populate Maksimal Penumpang based on Nomor Polisi selection
  function ISI_MAX(){
    $.ajax({
      url: "<?= site_url('sewa/ketersediaan/getJumlahMobil') ?>",
      type: "POST",
      data: {
        id_mobil_sewa: $("[name='id_mobil_sewa']").val()
      },
      dataType: "JSON",
      success: function(data){
        $("[name='jumlah_mobil']").val(data.data[0]['jumlah_mobil']);
      }
    });
  }

  // Function to refresh DataTable
  function REFRESH_DATA(){
    if ($.fn.DataTable.isDataTable("#tb_data")) {
      $("#tb_data").DataTable().clear().destroy();
    }
    $("#tb_data").DataTable({
      "order": [[ 0, "asc" ]],
      "autoWidth": false,
      "responsive": true,
      "pageLength": 25,
      "ajax": {
          "url": "<?= site_url('sewa/ketersediaan/getAllData') ?>",
          "type": "GET",
          "dataType": "json",
          "dataSrc": "data" // Ensure correct data source
      },
      "columns": [
          { "data": "id_ketersediaan" }, // ID Tiket Bus
          { "data": "tipe_sewa" }, // Tipe Sewa
          { "data": "tujuan" }, // Tujuan
          { "data": "nm_jenis_mobil" }, // Jenis Bus
          { "data": "kapasitas" }, // Waktu Keberangkatan
          { "data": "tgl" }, // Waktu Keberangkatan
          { "data": "jumlah_mobil" }, // Maksimal Penumpang
          { "data": "harga" }, // Harga
          { 
            "data": null, 
            "render": function(data){
              // Dropdown actions for Edit and Delete
              return "<div class='dropdown'>" +
                       "<button class='btn btn-primary btn-sm' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Aksi</button>" +
                       "<div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>" +
                         "<a class='dropdown-item' href='javascript:void(0)' onclick='editData("+ JSON.stringify(data) +");'><i class='fas fa-edit'></i> Edit</a>" +
                         "<a class='dropdown-item' href='javascript:void(0)' onclick='deleteData(\""+ data.id_ketersediaan +"\");'><i class='fas fa-trash'></i> Delete</a>" +
                       "</div>" +
                     "</div>";
            },
            "className": "text-center"
          },
      ]
    });
  }

  // Function to handle Add/Edit Data actions
  function ACTION(urlPost, formData){
    $.ajax({
      url: urlPost,
      type: "POST",
      data: formData,
      dataType: "JSON",
      beforeSend: function () {
        $("#LOADER").show();
      },
      complete: function () {
        $("#LOADER").hide();
      },
      success: function(data){
        if (data.status === "success") {
          toastr.info(data.message);
          REFRESH_DATA(); // Refresh DataTable after successful action
        } else {
          toastr.error(data.message);
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        toastr.error('Error: ' + textStatus + ' - ' + errorThrown);
      }
    });
  }

  // Function to populate modal with Edit Data
  function editData(data){
    save_method = "edit";
    id_edit = data.id_ketersediaan;

    $("#modal_add .modal-title").text('Edit Data');
    $("[name='id_jenis_mobil']").val(data.id_jenis_mobil).change();
    setTimeout(function() {
      $("[name='id_mobil_sewa']").val(data.id_mobil_sewa).change();
    }, 1000);
    $("[name='jumlah_mobil']").val(data.jumlah_mobil);
    $("[name='tujuan']").val(data.tujuan);
    $("[name='tgl']").val(data.tgl);
    $("[name='harga']").val(data.harga);
    $("[name='tipe_sewa']").val(data.tipe_sewa);
    
    $("#modal_add").modal('show');
  }

  // Function to delete data
  function deleteData(id){
    if(!confirm('Hapus data ini?')) return;

    urlPost = "<?= site_url('sewa/ketersediaan/deleteData') ?>";
    formData = "id_ketersediaan=" + id;
    ACTION(urlPost, formData);
  }

  // Function to ensure only numbers are entered in input fields
  function onlyNumberKey(evt) {
    var ASCIICode = (evt.which) ? evt.which : evt.keyCode;
    if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)) {
        return false;
    }
    return true;
  }
</script>

