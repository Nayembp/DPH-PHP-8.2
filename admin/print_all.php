
<?php

	require_once('includes/dbcon.php');

	if(!isset($_SESSION['bp'])){
		header('Location:dashboard.php');
	  }

	  if(isset($_SESSION['viewer'])){
		header('Location:dashboard.php');
	  }

	
		$result = mysqli_query($con,"SELECT * FROM `force_data`");
		
	
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print</title>
    <style type="text/css">
    	
    	body{
    		font-family: kalpush;
    		margin: 0;
    	}
    	.print-area{
    		width: 755px;
    		height: 1050px;
    		margin: auto;
    		box-sizing: border-box;
    		page-break-after: always;
    	}
    	.header,.page-info{
    		text-align: center;

    	}
    	.header h3{
    		margin: 0;
    	}
    	.data-info{

    	}
    	.data-info table{
    		width: 100%;
    		border-collapse: collapse;
    	}
    	
    	.data-info table th,td{
    		border: 1px solid #555;
    		padding: 4px;
    		line-height: 1em;
    	}
    </style>

</head>
<body onload="window.print()">

	<?php
	$sl = 1;
	$page = 1;
	$total = mysqli_num_rows($result);
	$per_page = 25;

	while ($row = mysqli_fetch_assoc($result)){ 
		if($sl % $per_page == 1 ){
			echo page_header();
		}

		?>
	


   		
				<tr>
					<td><?= $sl;?></td>
					<td><?=$row['name']; ?></td>
					<td><?=$row['bp']; ?></td>
					<td><?=$row['previous_units']; ?></td>
					<td><?=$row['current_unit']; ?></td>
				</tr>
				<?php 
				if($sl % $per_page == 0 || $total == $per_page){
					echo page_footer($page++);
				}
				$sl++;
			 }  ?>

	

			
    
</body>
</html>
<?php
	function page_header()
	{
		$data = ' 
				<div class="print-area">
					<div class="header">
						<h3> বরিশাল রেঞ্জের সকল সদস্য <h3></div>
					<div class="data-info">
						<table>
							<tr>
								<th>ক্রমিক নং</th>
								<th>নাম</th>
								<th> বিপি</th>
								<th>বর্তমান কর্মস্থল</th>
								<th>বদলীকৃত ইউনিট</th>
							</tr>

		';
		return $data;
	}
	function page_footer($page)
	{
		$data = '</table>

			<div class="page-info">page:- '.$page.'</div>
			
		</div>

	</div>';
		return $data;
	}
?>