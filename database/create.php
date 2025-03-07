<?php
include(__DIR__ . '/database.php'); // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $release_year = $_POST['release_year'];
    $genre = $_POST['genre'];
    $descriptions = $_POST['descriptions'];
    $ratings = $_POST['ratings'];

    $sql = "INSERT INTO movies (title, release_year, genre, descriptions, ratings) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisi", $title, $release_year, $genre, $descriptions, $ratings);

    if ($stmt->execute()) {
        header("Location: ../index.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>