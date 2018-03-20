<?php
require_once '../conn_iet.php';
$class_id = $_POST['class_id'];
$msg='';

for($i=1;$i<=8;$i++) {
	$faculty_id = $_POST['faculty_id'.$i];
	$subject_id = $_POST['subject_id'.$i];

	if($faculty_id == 'Select Faculty' && $subject_id == 'Select Subject')
		continue;

	$res = mysqli_query($conn,"select type from subject_table where id=$subject_id");
	$rw = mysqli_fetch_assoc($res);

	$result=mysqli_query($conn,"insert ignore into faculty_subject_table values ($faculty_id,$subject_id,$class_id)");
	if($result==false) {
	   $msg="Error! Please try again";
	   break;
	}

	if($rw['type'] == 0 || $rw['type'] == 2) {
		$result=mysqli_query($conn,"insert ignore into schedule_table(class_id,subject_id,batch) values($class_id,$subject_id,0)");
		if($result==false) {
		   $msg="Error! Please try again";
		   break;
		}
	}

	if($rw['type'] == 1 || $rw['type'] == 2) {
		$result=mysqli_query($conn,"insert ignore into schedule_table(class_id,subject_id,batch) values($class_id,$subject_id,1)");
		$result1=mysqli_query($conn,"insert ignore into schedule_table(class_id,subject_id,batch) values($class_id,$subject_id,2)");
		if($result==false || $result1==false) {
		   $msg="Error! Please try again";
		   break;
		}
	}
}

if($msg=='') 
	$msg="Details saved successfully";

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