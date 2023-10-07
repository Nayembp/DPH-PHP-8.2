


	<!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Police Hospital Barishal</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      Designed and Developed by <br> <a href="https://www.facebook.com/sagar.saha.3388?mibextid=ZbWKwL">Sagar Saha</a> & <a href="https://www.facebook.com/bappi.pirojpur?mibextid=ZbWKwL">Nayem Hossain</a>
    </div>
  </footer><!-- End Footer -->
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
  <script src="assets/js/popup.js"></script>

  <script>
    // Function to display a toastr notification
    function showToastr(message, type) {
      toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-top-center',
        timeOut: 3000 // Duration in milliseconds (3 seconds)
      };
      toastr[type](message);
    }

    // Check if a success message exists in the session
    <?php
   
    if (isset($_SESSION['status'])) {
      $status = $_SESSION['status'];
      unset($_SESSION['status']);
      echo "showToastr('$status', 'success');";
    }
    ?>
  </script>


</body>
</html>


