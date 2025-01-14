<?php
require 'function.php';
require 'cek.php';

// Query untuk mendapatkan jumlah senjata yang dipinjam, nama acara, jenis dinas, dan jenis senjata
$query = "
    SELECT 
        COUNT(p.id) AS total_borrowed,
        a.nama_acara,
        a.jenis_dinas,
        s.keterangan AS jenis_senjata
    FROM 
        pengambilan p
    JOIN 
        acara_dinas a ON p.id_acara_dinas = a.id_acara_dinas
    JOIN 
        senjata s ON p.idsenjata = s.idsenjata
    GROUP BY 
        a.nama_acara, a.jenis_dinas, s.keterangan
";
$result = mysqli_query($conn, $query);

// Query untuk mendapatkan jumlah total senjata yang dipinjam
$totalQuery = "
    SELECT 
        COUNT(p.id) AS total_borrowed
    FROM 
        pengambilan p
";
$totalResult = mysqli_query($conn, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalBorrowed = $totalRow['total_borrowed'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman Senjata</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <a class="navbar-brand" href="index.php">
                <img src="assets/img/Logo_Unhan.png" alt="Logo Unhan" style="height: 30px; margin-right: 10px;">
                SENJA-TA
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
                    <h1 class="mt-4">Laporan Peminjaman Senjata</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table mr-1"></i>
                            Data Peminjaman Senjata
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Acara</th>
                                            <th>Jenis Dinas</th>
                                            <th>Jenis Senjata</th>
                                            <th>Jumlah Senjata Dipinjam</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        while ($row = mysqli_fetch_assoc($result)) { ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $row['nama_acara']; ?></td>
                                                <td><?= $row['jenis_dinas']; ?></td>
                                                <td><?= $row['jenis_senjata']; ?></td>
                                                <td><?= $row['total_borrowed']; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4">Total Senjata Dipinjam</th>
                                            <th><?= $totalBorrowed; ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <button id="printButton" onclick="printReport()" class="btn btn-primary mt-3">Cetak Laporan</button>
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
        function printReport() {
            var printButton = document.getElementById('printButton');
            printButton.style.display = 'none';
            var printContents = document.querySelector('.card-body').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>
</body>
</html>
