
<?php
require 'connection.php';
$out = [];

$_SESSION['loggedin'] = true;
$_SESSION['usertype'] = 'mess';
$_SESSION['messname'] = 'C MESS';
$_SESSION['messid'] = '1001';

$_SESSION['rollno']="B130112CS";
$_SESSION['month']="2015-10";

$out = [];

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] && isset($_GET['usertype']) && $_SESSION['usertype'] == $_GET['usertype']) {

    if (isset($_GET['querytype'])) {

        $type = $_GET['querytype'];
        
        if ($_GET['usertype'] == 'mess') {
            switch ($type) {
                case 'available_students' : $out = messcardentry();
                    break;
                case 'added_students' : $out = addextra();
                    break;
                case 'extras_history': $out = addleave();
                    break;
                case 'leave_history': $out = addleave();
                    break;
                case 'billings': $out = addleave();
                    break;
                case 'extras_summary': $out = addleave();
                    break;
                case 'extras_history': $out = addleave();
                    break;
            }
        }else if($_GET['usertype']=='student'){
            switch ($type) {
                case 'ratemess': $out = ratemess();break;
                case 'forumpost': $out = forumpost();break;
            }
        }
    } else {
        $out['status'] = 'fail';
        $out['error'] = "querytype not set.";
    }
} else {
    $out['status'] = 'fail';
    $out['error'] = "authentication failure";
}

header('Content-type: text/plain');
echo json_encode($out, JSON_PRETTY_PRINT);


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
	$month=date("Y-m");
	$sql="select MemberName,Members.RollNo as RollNo,FromDate,ToDate from Members,MessCut where ".
			"Members.RollNo = MessCut.RollNo and MessID = $mess_id and FromDate like '$month-%' order by FromDate desc";
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

//Function to find bill of all students in any given month month
function month_bill()
{
	$mess_id=$_SESSION['mess_id'];
	$month=$_SESSION['month'];
	global $conn;
	$output = [];
	$no_days=0;
	$cut_days=0;
	$extras_total=0;
	$perdayrate=0;
	$day=date("Y-m-d");
	//$month=date("Y-m");
	
	$sql = "select mj.StartDate, mj.RollNo, m.PerDayRate, "
			."(select sum(DATEDIFF(ToDate,FromDate)) from MessCut,Members where MessCut.RollNo = Members.RollNo and Members.RollNo = mj.RollNo and FromDate like '$month-%') as CutDays, "	
			."(select sum(Price) from ExtrasTaken,Extras where ExtrasTaken.ExtrasId = Extras.ExtrasId and ExtrasTaken.Rollno = mj.RollNo and DateTime like '$month-%') as ExtrasTotal "
			."from MessJoins as mj,Mess as m where mj.MessId = m.MessId and mj.StartDate like '$month-%' and m.MessId = $mess_id";
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

//Function to list all available students
function list_available()
{
	$month=date("Y-m");
	global $conn;
	$output = [];
	$sql="select MemberName, RollNo from Members where Members.RollNo not in".
		"(select Members.RollNo as RollNo from Members, MessJoins where Members.RollNo=MessJoins.RollNo and StartDate like '$month-%') ";
		
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

//Function to find list of extras taken from a mess per day
function extras_mess_perday()
{
	$mess_id=$_SESSION['mess_id'];
	global $conn;
	$output = [];
	$day=date("Y-m-d");
	$sql="select MemberName,DateTime,Members.RollNo as RollNo,Extras.ExtrasID as ExtrasID, ExtrasName from Members,MessJoins,Mess,Extras,ExtrasTaken where ".
			"Members.RollNo = MessJoins.RollNo and Members.RollNo = ExtrasTaken.RollNo and ExtrasTaken.ExtrasID = Extras.ExtrasID and Mess.MessID = $mess_id and DateTime like '$day%'";
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

//Function to view the forum of the given mess
function forum_post_mess()
{
	$mess_id=$_SESSION['mess_id'];
	global $conn;
	$output = [];
	$sql="select MessName, Members.RollNo as RollNo, MemberName, DateTime, Comment from Members,Forum,Mess where ".
			"Members.RollNo = Forum.RollNo and Forum.MessID = Mess.MessID and Mess.MessID = $mess_id order by DateTime desc";
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

//Function to view details of given mess
function mess_info()
{
	$mess_id=$_SESSION['mess_id'];
	global $conn;
	$output = [];
	$sql="select MessID,MessName,MessCoordinator,PerDayRate from Mess where Mess.MessID = $mess_id";
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

//Function to view the forum of the students' current mess
function forum_post_student()
{
	$rollno=$_SESSION['rollno'];
	global $conn;
	$output = [];
	$sql="select MessName, Members.RollNo as RollNo, MemberName, DateTime, Comment from Members,Forum,Mess,MessJoins where ".
			"Members.RollNo = MessJoins.RollNo and MessJoins.MessID = Mess.MessID and Forum.MessID = Mess.MessID and Members.RollNo='$rollno' order by DateTime desc";
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

//Function to view mess ratings
function ratings_view()
{
	$rollno=$_SESSION['rollno'];
	global $conn;
	$tempoutput=[];
	$output = [];
	$sql="select MessName, avg(RatingValue) from Mess,Rating where Mess.MessID=Rating.MessID group by MessName";
	echo $sql;
	$result=mysqli_query($conn, $sql);

	if($result){
		$output['status'] = "success1";
		while($row = $result->fetch_assoc()){
			$data[] = $row;

		}
		$tempoutput['messratings'] = $data;
	}else{
		$output['status'] = 'fail';
		$output['error'] = "query error";
	}
	$sql="select Mess.MessID from Mess,MessJoins where Mess.MessID=MessJoins.MessID and MessJoins.RollNo='$rollno'";
	echo $sql;
	$result=mysqli_query($conn, $sql);
	
	if($result){
		$output['status'] = "success2";
		while($row = $result->fetch_array()[0]){
			$tempoutput["studentmess"] = $row;
	
		}
	}else{
		$output['status'] = 'fail';
		$output['error'] = "query error";
	}
	$output["data"]=$tempoutput;
	return $output;

}

//Function to find bill of a student in any given month month
function month_bill_student()
{
	$rollno=$_SESSION['rollno'];
	$month=$_SESSION['month'];
	global $conn;
	$output = [];
	$no_days=0;
	$cut_days=0;
	$extras_total=0;
	$perdayrate=0;
	$day=date("Y-m-d");
	//$month=date("Y-m");

	$sql = "select mj.StartDate, mj.RollNo, m.PerDayRate, "
			."(select sum(DATEDIFF(ToDate,FromDate)) from MessCut,Members where MessCut.RollNo = Members.RollNo and Members.RollNo = mj.RollNo and FromDate like '$month-%') as CutDays, "
			."(select sum(Price) from ExtrasTaken,Extras where ExtrasTaken.ExtrasId = Extras.ExtrasId and ExtrasTaken.Rollno = mj.RollNo and DateTime like '$month-%') as ExtrasTotal "
			."from MessJoins as mj,Mess as m where mj.MessId = m.MessId and mj.StartDate like '$month-%' and mj.RollNo = '$rollno'";
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

	?>