<?php
require "../conn_iet.php";
$attendance_post = $_POST["attendance"];
$attendance = json_decode($attendance_post, true);
$edited = true;
for($i=0;$i<sizeof($attendance);$i++) {
	$temp = $attendance[$i];
	$id = $temp['student_id'];
	$l = $temp['lecture_num'];
	$att = $temp['attendance'];
	if($att == 0)
		$mysql_qry = "update attendance_table set $l = 1, present_no = present_no+1 where student_id = $id;";
	else $mysql_qry = "update $table_code set $l = 0, present_no = present_no-1 where student_id = $id;";
	if($conn->query($mysql_qry) === TRUE)
		continue;
	else {
		$edited = false;
		break;
	}
}
if($edited)
	echo "Attendance saved";
else echo "Attendance not saved!!";
?>