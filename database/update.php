<?php
include('database.php');

if (isset($_POST['movie_id'])) {
  $movie_id = $_POST['movie_id'];
  $title = $_POST['title'];
  $release_year = $_POST['release_year'];
  $genre = $_POST['genre'];
  $descriptions = $_POST['descriptions'];
  $rating = $_POST['ratings'];

  // Prepare and execute the update query
  $stmt = $conn->prepare("UPDATE movies SET title = ?, release_year = ?, genre = ?, descriptions = ?,  ratings = ? WHERE movie_id = ?");
  $stmt->bind_param("sisdi", $title, $release_year, $genre, $descriptions, $rating, $movie_id);

  if ($stmt->execute()) {
    echo "Record updated successfully";
  } else {
    echo "Error updating record: " . $stmt->error;
  }

  $stmt->close();
  $conn->close();
} else {
  echo "Invalid request.";
}
?>
