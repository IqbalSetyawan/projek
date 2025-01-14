<?php
require 'function.php';
require 'cek.php';

// Ambil daftar mahasiswa
$mahasiswaQuery = mysqli_query($conn, "SELECT * FROM mahasiswa");

// Periksa apakah acara dan dinas sudah disetel dalam sesi
if (!isset($_SESSION['id_acara_dinas'])) {
    // Alihkan ke halaman acara_dinas jika belum disetel
    header("Location: acara_dinas.php");
    exit();
}

$id_acara_dinas = $_SESSION['id_acara_dinas'];

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
        echo "<script>window.location.href='pengambilan.php';</script>";
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
            <a class="navbar-brand" href="index.php">SENJA-TA/a>

        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Data Senjata
                            </a>
                            <a class="nav-link" href="mahasiswa.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Data Mahasiswa
                            </a>
                            <a class="nav-link" href="pengambilan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Peminjaman Senjata
                            </a>
                            <a class="nav-link" href="kembali.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Pengembalian Senjata
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
                            <div class="card-header">
                                <!-- Tombol untuk Membuka Modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    Peminjaman Senjata
                                </button>
                                <!-- Tombol untuk Kembali ke Acara Dinas -->
                                <a href="acara_dinas.php" class="btn btn-secondary">Kembali ke Acara Dinas</a>
                            </div>
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
            <!-- Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
        <div class="modal-content">
        
            <!-- Header Modal -->
            <div class="modal-header">
                <h4 class="modal-title">Pengambilan Senjata</h4>
                <button type="button" class="close" data-dismiss="modal">&times;"></button>
            </div>
            
            <!-- Body Modal -->
            <form method="post">
                <div class="modal-body">
                    <video id="preview" width="100%"></video>
                    <input type="text" name="nosenjata" id="nosenjata" placeholder="Nomor senjata" class="form-control" required>
                    <br>
                    <!-- Dropdown untuk memilih penerima -->
                    <select id="penerimaDropdown" name="penerima" class="form-control" required>
                        <option value="">Pilih Penerima</option>
                        <?php while($row = mysqli_fetch_array($mahasiswaQuery)) { ?>
                            <option value="<?=$row['id_mahasiswa']?>"><?=$row['nama']?></option>
                        <?php } ?>
                    </select>
                    <br>
                    <br>
                    <button type="submit" class="btn btn-primary" name="senjatakeluar">Submit</button>
                    <script>
                    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
                    Instascan.Camera.getCameras().then(function(cameras) {
                        if (cameras.length > 0) {
                            scanner.start(cameras[0]);
                        } else {
                            alert('No cameras found');
                        }

                    }).catch(function(e) {
                        console.error(e);
                    });

                    scanner.addListener('scan', function(c) {
                        document.getElementById('nosenjata').value = c;
                    });
                </script>
                </div>
            </form>
        </div>
        </div>
    </div>

<!-- Sertakan pustaka Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Inisialisasi Select2 untuk dropdown
        $('#penerimaDropdown').select2();
    });
</script>
</html>
