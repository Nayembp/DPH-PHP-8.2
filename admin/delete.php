
<?php 


 	require_once('includes/dbcon.php');

	session_start();

	  if(isset($_SESSION['viewer'])){
	    header('Location:dashboard.php');
	  }


	$id = base64_decode($_GET['id']);
	
	$data = mysqli_query($con,"SELECT * FROM `force-data` WHERE `id`='$id'");
	
	$result = mysqli_query($con, "DELETE FROM `force_data` WHERE `id`='$id';");

	if($result){
		header('Location: force_view.php?success=1');
	} else{
		echo mysqli_error($con);
	}
?>