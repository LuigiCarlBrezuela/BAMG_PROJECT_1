<?php
  include('partials\header.php');
  include('partials\sidebar.php');
  include('database\database.php');

  // Handle search query
  $query = isset($_GET['query']) ? $_GET['query'] : '';

  // Prepare the SQL query
  if ($query) {
    $sql = "SELECT * FROM movies WHERE title LIKE ? OR release_year LIKE ? OR genre LIKE ? OR ratings LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchTerm = '%' . $query . '%';
    $stmt->bind_param("ssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $movies = $stmt->get_result();
  } else {
    $sql = "SELECT * FROM movies";
    $movies = $conn->query($sql);
  }
?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Movie Information Management System</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item">Tables</li>
        <li class="breadcrumb-item active">General</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h5 class="card-title">Movie Table</h5>
              </div>
              <div>
                <button class="btn btn-primary btn-sm mt-4 mx-3" data-bs-toggle="modal" data-bs-target="#addMovie">Add Movie</button>
              </div>
            </div>

            <!-- Default Table -->
            <table class="table table-striped" >
              <thead>
                <tr>
                  <th scope="col">Movie ID</th>
                  <th scope="col">Movie Title</th>
                  <th scope="col">Release Year</th>
                  <th scope="col">Genre</th>
                  <th scope="col">Ratings</th>
                  <th scope="col" class="text-center">Action</th>
                </tr>
              </thead>               
              <tbody>
                <?php if ($movies->num_rows > 0): ?>
                  <?php while($row = $movies->fetch_assoc()): ?>
                    <tr>
                      <td><?php echo $row['movie_id']; ?></td>
                      <td><?php echo $row['title']; ?></td>
                      <td><?php echo $row['release_year']; ?></td>
                      <td><?php echo $row['genre']; ?></td>
                      <td><?php echo $row['ratings']; ?></td>
                      <td class="d-flex justify-content-center">
                        <button class="btn btn-success btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#editInfo" onclick="populateEditForm(<?php echo htmlspecialchars(json_encode($row)); ?>)">Edit</button>
                        <button class="btn btn-secondary btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#viewInfo" onclick="populateViewForm(<?php echo htmlspecialchars(json_encode($row)); ?>)">View</button>
                        <button class="btn btn-danger btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#deleteInfo" onclick="populateDeleteForm(<?php echo $row['movie_id']; ?>)">Delete</button>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="7" class="text-center">No Movie found</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
            <!-- End Default Table Example -->
          </div>
          <div class="mx-4">
            <nav aria-label="Page navigation example">
              <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
              </ul>
            </nav>
          </div>
        </div>

      </div>
    </div>

    <!-- Add Movie Modal -->
    <div class="modal fade" id="addMovie" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addMovieLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="addMovieLabel">Add Movie</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="addMovieForm" novalidate>
              <div class="mb-3">
                <label for="addMovieTitle" class="form-label">Movie Title</label>
                <input type="text" class="form-control" id="addMovieTitle" name="title" required>
                <div class="invalid-feedback">Please fill out the Movie Title field.</div>
              </div>
              <div class="mb-3">
                <label for="addReleaseYear" class="form-label">Release Year</label>
                <input type="number" class="form-control" id="addReleaseYear" name="release_year" required>
                <div class="invalid-feedback">Please fill out the Release Year field.</div>
              </div>
              <div class="mb-3">
                <label for="addGenre" class="form-label">Genre</label>
                <input type="text" class="form-control" id="addGenre" name="genre" required>
                <div class="invalid-feedback">Please fill out the Genre field.</div>
              </div>
              <div class="mb-3">
                <label for="addRatings" class="form-label">Ratings</label>
                <input type="number" class="form-control" id="addRatings" name="ratings" required>
                <div class="invalid-feedback">Please fill out the Ratings field.</div>
              </div>
              <div id="validationMessage" class="text-danger"></div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="saveNewMovie">Save Movie</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editInfoLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="editInfoLabel">Edit Movie Information</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="editMovieForm">
              <div class="mb-3">
                <label for="movieTitle" class="form-label">Movie Title</label>
                <input type="text" class="form-control" id="movieTitle" name="title" required>
                <div class="invalid-feedback">Please fill out the Movie Title field.</div>
              </div>
              <div class="mb-3">
                <label for="releaseYear" class="form-label">Release Year</label>
                <input type="number" class="form-control" id="releaseYear" name="release_year" required>
                <div class="invalid-feedback">Please fill out the Release Year field.</div>
              </div>
              <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <input type="text" class="form-control" id="genre" name="genre" required>
                <div class="invalid-feedback">Please fill out the Genre field.</div>
              </div>
              <div class="mb-3">
                <label for="ratings" class="form-label">Ratings</label>
                <input type="number" class="form-control" id="ratings" name="ratings" required>
                <div class="invalid-feedback">Please fill out the Ratings field.</div>
              </div>
              <input type="hidden" id="movieId" name="movie_id">
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="saveChanges">Save changes</button>
          </div>
        </div>
      </div>
    </div>

    <!-- View Modal -->
    <div class="modal fade" id="viewInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="viewInfoLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="viewInfoLabel">View Movie Information</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="viewMovieForm">
              <div class="mb-3">
                <label for="viewMovieTitle" class="form-label">Movie Title</label>
                <input type="text" class="form-control" id="viewMovieTitle" name="title" readonly>
              </div>
              <div class="mb-3">
                <label for="viewReleaseYear" class="form-label">Release Year</label>
                <input type="number" class="form-control" id="viewReleaseYear" name="release_year" readonly>
              </div>
              <div class="mb-3">
                <label for="viewGenre" class="form-label">Genre</label>
                <input type="text" class="form-control" id="viewGenre" name="genre" readonly>
              </div>
              <div class="mb-3">
                <label for="viewRatings" class="form-label">Ratings</label>
                <input type="number" class="form-control" id="viewRatings" name="ratings" readonly>
              </div>
              <input type="hidden" id="viewMovieId" name="movie_id">
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteInfoLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="deleteInfoLabel">Delete Movie</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to delete this movie?</p>
            <input type="hidden" id="deleteMovieId">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
            <button type="button" class="btn btn-danger" id="confirmDelete">Yes</button>
          </div>
        </div>
      </div>
    </div>
  </section>

</main><!-- End #main -->

<?php
include('partials\footer.php');
?>

<script>
  function populateEditForm(movie) {
    document.getElementById('movieId').value = movie.movie_id;
    document.getElementById('movieTitle').value = movie.title;
    document.getElementById('releaseYear').value = movie.release_year;
    document.getElementById('genre').value = movie.genre;
    document.getElementById('ratings').value = movie.ratings;
  }

  function populateViewForm(movie) {
    document.getElementById('viewMovieId').value = movie.movie_id;
    document.getElementById('viewMovieTitle').value = movie.title;
    document.getElementById('viewReleaseYear').value = movie.release_year;
    document.getElementById('viewGenre').value = movie.genre;
    document.getElementById('viewRatings').value = movie.ratings;
  }

  function populateDeleteForm(movieId) {
    document.getElementById('deleteMovieId').value = movieId;
  }

  function validateForm(formId) {
    var form = document.getElementById(formId);
    var title = form.querySelector('[name="title"]').value.trim();
    var releaseYear = form.querySelector('[name="release_year"]').value.trim();
    var genre = form.querySelector('[name="genre"]').value.trim();
    var ratings = form.querySelector('[name="ratings"]').value.trim();
    var isValid = true;

    if (!title) {
      form.querySelector('[name="title"]').classList.add('is-invalid');
      isValid = false;
    } else {
      form.querySelector('[name="title"]').classList.remove('is-invalid');
    }

    if (!releaseYear || isNaN(releaseYear)) {
      form.querySelector('[name="release_year"]').classList.add('is-invalid');
      isValid = false;
    } else {
      form.querySelector('[name="release_year"]').classList.remove('is-invalid');
    }

    if (!genre) {
      form.querySelector('[name="genre"]').classList.add('is-invalid');
      isValid = false;
    } else {
      form.querySelector('[name="genre"]').classList.remove('is-invalid');
    }

    if (!ratings || isNaN(ratings)) {
      form.querySelector('[name="ratings"]').classList.add('is-invalid');
      isValid = false;
    } else {
      form.querySelector('[name="ratings"]').classList.remove('is-invalid');
    }

    return isValid;
  }

  document.getElementById('saveChanges').addEventListener('click', function() {
    if (!validateForm('editMovieForm')) {
      return;
    }

    var form = document.getElementById('editMovieForm');
    var formData = new FormData(form);

    fetch('database/update.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        location.reload();
      } else {
        alert('Failed to update movie information: ' + (data.error || 'Unknown error'));
      }
    })
    .catch(error => console.error('Error:', error));
  });

  document.getElementById('confirmDelete').addEventListener('click', function() {
    var movieId = document.getElementById('deleteMovieId').value;
    var formData = new FormData();
    formData.append('movie_id', movieId);

    fetch('database/delete.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.text())
    .then(data => {
      alert(data);
      location.reload();
    })
    .catch(error => console.error('Error:', error));
  });

  document.getElementById('saveNewMovie').addEventListener('click', function() {
    if (!validateForm('addMovieForm')) {
      return;
    }

    var form = document.getElementById('addMovieForm');
    var formData = new FormData(form);

    fetch('database/create.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        location.reload();
      } else {
        document.getElementById('validationMessage').textContent = 'Failed to add movie: ' + (data.error || 'Unknown error');
      }
    })
    .catch(error => {
      document.getElementById('validationMessage').textContent = 'Error: ' + error;
      console.error('Error:', error);
    });
  });

  // Ensure only numbers are allowed in the Release Year and Ratings fields
  document.getElementById('addReleaseYear').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  document.getElementById('addRatings').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  document.getElementById('releaseYear').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
  });

  document.getElementById('ratings').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
  });
</script>