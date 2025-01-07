<?php
require 'function.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Universitas Pertahanan</title>
    <link rel="stylesheet" href="css/styles.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
</head>
<body>

<div class="login-container">
    <img src="assets/img/Logo_Unhan.png" alt="Logo Universitas Pertahanan">
    <h2>Login</h2>
    <form id="loginForm">
        <input type="text" placeholder="Nama pengguna" required>
        <input type="password" placeholder="Kata sandi" required>
        
        <button type="submit">Masuk</button>
    </form>
</div>

<script>
    document.getElementById("loginForm").addEventListener("submit", function(event) {
        event.preventDefault();
        alert("Login sukses!");
    });
</script>

</body>
</html>
