<?php

require_once('includes/dbcon.php');
session_start();

if(!isset($_SESSION['admin'])){
    header('Location:dashboard.php');
  }

if (isset($_GET['edit'])) {
    
    $bp = base64_decode($_GET['edit']);
    $result = mysqli_query($con,"SELECT * FROM `users` WHERE `bp`='$bp'");
    $row_user_edit = mysqli_fetch_assoc($result);
  }





  if(isset($_POST['update'])){

    $bp_search = $_POST['bp'];
    $result = mysqli_query($con,"SELECT * FROM `force_data` WHERE `bp`='$bp_search'");
    $row = mysqli_fetch_assoc($result);
  }



if(isset($_POST['update'])){
    
    
    $password = $_POST['password'];
    $c_password = $_POST['c_password'];
   
    $role = $_POST['role'];
    
    $status = $_POST['status'];

    
    $photo_name = $_POST['img_name'];
    
    $input_error = array();


  
    if(count($input_error)== 0){

      $bp_check = mysqli_query($con,"SELECT * FROM `users` WHERE `bp`='$bp'");

      if(mysqli_num_rows($bp_check) > 0){

        if($password == $c_password){


          $results = mysqli_query($con,"UPDATE `users` SET `password`='$password',`role`='$role',`status`='$status' WHERE `bp` = '$bp'");

          

          if($results){

            $input_success = "Data Insert Success";
            header('Location: user_view.php?edit=1');

            
          }else{

            $update_error = "Data Insert Error";
          }
        }else{

          $password_not_match = "Confirm Password Not Match";
        }
      }else{

        $bp_error = "This User Has Already An Account";
      }
    }


   }


?>



<head>

<style>
    
  .error{
  color: red;
  font-style: italic;
  font-weight: 700;
}

  </style>

  <script>
            if(window.history.replaceState){
                window.history.replaceState(null,null,window.location.href);
  }
  </script>

 </head>

<body>


<!-- ======= Header and Sidebar ======= -->
 
  <?php include_once 'includes/header_aside.php';?>

  <!-- ======= End Header and Sidebar ======= -->


  
  <main id="main" class="main">


    <!--end From-->

     <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title d-flex justify-content-center" style="border-bottom: 2px solid #4154f1;">Update User</h5>

                <div class="row">
                  <div class="col-md-8">
                    <form action="" method="POST" class="row g-3 needs-validation" novalidate>
                    
                      <div class="col-6">
                      <div class="input-group has-validation">
                       
                        <span class="input-group-text" id="inputGroupPrepend">BP</span>
                        <input type="text" name="bp" class="form-control" id="bp" placeholder="Please Input BP & Search" required>
                        <button class="btn btn-outline-primary pull-right" type="submit" name="bp_search"><i class="ri-search-eye-line" ></i></button>  
                        <div class="invalid-feedback">Please enter your user ID.</div>
                                          
                      </div>

                    </div>

                    </form>
                  </div>

                  <div class="col-md-4">
                    <form action="" method="POST" class="row g-3 needs-validation" novalidate>
                      <table style="width: 100%;">
                        <tr>
                          <td >
                            <label for="bp" class="form-label"></label>
                          </td>
                          
                          <td style="width: 25px;">
                            <a href="user_view.php" class="btn btn-primary d-flex justify-content-right" style="margin-bottom: 15px;">Users</a>
                          </td>
                        </tr>
                      </table>
                    </form>
                  </div>
                </div>



                 <section class="section">
      <div class="row">
        <div class="col-lg-9">
          <div class="card">
            <div class="card-body">
              <hr>
               
              
              <!-- General Form Elements -->
              <form action="" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>

                                

                <div class="col-md-4">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php if(isset($row_user_edit['name'])){echo $row_user_edit['name']; } ?>"  readonly>
                </div>

                <div class="col-md-4">
                  <label for="bp" class="form-label">BP</label>
                  <input class="form-control" type="Text"id="bp" name="bp" value="<?php if(isset($row_user_edit['bp'])){echo $row_user_edit['bp']; } ?>"  readonly>
                </div>

                <div class="col-md-4">
                  <label  class="form-label">Designation</label>
                  <input class="form-control" type="Text" name="designation" value="<?php if(isset($row_user_edit['designation'])){echo $row_user_edit['designation']; } ?>"  readonly>
                </div>



                <div class="col-md-4">
                  <label class="form-label">Unit</label>
                  <input type="text" class="form-control" name="current_unit" value="<?php if(isset($row_user_edit['current_unit'])){echo $row_user_edit['current_unit']; } ?>"  readonly>
                </div>

                <div class="col-md-4">
                  <label class="form-label">Mobile Number</label>
                  <input class="form-control" type="Text"  name="mobile" value="<?php if(isset($row_user_edit['mobile'])){echo $row_user_edit['mobile']; } ?>"  readonly>
                  <input class="form-control" type="email"  id="email" name="email" value="<?php if(isset($row_user_edit['email'])){echo $row_user_edit['email']; } ?>" hidden >
                </div>

                

                <div class="col-md-4">
                  <label class="form-label">Home District</label>
                  <input class="form-control" type="text"  name="home_district" value="<?php if(isset($row_user_edit['home_district'])){echo $row_user_edit['home_district']; } ?>" readonly>
                </div>     

                 <hr style="border-bottom: 5px solid #4154f1;">

  
                <div class="col-md-4">
                  <label for="status" class="form-label">User Status</label>
                    <select class="form-select" name="status" id="status" required>
                              <option selected disabled value="">Select</option>
                              <option <?php echo $row_user_edit['status'] == 'Active' ? 'selected = ""':''; ?> value="Active">Active</option>
                              <option <?php echo $row_user_edit['status'] == 'Inactive' ? 'selected = ""':''; ?> value="Inactive">Inactive</option>
                             
                    </select>             
                 </div>

                 <div class="col-md-4">
                  <label for="role" class="form-label">User Role</label>
                    <select class="form-select" name="role" id="role" required>
                              <option selected disabled value="">Select</option>
                              <option <?php echo $row_user_edit['role'] == 'Admin' ? 'selected = ""':''; ?> value="Admin">Admin</option>
                              <option <?php echo $row_user_edit['role'] == 'Editor' ? 'selected = ""':''; ?> value="Editor">Editor</option>
                              <option <?php echo $row_user_edit['role'] == 'Viewer' ? 'selected = ""':''; ?> value="Viewer">Viewer</option>
                              
                    </select>             
                 </div>

