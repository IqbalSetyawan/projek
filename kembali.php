<?php
require 'function.php';
require 'cek.php';

// Set the default timezone to match the local time on the laptop
date_default_timezone_set('Asia/Jakarta'); // Adjust the timezone as needed

// Check database connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Ambil daftar mahasiswa
$mahasiswaQuery = mysqli_query($conn, "SELECT * FROM mahasiswa");

// Proses pengembalian senjata
if (isset($_POST['hapus_senjata'])) {
    $id_pengambilan = $_POST['id_pengambilan'];
    $deleteQuery = "DELETE FROM pengambilan WHERE id='$id_pengambilan' LIMIT 1";
    if (!mysqli_query($conn, $deleteQuery)) {
        echo json_encode(['status' => 'error', 'message' => 'Delete query failed: ' . mysqli_error($conn)]);
    } else {
        echo json_encode(['status' => 'success', 'message' => 'Data pengambilan berhasil dihapus.']);
    }
    exit();
}

if (isset($_POST['senjatakembali'])) {
    $nosenjata = $_POST['nosenjata'];
    $id_acara_dinas = $_POST['id_acara_dinas'];
    $nama_peminjam = $_POST['nama_peminjam'];
    $timestamp = $_POST['timestamp'];
    $acara = $_POST['acara'];
    $getIdQuery = "SELECT p.id FROM pengambilan p JOIN senjata s ON p.idsenjata = s.idsenjata JOIN mahasiswa m ON p.id_mahasiswa = m.id_mahasiswa JOIN acara_dinas a ON p.id_acara_dinas = a.id_acara_dinas WHERE s.nosenjata='$nosenjata' AND p.id_acara_dinas='$id_acara_dinas' AND m.nama='$nama_peminjam' AND p.tanggal_waktu='$timestamp' AND a.nama_acara='$acara' LIMIT 1";
    $result = mysqli_query($conn, $getIdQuery);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $id_pengambilan = $row['id'];
        $deleteQuery = "DELETE FROM pengambilan WHERE id='$id_pengambilan' LIMIT 1";
        if (!mysqli_query($conn, $deleteQuery)) {
            echo json_encode(['status' => 'error', 'message' => 'Delete query failed: ' . mysqli_error($conn)]);
        } else {
            echo json_encode(['status' => 'success', 'message' => 'Data pengambilan berhasil dihapus.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Record not found.']);
    }
    exit();
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
        <title>Pengembalian Senjata</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/instascan/1.0.0/instascan.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
        <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
        <style>
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
                        <h1 class="mt-4">Pengembalian Senjata</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Tombol untuk Membuka Modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    Pengembalian Senjata
                                </button>
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
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="senjataTableBody">
                                            <?php
                                            $ambildatasenjata = mysqli_query($conn, "SELECT p.*, s.nosenjata, m.nama as penerima, a.nama_acara FROM pengambilan p JOIN senjata s ON s.idsenjata = p.idsenjata JOIN mahasiswa m ON m.id_mahasiswa = p.id_mahasiswa JOIN acara_dinas a ON a.id_acara_dinas = p.id_acara_dinas");
                                            $i = 1;
                                            while($data=mysqli_fetch_array($ambildatasenjata)){
                                                $nosenjata = $data['nosenjata'];
                                                $tanggal = $data['tanggal_waktu'];
                                                $penerima = $data['penerima'];
                                                $acara = $data['nama_acara'];
                                                $id_acara_dinas = $data['id_acara_dinas'];
                                                $id_pengambilan = $data['id'];
                                            ?>
                                            <tr data-id="<?=$id_pengambilan;?>" data-nosenjata="<?=$nosenjata;?>" data-tanggal="<?=$tanggal;?>" data-penerima="<?=$penerima;?>" data-acara="<?=$acara;?>">
                                                <td><?=$i++;?></td>
                                                <td><?=$nosenjata;?></td>
                                                <td><?=$tanggal;?></td>
                                                <td><?=$penerima;?></td>
                                                <td><?=$acara;?></td>
                                                <td class="text-center">
                                                    <button class="btn btn-danger btn-sm delete-btn" data-id="<?=$id_pengambilan;?>">&times;</button>
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
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
        <script>
            $(document).ready(function() {
                $('#dataTable').DataTable(); // Initialize DataTables

                // Handle delete button click
                $('.delete-btn').on('click', function() {
                    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                        let id_pengambilan = $(this).data('id');
                        $.ajax({
                            type: 'POST',
                            url: 'kembali.php',
                            data: { hapus_senjata: true, id_pengambilan: id_pengambilan },
                            success: function(response) {
                                let res = JSON.parse(response);
                                if (res.status === 'success') {
                                    alert(res.message);
                                    location.reload(); // Reload the page to reflect changes
                                } else {
                                    alert(res.message);
                                }
                            },
                            error: function(xhr, status, error) {
                                alert('An error occurred: ' + error);
                            }
                        });
                    }
                });

                // Handle QR code scan
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
                    // Assuming the QR code contains both nosenjata and id_acara_dinas separated by a comma
                    let parts = c.split(',');
                    document.getElementById('nosenjata').value = parts[0];
                    document.getElementById('id_acara_dinas').value = parts[1];

                    // Find the corresponding row and set the data-id attribute in the form
                    $('#senjataTableBody tr').each(function() {
                        if ($(this).data('nosenjata') === parts[0]) {
                            $('#nama_peminjam').val($(this).data('penerima'));
                            $('#timestamp').val($(this).data('tanggal'));
                            $('#acara').val($(this).data('acara'));
                            $('#kembaliForm').data('id', $(this).data('id'));
                        }
                    });
                });

                $('#submitBtn').on('click', function(e) {
                    e.preventDefault();
                    let id_pengambilan = $('#kembaliForm').data('id');
                    $.ajax({
                        type: 'POST',
                        url: 'kembali.php',
                        data: { hapus_senjata: true, id_pengambilan: id_pengambilan },
                        success: function(response) {
                            let res = JSON.parse(response);
                            if (res.status === 'success') {
                                alert(res.message);
                                location.reload(); // Reload the page to reflect changes
                            } else {
                                alert(res.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('An error occurred: ' + error);
                        }
                    });
                });
            });
        </script>
    </body>
    <!-- Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
        <div class="modal-content">
        
            <!-- Header Modal -->
            <div class="modal-header">
                <h4 class="modal-title">Pengembalian Senjata</h4>
                <button type="button" class="close" data-dismiss="modal">&times;"></button>
            </div>
            
            <!-- Body Modal -->
            <form method="post" id="kembaliForm">
                <div class="modal-body">
                    <video id="preview" width="100%"></video>
                    <input type="text" name="nosenjata" id="nosenjata" placeholder="Nomor senjata" class="form-control" required>
                    <input type="hidden" name="id_acara_dinas" id="id_acara_dinas">
                    <input type="text" name="nama_peminjam" id="nama_peminjam" placeholder="Nama Peminjam" class="form-control" readonly>
                    <input type="text" name="timestamp" id="timestamp" placeholder="Tanggal & Waktu Peminjaman" class="form-control" readonly>
                    <input type="text" name="acara" id="acara" placeholder="Acara" class="form-control" readonly>
                    <br>
                    <button type="submit" class="btn btn-danger" name="senjatakembali" id="submitBtn">Hapus</button>
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

<?php
include 'function.php';

if (isset($_POST['hapus_senjata'])) {
    $id_pengambilan = $_POST['id_pengambilan'];
    $deleteQuery = "DELETE FROM pengambilan WHERE id='$id_pengambilan' LIMIT 1";
    if (!mysqli_query($conn, $deleteQuery)) {
        echo json_encode(['status' => 'error', 'message' => 'Delete query failed: ' . mysqli_error($conn)]);
    } else {
        echo json_encode(['status' => 'success', 'message' => 'Data pengambilan berhasil dihapus.']);
    }
    exit();
}

if (isset($_POST['senjatakembali'])) {
    $nosenjata = $_POST['nosenjata'];
    $id_acara_dinas = $_POST['id_acara_dinas'];
    $nama_peminjam = $_POST['nama_peminjam'];
    $timestamp = $_POST['timestamp'];
    $acara = $_POST['acara'];
    $getIdQuery = "SELECT p.id FROM pengambilan p JOIN senjata s ON p.idsenjata = s.idsenjata JOIN mahasiswa m ON p.id_mahasiswa = m.id_mahasiswa JOIN acara_dinas a ON p.id_acara_dinas = a.id_acara_dinas WHERE s.nosenjata='$nosenjata' AND p.id_acara_dinas='$id_acara_dinas' AND m.nama='$nama_peminjam' AND p.tanggal_waktu='$timestamp' AND a.nama_acara='$acara' LIMIT 1";
    $result = mysqli_query($conn, $getIdQuery);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $id_pengambilan = $row['id'];
        $deleteQuery = "DELETE FROM pengambilan WHERE id='$id_pengambilan' LIMIT 1";
        if (!mysqli_query($conn, $deleteQuery)) {
            echo json_encode(['status' => 'error', 'message' => 'Delete query failed: ' . mysqli_error($conn)]);
        } else {
            echo json_encode(['status' => 'success', 'message' => 'Data pengambilan berhasil dihapus.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Record not found.']);
    }
    exit();
}
?>
