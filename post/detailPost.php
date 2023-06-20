<?php
require "../config/connection.php";

session_start();

if (!isset($_SESSION["nama"])) {
    header("Location: ../auth/login.php");
    exit;
}


if (isset($_GET["id"])) {
    $post_id = $_GET["id"];

    $sql_post = "SELECT * FROM post WHERE id = '$post_id'";
    $postResult = $conn->query($sql_post);

    if ($postResult->num_rows > 0) {
        $postRow = $postResult->fetch_assoc();
        $user_id = $postRow["user_id"];

        $sql_user = "SELECT nama FROM user WHERE id = '$user_id'";
        $userResult = $conn->query($sql_user);
        if ($userResult->num_rows > 0) {
            $userRow = $userResult->fetch_assoc();
        } else {
            $userRow = array("nama" => "Unknown");
        }
    } else {
        echo "Post not found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Post</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/detailPost.css">
</head>

<body id="body" style="background-color: aliceblue;">
    <nav id="navbar" class="navbar bg-body-tertiary" style="margin-bottom: 40px">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">
            <img src="../image/favicon.ico" alt="Logo" width="25" height="25" class="d-inline-block align-text-top">
            AppKu
            </a>
            <h3 style="text-align: center; margin:auto">Detail Post</h3>
        </div>
        
    </nav>
    <div class="container">
        <div class="card">
            <img src="../<?php echo $postRow['gambar']; ?>" class="card-img-top" alt="Gambar">
            <div class="card-body">
                <h5 class="card-title"><?php echo $postRow['judul']; ?></h5>
                <p class="card-text"><?php echo $postRow['konten']; ?></p>
                <p class="card-text">At: <?php echo $postRow['tanggal_post']; ?></p>
                <p class="card-text">By: <?php echo $userRow['nama']; ?></p>
                <!-- Tambahkan tombol Edit dan Delete -->
                <a href="editPost.php?id=<?php echo $postRow['id']; ?>" class="btn btn-primary">Edit</a>
                <form method="POST" action="deletePost.php" style="display: inline;">
                    <input type="hidden" name="post_id" value="<?php echo $postRow['id']; ?>">
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById("editButton").addEventListener("click", function() {
            var postId = <?php echo $postRow['id']; ?>;
            window.location.href = "editPost.php?id=" + postId;
        });
    </script>
</body>

</html>
