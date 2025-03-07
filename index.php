<?php
  include('partials\header.php');
  include('partials\sidebar.php');
  include('database\database.php');


  // Your PHP BACK CODE HERE
  $sql = "SELECT * FROM movies";
  $movies = $conn->query($sql);

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
                  <button class="btn btn-primary btn-sm mt-4 mx-3">Add Movie</button>
                </div>
              </div>

              <!-- Default Table -->
              <table class="table">
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
                          <button class="btn btn-success btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#editInfo">Edit</button>
                          <button class="btn btn-secondary btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#viewInfo">View</button>
                          <button class="btn btn-danger btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#deleteInfo">Delete</button>
                          <!-- UPDATE MODAL -->
                           <div class="modal fade" id="editInfo" data-bs-backdrop="static" data-bs-toggle="false" tabindex="-1" aria-labelledby="editInfoLabel" aria-hidden="true">
                          <!-- VIEW MODAL   -->
                          <div class="modal fade" id="viewInfo" data-bs-backdrop="static" data-bs-toggle="false" tabindex="-1" aria-labelledby="viewInfoLabel" aria-hidden="true">
                          </div>
                          <!-- DELETE MODAL -->
                           <div class="modal fade" id="deleteInfo" data-bs-backdrop="static" data-bs-toggle="false" tabindex="-1" aria-labelledby="deleteInfoLabel" aria-hidden="true">
                            
                           </div>
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

      <!-- Modal -->
      <div class="modal fade" id="editInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editInfoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="editInfoLabel">Employee Information</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              ...
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->
<?php
include('partials\footer.php');
?>