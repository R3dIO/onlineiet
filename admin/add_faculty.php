<?php
require '../conn_iet.php';
$name = $_POST['faculty_name'];
$branch = $_POST['branch_fac'];
$designation = $_POST['designation'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = md5($_POST['password']);

$result = mysqli_query($conn,"insert into faculty_table (name,branch,designation,email) values ('$name','$branch','$designation','$email')");
if($result) {
	$res = mysqli_query($conn,"insert into faculty_login_table select id,'$username','$password' from faculty_table where name='$name' and branch='$branch' and 
			designation='$designation' and email='$email'");
	if($res)
		$msg = "Details saved successfully!!";
	else $msg = "Error! Please try again";
}
else $msg = "Error! Please try again";

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