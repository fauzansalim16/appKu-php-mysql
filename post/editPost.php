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
    } else {
        echo "Post not found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newJudul = $_POST["judul"];
    $newKonten = $_POST["konten"];

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $gambar_tmp = $_FILES['gambar']['tmp_name'];
        $gambar_name = $_FILES['gambar']['name'];
        $gambar_path = "../upload/" . $gambar_name;

        $gambar_path_dabase = "upload/" . $gambar_name;

        if (move_uploaded_file($gambar_tmp, $gambar_path)) {
            $sql_update = "UPDATE post SET judul = '$newJudul', konten = '$newKonten', gambar = '$gambar_path_dabase' WHERE id = '$post_id'";
            if ($conn->query($sql_update) === TRUE) {
                echo "Post updated successfully.";
                header("Location: detailPost.php?id=" . $post_id);
                exit;
            } else {
                echo "Error updating post: " . $conn->error;
            }
        } else {
            echo "Failed to move uploaded file.";
        }
    } else {
        $sql_update = "UPDATE post SET judul = '$newJudul', konten = '$newKonten' WHERE id = '$post_id'";
        if ($conn->query($sql_update) === TRUE) {
            echo "Post updated successfully.";
            header("Location: detailPost.php?id=" . $post_id);
            exit;
        } else {
            echo "Error updating post: " . $conn->error;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/editPost.css">
</head>

<body id="body" style="background-color: aliceblue;">
    <nav id="navbar" class="navbar bg-body-tertiary" style="margin-bottom: 70px">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">
            <img src="../image/favicon.ico" alt="Logo" width="25" height="25" class="d-inline-block align-text-top">
            AppKu
            </a>
            <h3 style=" margin-right: 550px;">Edit Post</h3>
        </div>
        
    </nav>
    <div class="container">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $post_id; ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label for="judul">Judul:</label>
                <input type="text" class="form-control" id="judul" name="judul" value="<?php echo $postRow['judul']; ?>">
            </div>
            <div class="form-group">
                <label for="konten">Konten:</label>
                <textarea class="form-control" id="konten" name="konten" rows="5"><?php echo $postRow['konten']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="gambar">Gambar:</label>
                <input type="file" class="form-control-file" id="gambar" name="gambar">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
