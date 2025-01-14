<?php
require 'function.php';
require 'cek.php';
require_once("assets/phpqrcode/qrlib.php");

if(isset($_POST['addmahasiswa'])){
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $prodi = $_POST['prodi'];

    // Generate QR code
    $fileName = "qrcodes/" . $nim . ".png";
    QRcode::png($nim, $fileName, "H", 4, 4);

    // Save data to database
    $query = "INSERT INTO mahasiswa (nim, nama, prodi, kodeqr) VALUES ('$nim', '$nama', '$prodi', '$fileName')";
    mysqli_query($conn, $query);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Data Mahasiswa</title>
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
            <a class="navbar-brand" href="index.php">Sistem Data Mahasiswa UNHAN RI</a>
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
                        <h1 class="mt-4">Data Mahasiswa</h1>

                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    Tambah Mahasiswa
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>NIM</th>
                                                <th>Nama</th>
                                                <th>Prodi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $ambildatamahasiswa = mysqli_query($conn, "select * from mahasiswa");
                                            $i = 1;
                                            while($data=mysqli_fetch_array($ambildatamahasiswa)){
                                                
                                                $nim = $data['nim'];
                                                $nama = $data['nama'];
                                                $prodi = $data['prodi'];
                                            ?>
                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$nim;?></td>
                                                <td><?=$nama;?></td>
                                                <td><?=$prodi;?></td>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/instascan/1.0.0/instascan.min.js"></script>
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
        <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Mahasiswa</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;"></button>
                </div>
                
                <!-- Modal body -->
                <form method="post">
                    <div class="modal-body">
                        <input type="text" name="nim" id="nim" placeholder="NIM" class="form-control" required>
                        <br> 
                        <input type="text" name="nama" placeholder="Nama" class="form-control" required>
                        <br>
                        <select name="prodi" class="form-control" required>
                            <option value="" disabled selected>Pilih Prodi</option>
                            <option value="Kedokteran">Kedokteran</option>
                            <option value="Farmasi">Farmasi</option>
                            <option value="Fisika">Fisika</option>
                            <option value="Kimia">Kimia</option>
                            <option value="Biologi">Biologi</option>
                            <option value="Matematika">Matematika</option>
                            <option value="Informatika">Informatika</option>
                            <option value="Teknik Elektro">Teknik Elektro</option>
                            <option value="Teknik Sipil">Teknik Sipil</option>
                            <option value="Teknik Mesin">Teknik Mesin</option>
                        </select>
                        <br>
                        <button type="submit" class="btn btn-primary" name="addmahasiswa">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  
</html>
