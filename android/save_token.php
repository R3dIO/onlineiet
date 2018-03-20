<?php
require '../conn_iet.php';
if(isset($_POST['token'])) {
	$token = $_POST['token'];
	$id = $_POST['id'];
	$result = mysqli_query($conn,"insert into firebase_tokens values ($id,'$token') on duplicate key update token='$token';");
	if($result) echo "Success";
	mysqli_close($conn);
} else echo "Failed";
?>