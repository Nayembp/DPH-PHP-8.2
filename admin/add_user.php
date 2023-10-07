<?php

require_once('includes/dbcon.php');
  session_start();

  if(!isset($_SESSION['bp'])){
      header('Location:dashboard.php');
    }

  if(!isset($_SESSION['admin'])){
      header('Location:dashboard.php');
    }

  if(isset($_POST['bp_search'])){

    $bp_search_without_bp = $_POST['bp'];
    $bp_search = "BP".$bp_search_without_bp;
    $result = mysqli_query($con,"SELECT * FROM `force_data` WHERE `bp`='$bp_search'");
    $row_add_user = mysqli_fetch_assoc($result);
  }



 if(isset($_POST['adduser'])){
    
    $name = $_POST['name'];
    $bp = $_POST['bp'];
    $designation = $_POST['designation'];
    $current_unit = $_POST['current_unit'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $c_password = $_POST['c_password'];
    $role = $_POST['role'];
    $status = "Active";

    $photo_name = $_POST['img_name'];

    $input_error = array();

    
  
      if(count($input_error)== 0){
        $bp_check = mysqli_query($con,"SELECT * FROM `users` WHERE `bp`='$bp'");
        
        if(mysqli_num_rows($bp_check)== 0){
          
          if($password == $c_password){
           $password = password_hash($password, PASSWORD_DEFAULT);
            

            $query = "INSERT INTO `users`(`name`,`bp`,`designation`,`current_unit`,`mobile`,`email`,`password`,`status`,`role`,`photo`) VALUES('$name','$bp','$designation','$current_unit','$mobile','$email','$password','$status','$role','$photo_name')";

            $result = mysqli_query($con,$query);

            if($result){

              $input_success = "Data Insert Success";

              $_SESSION['data_insert_success'] = "Data Insert Success";
                  move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$photo_name);
                  header('Location:add_user.php?success=1');
            }else{

              $_SESSION['data_insert_error'] = "Data Insert Error";
              
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


<!DOCTYPE html>
<html lang="en">

<head>
    <!--alert-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
 <!--sweet alert-->
  <script type="text/javascript" src="assets/js/sweetalert.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>



  <script>
            if(window.history.replaceState){
                window.history.replaceState(null,null,window.location.href);
  }
  </script>

</head>

<body>

   <!-- Start Header and Sidebar -->
 
  <?php include_once 'includes/header_aside.php';?>

  <!-- ======= End Header and Sidebar ======= -->
  
  <main id="main" class="main">

    <!--sweet alart success-->
      <?php
        if (isset($_GET["success"]) && $_GET["success"] == 1) {
          ?>
          <script>
          swal({
                title: "Success",
                text: "User added successfully",
                icon: "success",
                button: "OK",
              });
          </script>
          <?php
        }

      ?>


    <?php 
      if(isset($bp_error)){
      ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <?=$bp_error; ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

        <?php
      }
      ?>


      <?php 
      if(isset($password_not_match)){
      ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <?=$password_not_match; ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
      }
      ?>


    <!--sweet alart success-->

    <!--end From-->
      <section class="section">
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title d-flex justify-content-center" style="border-bottom: 2px solid #4154f1;">Add User</h5>

                    <div class="row">

                        <div class="col-md-8">
                          <form action="" method="POST" class="row g-3 needs-validation" novalidate>
                            <div class="col-6">
                              <div class="input-group has-validation">
                                <span class="input-group-text" id="inputGroupPrepend">BP</span>
                                <input type="text" name="bp" class="form-control" id="bp" placeholder="Please Input BP & Search" required />
                                <button class="btn btn-outline-primary pull-right" type="submit" name="bp_search"><i class="ri-search-eye-line" ></i></button>  
                                <div class="invalid-feedback">Please enter your user ID.</div>                 
                              </div>
                            </div>
                          </form>
                        </div>

                        <div class="col-md-4">
                          <form action="" method="POST" class="row g-3 needs-validation" novalidate>
                            <table style="width: 100%;">
                              <tr>  <td >
                                  <label for="bp" class="form-label"></label>
                                </td>
                                                             
                                <td style="width: 20px;">
                                  <a href="user_view.php" class="btn btn-warning d-flex justify-content-right" style="margin-bottom: 15px;">View All</a>
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
                                     
                      <!-- User Form  -->
                        <form action="" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                                  <div class="col-md-4">
                                      <label for="name" class="form-label">Name</label>
                                      <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="<?php if(isset($row_add_user['name'])){echo $row_add_user['name']; } ?>" readonly />
                                  </div>

                                  <div class="col-md-4">
                                    <label for="bp" class="form-label">BP</label>
                                    <input class="form-control" type="Text" placeholder="BP" id="bp" name="bp" value="<?php if(isset($row_add_user['bp'])){echo $row_add_user['bp']; } ?>" readonly />
                                  </div>

                                  <div class="col-md-4">
                                    <label for="designation" class="form-label">Designation</label>
                                    <input class="form-control" type="Text" placeholder="Designation" id="designation" name="designation" value="<?php if(isset($row_add_user['designation'])){echo $row_add_user['designation']; } ?>"readonly />
                                  </div>

                                  <div class="col-md-4">
                                    <label for="current_unit" class="form-label">Unit</label>
                                    <input type="text" class="form-control" id="current_unit" placeholder="Unit" name="current_unit" value="<?php if(isset($row_add_user['current_unit'])){echo $row_add_user['current_unit']; } ?>" readonly />
                                  </div>

                                  <div class="col-md-4">
                                    <label for="mobile" class="form-label">Mobile Number</label>
                                    <input class="form-control" type="Text" placeholder="Mobile Number" id="mobile" name="mobile" value="<?php if(isset($row_add_user['mobile'])){echo $row_add_user['mobile']; } ?>" readonly />
                                   
                                    <input class="form-control" type="email" placeholder="Email" id="email" name="email" value="<?php if(isset($row_add_user['email'])){echo $row_add_user['email']; } ?>" hidden />
                                  </div>

                                  <div class="col-md-4">
                                    <label for="home_district" class="form-label">Home District</label>
                                    <input class="form-control" type="text" placeholder="Home District" id="home_district" name="home_district" value="<?php if(isset($row_add_user['home_district'])){echo $row_add_user['home_district']; } ?>" required>
                                   
                                  </div>     


                                   <hr style="border-bottom: 5px solid #4154f1;">

                                  
                                   <div class="col-md-4">
                                    <label for="role" class="form-label">User Role</label>
                                      <select class="form-select" name="role" id="role" required>
                                                <option selected disabled value="">Select</option>
                                                <option value="Admin">Admin</option>
                                                <option value="Editor">Editor</option>
                                                <option value="Viewer">Viewer</option>
                                      </select>             
                                   </div>

                                  <div class="col-md-4">
                                    <label for="password" class="form-label">Password</label>
                                    <input class="form-control" type="password" placeholder="Password" id="password" name="password" value="<?php if(isset($row_add_user['password'])){echo $row_add_user['password']; } ?>" required />
                                    <div class="valid-feedback">
                                      Looks good!
                                    </div>
                                  </div>

                                  <div class="col-md-4">
                                    <label for="c_password" class="form-label">Confirm Password</label>
                                    <input class="form-control" type="password" placeholder="Confirm Password" id="c_password" name="c_password" value="<?php if(isset($row_add_user['password'])){echo $row_add_user['password']; } ?>" required />
                                  </div>


                                  <div style="text-align:center; margin-top: 1rem;">
                                    <label class="col-sm-12 col-form-label"></label>
                                    <div class="col-sm-12">
                                      <input type="submit" value="Add User" name="adduser" class="btn btn-primary" />
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
                                    <img src = "../images/<?=$row_add_user['image']?>" width="180" height="180" alt="No Photo Uploaded" name="photo"/>
                                    
                                    <input class="form-control" type="text"  name="img_name" value="<?php if(isset($row_add_user['image'])){echo $row_add_user['image']; } ?>" hidden />
                                    <input type="text" class="form-control" placeholder="Username" value="<?php if(isset($row_add_user['name'])){echo $row_add_user['name']; } ?>" style="text-align: center;" readonly />
                                  </div>


                       
                      </form><!-- end user add -->
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

  <!--Footer -->
  <?php include_once 'includes/footer.php' ?>
  <!-- End Footer -->

</body>
</html>