<?php
if(isset($_POST['username']) and $_POST['username']!='' && isset($_POST['password']) and $_POST['password']!='') {
	require_once('include/include.php');
	//header('location:home.php');
    //active_log("viewing login page ");
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	$password = md5($password);
	
	
	$query = "select employeeid,departmentid,empname,pwd,isadmin from employee where empname = \"$username\" and pwd = \"$password\"";
	$query .= " AND empstatus = 1 ";
	$result = $GLOBALS['db']->query($query);
	
	if(isset($result) and $result->num_rows>0) {
			
			$row = $result->fetch_assoc();
			//active_log("user name $username and password ********** found on database . so going to start session");
			
			session_start();
			$_SESSION['USERID'] = $row['employeeid'];
			$_SESSION['NAME'] = ucwords($row['empname']);
			$_SESSION['ISADMIN'] = $row['isadmin'];
			$_SESSION['DEPART'] = $row['departmentid'];
			header('location:home.php');
		}
		else{
			header('location:index.php?e=1');
		}
	}
	else{
		header('location:index.php?e=2');
		}

?>
