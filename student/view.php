<?php 
session_start(); #if session exist then session error variable will be set to null
require_once '../conn_iet.php';
if(!isset($_SESSION["student_id"]))
 	header('Location: ../index.php');
$list="";
$lln;
$pno;
$schedule=$_POST['schedule_id'];
$sid= $_SESSION["student_id"];



$result=mysqli_query($conn,"SELECT * from attendance_table where student_id=$sid and schedule_id=$schedule");


                $result1=mysqli_query($conn,"SELECT last_lecture_no from schedule_table where id=$schedule");
                if (($result1->num_rows)==1) {
             while($row1 = $result1->fetch_assoc())
              {
                  $lln=$row1["last_lecture_no"];
              }
                }
                
$pen=0;
$headval=' <th>LECTURE DATE</th><th>ATTENDANCE</th><th>LECTURE DATE</th><th>ATTENDANCE</th>'.$headval; 
if (($result->num_rows)==1) {

    while($row = $result->fetch_assoc())
          {
            $pno= $row['present_no'];
            for($i=1;$i<=$lln;$i++)
            {
                $l="l".$i;
                
                
                
                $preabs;
                if($row["$l"]==0)
                  {$preabs='Absent'; $class="bg-warning";}
                else if($row["$l"]==1)
                {$preabs='Present';$class="bg-success";}
                
                $result1=mysqli_query($conn,"SELECT $l,last_lecture_no from schedule_table where id=$schedule");
               

                if (($result1->num_rows)==1) {
             while($row1 = $result1->fetch_assoc())
              {
                  $date=$row1["$l"];
                  $date = strtotime( $date );
                  $date = date( 'd-m-Y', $date );
                  $lln=$row1["last_lecture_no"];
              }
              }
              
         $list.='
      <td class="mobile">'.$date.'</td>
      <td class="'.$class.'">'.$preabs.'</td>
        ';
    
    $pen++;


                     if($pen==2){

                         $list='<tr>'.$list.'</tr>';

                         $list1.=$list;

                         $list="";

                         $pen=0;
                                

                     }  
            } if($pen>0) {
        	$list='<tr>'.$list.'</tr>';

                         $list1.=$list;
                           }
                         
           
    }
}
            
?>




<script>
	$('#myModal').on('shown.bs.modal', function () {

  $('#myInput').focus()

})

</script>

<style>

body{
  background-color: #f0f0f0;
}

	h3{color: #042c4f}


	</style>
<head><title>Teachers panel</title>
  <style type="text/css">
    @media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

    /* Force table to not be like tables anymore */
    table, thead, tbody, th, td, tr { 
        display: block; 
    }
    
    /* Hide table headers (but not display: none;, for accessibility) */
    thead tr { 
        position: absolute;
        top: -9999px;
        left: -9999px;
    }
    
    tr { border: 1px solid #ccc; }
    
    td { 
        /* Behave  like a "row" */
        border: none;
        border-bottom: 1px solid #eee; 
        position: relative;
        padding-left: 50%; 
    }
    
    td:before { 
        /* Now like a table header */
        position: absolute;
        /* Top/left values mimic padding */
        top: 6px;
        left: 6px;
        width: 45%; 
        padding-right: 10px; 
        white-space: nowrap;
    }
    .mobile{
      background-color: gray;
      color: white;
    }
 }


   
</style>
</head>
<?php include("header.php"); ?>

<body>



<!--

<img src="iet.jpg" style="width: 100%;"/>

-->

<br>

<center>


<div class="row">
<?php if ($lln != 0 && $lln != null) {?>
  <div class="col-sm-12">
      present no : <?php echo $pno; ?><br>
      total lectures : <?php echo $lln; ?><br>
      percentage : <?php echo intval($pno*100/$lln); ?>%<br>
      
<div class="table-responsive">
<table class="table table-striped table-bordered">
  <thead class="thead-inverse">
    <tr>
  <?php echo $headval;?>
    </tr>
  </thead>
  <tbody>
    <?php echo $list1; ?>
    </tbody>
    </table>
</div>
	</div>
<?php } else {?>
<h1 class="col-md-12" style="height:300px;"><p  align="center"> No attendance to show !</p><h1>

<?php }?>
</div>

</center>

<?php include("../footer.php"); ?>
    

</body>

</html>