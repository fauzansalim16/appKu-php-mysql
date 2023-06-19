<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user";

/* deployment
$username = "fauzanpe_fauzan";
$password = "16fauzansalim";
$dbname = "fauzanpe_appku";
*/

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>