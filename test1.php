<?php
require_once('include/include.php');
$emp_power=emp_authority($_SESSION['USERID']);
//$empid=$_SESSION['USERID'];
//echo "emp=".$empid;
$empid='71';
$selectFile="select * from fileshare where privillage='private' ";
$result=$GLOBALS['db']->query($selectFile);
while($row=$result->fetch_assoc())
{
	$employeeid=$row['employeeid'];
	$arr=explode(",",$employeeid);
	//print_r($arr);
	if(in_array($empid,$arr))
	{
	 	//echo "<br/>".$employeeid;
	}
}
/////////////////////////////////////////////////////////
//Get emps of HOD
//printarray($emp_power);


$selectFile1="select * from fileshare where privillage='private' ";
$result1=$GLOBALS['db']->query($selectFile1);
while($row1=$result1->fetch_assoc())
{
	if($emp_power['is_hod']==1)
	{
		$selectEmpOfHod="select employeeid,fullname from employee where departmentid in ('".$emp_power['ishod_deptid']."') and employee.empstatus='active'";
		$selectEmpOfHodRes=$GLOBALS['db']->query($selectEmpOfHod);	
		while($rowRes=$selectEmpOfHodRes->fetch_assoc())
		{
			$hodEmp[]=$rowRes['employeeid'];			
		}
		
		$employeeid=$row1['employeeid'];
		$arrPvtEmp=explode(",",$employeeid);
		$arrNew=array_intersect($hodEmp,$arrPvtEmp);
		printarray(array_unique($arrNew));
	}
	else //files of login emp
	{	
		$employeeid=$row1['employeeid'];
		$arr=explode(",",$employeeid);
		//print_r($arr);
		if(in_array($empid,$arr))
		{
			//echo "<br/>".$employeeid;
		}
	}
}
?>