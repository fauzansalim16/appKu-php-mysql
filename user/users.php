<?php
require "../config/connection.php";
require "../functions.php";

session_start();

if (!isset($_SESSION["nama"])) {
    header("Location: ../auth/login.php");
    exit;
}

if (isset($_GET["delete"])) {
    $id = $_GET["delete"];

    if (deleteUserData($conn, $id)) {
        header("Location: users.php");
    } else {
        echo "Error: Gagal menghapus data.";
    }
}

$users = getAllUsers($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>Applikasi Ku - Users</title>
    <link rel="icon" href="../image/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body id="body" style="background-color: aliceblue;">
    <nav id="navbar" class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">
                <img src="../image/favicon.ico" alt="Logo" width="25" height="25" class="d-inline-block align-text-top">  AppKu
            </a>    
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link active" href="#">Home</a>
                    <a class="nav-link" href="users.php">Users</a>
                    <a class="nav-link" href="../post/posting.php">Posting!</a>
                </div>
            </div>
            <form action="auth/logout.php" method="post" class="logout-form">
                <p class="greeting">Howdy, <?php echo $_SESSION["nama"]; ?></p>
                <button type="submit" class="btn btn-primary" name="logout">Logout</button>
            </form>
        </div>
    </nav>

    <h2 id="h2-data-user" class="text-center">User</h2>
    <div class="card-container">
        <?php
        foreach ($users as $user) {
            echo "<div class='card' style='width: 18rem;'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>" . $user["nama"] . "</h5>";
            echo "<p class='card-text'>" . $user["alamat"] . "</p>";
            if ($_SESSION["level"] == 1) {
                echo "<a href='editUser.php?id=" . $user["id"] . "' class='btn btn-primary mx-2'>Edit</a>";
                echo "<a href='../index.php?delete=" . $user["id"] . "' class='btn btn-danger'>Delete</a>";
            }
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
