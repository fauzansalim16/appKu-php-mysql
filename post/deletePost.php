<?php
require "../config/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["post_id"])) {
        $post_id = $_POST["post_id"];

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "DELETE FROM post WHERE id = '$post_id'";

        if ($conn->query($sql) === TRUE) {
            header("Location: ../index.php");
            exit();
        } else {
            echo "Error deleting post: " . $conn->error;
        }
        $conn->close();
    } else {
        echo "Invalid request. Post ID is missing.";
    }
} else {
        echo "Invalid request method.";
}
?>