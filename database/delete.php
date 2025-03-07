<?php
include('database.php');

if (isset($_POST['movie_id'])) {
  $movie_id = $_POST['movie_id'];

  // Prepare and execute the delete query
  $stmt = $conn->prepare("DELETE FROM movies WHERE movie_id = ?");
  $stmt->bind_param("i", $movie_id);

  if ($stmt->execute()) {
    echo "Movie deleted successfully.";
  } else {
    echo "Error deleting movie: " . $conn->error;
  }

  $stmt->close();
  $conn->close();
} else {
  echo "Invalid request.";
}
?>
