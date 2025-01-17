<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$conn = mysqli_connect("localhost", "root", "","inventory");

function recordExists($table, $column, $value) {
    global $conn;
    $query = "SELECT * FROM $table WHERE $column='$value'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result) > 0;
}

function showAlert($message, $type = 'success') {
    echo "<div class='alert alert-$type alert-dismissible fade show' role='alert'>
            $message
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
          </div>";
}

// Menambah senjata baru
if (isset($_POST['addsenjata'])) {
    $nosenjata = $_POST['nosenjata'];
    $keterangan = $_POST['keterangan'];

    if (recordExists('senjata', 'nosenjata', $nosenjata)) {
        $_SESSION['alert'] = ['message' => 'Data sudah ada dan tidak dapat diterima', 'type' => 'danger'];
    } else {
        $addtotable = mysqli_query($conn, "INSERT INTO senjata (nosenjata, keterangan) VALUES ('$nosenjata', '$keterangan')");
        if ($addtotable) {
            $_SESSION['alert'] = ['message' => 'Data berhasil diterima', 'type' => 'success'];
        } else {
            $_SESSION['alert'] = ['message' => 'Gagal', 'type' => 'danger'];
        }
    }
    header('Location: index.php');
    exit();
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
    $idsenjata = $senjataData['idsenjata'] ?? null;

    if ($idsenjata) {
        // Periksa apakah idsenjata sudah ada di tabel pengambilan
        $checkQuery = mysqli_query($conn, "SELECT * FROM pengambilan WHERE idsenjata='$idsenjata'");
        if (mysqli_num_rows($checkQuery) > 0) {
            $_SESSION['alert'] = ['message' => 'Data sudah ada dan tidak dapat diterima', 'type' => 'danger'];
            header('Location: pengambilan.php');
            exit();
        }

        // Simpan data pengambilan ke dalam tabel pengambilan
        $insertQuery = "INSERT INTO pengambilan (idsenjata, tanggal_waktu, id_mahasiswa, id_acara_dinas) VALUES ('$idsenjata', '$tanggal_waktu', '$id_mahasiswa', '$id_acara_dinas')";
        if (mysqli_query($conn, $insertQuery)) {
            $_SESSION['alert'] = ['message' => 'Data berhasil diterima', 'type' => 'success'];
        } else {
            $_SESSION['alert'] = ['message' => 'Gagal: ' . mysqli_error($conn), 'type' => 'danger'];
        }
    } else {
        $_SESSION['alert'] = ['message' => 'Senjata dengan nomor ' . $nosenjata . ' tidak ditemukan.', 'type' => 'danger'];
    }
    header('Location: pengambilan.php');
    exit();
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

// Fungsi login mahasiswa
function loginMahasiswa($email, $password) {
    global $conn;

    $cekdatabase = mysqli_query($conn, "SELECT * FROM loginmhsw WHERE email='$email' AND password='$password'");
    $hitung = mysqli_num_rows($cekdatabase);

    if ($hitung > 0) {
        $_SESSION['log'] = 'True';
        return true;
    } else {
        return false;
    }
}
?>