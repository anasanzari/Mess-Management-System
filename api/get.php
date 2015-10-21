
<?php
require 'connection.php';
$out = [];
/*
if(isset($_GET['type'])){
	switch($_GET['type']){
		case 'rollexists' : $out = rollexist();break;
		
	}
	
}else{
	$output['status'] = 'fail';
	$output['error'] = "more fields required.";
}
*/

//header('Content-type: text/plain');
//echo json_encode($out, JSON_PRETTY_PRINT);


//Function to check if rollno exists
function rollexist()
{
    $rollno=$_SESSION['rollno'];
	global $conn;
	//var_dump($conn);
	$output = [];
	$sql="select * from members where RollNo='$rollno';";
			
	
	$result=$conn->query($sql);
	if($result){
	
		$output['status'] = "success";
		
		if($result->num_rows > 0)
			$data = ['exists'=>true]; 
		else{
			$data = ['exists' =>false];
		}
		$output['data'] = $data;
	}else{
		echo 'nope';
		$output['status'] = 'fail';
		$output['error'] = "query error";
	}
	return $output;
		
}

//Function to check the details of students' current extras
function current_extras()
{
	$rollno=$_SESSION['rollno'];
	global $conn;
	global $db;
	$output = [];
	$month=date("Y-m");
	$sql="select ExtrasName,DateTime from Extras,ExtrasTaken where ".
	"ExtrasTaken.ExtrasID = Extras.ExtrasID and RollNo = '$rollno' and DateTime like '$month-%' ";
	echo $sql;
	$result=mysqli_query($conn, $sql);
	
	if($result){
		$output['status'] = "success";
		while($row = $result->fetch_assoc()){
			$data[] = $row;
		
		}
		$output['data'] = $data;
	}else{
		$output['status'] = 'fail';
		$output['error'] = "query error";
	}
	return $output;
	
}

//Function to check the history of students all extras
function history_extras()
{
	$rollno=$_SESSION['rollno'];
	global $conn;
	$output = [];
	$month=date("Y-M");
	$sql="select ExtrasName,DateTime from Extras,ExtrasTaken where ".
			"ExtrasTaken.ExtrasID = Extras.ExtrasID and RollNo = '$rollno' ";
	echo $sql;
	$result=mysqli_query($conn, $sql);

	if($result){
		$output['status'] = "success";
		while($row = $result->fetch_assoc()){
			$data[] = $row;

		}
		$output['data'] = $data;
	}else{
		$output['status'] = 'fail';
		$output['error'] = "query error";
	}
	return $output;

}

//Function to find history of members added to a mess
function added_members()
{
	$mess_id=$_SESSION['mess_id'];
	global $conn;
	$output = [];
	$sql="select MemberName,StartDate,Members.RollNo as RollNo from Members,MessJoins where ".
			"Members.RollNo = MessJoins.RollNo and MessID = $mess_id order by StartDate desc";
	echo $sql;
	$result=mysqli_query($conn, $sql);

	if($result){
		$output['status'] = "success";
		while($row = $result->fetch_assoc()){
			$data[] = $row;

		}
		$output['data'] = $data;
	}else{
		$output['status'] = 'fail';
		$output['error'] = "query error";
	}
	return $output;

}

//Function to find history of extras taken from a mess
function extras_mess_history()
{
	$mess_id=$_SESSION['mess_id'];
	global $conn;
	$output = [];
	$sql="select MemberName,DateTime,Members.RollNo as RollNo,Extras.ExtrasID as ExtrasID, ExtrasName from Members,MessJoins,Mess,Extras,ExtrasTaken where ".
			"Members.RollNo = MessJoins.RollNo and Members.RollNo = ExtrasTaken.RollNo and ExtrasTaken.ExtrasID = Extras.ExtrasID and Mess.MessID = $mess_id order by DateTime desc";
	echo $sql;
	$result=mysqli_query($conn, $sql);

	if($result){
		$output['status'] = "success";
		while($row = $result->fetch_assoc()){
			$data[] = $row;

		}
		$output['data'] = $data;
	}else{
		$output['status'] = 'fail';
		$output['error'] = "query error";
	}
	return $output;

}

