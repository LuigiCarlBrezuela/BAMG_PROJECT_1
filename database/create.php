<?php
include(__DIR__ . '/database.php'); // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $release_year = $_POST['release_year'];
    $genre = $_POST['genre'];
    $ratings = $_POST['ratings'];

    $sql = "INSERT INTO movies (title, release_year, genre, ratings) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisi", $title, $release_year, $genre, $ratings);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
?>