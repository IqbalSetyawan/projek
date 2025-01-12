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
</head>
<body>
    <div class="container">
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
