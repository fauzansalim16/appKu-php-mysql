<?php
require "config/connection.php";

function getAllUsers($conn) {
    $sql = "SELECT * FROM user";
    $result = $conn->query($sql);

    $users = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }

    return $users;
}

function deleteUserData($conn, $id) {
    $sql = "DELETE FROM user WHERE id = '$id'";

    return $conn->query($sql);
}

function getAllPosts($conn) {
    $sql = "SELECT * FROM post";
    $result = $conn->query($sql);

    $posts = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
    }

    return $posts;
}

function getUserById($conn, $id) {
    $sql = "SELECT nama FROM user WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return null;
}
?>
