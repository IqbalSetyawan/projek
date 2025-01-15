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

if (isset($_POST['cetak_laporan'])) {
    $fpdfPath = 'library/fpdf.php';
    if (file_exists($fpdfPath)) {
        require($fpdfPath);

        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();

        $pdf->SetFont('Times', 'B', 13);
        $pdf->Cell(200, 10, 'DATA LAPORAN PEMINJAMAN SENJATA', 0, 0, 'C');

        $pdf->Cell(10, 15, '', 0, 1);
        $pdf->SetFont('Times', 'B', 9);
        $pdf->Cell(10, 7, 'NO', 1, 0, 'C');
        $pdf->Cell(50, 7, 'NAMA ACARA', 1, 0, 'C');
        $pdf->Cell(50, 7, 'JENIS DINAS', 1, 0, 'C');
        $pdf->Cell(50, 7, 'JENIS SENJATA', 1, 0, 'C');
        $pdf->Cell(30, 7, 'JUMLAH DIPINJAM', 1, 1, 'C');

        $pdf->SetFont('Times', '', 10);
        $no = 1;
        $data = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_array($data)) {
            $pdf->Cell(10, 6, $no++, 1, 0, 'C');
            $pdf->Cell(50, 6, $row['nama_acara'], 1, 0);
            $pdf->Cell(50, 6, $row['jenis_dinas'], 1, 0);
            $pdf->Cell(50, 6, $row['jenis_senjata'], 1, 0);
            $pdf->Cell(30, 6, $row['total_borrowed'], 1, 1);
        }

        // Tambahkan total keseluruhan senjata yang dipinjam
        $pdf->SetFont('Times', 'B', 9);
        $pdf->Cell(160, 6, 'Total Senjata Dipinjam', 1, 0, 'C');
        $pdf->Cell(30, 6, $totalBorrowed, 1, 1, 'C');

        $pdf->Output();
        exit();
    } else {
        echo "<script>alert('Library FPDF tidak ditemukan. Pastikan library sudah diinstal.');</script>";
    }
}
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
                            <form method="post">
                                <button type="submit" id="printButton" name="cetak_laporan" class="btn btn-primary mt-3">Cetak Laporan</button>
                            </form>
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
</body>
</html>
