<?php
// Memulai session
session_start();

// Menghapus semua data session
session_unset();

// Menghancurkan session
session_destroy();

// Mengarahkan kembali ke halaman login.php
header("Location: login.php");
exit;
?>
