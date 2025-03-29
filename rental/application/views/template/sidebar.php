<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Google Font: Roboto -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url('/assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('/assets/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('/assets/adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css'); ?>">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url('/assets/adminlte/plugins/select2/css/select2.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('/assets/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'); ?>">
  <style>
    body {
      font-family: 'Roboto', sans-serif;
    }
    .content-wrapper h3 {
      font-weight: 700;
    }
    .content-wrapper p {
      font-weight: 400;
    }
  </style>
  </head>
<!-- Sidebar Menu -->
<nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="<?= base_url("home")?>" class="nav-link <?php if(strtoupper($this->uri->segment(1))=="HOME" OR $this->uri->segment(1)==""){echo 'active';}?>">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Home
              </p>
            </a>
          </li>

          <!-- HAK AKSES UNTUK SEKERTARIS -->
          <?php if($this->session->userdata('level') == "karyawan"){ ?>
            
            <li class="nav-item">
              <a href="#" class="nav-link <?php if(strtoupper($this->uri->segment(1))=="DATA" OR $this->uri->segment(1)==""){echo 'active';}?>">
                <i class="nav-icon fas fa-table"></i>
                <p>
                  Data Master
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= base_url("pelanggan/")?>" class="nav-link <?php if(strtoupper($this->uri->segment(1))=="pelanggan"){echo 'active';}?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Pelanggan</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url("kategori/")?>" class="nav-link <?php if(strtoupper($this->uri->segment(1))=="kategori"){echo 'active';}?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kategori Mobil</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url("sewa/jenis_mobil/")?>" class="nav-link <?php if(strtoupper($this->uri->segment(1))=="jenis_mobil"){echo 'active';}?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Jenis Mobil</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url("sewa/mobil_sewa/")?>" class="nav-link <?php if(strtoupper($this->uri->segment(1))=="mobil_sewa"){echo 'active';}?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Mobil</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="<?= base_url("sewa/ketersediaan/")?>" class="nav-link <?php if(strtoupper($this->uri->segment(1))=="ketersediaan"){echo 'active';}?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Ketersediaan</p>
                  </a>
                </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Data Transaksi
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="<?= base_url("sewa/penyewaan/")?>" class="nav-link <?php if(strtoupper($this->uri->segment(1))=="penyewaan"){echo 'active';}?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Penyewaan</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url("sewa/pembayaran/")?>" class="nav-link <?php if(strtoupper($this->uri->segment(1))=="pembayaran"){echo 'active';}?>">
          <i class="far fa-circle nav-icon"></i>
          <p>Pembayaran</p>
        </a>
      </li>
    </ul>
  </li>
          <li class="nav-item">
            <a href="<?= base_url("login/logout")?>" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Sign Out
              </p>
            </a>
          </li>
          <!-- END SEKERTARIS -->

          <!-- HAK AKSES UNTUK ADMIN -->
          <?php }elseif($this->session->userdata('level') == "admin"){ ?>

            <li class="nav-item">
                <a href="<?= base_url("user/")?>" class="nav-link <?php if(strtoupper($this->uri->segment(1))=="USER"){echo 'active';}?>">
                  <i class="nav-icon fas fa-user"></i>
                  <p>Data User</p>
                </a>
              </li>

            <li class="nav-item">
              <a href="#" class="nav-link <?php if(strtoupper($this->uri->segment(1))=="DATA" OR $this->uri->segment(1)==""){echo 'active';}?>">
                <i class="nav-icon fas fa-table"></i>
                <p>
                  Data Master
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="<?= base_url("parameter_kepuasan/")?>" class="nav-link <?php if(strtoupper($this->uri->segment(1))=="PARAMETER_KEPUASAN"){echo 'active';}?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Parameter Kepuasan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url("kategori_nilai/")?>" class="nav-link <?php if(strtoupper($this->uri->segment(1))=="KATEGORI_NILAI"){echo 'active';}?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Parameter Penilaian</p>
                </a>
              </li>
            </ul>
          </li>
            
            <li class="nav-item">
              <a href="<?= base_url("kepuasan/")?>" class="nav-link <?php if(strtoupper($this->uri->segment(1))=="KEPUASAN" OR $this->uri->segment(1)==""){echo 'active';}?>">
                <i class="nav-icon fas fa-receipt"></i>
                <p>
                  Kepuasan Pelanggan
                </p>
              </a>
            </li>
          <li class="nav-item">
            <a href="<?= base_url("login/logout")?>" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Sign Out
              </p>
            </a>
          </li>
          <!-- END ADMIN -->

          <!-- HAL AKSES UNTUK DIREKTUR -->
          <?php }else{ ?>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-print"></i>
              <p>
                Laporan
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url("sewa/report_sewa/pelanggan")?>" class="nav-link <?php if(strtoupper($this->uri->segment(1))=="pelanggan"){echo 'active';}?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Pelanggan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url("sewa/report_sewa/penyewaan")?>" class="nav-link <?php if(strtoupper($this->uri->segment(1))=="report_sewa"){echo 'active';}?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Penyewaan</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="<?= base_url("sewa/report_sewa/kepuasan")?>" class="nav-link <?php if(strtoupper($this->uri->segment(1))=="KEPUASAN"){echo 'active';}?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Kepuasan</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="<?= base_url("login/logout")?>" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Sign Out
              </p>
            </a>
          </li>
          <!-- END DIREKTUR -->
          <?php } ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>