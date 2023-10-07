<?php

require_once('includes/dbcon.php');
session_start();

    if(!isset($_SESSION['bp'])){
      header('Location:dashboard.php');
    }

    if(isset($_SESSION['viewer'])){
        header('Location:dashboard.php');
      }


    $sql = "SELECT * FROM `ticket`  ";
    $result = mysqli_query($con,$sql);

     
                         
   
       $download ='<table>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>BP</th>
                            <th>Designation</th>
                            <th>Unit</th>
                            <th>Mobile</th>
                            
                            
                        </tr>';

                        while ($row = mysqli_fetch_assoc($result)) {              
                                
                        $download.='<tr>
                            <td>'.$row['id'].'</td>
                            <td>'.$row['date'].'</td>
                            <td>'.$row['name'].'</td>
                            <td>'.$row['bp'].'</td>
                            <td>'.$row['designation'].'</td>
                            <td>'.$row['unit'].'</td>
                            <td>'.$row['mobile'].'</td>
                           
                        </tr>';
                    }
    $download.='</table>';
    header('Content-Type:application/xls');
    header('Content-Disposition:attachment;filename=Ticket_report.xls');


    echo $download;
                        
                        
                        
    ?>

                        
               
            
                     
