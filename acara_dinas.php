<?php
require 'function.php';
require 'cek.php';

if (isset($_POST['submitAcaraDinas'])) {
    $acara = $_POST['acara'];
    $dinas = $_POST['dinas'];

    // Insert data into acara_dinas table
    $query = "INSERT INTO acara_dinas (nama_acara, jenis_dinas) VALUES ('$acara', '$dinas')";
    mysqli_query($conn, $query);

    // Get the last inserted id
    $id_acara_dinas = mysqli_insert_id($conn);

    // Save acara and dinas in session variables
    $_SESSION['id_acara_dinas'] = $id_acara_dinas;

    // Redirect to pengambilan.php
    header("Location: pengambilan.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Acara dan Dinas</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <a class="navbar-brand" href="index.php">SENJA-TA</a>
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
                    <h1 class="mt-4">Pilih Acara dan Dinas</h1>
                    <form method="post">
                        <!-- Input untuk memasukkan acara -->
                        <input type="text" name="acara" class="form-control" placeholder="Masukkan Acara" required>
                        <br>
                        <!-- Dropdown untuk memilih dinas luar/dalam -->
                        <select id="dinasDropdown" name="dinas" class="form-control" required>
                            <option value="">Pilih Dinas</option>
                            <option value="Luar">Luar</option>
                            <option value="Dalam">Dalam</option>
                        </select>
                        <br>
                        <br>
                        <button type="submit" class="btn btn-primary" name="submitAcaraDinas">Submit</button>
                    </form>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi Select2 untuk dropdown
            $('#dinasDropdown').select2();
        });
    </script>
</body>
</html>
