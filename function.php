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

// Menghapus pengambilan senjata
if (isset($_POST['senjatakembali'])) {
    $nosenjata = $_POST['nosenjata'];
    $id_acara_dinas = $_POST['id_acara_dinas'];
    
    $result = deletePengambilan($nosenjata, $id_acara_dinas);
    echo json_encode($result);
    exit();
}

function deletePengambilan($nosenjata, $id_acara_dinas) {
    global $conn;

    // Get the id of the pengambilan record to delete
    $getIdQuery = "SELECT p.id FROM pengambilan p JOIN senjata s ON p.idsenjata = s.idsenjata WHERE s.nosenjata='$nosenjata' AND p.id_acara_dinas='$id_acara_dinas' LIMIT 1";
    $result = mysqli_query($conn, $getIdQuery);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $id_pengambilan = $row['id'];

        // Hapus data pengambilan dari tabel pengambilan berdasarkan id
        $deleteQuery = "DELETE FROM pengambilan WHERE id='$id_pengambilan' LIMIT 1";
        if (mysqli_query($conn, $deleteQuery)) {
            return ['status' => 'success', 'message' => 'Data pengambilan berhasil dihapus.'];
        } else {
            error_log("Delete query failed: " . mysqli_error($conn)); // Log the error
            return ['status' => 'error', 'message' => 'Delete query failed: ' . mysqli_error($conn)];
        }
    } else {
        error_log("Record not found for nosenjata: $nosenjata, id_acara_dinas: $id_acara_dinas"); // Log the error
        return ['status' => 'error', 'message' => 'Record not found.'];
    }
}
?>