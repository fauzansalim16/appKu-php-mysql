<?php
require "../config/connection.php";

// Memeriksa apakah form telah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Mengecek data pengguna berdasarkan email
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row["password"];

        // Memeriksa kecocokan password
        if (password_verify($password, $hashedPassword)) {
            // Memulai session dan menyimpan data pengguna
            session_start();
            $_SESSION["email"] = $email;
            $_SESSION["nama"] = $row["nama"];
            $_SESSION["level"] = $row["level"];
            $_SESSION["id"] = $row["id"];

            // Mengarahkan ke halaman index.php
            header("Location: ../index.php");
            exit;
        } else {
            echo "Password yang dimasukkan salah.";
        }
    } else {
        echo "Email pengguna tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body id="body" style="background-color: aliceblue;">
    <form class="login-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h2 class="text-center">Sign In</h2>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control"  name="password" required>
        </div>
        <button type="submit" class="btn btn-primary mb-3">Sign In</button>
        <p>Silahkan <a href='registrasi.php'>mendaftar</a> jika belum memiliki akun</p>
    </form>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Menutup koneksi ke database
$conn->close();
?>
