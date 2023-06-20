<?php
require "config/connection.php";
require "functions.php";

session_start();

if (!isset($_SESSION["nama"])) {
    header("Location: auth/login.php");
    exit;
}

$posts = getAllPosts($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>Applikasi Ku</title>
    <link rel="icon" href="image/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body id="body" style="background-color: aliceblue;">
    <nav id="navbar" class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="image/favicon.ico" alt="Logo" width="25" height="25" class="d-inline-block align-text-top">  AppKu
            </a>    
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" href="#">Home</a>
                    <a class="nav-link" href="user/users.php">Users</a>
                    <a class="nav-link" href="post/posting.php">Posting!</a>
                </div>
            </div>
            <form action="auth/logout.php" method="post" class="logout-form">
                <p class="greeting">Howdy, <?php echo $_SESSION["nama"]; ?></p>
                <button type="submit" class="btn btn-primary" name="logout">Logout</button>
            </form>
        </div>
    </nav>
    
    <div class="card-container">
        <?php
        foreach ($posts as $post) {
            echo "<div class='card' style='width: 18rem;'>";
            echo "<img src='" . $post["gambar"] . "' class='card-img-top' alt='Gambar'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'><a href='post/detailPost.php?id=" . $post["id"] . "' class='custom-link'>" . $post["judul"] . "</a></h5>";
            echo "<p class='card-text'>" . $post["konten"] . "</p>";
            echo "<p class='card-text'>At: " . $post["tanggal_post"] . "</p>";
            $user_id = $post["user_id"];
            $user = getUserById($conn, $user_id);
            if ($user) {
                echo "<p class='card-text'>By: " . $user["nama"] . "</p>";
            }
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
