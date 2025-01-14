<?php
require 'function.php';
require 'cek.php';

if ($_SESSION['role'] !== 'mahasiswa') {
    header('location:login2.php');
    exit();
}

// Ambil daftar mahasiswa
$mahasiswaQuery = mysqli_query($conn, "SELECT * FROM mahasiswa");


// Proses pengambilan senjata
if (isset($_POST['senjatakeluar'])) {
    $nosenjata = $_POST['nosenjata'];
    $id_mahasiswa = $_POST['penerima'];
    $tanggal_waktu = date('Y-m-d H:i:s');

    // Ambil idsenjata berdasarkan nosenjata
    $senjataQuery = mysqli_query($conn, "SELECT idsenjata FROM senjata WHERE nosenjata='$nosenjata'");
    if (!$senjataQuery) {
        die("Query failed: " . mysqli_error($conn));
    }
    $senjataData = mysqli_fetch_array($senjataQuery);
    $idsenjata = $senjataData['idsenjata'];

    if ($idsenjata) {
        
        // Redirect to prevent form resubmission
        echo "<script>window.location.href='cari.php';</script>";
        exit();
    } else {
        die("Senjata dengan nomor $nosenjata tidak ditemukan.");
    }
}
?>

<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Senjata Masuk</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/instascan/1.0.0/instascan.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
        <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <a class="navbar-brand" href="cari.php">
                <img src="assets/img/Logo_Unhan.png" alt="Logo Unhan" style="height: 30px; margin-right: 10px;">
                SENJA-TA
            </a>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            </a>
                            <a class="nav-link" href="cari.php">
                               <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Pencarian Senjata
                            </a>
                            </a>
                            <a class="nav-link" href="logout.php">
                                Logout
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Peminjaman Senjata</h1>

                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nomor Senjata</th>
                                                <th>Tanggal Keluar & Waktu Peminjaman</th>
                                                <th>Peminjam</th>
                                                <th>Acara</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $ambildatasenjata = mysqli_query($conn, "SELECT p.*, s.nosenjata, m.nama as penerima, a.nama_acara FROM pengambilan p JOIN senjata s ON s.idsenjata = p.idsenjata JOIN mahasiswa m ON m.id_mahasiswa = p.id_mahasiswa JOIN acara_dinas a ON a.id_acara_dinas = p.id_acara_dinas");
                                            $i = 1;
                                            while($data=mysqli_fetch_array($ambildatasenjata)){
                                                $nosenjata = $data['nosenjata'];
                                                $tanggal = $data['tanggal_waktu'];
                                                $penerima = $data['penerima'];
                                                $acara = $data['nama_acara'];
                                            ?>
                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$nosenjata;?></td>
                                                <td><?=$tanggal;?></td>
                                                <td><?=$penerima;?></td>
                                                <td><?=$acara;?></td>
                                            </tr>
                                            <?php
                                            };
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Biro Umum dan Perencanaan</div>
                            <div>
                                <a>Universitas Pertahanan RI</a>
                                &middot;
                                <a>2024</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>
</html>