<!--
                <div class="col-md-3">
                  <label for="password" class="form-label">Password</label>
                  <input class="form-control" type="password" placeholder="Password" id="password" name="password" value="<?php if(isset($row_user_edit['password'])){echo $row_user_edit['password']; } ?>" required>
                  <div class="valid-feedback">
                  Looks good!
                  </div>
                </div>
-->

                <?php 
                  if(isset($_POST['reset_pass'])){
                    $bp = base64_decode($_GET['edit']);
                    $password_default = substr($bp, 2);
                    $pasword_hash = password_hash( $password_default, PASSWORD_DEFAULT);
                    
                    $result_pass_reset = mysqli_query($con,"UPDATE `users` SET `password`='$pasword_hash' WHERE `bp` = '$bp'");

                  }
                ?>


                <form method="POST" action="">
                  <div class="col-md-4">
                      <label for="" class="form-label"></label>
                      <input  type="submit" value="Reset Password" name="reset_pass" class="btn btn-danger" style="margin-top:25px; margin-left:25px" />
                  </div>
                </form>

                 
                <div style="text-align:center; margin-top: 1rem;">
                  <label class="col-sm-12 col-form-label"></label>
                  <div class="col-sm-12">
                    <input type="submit" value="Update" name="update" class="btn btn-primary" />
                  </div>
                </div>



              
            </div>
          </div>
        </div>
        <div class="col-lg-3">
           <div class="card">
            <div class="card-body">
              <hr>
               
              
              

                 
                <div class="col-md-12">
                  <label for="photo" class="form-label"></label>
                  <img src = "../images/<?=$row_user_edit['photo']?>" width="180" height="180" alt="No Photo Uploaded" name="photo">
                  
                  <input class="form-control" type="text"  name="img_name" value="<?php if(isset($row_user_edit['photo'])){echo $row_user_edit['photo']; } ?>" hidden >
                  <input type="text" class="form-control" placeholder="Username" value="<?php if(isset($row_user_edit['name'])){echo $row_user_edit['name']; } ?>" style="text-align: center;" readonly>

                  <div class="valid-feedback">
                    Looks good! 
                  </div>
                </div>


               
              </form><!-- End General Form Elements -->
            </div>
          </div>
        </div>
      </div>
    </section>






            </div>
          </div>
        </div>
      </div>
    </section>







  </main><!-- End #main -->

  <!-- ======= Footer ======= -->

  <?php include_once 'includes/footer.php' ?>
  <!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>