<?php
session_start();
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

// Menambah senjata keluar
if (isset($_POST['senjatakeluar'])) {
    $senjatanya = $_POST['senjatanya'];
    $penerima = $_POST['penerima'];
    $cohort = $_POST['cohort'];

    $addtokeluar = mysqli_query($conn, "INSERT INTO pengambilan (idsenjata, penerima, cohort) VALUES ('$senjatanya', '$penerima','$cohort')");
    if ($addtokeluar) {
        header('Location: index.php');
    } else {
        echo 'Gagal';
        header('Location: index.php');
    }
}

?>