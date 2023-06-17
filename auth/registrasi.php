<?php
require "../config/connection.php";

// Memeriksa apakah form telah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $email = $_POST["email"]; // Tambahkan kolom email
    $password = $_POST["password"];
    $alamat = $_POST["alamat"];

    // Menghasilkan hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Menambahkan akun baru ke database
    $sql = "INSERT INTO user (nama, email, password, alamat) VALUES ('$nama', '$email', '$hashedPassword', '$alamat')";

    if ($conn->query($sql) === TRUE) {
        header("Location: login.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrasi Akun</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/registrasi.css">
</head>
<body>
    
    <form class="registrasi-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h2 class="text-center">Sign Up</h2>
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" name="nama" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label> <!-- Tambahkan input email -->
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" name="alamat" required>
        </div>
        <button type="submit" class="btn btn-primary mb-3">Sign Up</button>
        <p>Sudah memiliki akun? <a href='login.php'>Login</a></p>
    </form>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Menutup koneksi ke database
$conn->close();
?>
