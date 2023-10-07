<?php

require_once('includes/dbcon.php');
session_start();

    if(!isset($_SESSION['bp'])){
      header('Location:dashboard.php');
    }

       
    //pagenation start
    if(isset($_GET['pageno'])){

        $getpageno =  $_GET['pageno'];
        $offset = ($getpageno - 1) * 20;
    
        $page_incriment = $getpageno + 1;
        $page_decriment = $getpageno - 1;
      
        }else{
    
            $offset = 0;
    
            $page_incriment = 2;
            $page_decriment = 0;
            
        }
    
        //This sql is for counting all data to stop last next page
        $sql_pgn = "SELECT * FROM `ticket`";
        $query1 = mysqli_query($con,$sql_pgn);
        $num_rows = mysqli_num_rows($query1);
        $divided_num_rows = ($num_rows/20)+1;


        if (isset($_POST['search'])) {
            $from = $_POST['from'];
            $to = $_POST['to'];
        
            // Assuming you have a database connection object named $con
            $stmt = mysqli_prepare($con, "SELECT * FROM `ticket` WHERE DATE(`date`) BETWEEN ? AND ? ORDER BY id DESC LIMIT 20 OFFSET ?");
            
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssi", $from, $to, $offset);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                mysqli_stmt_close($stmt);
            } else {
                
            }
        } else {
            // If search is not set, fall back to the default query
            $sql = "SELECT * FROM `ticket` ORDER BY id DESC LIMIT 20 OFFSET $offset";
            $result = mysqli_query($con, $sql);
            $result = mysqli_query($con, $sql);
        }
        // if(isset($_GET['table_search']))
        // {
        //     $table_search = $GET_['search_t'];
        //     $sql = "SELECT * FROM `ticket` WHERE 
        //         'id' LIKE '%$table_search%' OR 
        //         'name' LIKE '%$table_search%' OR 
        //         'bp' LIKE '%$table_search%' OR
        //         'designation' LIKE '%$table_search%' OR
        //         'unit' LIKE '%$table_search%' ORDER BY id DESC LIMIT 20 OFFSET $offset";
        // }else{
        //     $sql = "SELECT * FROM `ticket` ORDER BY id DESC LIMIT 20 OFFSET $offset";
        // }

        
        


    
?>



<!DOCTYPE html>
<html lang="en">
<head>
<script>
  if(window.history.replaceState){
                window.history.replaceState(null,null,window.location.href);
  }
  </script>
</head>
<body>
     
    <?php include_once 'includes/header_aside.php';?><!--Header and Sidebar-->

  <main id="main" class="main">



    <div class="pagetitle">
        <div class="row">
            <div class="col-9">
                <h1>TICKET LOG</h1>
            </div>
            <div class="col-3">
                <a type="button" href="download.php" class="btn btn-success float-md-end "> Download</a>
            </div>
            
        </div>   
    </div><!-- End Page Title -->


    <hr> 


    <div class="card">
        <div class="card-body">

            <div class="row mt-3">                
                    <div class="col-3">
                        <form action="" method="GET">                        
                            <div class="input-group has-validation float-end ">
                                <input  type="text" name="search_t" class="form-control" placeholder="Search here" value="<?php if(isset($searchkey)){echo $searchkey;} ?>" required />
                                <button class="btn btn-outline-primary pull-right" type="submit" name="table_search"><i class="ri-search-eye-line"></i></button>  
                                <div class="invalid-feedback">Please type any clue of force</div>                 
                            </div>
                        </form>
                    </div>
                    <div class="col-5">
                        <form action="" method="post">
                            <div class="input-group">
                                <input type="date" name="from" value="<?php if(isset($_POST['search'])) { echo $from; } ?>" class="form-control" />
                                <span class="input-group-text">TO</span>
                                <input type="date" name="to" value="<?php if(isset($_POST['search'])) { echo $to; } ?>" class="form-control" />
                            </div>                                                  
                    </div>
                    <div class="col-4">
                        <input type="submit" value="Search" class="form-control" name="search" />                    
                    </div>
                        </form>     
                
            </div>
                
                        
            
                <div class="table-responsive mt-3">
                    <table class="table table-bordered table-hover" data-bs-toggle="table"  >
                        <thead class="position-sticky top-0">
                            <tr>                            
                                <th>Action</th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>BP</th>
                                <th>Designation</th>
                                <th>Current Unit</th> 
                                <th>Ticket For</th>
                            </tr>
                        </thead>
                    
                        <tbody>
                            <?php                                                                                                   
                                while ($row = mysqli_fetch_assoc($result)) {                                    
                            ?>

                                <tr>
                                    
                                    <td><?=$row['id']?></td>
                                    <td><?=$row['name']?></td>
                                    <td><?=$row['bp']?></td>
                                    <td><?=$row['designation']?></td>
                                    <td><?=$row['unit']?></td>
                                    <td><?=$row['mobile']?></td>
                                    <td><?=$row['relation']?></td>
                                        
                                </tr>

                            <?php
                                }
                            ?>

                        </tbody>
                    </table>
                    <!-- End Table with hoverable rows -->
        
                </div>
                
                
                <div class="col mt-2">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end" data-bs-items-per-page="5">

                            <?php
                            if($page_decriment == 0){  //whern page less than 0 then
                                echo "<li class='page-item disabled'>
                                <a class='page-link'> Previous</a>
                                </li>";   
                            }else{
                                echo "<li class='page-item'>
                                <a class='page-link' href='force_view.php?pageno=$page_decriment' > Previous</a>
                                </li>"; 
                            }

                            ?>

                            <?php
                                if(isset($getpageno)){
                                echo "<li class='page-item disabled'><a class='page-link'>$getpageno</a></li>";
                                }else{
                                echo "<li class='page-item disabled'><a class='page-link'>1</a></li>";
                                }
                            ?>
                            <?php
                            if($page_incriment > $divided_num_rows){//whern page more than all data
                                echo "<li class='page-item disabled'>
                                <a class='page-link'> Next</a>
                                </li>"; 

                            }else{
                                echo "<li class='page-item '>
                                <a class='page-link' href='force_view.php?pageno=$page_incriment'> Next</a>
                            </li>";
                            }
                            ?>                            
                            
                        </ul>
                    </nav>
                </div>


            </div>
        </div>
    </div>
 
<script>

</main>
<?php include_once 'includes/footer.php' ?> <!-- Footer -->
