<?php

require_once('includes/dbcon.php');
session_start();

  if(!isset($_SESSION['bp'])){
      header('Location:dashboard.php');
    }

  if(!isset($_SESSION['admin'])){
      header('Location:dashboard.php');
    }

    if (isset($_POST['bp_search'])) {
        $bp_search_without_bp = $_POST['bp'];
        $bp_search = "BP" . $bp_search_without_bp;
        $result = mysqli_query($con, "SELECT * FROM `force_data` WHERE `bp`='$bp_search'");
        $row_add_user = mysqli_fetch_assoc($result);
    
        // Store the searched data in a session
        $_SESSION['searched_data'] = $row_add_user;
    }
    
    // Check if user data is available in session and pre-fill the form
    if (isset($_SESSION['searched_data'])) {
        $searched_data = $_SESSION['searched_data'];
    
    
      if (isset($_POST['ticket_generate'])) {
          $name = $searched_data['name'];
          $bp = $searched_data['bp'];
          $designation = $searched_data['designation'];
          $current_unit = $searched_data['unit'];
          $mobile = $searched_data['mobile'];
          $relation = $_POST['relation'];
          if(isset($bp))
            {

          
              $query = "INSERT INTO `ticket`(`name`,`bp`,`designation`,`unit`,`mobile`,`relation`) 
                        VALUES('$name','$bp','$designation','$current_unit','$mobile','$relation')";
          
              $result = mysqli_query($con, $query);
          
              if ($result) {
                  // Fetch the generated ticket's data using a SELECT query
                  $ticket_query = "SELECT * FROM `ticket` WHERE `bp`='$bp' ORDER BY id DESC LIMIT 1";
                  $ticket_result = mysqli_query($con, $ticket_query);
                  $generated_ticket_data = mysqli_fetch_assoc($ticket_result);
          
                  // Store the generated ticket data in a session variable
                  $_SESSION['ticket_data'] = $generated_ticket_data;
          
                  // Free the result set
                  mysqli_free_result($ticket_result);
              } else {
                  // Handle the query error
                  echo "Error: " . mysqli_error($con);
              }
          
              $_SESSION['ticket_generated'] = true;

              $status = "Ticket data added.";
              $_SESSION['status'] = $status;
              header('Location: ticket_generate.php');
              exit();
            }else{
              $status = "Ticket data Not Found.";
              $_SESSION['status'] = $status;

            }   
      }
    }    
      //new force added functions
        if(isset($_POST['add_new']))
        {
            $add_new_name = $_POST['name'];
            $add_new_bp_post = $_POST['bp'];
            $add_new_bp = "BP".$add_new_bp_post;
            $add_new_designation = $_POST['designation'];
            $add_new_unit = $_POST['unit'];
            $add_new_mobile = $_POST['mobile'];

            $query = "INSERT INTO `force_data`(`name`,`bp`,`designation`,`unit`,`mobile`) 
                      VALUES('$add_new_name','$add_new_bp','$add_new_designation','$add_new_unit','$add_new_mobile')";
           
           $result = mysqli_query($con, $query);
            
           if ($result) 
           {
              
              $status = "Force Added Successful!.";
              $_SESSION['status'] = $status;
              header('Location: ticket_generate.php');
              exit;

            } 

        }
        
      ?><!--//END NEW FORCE ADD -->


  
  <?php include_once 'includes/header_aside.php';?>

  
  <main id="main" class="main">
  
    <!--end From-->
      <section class="section">
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title d-flex" style="border-bottom: 2px solid #4154f1;">TICKET COUNTR</h5>
                  <div class="row mt-3">                    
                    <div class="col-4">
                      <form action="" method="POST" class="row g-3 needs-validation" novalidate>
                          
                          <div class="input-group has-validation">
                              <span class="input-group-text" id="inputGroupPrepend">BP</span>
                              <input type="text" 
                                    name="bp" 
                                    class="form-control" 
                                    id="bp" 
                                    value="<?php 
                                        if(isset($bp_search_without_bp ))
                                          { 
                                          echo $bp_search_without_bp;
                                          } ?>" 
                                    placeholder="Search by bp" required
                                />
                              <button class="btn btn-outline-primary pull-right" type="submit" name="bp_search"><i class="ri-search-eye-line" ></i></button>  
                              <div class="invalid-feedback">Please enter your user ID.</div>                 
                          </div>                          
                      </form>
                    </div> 
                    <div class="col-4">
                      <form action="" method="POST" class="row g-3 needs-validation">    
                        <div class="col-md-6">                               
                            <select class="form-select" name="relation" id="role" required>
                              <option value="Self">Self</option>
                              <option value="Father">Father</option>
                              <option value="Mother">Mother</option>
                              <option value="Wife">Wife</option>
                              <option value="Son">Son</option>
                              <option value="Daughter">Daughter</option>
                            </select>             
                        </div>
                        <div class="col-6">
                            <label class="col-form-label"></label>
                            <input type="submit" value="Get Ticket" name="ticket_generate" class="btn btn-success" />
                        </div>
                      </form>
                    </div> 
                    <div class="col-4">
                      
                    <button type="button" class="btn btn-info float-end" data-bs-toggle="modal" data-bs-target="#AddForceModal">
                      Add Force
                    </button>
                          
                             
                    </div>                       
                  </div>

                    <br>

                  <div class="row">
                    <div class="col-lg-5">
                      
                    <ul>
                        <?php if(isset($searched_data)){ ?>                            
                            <li><strong> NAME:</strong> <?php echo $searched_data['name']; ?> </li>
                            <li><strong> BP: </strong><?php echo $searched_data['bp']; ?> </li>
                            <li><strong> RANK: </strong><?php echo $searched_data['designation']; ?> </li>
                            <li><strong> UNIT: </strong><?php echo $searched_data['unit']; ?> </li>
                            <li><strong> MOBILE: </strong><?php echo $searched_data['mobile']; ?> </li>
                        <?php } else{ ?>
                            <h4 class="text-danger text-center">No Record Found</h4>
                        <?php
                        } ?>
                    </ul>
                        
                            
                      
                      
                      <div class="row mt-2">           
                        <div class="col-6">
                        </div>
                        <div class="col-6">
                          

                        </div>
                      </div> 

                    </div>
                    
                    <div class="col-lg-6">

                    
                      <?php 
                          if (isset($_SESSION['ticket_data'])) {
                            // Access the data
                            $ticket_data = $_SESSION['ticket_data'];
                                                    
                            ?>
                              <p class="text-primary mt-4 h4"><b>Ticket For: </b>
                              <?php 
                                echo $ticket_data['relation'];

                              ?>
                              </p>
                            <br>
                            <br>
                           

                            <button class="btn btn-success" onclick="printTicket()">Print Ticket</button>
                            <?php

                          } else {
                              echo "Ticket Data not found!<br>";
                          }
                                                
                      ?>
                      <script>
                          function printTicket() {
                            var printWindow = window.open('print_ticket.php');
                            printWindow.print();

                        }
                      </script>
                        

                    </div>
                  </div>
                    
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Modal -->
      <div class="modal fade" id="AddForceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add new force</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
             
              <form action="" method="POST">
                <div class="row mb-3">
                  <label for="name"  class="col-sm-3 col-form-label">Name</label>
                  <div class="col-sm-9">
                    <input type="text" name="name" class="form-control" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputEmail"  class="col-sm-3 col-form-label">BP</label>
                  <div class="col-sm-9">
                    <input type="number" name="bp" class="form-control">
                  </div>
                </div>
                <div class="row mb-3">
                  <label class="col-sm-3 col-form-label">Designation</label>
                  <div class="col-sm-9">
                    <select class="form-select" name="designation" aria-label="Default select example">
                      <option selected="">Select</option>
                      <option value="Barishal">Constable</option>
                      <option value="Patuakhali">Nayek</option>
                      <option value="ASI">ASI</option>
                      <option value="SI">SI</option>
                      <option value="Inspecto">Inspector</option>
                      <option value="ASP">ASP</option>
                      <option value="Addl SP">Addl SP</option>                    
                      <option value="SP">SP</option>
                      <option value="Addl DIG">Addl DIG</option>
                      <option value="DIG">DIG</option>
                    </select>
                  </div>
                </div>
                
                <div class="row mb-3">
                  <label class="col-sm-3 col-form-label">Unit</label>
                  <div class="col-sm-9">
                    <select class="form-select" name="unit" aria-label="Default select example">
                      <option selected="">Select</option>
                      <option value="Barishal">Barishal</option>
                      <option value="Patuakhali">Patuakhali</option>
                      <option value="Bhola">Bhola</option>
                      <option value="Pirojpur">Pirojpur</option>
                      <option value="Barguna">Barguna</option>
                      <option value="Jhalakathi">Jhalakathi</option>
                      <option value="RRF">RRF</option>
                      <option value="APBn">APBn</option>
                      <option value="BMP">BMP</option>                    
                      <option value="Range Office">Range Office</option>
                      <option value="BMP">Pension</option>
                    </select>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputNumber"  class="col-sm-3 col-form-label">Mobile</label>
                  <div class="col-sm-9">
                    <input type="number" name="mobile" class="form-control">
                  </div>
                </div>

            </div>
          
            <div class="modal-footer">
              <button type="button"  class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" name="add_new" class="btn btn-primary">Add New</button>

            </div>
            </form><!-- End General Form Elements -->
          </div>
        </div>
      </div><!-- End Modal -->

      
     

  </main><!-- End #main -->
 
  <!--Footer -->
  <?php include_once 'includes/footer.php' ?>
  <!-- End Footer -->

  
