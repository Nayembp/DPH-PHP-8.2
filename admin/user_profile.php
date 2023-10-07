<?php

  require_once('includes/dbcon.php');

  session_start();

  if(!isset($_SESSION['bp'])){
        header('Location:dashboard.php');
      }

  $bp_database = $_SESSION['bp'];

  $user = mysqli_query($con,"SELECT * FROM `users` WHERE `bp`='$_SESSION[bp]'");

  $row = mysqli_fetch_assoc($user);

  //user profile update
  if (isset($_POST['save'])){

    $name = $_POST['name'];
    $designation = $_POST['designation'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $bp = $_POST['bp'];
    
    $results = mysqli_query($con,"UPDATE `users` SET `name`='$name',`designation`='$designation',`mobile`='$mobile',`email`='$email' WHERE `bp` = '$bp'");

    if($results){
    
      $profile_update ="Profile update successful";
      move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$photo_name);
    }

  } 


  //user password update
  if(isset($_GET['change_pass'])){

      $password = $_GET['password'];  
      $newpassword = $_GET['newpassword'];
      $renewpassword = $_GET['renewpassword'];

      $user = mysqli_query($con,"SELECT * FROM `users` WHERE `bp`='$bp_database'");

      $row = mysqli_fetch_assoc($user);

      $password_database = $row['password'];  

      if (password_verify($password, $password_database)){

        if($newpassword == $renewpassword){

          $newpassword_encode =password_hash( $_GET['newpassword'], PASSWORD_DEFAULT);
          $succ = mysqli_query($con,"UPDATE `users` SET `password`='$newpassword_encode' WHERE `bp` = '$bp_database'");

          if($succ){
              $successful = "Password change successfull!";
          }

          
        }else{
          $c_pass_not_match = "Confirm Password Not Match";
        }
      }else{
        $old_pass_incorrect = "Please insert your old password correctly";
      }
  }

  //user image update
  if (isset($_POST['photo_change'])){

    $photo = explode('.',$_FILES['photo']['name']);
    $photo = end($photo);
    $photo_name = $bp_database.'.'.$photo;
    $results_photo = mysqli_query($con,"UPDATE `users` SET `photo`='$photo_name' WHERE `bp` = '$bp_database'");

    if($results_photo){
      $photo_update ="Image update successful";
      move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$photo_name);
    }

  } 

?>


<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <script>
            if(window.history.replaceState){
                window.history.replaceState(null,null,window.location.href);
  }
  </script>
  </head>

<body>

<!-- Header and Sidebar -->
<?php include_once 'includes/header_aside.php';?>

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Profile</h1>
    </div><!-- End Page Title -->
    <hr>

    <!-- alert -->
    <?php 
    if(isset($successful)){
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?= $successful ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php
    }
    ?>
    <?php 
    if(isset($c_pass_not_match)){
    ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?= $c_pass_not_match ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php
    }
    ?>
      <?php 
    if(isset($old_pass_incorrect)){
    ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?= $old_pass_incorrect ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php
    }
    ?>

    <?php 
      if(isset($profile_update)){
      ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $profile_update ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php
      }
    ?>

    <?php 
      if(isset($photo_update)){
      ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $photo_update ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php
      }
    ?>
          
    <section class="section profile">
      <div class="row">

        <div class="col-xl-7">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>

               
                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  
                  <div class="row" style="margin-top:20px;">
                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                    <div class="col-lg-9 col-md-8"><?=$row['name']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Designation</div>
                    <div class="col-lg-9 col-md-8"><?=$row['designation']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">BP</div>
                    <div class="col-lg-9 col-md-8"><?=$row['bp']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Present Unit</div>
                    <div class="col-lg-9 col-md-8"><?=$row['current_unit']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8"><?=$row['email']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Mobile</div>
                    <div class="col-lg-9 col-md-8"><?=$row['mobile']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">User Id Created</div>
                    <div class="col-lg-9 col-md-8"><?=$row['date_time']; ?></div>
                  </div>

                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form action="" method="POST" enctype="multipart/form-data">
                    

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="name" type="text" class="form-control" id="fullName" value="<?=$row['name']; ?>">
                        <input name="bp" type="hidden"  value="<?=$row['bp']; ?>">
                      </div>
                    </div>


                    <div class="row mb-3">
                      <label for="designation" class="col-md-4 col-lg-3 col-form-label">Designation</label>
                      <div class="col-md-8 col-lg-9">
                        <select class="form-control" id="designation" name="designation">
                          <option value="">Select</option>
                          <option <?php echo $row['designation']=='Inspector(UB)' ?'selected=""':''; ?> value="Inspector(UB)">Inspector(UB)</option>
                          <option <?php echo $row['designation']=='Inspector(AB)' ?'selected=""':''; ?> value="Inspector(AB)">Inspector(AB)</option>
                          <option <?php echo $row['designation']=='SI(UB)' ?'selected=""':''; ?> value="SI(UB)">SI(UB)</option>
                          <option <?php echo $row['designation']=='SI(AB)' ?'selected=""':''; ?> value="SI(AB)">SI(AB)</option>
                          <option <?php echo $row['designation']=='ASI(UB)' ?'selected=""':''; ?> value="ASI(UB)">ASI(UB)</option>
                          <option <?php echo $row['designation']=='ASI(AB)' ?'selected=""':''; ?> value="ASI(AB)">ASI(AB)</option>
                          <option <?php echo $row['designation']=='Nayek' ?'selected=""':''; ?> value="Nayek">Nayek</option>
                          <option <?php echo $row['designation']=='Constable' ?'selected=""':''; ?> value="Constable">Constable</option>
                        </select>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="email" type="text" class="form-control" id="email" value="<?=$row['email']; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="mobile" class="col-md-4 col-lg-3 col-form-label">Mobile</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="mobile" type="text" class="form-control" id="mobile" value="<?=$row['mobile']; ?>">
                      </div>
                    </div>

                    <div class="text-center">

                    <input class="btn btn-primary" type="submit" value="Save Changes" name="save">
                     
                    </div>
                  </form><!-- End Profile Edit Form -->
                </div>
                

                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <!-- Change Password Form -->

                  <form action="" method="GET">

                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="password" type="password" class="form-control" id="currentPassword">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="newpassword" type="password" class="form-control" id="newPassword">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                        
                      </div>
                    </div>

                    <div class="text-center">
                      <input class="btn btn-primary" type="submit" value="Change Password" name="change_pass">
                    </div>
                  </form><!-- End Change Password Form -->

                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>

        <div class="col-xl-5">

          <div class="card">
          <div class="card-body profile-card pt-5 d-flex flex-column align-items-center">

              <img src="../images/<?=$row['photo']?>" width="100" height="100"  alt="Profile" class="rounded-circle">
              <h2><?=$row['name']; ?></h2>
              <h3><?=$row['designation']; ?></h3>
              <h3>BP: <?=$row['bp']; ?></h3>
              <h3>Unit: <?=$row['current_unit']; ?></h3>
             <!--image change-->
              <div class="align-items-center">
                  <form action="" method="POST" enctype="multipart/form-data">
                    <div class="col-md-12 mt-3">
                      
                        <div class="pt-2">
                          <label for ="uploadimage" class="btn btn-outline-success btn-sm" title="Upload new profile image"><i class="bi bi-upload "></i> For image change click here</label>
                          <input type="file" id="uploadimage" name="photo" hidden />
                          <button class="btn btn-primary btn-sm" name="photo_change" >Update</button>
                        </div>
                    </div>
                    
                  </form>
              </div>
              

             
            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

<!-- Footer -->
<?php include_once 'includes/footer.php' ?>

</body>
</html>