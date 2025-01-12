<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$conn = mysqli_connect("localhost", "root", "","inventory");

// Menambah senjata baru
if (isset($_POST['addsenjata'])) {
    $nosenjata = $_POST['nosenjata'];
    $keterangan = $_POST['keterangan'];

    $addtotable = mysqli_query($conn, "INSERT INTO senjata (nosenjata, keterangan) VALUES ('$nosenjata', '$keterangan')");
    if ($addtotable) {
        header('Location: index.php');
    } else {
        echo 'Gagal';
        header('Location: index.php');
    }
}

// Menambah pengambilan senjata
if (isset($_POST['senjatakeluar'])) {
    $nosenjata = $_POST['nosenjata'];
    $id_mahasiswa = $_POST['penerima'];
    $id_acara_dinas = $_SESSION['id_acara_dinas'];
    $tanggal_waktu = date('Y-m-d H:i:s');

    // Ambil idsenjata berdasarkan nosenjata
    $senjataQuery = mysqli_query($conn, "SELECT idsenjata FROM senjata WHERE nosenjata='$nosenjata'");
    $senjataData = mysqli_fetch_array($senjataQuery);
    $idsenjata = $senjataData['idsenjata'];

    // Simpan data pengambilan ke dalam tabel pengambilan
    $insertQuery = "INSERT INTO pengambilan (idsenjata, tanggal_waktu, id_mahasiswa, id_acara_dinas) VALUES ('$idsenjata', '$tanggal_waktu', '$id_mahasiswa', '$id_acara_dinas')";
    if (mysqli_query($conn, $insertQuery)) {
        header('Location: pengambilan.php');
    } else {
        echo 'Gagal';
        header('Location: pengambilan.php');
    }
}
?>