<?php session_start(); #if session exist then session error variable will be set to null

if(!isset($_SESSION["student_id"]))

	
	header('Location: ../index.php');

$_SESSION["error"] = "";
?>




<script>

	$('#myModal').on('shown.bs.modal', function () {

  $('#myInput').focus()

})

</script>

<style>

	h3{color: #042c4f}

	</style>
<head><title>Student panel</title></head>
<?php include("header.php"); ?>

<body>



<!--

<img src="iet.jpg" style="width: 100%;"/>

-->

<br>

<center>

<div class="row">

  <div class="col-sm-12 col-12">

    <div class="card card-inverse card-info mb-3" style="margin-bottom:70px; margin-top:90px;">

      <div class="card-block">

        <h3 class="card-title"><h3 class="text-primary"><?php echo "Welcome ".$_SESSION['student_name']; /*display username welcome message*/ ?></h3>

        <div class="icon">

        <div class="row">

        <div class="col-md-1">

        </div>

   <div class="col-md-2">    

  <a class="icon-wrapper" href="subject.php"><i class="fa fa-calendar-check-o fa-4x custom-icon"><span class="fix-editor">&nbsp;</span></i></a>

    <a href="subject.php"><h3>Attendance</h3></a> 

  </div>

<div class="col-md-2">   

<a class="icon-wrapper" href="#"><i class="fa fa-calendar fa-4x custom-icon"><span class="fix-editor">&nbsp;</span></i></a><br>

<a href="#"><h3>Schedule</h3></a>

</div>

<div class="col-md-2">   

<a class="icon-wrapper" href="#"><i class="fa fa-pencil-square-o fa-4x  custom-icon"><span class="fix-editor">&nbsp;</span></i></a>

    <a href="#"><h3>Broadcast</h3></a>

</div>

<div class="col-md-2">   

<a class="icon-wrapper" href="#"><i class="fa fa-comment fa-4x  custom-icon"><span class="fix-editor">&nbsp;</span></i></a><br>

 <a href="#"><h3>Notes</h3></a>

 </div>

  <div class="col-md-2">   

<a class="icon-wrapper" href="#"><i class="fa fa-users fa-4x custom-icon"><span class="fix-editor">&nbsp;</span></i></a>

       <a href="#"><h3>Student's Details</h3></a>

       </div> 

        <div class="col-md-1">

        </div>

        </div>

        </div>

        

      

  

  </div>

</div>

</div>

	</div>

</center>

<?php include("../footer.php"); ?>
    

</body>

</html>