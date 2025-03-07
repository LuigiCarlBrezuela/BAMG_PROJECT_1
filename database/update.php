<?php
include('database.php');

$response = array('success' => false);

if (isset($_POST['movie_id'])) {
  $movie_id = $_POST['movie_id'];
  $title = $_POST['title'];
  $release_year = $_POST['release_year'];
  $genre = $_POST['genre'];
  $rating = $_POST['ratings'];

  // Prepare and execute the update query
  $stmt = $conn->prepare("UPDATE movies SET title = ?, release_year = ?, genre = ?, ratings = ? WHERE movie_id = ?");
  $stmt->bind_param("sisdi", $title, $release_year, $genre, $rating, $movie_id);

  if ($stmt->execute()) {
    $response['success'] = true;
  } else {
    $response['error'] = "Error updating record: " . $stmt->error;
  }

  $stmt->close();
  $conn->close();
} else {
  $response['error'] = "Invalid request.";
}

echo json_encode($response);
?>
