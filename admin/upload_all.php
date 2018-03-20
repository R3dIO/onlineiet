<?php

function send_notification($tokens,$message) {
	$url = "https://fcm.googleapis.com/fcm/send";
	$fields = array('registration_ids'=>$tokens,'data'=>$message);
	$headers = array('Authorization: key=AAAAPXVRt0k:APA91bFyB-5w6vMvnh7cSW6kbn404OYDJ8x30RDwdMIg8wTJLJI25tLrDr-48DNj2m49y7srxXqf8QBAG2qjfXratAC9KWmM9a9b3y0EaiaHjOJRjhEhUdf5aI_UkcKJLk2MPtQgyWqt'
					,'Content-Type: application/json');
	
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_POST,true);
	curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
	curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($fields));
	$r = curl_exec($ch);
	if($r === FALSE)
		die('Curl failed: '.curl_error($ch));
	curl_close($ch);
	//echo $r;
}

ini_set('max_execution_time',120);
require '../conn_iet.php';
$error=false;
$msg='';
if(is_uploaded_file($_FILES['file']['tmp_name']))
{
            //open uploaded csv file with read only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
			$branch = '';
			$val = '';
            while(($line = fgetcsv($csvFile)) !== FALSE){
				if($line[0] == 'Course' || $line[0] == 'Name' || $line[0] == 'Roll_no' || $line[0] == 'Enroll_no' || $line[0] == 'Branch' || $line[0] == 'Semester'
					|| $line[0] == 'Section')
					$flag = false;
				if(!$flag) {
					for($i=0;$i<7;$i++) {
						switch($line[$i]) {
							case 'Name':
								$col[3] = $i;
								break;
							case 'Enroll_no':
								$col[2] = $i;
								break;
							case 'Roll_no':
								$col[1] = $i;
								break;
							case 'Course':
								$col[0] = $i;
								break;
							case 'Branch':
								$j = $i;
								break;
							case 'Semester':
								$k = $i;
								break;
							case 'Section':
								$col[4] = $i;
								break;
						}
					}
					$flag = true;
				}
				else {
					switch($line[$j]) {
						case 'CIVIENG_FT':
							$branch = 'Civil Engineering';
							break;
						case 'COMPENG_FT':
							$branch = 'Computer Engineering';
							break;
						case 'ECIENG_FT':
							$branch = 'Electronics & Instrumentation';
							break;
						case 'ECTELEG_FT':
							$branch = 'Electronics & Telecommunications';
							break;
						case 'ITENG_FT':
							$branch = 'Information Technology';
							break;
						case 'MECHENG_FT':
							$branch = 'Mechanical Engineering';
							break;
						case 'CESPSE':
							$branch = 'Computer Engineering SE';
							break;
						case 'EESPDC':
							$branch = 'Electronics & Telecommunications DC';
							break;
						case 'IEM':
							$branch = 'Mechanical Engineering IEM';
							break;
						case 'ITSPIS':
							$branch = 'Information Technology nanoscience IS';
							break;
						case 'MESPTDE':
							$branch = 'Mechanical Engineering TM';
							break;
						case 'EESPDI':
							$branch = 'Electronics & Instrumentation DI';
							break;
						case 'AM':
							$branch = 'Applied Science';
							break;
					}
					switch($line[$k]) {
						case '1SEM':
						case '2SEM':
							$year = 1;
							break;
						case '3SEM':
						case '4SEM':
							$year = 2;
							break;
						case '5SEM':
						case '6SEM':
							$year = 3;
							break;
						case '7SEM':
						case '8SEM':
							$year = 4;
							break;
					}
					if(!$line[$col[4]]) {
						if(strpos($line[$col[0]],"SC") > 0)
							$query = "insert ignore into student_table (class_id,roll_no,enroll_no,name) select id,'".$line[$col[1]]."','".$line[$col[2]]."','"
								.$line[$col[3]]."' from class_table where course='".substr($line[$col[0]],0,3)."' and branch='$branch' and year=$year";
						else $query = "insert ignore into student_table (class_id,roll_no,enroll_no,name) select id,'".$line[$col[1]]."','".$line[$col[2]]."','"
								.$line[$col[3]]."' from class_table where course='".substr($line[$col[0]],0,2)."' and branch='$branch' and year=$year";
					}
					else {
						if(strpos($line[$col[0]],"SC") > 0)
							$query = "insert ignore into student_table (class_id,roll_no,enroll_no,name) select id,'".$line[$col[1]]."','".$line[$col[2]]."','"
								.$line[$col[3]]."' from class_table where course='".substr($line[$col[0]],0,3)."' and branch='$branch' and year=$year and section='".$line[$col[4]]."'";
						else $query = "insert ignore into student_table (class_id,roll_no,enroll_no,name) select id,'".$line[$col[1]]."','".$line[$col[2]]."','"
								.$line[$col[3]]."' from class_table where course='".substr($line[$col[0]],0,2)."' and branch='$branch' and year=$year and section='".$line[$col[4]]."'";
					}
					$result = mysqli_query($conn,$query);
					$res = mysqli_query($conn,"update student_table set roll_no='".$line[$col[1]]."' where enroll_no='".$line[$col[2]]."'");
					if($result==false) {
						$error = true;
						break;
					} 
					//echo $query.'\n';
				}
			}
}
else $msg = "No file uploaded!!";
if($error)
	$msg="Error! Please try again";
else if($msg=='') {
	$rs = mysqli_query($conn,"select token from firebase_tokens;");
	$tokens = array();
	if(mysqli_num_rows($rs) > 0) {
		while($rw = mysqli_fetch_assoc($rs))
			$tokens[] = $rw['token'];
	}
	$message = array('message'=>'Student list updated. Please sync!!');
	send_notification($tokens,$message);
	$msg="Details saved successfully";
    //echo $msg;
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