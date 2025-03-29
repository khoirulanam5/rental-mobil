<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url('/assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/adminlte/plugins/flatpickr/flatpickr.css'); ?>">
<!-- Select2 -->
<link rel="stylesheet" href="<?= base_url('/assets/adminlte/plugins/select2/css/select2.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'); ?>">

<div class="content-wrapper">  
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card" style="margin-top: 1rem">
            <div class="card-header">
              <h3 class="card-title">Data Penyewaan</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="tb_data" class="table table-bordered table-hover" style="font-size: 12px">
                <thead>
                <tr>
                  <th style="width: 25px;">No.</th>
                  <th>ID Sewa</th>
                  <th>Tanggal<br>Pembelian</th>
                  <th>ID Kategori</th>
                  <th>Tanggal<br>Penyewaan</th>
                  <th>Tanggal<br>Pengembalian</th>
                  <th>Jumlah Mobil</th>
                  <th>Jaminan</th>
                  <th style="min-width: 80px;">Aksi</th>
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
                      <label>Tanggal Penyewaan</label>
                      <input type="text" class="form-control date" name="tgl_penyewaan" 
                      onChange="ISI_TUJUAN()" >
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>ID Mobil</label>
                      <select class="form-control" name="tujuan" onChange="ISI_JENIS()"></select>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Nama Mobil</label>
                      <select class="form-control" name="id_jenis_bus" onChange="ISI_MOBIL()"></select>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Ketersediaan</label>
                      <select class="form-control" name="id_ketersediaan" onChange="ISI_HARGA()"></select>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>ID Pelanggan</label>
                      <select class="form-control select2" name="id_pelanggan" onChange="ISI_NM_PELANGGAN()" ></select>
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Nama Pelanggan</label>
                      <input type="text" class="form-control" name="nm_pelanggan">
                    </div>
                  </div>
                </div>

                <div class="row">
                  
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>No. Telpon</label>
                      <input type="text" class="form-control" name="no_pelanggan">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Jumlah Mobil</label>
                      <input type="text" class="form-control" name="jumlah_sewa" >
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group clearfix">
                      <h5 style="display: contents;">Bayar Sekarang? </h5>
                      <div class="icheck-primary d-inline">
                        <input type="checkbox"  id="cbbayar" checked="">
                        <label for="cbbayar">
                          Ya
                        </label>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6" >
                    <div class="form-group">
                      <label>Harga Sewa</label>
                      <input type="text" class="form-control" name="harga" readonly>
                    </div>
                  </div>
                  <div class="col-sm-6"  id="frmBayar">
                    <div class="form-group">
                      <label>Jumlah Pembayaran</label>
                      <input type="text" class="form-control" name="nominal" readonly>
                    </div>
                  </div>
                </div>
                
              </div>
              
            <div class="modal-footer justify-content-between">
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
<!-- Select2 -->
<script src="<?= base_url('/assets/adminlte/plugins/select2/js/select2.full.min.js'); ?>"></script>
<script>
  var save_method;
  var id_edit;
  var id_user;

  $(".datetime").flatpickr({
      enableTime: true,
      time_24hr: true,
      dateFormat: "Y-m-d H:i:S",
  });
  
  $(".date").flatpickr({
      dateFormat: "Y-m-d",
  });

  $('.select2').select2()

  $(function () {
    

    REFRESH_DATA()
    ISI_PELANGGAN()


    $("#add_data").click(function(){
      $("#FRM_DATA")[0].reset()
      save_method = "save"
      $("#modal_add .modal-title").text('Add Data')
      $("#modal_add").modal('show')
    }) 

    $("#cbbayar").change(function(){
      if($("#cbbayar").is(":checked") == true){
        $("#frmBayar").css("display", "")
      }else{
        $("#frmBayar").css("display", "none")
      }
      
    })

    $("#BTN_SAVE").click(function(){
      event.preventDefault();
      var formData = $("#FRM_DATA").serialize();

      
      if(save_method == 'save') {
          urlPost = "<?= site_url('sewa/penyewaan/saveData') ?>";
      }else{
          urlPost = "<?= site_url('sewa/penyewaan/updateData') ?>";
          formData+="&id_penyewaan="+id_edit
      }

      if($("#cbbayar").is(":checked") == true){
        formData+="&bayar=true"
      }
      // console.log(formData)
      ACTION(urlPost, formData)
      $("#modal_add").modal('hide')
    })

  });

  function REFRESH_DATA(){
    $('#tb_data').DataTable().destroy();
    var tb_data = $("#tb_data").DataTable({
      "order": [[ 0, "asc" ]],
      "autoWidth": false,
      "responsive": true,
      "pageLength": 25,
      "ajax": {
          "url": "<?= site_url('sewa/penyewaan/getAllData') ?>",
          "type": "GET"
      },
      "columns": [
          {
              "data": null,
              render: function (data, type, row, meta) {
                  return meta.row + meta.settings._iDisplayStart + 1;
              }
          },
          { "data": "id_penyewaan" },
          { "data": "tgl_pembelian" },
          { "data": "tujuan" },
          { "data": "tgl_penyewaan" },
          { "data": "tgl_pengembalian" },
          { "data": "jumlah_sewa" },
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
          { "data": null, 
            "render" : function(data){
              if(data.jenis_penyewaan == "ONLINE"){
                return "<button class='btn btn-sm btn-warning' onclick='editData("+JSON.stringify(data)+");'><i class='fas fa-edit'></i> Edit</button><br> "+
                "<button class='btn btn-sm btn-danger' onclick='deleteData(\""+data.id_penyewaan+"\");'><i class='fas fa-trash'></i> Delete</button>"
              }else{
                return "<button class='btn btn-sm btn-danger' onclick='deleteData(\""+data.id_penyewaan+"\");'><i class='fas fa-trash'></i> Delete</button>"
              }
              
            },
            className: "text-center"
          },
      ]
    })
  }

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
            // console.log(data)
            if (data.status == "success") {
              toastr.info(data.message)
              

              REFRESH_DATA()

            }else{
              toastr.error(data.message)
            }
          }
      })
  }

  function editData(data, index){
    // console.log(data)
    save_method = "edit"
    id_edit = data.id_penyewaan;

    $.ajax({
      url: "<?= site_url('sewa/penyewaan/getPenyewaanByID') ?>",
      type: "POST",
      data: {
        id_penyewaan: id_edit
      },
      dataType: "JSON",
      success: function(data){
        console.log(data[0])
        $("[name='tgl_penyewaan']").val(data[0].tgl_penyewaan).change()
        setTimeout(() => {
          $("[name='tujuan']").val(data[0].tujuan).change()
        }, 500);

        setTimeout(() => {
          $("[name='id_jenis_mobil']").val(data[0].id_jenis_mobil).change()
        }, 1000);

        setTimeout(() => {
          $("[name='id_ketersediaan']").val(data[0].id_ketersediaan).change()
          $("[name='nm_pelanggan']").val(data[0].nm_pelanggan)
          $("[name='no_pelanggan']").val(data[0].no_pelanggan)
          var nominal = parseInt(data[0].jumlah_sewa) * parseInt($("[name='harga']").val())
          $("[nominal='nominal']").val(nominal)
        }, 1500);

        setTimeout(() => {
          var nominal = parseInt(data[0].jumlah_sewa) * parseInt($("[name='harga']").val())
          console.log(nominal)
          $("[name='nominal']").val(nominal)
        }, 2000);
        
        var $newOption = $("<option selected='selected'></option>").val(data[0].id_pelanggan).text(data[0].nm_pelanggan)
        $("[name='id_pelanggan']").append($newOption).trigger('change');
        
        $("[name='jumlah_sewa']").val(data[0].jumlah_sewa)
        
      }
    })


    $("#modal_add .modal-title").text('Edit Data')
    $("#modal_add").modal('show')
  }

  function deleteData(id){
    if(!confirm('Delete this data?')) return

    urlPost = "<?= site_url('sewa/penyewaan/deleteData') ?>";
    formData = "id_sewa_bus="+id
    ACTION(urlPost, formData)
  }

  function ISI_TUJUAN(){
    $.ajax({
      url: "<?= site_url('sewa/penyewaan/getTujuan') ?>",
      type: "POST",
      data: {
        tgl_penyewaan: $("[name='tgl_penyewaan']").val()
      },
      dataType: "JSON",
      success: function(data){
        // console.log(data)
        var row = "<option></option>"
        $.map( data['data'], function( val, i ) {
          row += "<option value='"+val.tujuan+"'>"+val.tujuan+"</option>"
          
        });
        $("[name='tujuan']").html(row)
      }
    })
    
  }

  function ISI_JENIS(){
    $.ajax({
      url: "<?= site_url('sewa/penyewaan/getJenis') ?>",
      type: "POST",
      data: {
        tujuan: $("[name='tujuan']").val(),
        tgl_penyewaan: $("[name='tgl_penyewaan']").val()
      },
      dataType: "JSON",
      success: function(data){
        // console.log(data)
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
        tgl_penyewaan: $("[name='tgl_penyewaan']").val()
      },
      dataType: "JSON",
      success: function(data){
        // console.log(data)
        var row = "<option></option>"
        $.map( data['data'], function( val, i ) {
          row += "<option value='"+val.id_ketersediaan+"'>"+val.kapasitas+" - "+val.kapasitas+"</option>"
          
        });
        $("[name='id_ketersediaan']").html(row)
      }
    })
  }

  function ISI_PELANGGAN(){
    $.ajax({
      url: "<?= site_url('sewa/penyewaan/getPelanggan') ?>",
      type: "POST",
      dataType: "JSON",
      success: function(data){
        // console.log(data)
        var row = "<option></option>"
        $.map( data['data'], function( val, i ) {
          row += "<option value='"+val.id_pelanggan+"'>"+val.id_pelanggan+" - "+val.nm_pelanggan+"</option>"
          
        });
        $("[name='id_pelanggan']").html(row)
      }
    })
  }

  function ISI_NM_PELANGGAN(){
    $.ajax({
      url: "<?= site_url('sewa/penyewaan/getNamaPelanggan') ?>",
      type: "POST",
      data: {
        id_pelanggan: $("[name='id_pelanggan']").val()
      },
      dataType: "JSON",
      success: function(data){
        // console.log(data)
        $("[name='nm_pelanggan']").val(data['data'][0]['nm_pelanggan'])
        $("[name='no_pelanggan']").val(data['data'][0]['no_pelanggan'])
      }
    })
  }

  function ISI_HARGA(){
    $.ajax({
      url: "<?= site_url('sewa/penyewaan/getHarga') ?>",
      type: "POST",
      data: {
        id_ketersediaan: $("[name='id_ketersediaan']").val()
      },
      dataType: "JSON",
      success: function(data){
        // console.log(data['data'])
        $("[name='harga']").val(data['data'][0]['harga'])
      }
    })
  }

  $("[name='jumlah_sewa']").change(function(){
    var nominal = parseInt($("[name='jumlah_sewa']").val()) * parseInt($("[name='harga']").val())
    $("[name='nominal']").val(nominal)
    
  })
</script>