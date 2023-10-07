<?php

require_once('includes/dbcon.php');

session_start();

if(!isset($_SESSION['admin'])){
    header('Location:dashboard.php');
  }

$sql = "SELECT * FROM `users`";

?>

<!DOCTYPE html>
<html lang="en">


<head>
    <!--DataTable File -->
  <link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap/css/bootstrap2.css">
  <link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap/css/buttons.bootstrap4.min.css">
  

  <script type="text/javascript" src="assets/vendor/bootstrap/js/jquery-3.5.1.js"></script>
  <script type="text/javascript" src="assets/vendor/bootstrap/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="assets/vendor/bootstrap/js/dataTables.bootstrap4.min.js"></script>
  <script type="text/javascript" src="assets/vendor/bootstrap/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" src="assets/vendor/bootstrap/js/buttons.bootstrap4.min.js"></script>
  <script type="text/javascript" src="assets/vendor/bootstrap/js/jszip.min.js"></script>
  <script type="text/javascript" src="assets/vendor/bootstrap/js/pdfmake.min.js"></script>
  <script type="text/javascript" src="assets/vendor/bootstrap/js/vfs_fonts.js"></script>
  <script type="text/javascript" src="assets/vendor/bootstrap/js/buttons.html5.min.js"></script>
  <script type="text/javascript" src="assets/vendor/bootstrap/js/buttons.print.min.js"></script>
  <script type="text/javascript" src="assets/vendor/bootstrap/js/buttons.colVis.min.js"></script>
  <script type="text/javascript" src="assets/vendor/bootstrap/js/script.js"></script>


</head>



<body>

 <!-- ======= Header and Sidebar ======= -->
 
  <?php include_once 'includes/header_aside.php';?>

  <!-- ======= End Header and Sidebar ======= -->

  


  
  <main id="main" class="main">


    <div class="pagetitle">
      <h1>View All Users</h1>
    </div><!-- End Page Title -->
  
  <hr>

  <?php 
    if(isset($_GET['delete']) && $_GET['delete'] == 1){
      ?>
          <div class='alert alert-success alert-dismissible fade show' role='alert'>
            Data successfully deleted!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>
      <?php
    }
  ?>

<?php 
    if(isset($_GET['edit']) && $_GET['edit'] == 1){
      ?>
          <div class='alert alert-success alert-dismissible fade show' role='alert'>
            User information updated successfully!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>
      <?php
    }
  ?>



    <section class="section">
            <div class="row">
              <div class="col-lg-12 ">
                <div class="card">
                  <div class="card-body" style="padding-top:20px;">
                     

                    <table id="example" class="table table-striped table-bordered table-responsive" style="width:100%; display: scrool; ">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>ID</th>
                                <th>BP</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Mobile Number</th>
                                <th>Email</th>
                                <th>Current Unit</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Image</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php 

                                $result = mysqli_query($con,$sql);
                                while ($row = mysqli_fetch_assoc($result)) {
                                
                                ?>


                            <tr>
                                <td>
                                    <a onclick="return confirm('Do you want to delete this user?')" href="user_delete.php?id=<?= base64_encode($row['id'])?>"><i style="color: red;" class="bi bi-trash-fill"></i></a>
                                    <a href="user_edit.php?edit=<?= base64_encode ($row['bp'])?>"> <i  style="color: green;" class="bi bi-pencil-square"></i></a>
                                    <a href="#"> <i style="color: blue;" class="bi bi-eye-fill"></i></a>
                                </td>
                                <td><?=$row['id']?></td>
                                <td><?=$row['bp']?></td>
                                <td><?=$row['name']?></td>
                                <td><?=$row['designation']?></td>
                                <td><?=$row['mobile']?></td>
                                <td><?=$row['email']?></td>
                                <td><?=$row['current_unit']?></td>
                                <td><?=$row['role']?></td>
                                <td><?=$row['status']?></td>
                                <td><img src = "../images/<?=$row['photo']?>" width="100" height="100" alt="No Photo"> </td>
                            </tr>

                            <?php

                                }

                            ?>

                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Action</th>
                                <th>ID</th>
                                <th>BP</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Mobile Number</th>
                                <th>Email</th>
                                <th>Current Unit</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Image</th>                                
                            </tr>
                        </tfoot>
                      </table>


                  </div>
                </div>
              </div>
            </div>
          </section>



  </main><!-- End #main -->

  <!-- ======= Footer ======= -->

  <?php include_once 'includes/footer.php' ?>

  <!-- End Footer -->

 
</body>

</html>