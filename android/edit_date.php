<?php
require '../conn_iet.php';
$id = $_POST['id'];
$lec_num = $_POST['lecture_num'];
$date = $_POST['date'];

$l = 'l'.$lec_num;
$result = mysqli_query($conn,"select last_lecture_date,$l from schedule_table where id=$id");
$row = mysqli_fetch_assoc($result);
if($row[$l] == $row['last_lecture_date'])
	$result = mysqli_query($conn,"update schedule_table set last_lecture_date='$date',$l='$date' where id=$id");
else $result = mysqli_query($conn,"update schedule_table set $l='$date' where id=$id");

echo "Date Saved";
?>