//Function to find history of messcuts in a mess
function history_messcut()
{
	$mess_id=$_SESSION['mess_id'];
	global $conn;
	$output = [];
	$sql="select MemberName,Members.RollNo as RollNo,FromDate,ToDate from Members,MessCut where ".
			"Members.RollNo = MessCut.RollNo and MessID = $mess_id order by FromDate desc";
	echo $sql;
	$result=mysqli_query($conn, $sql);

	if($result){
		$output['status'] = "success";
		while($row = $result->fetch_assoc()){
			$data[] = $row;

		}
		$output['data'] = $data;
	}else{
		$output['status'] = 'fail';
		$output['error'] = "query error";
	}
	return $output;

}

//Function to find bill of a student in current month
function current_month_bill()
{
	$rollno=$_SESSION['rollno'];
	global $conn;
	$output = [];
	$no_days=0;
	$cut_days=0;
	$extras_total=0;
	$perdayrate=0;
	$day=date("Y-m-d");
	$month=date("Y-m");
	
	$sql = "select mj.StartDate, mj.RollNo, m.PerDayRate, "
			."(select sum(DATEDIFF(ToDate,FromDate)) from MessCut,Members where MessCut.RollNo = Members.RollNo and Members.RollNo = mj.RollNo and FromDate like '$month-%') as CutDays, "	
			."(select sum(Price) from ExtrasTaken,Extras where ExtrasTaken.ExtrasId = Extras.ExtrasId and ExtrasTaken.Rollno = mj.RollNo and DateTime like '$month-%') as ExtrasTotal "
			."from MessJoins as mj,Mess as m where mj.MessId = m.MessId and mj.StartDate like '$month-%' and m.MessId = '1001';";
	$result=mysqli_query($conn, $sql);
	while($row=$result->fetch_assoc()){
		$output[] = $row;
	}
	
	/*$sql="select DATEDIFF('$day',MessJoins.StartDate) as DiffDate from MessJoins,Members where MessJoins.RollNo = Members.RollNo and Members.Rollno = '$rollno' and StartDate like '$month-%'";
	$result=mysqli_query($conn, $sql);
	if($result)
		$no_days=$result->fetch_array()[0];
	else {
		$output['status'] = 'fail';
		$output['error'] = "query1 error";
	}
	$output['no_days'] = $no_days;
	$sql="select sum(DATEDIFF(ToDate,FromDate)) from MessCut,Members where MessCut.RollNo = Members.RollNo and Members.Rollno = '$rollno' and FromDate like '$month-%'";
	$result=mysqli_query($conn, $sql);
	if($result)
		$cut_days=$result->fetch_array()[0];
	else {
		$output['status'] = 'fail';
		$output['error'] = "query1 error";
	}
	$output['cut_days'] = $cut_days;
	$sql="select sum(Price) from ExtrasTaken,Extras where ExtrasTaken.ExtrasId = Extras.ExtrasId and ExtrasTaken.Rollno = '$rollno' and DateTime like '$month-%'";
	$result=mysqli_query($conn, $sql);
	if($result)
		$extras_total=$result->fetch_array()[0];
	else {
		$output['status'] = 'fail';
		$output['error'] = "query1 error";
	}
	$output['extras_total'] = $extras_total;
	$sql="select PerDayRate from MessJoins,Mess where MessJoins.MessId = Mess.MessId and StartDate like '$month-%'";
	echo $sql;
	$result=mysqli_query($conn, $sql);
	if($result)
		$perdayrate=$result->fetch_array()[0];
	else {
		$output['status'] = 'fail';
		$output['error'] = "query1 error";
	}
	$output['perdayrate'] = $perdayrate;*/
	return $output;

}

//Function for analysis of extras for a mess
function mess_amount_analysis()
{
	$mess_id=$_SESSION['mess_id'];
	global $conn;
	$output = [];
	$sql="select ExtrasName,sum(Price), count(*) from Members, MessJoins, Mess, ExtrasTaken, Extras where ".
			"Members.RollNo = MessJoins.RollNo and Members.RollNo = ExtrasTaken.RollNo and ExtrasTaken.ExtrasID = Extras.ExtrasID and Mess.MessID = $mess_id group by Extras.ExtrasID";
			
	echo $sql;
	$result=mysqli_query($conn, $sql);

	if($result){
		$output['status'] = "success";
		while($row = $result->fetch_assoc()){
			$data[] = $row;

		}
		$output['data'] = $data;
	}else{
		$output['status'] = 'fail';
		$output['error'] = "query error";
	}
	return $output;

}



	$_SESSION['rollno']="B130112CS";
	$output= current_month_bill();
header('Content-type: text/plain');
echo json_encode($output, JSON_PRETTY_PRINT);
	?>