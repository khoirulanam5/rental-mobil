<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url('/assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('/assets/adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css'); ?>">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="content-wrapper">  
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-8">
          <div class="card" style="margin-top: 1rem">
            <div class="card-header">
              <h3 class="card-title">Halaman Profile</h3>
            </div>
            <!-- /.card-header -->
            <?php if ($this->session->flashdata('pesan')): ?>
                                <div class="">
                                    <?= $this->session->flashdata('pesan'); ?>
                                </div>
                                <?php $this->session->unset_userdata('pesan'); ?> <!-- Hapus Flashdata -->
                            <?php endif; ?>
            <div class="card-body">
            <form action="<?= base_url('profile/update/'.$val->id_user) ?>" method="POST">

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="username" value="<?= $val->username ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Password Baru</label>
                    <input type="text" class="form-control" name="password" id="password" value="<?= $val->password ?>" required>
                </div>

                <div class="mb-3">
                    <label for="nm_pengguna" class="form-label">Nama Pengguna</label>
                    <input type="text" class="form-control" name="nm_pengguna" id="nm_pengguna" value="<?= $val->nm_pengguna ?>" required>
                </div>

                <button type="submit" class="btn btn-primary">Update Profil</button>
            </form>
        </div>
    </div>
</div>
        </div>
    </div>
</div>

</body>
</html>
