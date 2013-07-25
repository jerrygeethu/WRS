<?php
require_once('include/include.php');
$emp_power=emp_authority($_SESSION['USERID']);	
$dep_id=$emp_power['ishod_deptid'];
/*if(isset($_GET['reqid']))
{
	$reqid=$_GET['reqid'];
	//echo "r=".$reqid; //print_r($reqid);
	//$c=count($reqid);
	//echo "count=".$c; //  o/p=1
	
}*/
//Approve click
if(isset($_POST['approveBtn']))
{
	if(isset($_POST['chkreq']))
	{
		$reqids=$_POST['chkreq'];
		$count=count($reqids);
		for($i=0;$i<$count;$i++)
		{
			$reqId=$reqids[$i];
			//Set status as closed in emprequest
			$updateQuery="update emprequest set status='closed' where jobrequestid='".$reqId."' ";
			$updateResult=$GLOBALS['db']->query($updateQuery);
			//Get schedule and emplyee from emprequest 
			$reqQuery="select scheduleid,employeeid 	from emprequest where jobrequestid='".$reqId."' ";		
			$reqResult=$GLOBALS['db']->query($reqQuery);
			$reqRow=$reqResult->fetch_assoc();
			$schid=$reqRow['scheduleid'];
			$empid=$reqRow['employeeid'];
			
			//Insert emprequest into schemployee
			$insertQuery="insert into schemployee(scheduleid,employeeid) values('".$schid."','".$empid."')";
			$result=$GLOBALS['db']->query($insertQuery);
			if($result)
			{			
				$msg="Employee request has been approved";
			}
			else
			{
				$msg="Error occured";
			}
		}
	}
}
//Reject click
if(isset($_POST['rejectBtn']))
{
	if(isset($_POST['chkreq']))
	{
		$reqids=$_POST['chkreq'];
		$count=count($reqids);
		for($i=0;$i<$count;$i++)
		{
			$reqId=$reqids[$i];
			//Set status as closed in emprequest
			$updateQuery="update emprequest set status='cancelled' where jobrequestid='".$reqId."' ";
			$updateResult=$GLOBALS['db']->query($updateQuery);
			
			if($updateResult)
			{			
				$msg="Employee request has been cancelled";
			}
			else
			{
				$msg="Error occured";
			}
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<title><?php print $company_name;?> - Approve employee request</title>
<link href="css/reporting.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="./images/icon.gif" >
<script language="javascript">
/*function show()
{			
	var reqids=new Array();		
	for(var i=0;i<document.approveFrm.chkreq.length; i++)
	{
		if(document.approveFrm.chkreq[i].checked)
		reqids[i]=document.approveFrm.chkreq[i].value;
	}		
	document.location.href="approveRequest.php?reqid="+reqids;
}*/
function changeSch()
{
	var schid=document.getElementById('schid').value;
	

}
</script>
</head>

<body>
<form id="approveFrm" name="approveFrm" method="post" action="approveRequest.php">  
<table class="main_content_table" width="100%" border="0">
<tr><td colspan="6"><?php echo $msg;?></td></tr>
<tr>
  <td colspan="6" class="table_heading">Employee request list</td>
</tr>
<tr class="table_heading">
<th>No:</th>
<th>Employee</th>
<th>Schedule</th>
<th>Request Details</th>
<th colspan="2">Date</th>
</tr>
<?php
$query="select
 				req.jobrequestid,	
				sch.description,
				req.employeeid,
				req.request,
				req.requestdate,
				req.status,
				e.fullname
			from 
				emprequest  req,
				schedule sch,
				employee e
			where 
				 req.deptid='".$dep_id."'
			and
				 req.status='open'
			and
				 req.scheduleid=sch.scheduleid
			and
				e.employeeid=req.employeeid
				 
			";		
$result=$GLOBALS['db']->query($query);
if($result->num_rows>0)
{
	$i=0;
	while($row=$result->fetch_assoc())
	{	
		$i++;	
		if(($i%2)<1) $class=" class=\"even\" ";else  $class=" class=\"odd\" ";
		?>  
		<tr <?php echo $class;?>>
			<td class="main_matter_txt"><?php echo $i;?></td>
			<td><?php echo $row['fullname'];?></td>
			<td><?php echo $row['description'];?></td>
			<td><?php echo $row['request'];?></td>
			<td><?php echo ymdTodmy($row['requestdate']);?></td>
			<td><input type="checkbox" name="chkreq[]"  value="<?php echo $row['jobrequestid'];?>"/></td>
		</tr>
		<?php
	}
	?>
	<tr>
	
	<td colspan="6"><input type="submit" name="approveBtn" id="approveBtn" value="Approve"  class="s_bt"/>
	<input type="submit" name="rejectBtn" id="rejectBtn" value="Reject"  class="s_bt"/>
	</td>
	</tr>
	<?php	
}
else
{
	?>
	<tr>
	<td colspan="6" align="center">No Records</td>
	</tr>
	<?php
}
?>	
  </table> 
</form>
</body>
</html>
