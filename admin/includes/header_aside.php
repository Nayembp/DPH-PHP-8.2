<?php

require_once('includes/dbcon.php');
$bp_database = $_SESSION['bp'];

$user = mysqli_query($con,"SELECT * FROM `users` WHERE `bp`='$_SESSION[bp]'");

$row = mysqli_fetch_assoc($user);

 $page =  explode('/',$_SERVER['PHP_SELF']);
 $active_page = end($page);

?>


<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Force Management</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

   <!-- Favicons -->
  <link href="../admin/assets/img/favicon.png" rel="icon">
  <link href="../admin/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="assets/css/popup.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

 
  <script>
    if(window.history.replaceState){
        window.history.replaceState(null,null,window.location.href);
    }
  </script>
 

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="dashboard.php" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">POLICE HOSPITAL</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="../images/<?=$row['photo'] ?>" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?=$row['name'] ?></span>
            
          </a><!-- End Profile Iamge Icon -->
          
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?=$row['name'] ?></h6>
              <span><?=$row['designation'] ?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="user_profile.php">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

           
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Log out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->
      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item ">
        <a class="nav-link <?=$active_page == 'dashboard.php' ? '':'collapsed' ?> " href="dashboard.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <?php
          if(isset($_SESSION['admin'])){

          ?>
      <li class="nav-item">
        <a class="nav-link <?= $active_page == 'ticket_generate.php'|| $active_page == 'ticket_log.php' ? '':'collapsed' ?>" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-person-lines-fill"></i><span>Ticket Counter</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse <?= $active_page == 'ticket_generate.php'|| $active_page == 'ticket_log.php' ? 'show':'' ?>" data-bs-parent="#sidebar-nav">
          <li>
            <a class="<?= $active_page == 'ticket_generate.php' ? 'active':'' ?>" href="ticket_generate.php">
              <i style="font-size: 15px;" class="bi bi-person-plus-fill"></i><span>Ticket Generate</span>
            </a>
          </li>
          <li>
            <a class="<?= $active_page == 'ticket_log.php' ? 'active':'' ?>" href="ticket_log.php">
              <i style="font-size: 15px;" class="bi bi-eye-fill"></i><span>Ticket Log</span>
            </a>
          </li>
        </ul>
      </li><!-- End Ticket Nav -->

        <?php } ?>

        <?php
          if(isset($_SESSION['admin'])){

          ?>
      <li class="nav-item">
        <a class="nav-link <?= $active_page == 'patient_status.php'|| $active_page == 'patient_add.php' ? '':'collapsed' ?>" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-person-lines-fill"></i><span>Indoor</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse <?= $active_page == 'patient_add.php'|| $active_page == 'patient_status.php' ? 'show':'' ?>" data-bs-parent="#sidebar-nav">
          <li>
            <a class="<?= $active_page == 'patient_add.php' ? 'active':'' ?>" href="patient_add.php">
              <i style="font-size: 15px;" class="bi bi-person-plus-fill"></i><span>Patient ADD</span>
            </a>
          </li>
          <li>
            <a class="<?= $active_page == 'patient_status.php' ? 'active':'' ?>" href="patient_status.php">
              <i style="font-size: 15px;" class="bi bi-eye-fill"></i><span>Patient Status</span>
            </a>
          </li>
        </ul>
      </li><!-- End Forms Nav -->
      <?php } ?>

        <?php
          if(isset($_SESSION['admin'])){

          ?>
      <li class="nav-item">
        <a class="nav-link <?= $active_page == 'add_user.php'|| $active_page == 'user_view.php'|| $active_page == 'user_edit.php' ? '':'collapsed' ?>" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-person-lines-fill"></i><span>User</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse <?= $active_page == 'add_user.php'|| $active_page == 'user_view.php'|| $active_page == 'user_edit.php' ? 'show':'' ?>" data-bs-parent="#sidebar-nav">
          <li>
            <a class="<?= $active_page == 'add_user.php' ? 'active':'' ?>" href="add_user.php">
              <i style="font-size: 15px;" class="bi bi-person-plus-fill"></i><span>Add User</span>
            </a>
          </li>
          <li>
            <a class="<?= $active_page == 'user_view.php' ? 'active':'' ?>" href="user_view.php">
              <i style="font-size: 15px;" class="bi bi-eye-fill"></i><span>View User</span>
            </a>
          </li>
        </ul>
      </li><!-- End Forms Nav -->

          <?php } ?>

      
      
      <li class="nav-item">
        <a class="nav-link <?=$active_page == 'user_profile.php' ? '':'collapsed' ?>" href="user_profile.php">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li><!-- End Profile Page Nav -->


        

      <li class="nav-item">
        <a class="nav-link collapsed" href="logout.php">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Logout</span>
        </a>
      </li><!-- End Login Page Nav -->

    
    </ul>

  </aside><!-- End Sidebar-->

