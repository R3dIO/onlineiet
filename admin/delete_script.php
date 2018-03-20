<?php
require '../conn_iet.php';
$delete_type = $_POST['delete_type'];
$msg = "";

if($delete_type == 'faculty') {
	$id = $_POST['id'];
	$result = mysqli_query($conn,"delete from faculty_table where id=$id");
	if($result)
		$msg = "Data deleted";
	else $msg = "Error! Please try again";
}

if($delete_type == 'subject') {
	$id = $_POST['subject_id'];
	$result = mysqli_query($conn,"delete from subject_table where id=$id");
	if($result) 
		$msg = "Data deleted";
	else $msg = "Error! Please try again";
}

?>

<html>
<head>
<title>Admin</title>
</head>
<body>
<script>
alert("<?php echo $msg; ?>");
window.location.href = "admin_panel.php";
</script>
</body>
</html>