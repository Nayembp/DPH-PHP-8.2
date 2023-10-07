<?php
session_start();

// Check if the session variable is set
if (isset($_SESSION['ticket_data'])) {
    $row_add_user = $_SESSION['ticket_data'];
} else {
    echo "No data found";
}
date_default_timezone_set('Asia/Dhaka');

?>

<!DOCTYPE html>
<html>
<head>
    <title>Ticket Slip</title>
    <!-- Include Bootstrap CSS for styling -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/css/bootstrap.min.css">
    <!-- Include your custom CSS for printing here -->
    <link rel="stylesheet" type="text/css" href="print-style.css">
</head>

<style>
    @media print {
        size: 3in 4in;
        margin: 0.25in;

        body {
            margin: 0;
            padding: 0;
            font-size: 12pt;
            text-align: center;
        }

        h2 {
            text-align: center;
            font-size: 18pt; 
            margin-bottom: 10pt;
        }

        
        p {
            text-align: center;
            font-size: 7px;
            margin-bottom: 10pt;
        }

       
        .no-print {
            display: none;
        }

       
        td {
            text-align: center;
            font-size: 7px; 
            text-align: center;
        }

    }
</style>

<body>
    <h2 class="text-center">Divisional Police Hospital</h2>

    <table class="table text-center table-bordered">
         <tr>
            <td><strong>Date:</strong> <?php echo date("d-M-Y h:i A"); ?></td>
            <td><strong>Reg NO::</strong> <?php echo $row_add_user['id']; ?></td>
        </tr>
        <tr>
            <td><strong>Name:</strong> <?php echo $row_add_user['name']; ?></td>
            <td><strong>Rank:</strong> <?php echo $row_add_user['designation']; ?></td>
        </tr>
        <tr>
            <td><strong>BP:</strong> <?php echo $row_add_user['bp']; ?></td>
            <td><strong>Mobile:</strong> <?php echo $row_add_user['mobile']; ?></td>
        </tr>
        <tr>
            <td><strong>Unit:</strong> <?php echo $row_add_user['unit']; ?></td>
            <td><strong>Relation:</strong> <?php echo $row_add_user['relation']; ?></td>
        </tr>
    </table>
    
    <!-- Add other data fields as needed -->
</body>
</html>
