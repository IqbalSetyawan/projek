<?php
require 'function.php';
require 'cek.php';
require_once("assets/phpqrcode/qrlib.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Inventaris Senjata</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/instascan/1.0.0/instascan.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
        <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap');
            body {
                background: url('pictures/gudang.jpg') no-repeat center center fixed;
                background-size: cover;
                font-family: 'Arial', sans-serif;
            }

            .sb-topnav {
                background: rgba(0, 0, 0, 0.8);
            }

            .sb-sidenav {
                background: rgba(0, 0, 0, 0.9);
            }

            .card {
                background: rgba(255, 255, 255, 0.9);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            }

            .modal-content {
                background: rgba(255, 255, 255, 0.9);
            }

            .btn-primary {
                background: #4b79a1; /* Luxurious blue shade */
                border: none;
                transition: background 0.3s ease-in-out, transform 0.3s ease-in-out;
            }

            .btn-primary:hover {
                background: #283e51; /* Darker shade for hover effect */
                transform: translateY(-5px);
            }

            h1.mt-4 {
                font-size: 2.5em;
                font-weight: bold;
                color: #333;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
                margin-bottom: 20px;
                text-align: center;
                text-transform: uppercase;
                letter-spacing: 2px;
            }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <a class="navbar-brand" href="index.php">
                <img src="assets/img/Logo_Unhan.png" alt="Logo Unhan" style="height: 30px; margin-right: 10px;">
                <span style="font-size: 1.25em; font-weight: bold; color: #ffffff; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2); font-family: 'Montserrat', sans-serif;">SENJA-TA</span>
            </a>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Data Senjata
                            </a>
                            <a class="nav-link" href="mahasiswa.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
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
                            <a class="nav-link" href="laporan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                                Cetak Laporan
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
                        <h1 class="mt-4">
                            Inventaris Senjata
                        </h1>

                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    Tambah Senjata
                                </button>
                                <!-- Button to Open the CSV Modal -->
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nomor Senjata</th>
                                                <th>Keterangan</th>
                                                <th>QR Code</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $ambildatasenjata = mysqli_query($conn, "select * from senjata");
                                            $i = 1;
                                            while($data=mysqli_fetch_array($ambildatasenjata)){
                                                
                                                $nosenjata = $data['nosenjata'];
                                                $keterangan = $data['keterangan'];
                                                
                                                // Generate QR code
                                                $fileName = "qrcodes/" . $nosenjata . ".png";
                                                QRcode::png($nosenjata, $fileName, "H", 4, 4);

                                                // Save QR code file name in the database
                                                $updateQuery = "UPDATE senjata SET kodeqr='$fileName' WHERE nosenjata='$nosenjata'";
                                                mysqli_query($conn, $updateQuery);
                                            ?>
                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$nosenjata;?></td>
                                                <td><?=$keterangan;?></td>
                                                <td>
                                                    <img src="<?=$fileName;?>" alt="QR Code">
                                                </td>

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
                    <h4 class="modal-title">Tambah Senjata</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <form method="post">
                    <div class="modal-body">
                        <input type="text" name="nosenjata" id="nosenjata" placeholder="Nomor senjata" class="form-control" required>
                        <br> 
                        <select name="keterangan" class="form-control" required>
                            <option value="" disabled selected>Pilih Keterangan</option>
                            <option value="SS2-V5">SS2-V5</option>
                            <option value="G6-Combat">G6-Combat</option>
                        </select>
                        <br>
                        <button type="submit" class="btn btn-primary" name="addsenjata">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- The CSV Modal -->
    <div class="modal fade" id="csvModalSenjata">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Senjata via CSV</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="file" name="csvfile" class="form-control" required>
                        <br>
                        <button type="submit" class="btn btn-primary" name="uploadcsvsenjata">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  
</html>
