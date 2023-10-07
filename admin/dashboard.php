<?php
require_once('includes/dbcon.php');

session_start();

if(!isset($_SESSION['role'])){
    header('Location:../index.php');
  }
  date_default_timezone_set("Asia/Dhaka");


  $today = date("Y-m-d");
  $month_start = "1971-12-16";
  $duration = "duration";

    if (isset($_POST['search'])) {
      $from = $_POST['from'];
      $to = $_POST['to'];
      $unit = isset($_POST['unit']) ? $_POST['unit'] : ''; // Default to an empty string if unit is not selected

      
      if (!empty($unit)) {
          $sql = "SELECT * FROM `ticket` WHERE DATE(`date`) BETWEEN '$from' AND '$to' AND `unit` = '$unit'";
      } else {
          $sql = "SELECT * FROM `ticket` WHERE DATE(`date`) BETWEEN '$from' AND '$to'";
      }
  } else {
      
      $sql = "SELECT * FROM `ticket` WHERE DATE(`date`) = '$today'";
  }

  $result = mysqli_query($con, $sql);

  if (!$result) {
    die("Query failed: " . mysqli_error($con));
  }else{
    $row_count = mysqli_num_rows($result);
   
    $unitCounts = array();

    while ($row = mysqli_fetch_assoc($result)) {
      $unit = $row['unit'];
      
      if (isset($unitCounts[$unit])) {
          $unitCounts[$unit]++;
      } else {
          $unitCounts[$unit] = 1;
      }
    }

    $dataSeries = array();
    foreach ($unitCounts as $unit => $count) {
        $dataSeries[] = array(
            'name' => $unit,
            'type' => 'bar',
            'data' => array($count) // Assuming you want the count as the data point
        );
    }

    // Convert $dataSeries to JSON format for use in Highcharts
    $dataSeriesJSON = json_encode($dataSeries);

  }

  
  


  

  
  
 
  


?>
  
<?php include_once 'includes/header_aside.php';?>

   
  <main id="main" class="main">

      <!--search section-->
        <div class="col-lg-12">
            
                <form action="" method="POST" class="row g-3">
                    
                  <div class="col-md-2">
                    
                    <select  class="form-select" name="unit">
                      <option value="">Select</option>
                      <option <?php if (isset($_POST['search'])) {echo $_POST['unit'] =='Range Office' ?'selected=""':'';}?> value="Range Office">Range Office</option>
                      <option <?php if (isset($_POST['search'])) {echo $_POST['unit']=='Barishal' ?'selected=""':'';}?> value="Barishal">Barishal</option>
                      <option <?php if (isset($_POST['search'])) {echo $_POST['unit']=='Patuakhali' ?'selected=""':''; }?> value="Patuakhali">Patuakhali</option>
                      <option <?php if (isset($_POST['search'])) {echo $_POST['unit']=='Bhola' ?'selected=""':''; }?> value="Bhola">Bhola</option>
                      <option <?php if (isset($_POST['search'])) {echo $_POST['unit']=='Barguna' ?'selected=""':''; }?> value="Barguna">Barguna</option>
                      <option <?php if (isset($_POST['search'])) {echo $_POST['unit']=='Pirojpur' ?'selected=""':''; }?> value="Pirojpur">Pirojpur</option>
                      <option <?php if (isset($_POST['search'])) {echo $_POST['unit']=='Jhalakathi' ?'selected=""':''; }?> value="Jhalakathi">Jhalakathi</option>
                      <option <?php if (isset($_POST['search'])) {echo $_POST['unit']=='RRF' ?'selected=""':''; }?> value="RRF">RRF</option>
                      <option <?php if (isset($_POST['search'])) {echo $_POST['unit']=='In-Service Barishal' ?'selected=""':''; }?> value="In-Service Barishal">In-Service Barishal</option>
                      <option <?php if (isset($_POST['search'])) {echo $_POST['unit']=='In-Service Pirojpur' ?'selected=""':''; }?> value="In-Service Pirojpur">In-Service Pirojpur</option>
        
                    </select>
                    </div>


                    <div class="col-5">
                        
                      <div class="input-group">
                          <input type="date" name="from" value="<?php if(isset($_POST['search'])) { echo $from; } ?>" class="form-control" />
                          <span class="input-group-text">TO</span>
                          <input type="date" name="to" value="<?php if(isset($_POST['search'])) { echo $to; } ?>" class="form-control" />
                      </div>  
                                                  
                    </div>
                      
                    <div class="col-md-2">
                                     
                      <button class="form-control" type="submit" name="search">Search</button>
                    </div>

                 </form>

                 
      </div>
      
      <!--end search bar-->

      <hr>

    <section class="section dashboard">
      
      <div class="row">

        <div class="col-xl-8 col-sm-12">
          <div class="row">
              <div class="col-xxl-4  col-md-6">
                <div class="card info-card sales-card">

                  <div class="card-body">
                    <h5 class="card-title">Ticket Count <span>| Today</span></h5>

                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-cart"></i>
                      </div>
                      <div class="ps-3">
                        <h6><?= $row_count ?></h6>
                        <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                      </div>
                    </div>
                  </div>

                </div>
              </div><!--total end>-->
            <div class="col-xxl-4  col-md-6">
              <div class="card info-card sales-card">

                <div class="card-body">
                  <h5 class="card-title">Indoor Count <span>| Today</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?= $row_count ?></h6>
                      <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!--total indoor end>-->

          </div>
        </div><!-- div 8 close-->

        
        <div class="col-lg-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Ticket by units</h5>

              <div id="verticalBarChart" style="min-height: 300px;" class="echart"></div>
              <script>
                  document.addEventListener("DOMContentLoaded", () => {
                      // Dynamic data from PHP
                      var unitNames = <?php echo json_encode(array_keys($unitCounts)); ?>;
                      var unitCounts = <?php echo json_encode(array_values($unitCounts)); ?>;

                      echarts.init(document.querySelector("#verticalBarChart")).setOption({
                          tooltip: {
                              trigger: 'axis',
                              axisPointer: {
                                  type: 'shadow'
                              }
                          },
                          legend: {},
                          grid: {
                              left: '3%',
                              right: '4%',
                              bottom: '3%',
                              containLabel: true
                          },
                          xAxis: {
                              type: 'value',
                              boundaryGap: [0, 0.01]
                          },
                          yAxis: {
                              type: 'category',
                              data: unitNames 
                          },
                          series: [{
                              name: 'Ticket Count',
                              type: 'bar',
                              data: unitCounts 
                          }]
                      });
                  });
              </script>


            </div>
          </div>
        </div>

      </div>
      
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->

  <?php include_once 'includes/footer.php' ?>
