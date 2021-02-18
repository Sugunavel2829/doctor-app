<?php
include_once './assets/config/config.php';
$request=$_GET['request'];
if($request=='DoctorInsert'){
	global $conn;
	$id=trim(mysqli_real_escape_string($conn,$_POST['id']));
	$name=trim(mysqli_real_escape_string($conn,$_POST['name']));
	$qualification=trim(mysqli_real_escape_string($conn,$_POST['qualification']));
	$location=trim(mysqli_real_escape_string($conn,$_POST['location']));
	$fromDate=trim(mysqli_real_escape_string($conn,$_POST['fromDate']));
	$toDate=trim(mysqli_real_escape_string($conn,$_POST['toDate']));
	$fromTime=trim(mysqli_real_escape_string($conn,$_POST['fromTime']));
	$toTime=trim(mysqli_real_escape_string($conn,$_POST['toTime']));

	if($id==''){
		if(isset($_FILES["files"]["name"]["image"]) && $_FILES["files"]["name"]["image"]!=""){
		    $tempcphoto = $_FILES['image']['tmp_name']; //echo '<br/> '.$this->tempcphoto;
		    $folder="./assets/uploads/";
		    $file1 = rand(1000,1000000)."-".$_FILES['image']['name'];

		    $moved=move_uploaded_file($tempcphoto, $folder.$file1);
		    if($moved){
		    	$sql="INSERT INTO doctor_schedule SET name='".$name."',quali='".$qualification."',location='".$location."',img='".$file1."',from_date='".$fromDate."',to_date='".$toDate."',from_time='".$fromTime."',to_time='".$toTime."'";
		 		$result=mysqli_query($conn,$sql);
				if($result){
					echo "insert";
				}else{
					echo "error";
				}
		    }
		}	
	}
	
}else if($request=='AppointmentInsert'){
	global $conn;
	$docname=$_POST['docname'];
	$date=$_POST['date'];
	$start_time=$_POST['start_time'];
	$end_time=$_POST['end_time'];
	$pat_name=$_POST['pat_name'];
	$pat_mobile=$_POST['pat_mobile'];
	$pat_email=$_POST['pat_email'];
	$symptom=$_POST['symptom'];
	$comment=$_POST['comment'];
	if(isset($docname) && isset($date) && isset($start_time) && isset($end_time) && isset($pat_name) && isset($pat_mobile) && isset($pat_email)){
		$sql="INSERT INTO appointment SET pat_name='".$pat_name."',pat_mobile='".$pat_mobile."',pat_email='".$pat_email."',doc_name='".$docname."',appdate='".$date."',from_time='".$start_time."',to_time='".$end_time."',symptom='".$symptom."',comment='".$comment."'";
		$result=mysqli_query($conn,$sql);
		if($result){
			echo "insert";
		}else{
			echo "error";
		}
	}
}