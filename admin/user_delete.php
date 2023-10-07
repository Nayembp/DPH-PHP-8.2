
<?php 


 	require_once('includes/dbcon.php');
 	session_start();

  if(!isset($_SESSION['admin'])){
      header('Location:dashboard.php');
    }


$id = base64_decode($_GET['id']);
$result = mysqli_query($con, "DELETE FROM `users` WHERE `id`='$id';");

if($result){
	header('Location: user_view.php?delete=1');
} else{
	echo mysqli_error($con);
}
?>