<?php
      require_once'admin/includes/dbcon.php'; //database con

      
      session_start(); 

      if(isset($_SESSION['bp'])){  
        header('Location:admin/dashboard.php');
      }



    if(isset($_POST['login'])){  // if user clicks login or submit button then--

      $bp1 = $_POST['bp']; //get bp from input field and keep it in bp variable
      $bp = "BP".$bp1;
      $password = $_POST['password']; //get pass from input field and keep it in password variable
      
      $bp_check = mysqli_query($con,"SELECT * FROM `users` WHERE `bp`='$bp'"); //check input pb with database if it matches or not

     if(mysqli_num_rows($bp_check)>0){  //if bp found then 
      
      $row= mysqli_fetch_assoc($bp_check); //get this bp into this row variable
       
      
      if (password_verify($password, $row['password'])){  //match password with input password

        if($row['status'] == 'Active'){  //match status with databse for active inactive status

          $_SESSION['bp']= $bp;
          $_SESSION['role'] = 'yes';
          header('Location: admin/dashboard.php'); //and send him to dashboard

          if($row['role'] == 'Admin'){
            $_SESSION['admin']= $bp;
          }
          if($row['role'] == 'Editor'){
            $_SESSION['editor']= $bp;
          }
          if($row['role'] == 'Viewer'){
            $_SESSION['viewer']= $bp;
          }

          // $_SESSION['bp']= $bp;  //if all matches then creat a session
          // $_SESSION['is_login'] = 'yes';

          // header('Location: admin/dashboard.php'); //and send him to dashboard

        }else{ 

          $status_inactive ="Your id is inactive. Please contact with administrator";
        }

      }else{

          $wrong_password ="Wrong password";
        }
      
    }else{
          $wrong_bp ="Wrong user id";
         
        }

  }


?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="admin/assets/img/favicon.png" rel="icon">
  <link href="admin/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  
  <!-- Vendor CSS Files -->
  <link href="admin/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="admin/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="admin/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="admin/assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="admin/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="admin/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="admin/assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="admin/assets/css/style.css" rel="stylesheet">

  <script>
            if(window.history.replaceState){
                window.history.replaceState(null,null,window.location.href);
  }
  </script>
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="#" class="logo d-flex align-items-center w-auto">
                  
                    <span class="d-none d-lg-block">Divisional Police Hospital</span>
                </a>
              </div>

                    <div>
                      <p style="font-size: 20; margin-top: -15px; color: green;"><b>(DPH) Barishal</b></p>
                    </div>
              <!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login</h5>
                  </div>

                  <?php 
                     if(isset($wrong_bp)){
                     ?>
                           <div class="alert alert-danger alert-dismissible fade show" role="alert">
                           <?= $wrong_bp ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                        <?php
                     }
                     
                        ?>
                     <?php 
                     if(isset($wrong_password)){
                     ?>
                           <div class="alert alert-danger alert-dismissible fade show" role="alert">
                           <?= $wrong_password ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                        <?php
                     }
                        ?>
                    <?php 
                     if(isset($status_inactive)){
                     ?>
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                           <?= $status_inactive ?>
                           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                           
                        <?php
                     }
                     
                        ?>

                  <form acition="" method="POST" class="row g-3 needs-validation" novalidate>

                    <div class="col-12">
                      <label for="bp" class="form-label">User ID</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">BP</span>
                        <input type="text" name="bp" class="form-control" id="bp" required>
                        <div class="invalid-feedback">Please enter your user ID.</div>
                        </div>
                      </div>

                    <div class="col-12">
                      <label for="password" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="password" required>
                     
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" name="login" >Login</button>
                    </div>
                    
                  </form>

                </div>
                
              </div>
              

              
              <div class="credits text-center">
                 Designed and Developed by <br> <a href="https://www.facebook.com/sagar.saha.3388?mibextid=ZbWKwL">Sagar Saha</a> & <a href="https://www.facebook.com/bappi.pirojpur?mibextid=ZbWKwL">Nayem Hossain</a>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->


</body>

</html>