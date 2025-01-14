<?php

if (!isset($_SESSION['log'])) {
    header('location:login1.php');
    exit();
}

// Restrict mahasiswa role from accessing other pages
if (isset($_SESSION['role']) && $_SESSION['role'] === 'mahasiswa' && basename($_SERVER['PHP_SELF']) !== 'cari.php') {
    header('location:cari.php');
    exit();
}
?>