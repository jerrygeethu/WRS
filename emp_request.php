<?php
require_once('include/include.php');
require_once('include/emp_request_functions.php');
$flag="";
//Get schedule id from url
if(isset($_GET['id']))
{
	$schid=$_GET['id'];	
}
//Get department id from url
if(isset($_GET['dep']))
{
	$depid=$_GET['dep'];	
}

//send click
if(isset($_POST['reqdetails']))
{	
	$flag="1";
	$shid=$_POST['schid'];
	$reqdetails=trim($_POST['reqdetails']);
	$status=$_POST['status'];
	$today=date('Y-m-d');	
	//echo "<br/>req=".$reqdetails."<br/>date=".$today."<br/>status=".$status;
	
	//get schedule details for $shid
	$schQuery="select s.departmentid,s.description,d.depname from schedule s,department d where scheduleid='".$shid."' and d.departmentid=s.departmentid";
	$schResult=$GLOBALS['db']->query($schQuery);
	$schRow=$schResult->fetch_assoc();
	
	$emps=$_POST['employeelist'];	//($emps contain empid and depid )
	//printarray($emps);
	//echo "<br/>";	
	$c=count($emps);
	$newArr=array();
	for($i=0;$i<$c;$i++)
	{
		$getarr=$emps[$i];
		$explodeArr=explode("-",$getarr);
		$empid=$explodeArr[0];
		$dep=$explodeArr[1];
		$newArr[$dep][]=$empid;
	}	
	//printarray($newArr);		
	$empExists="";$empvalues="";	
	foreach($newArr as  $dep =>$employee)
	{
		//echo "dep=".$dep."   ";
		$ct=count($employee);	
		
	
		for($j=0;$j<$ct;$j++)
		{
			//echo $employee[$j].",";
			$fullnameQuery="select fullname from employee where  employeeid='".$employee[$j]."'";
			$fullnameResult=$GLOBALS['db']->query($fullnameQuery);
			$fullnameRow=$fullnameResult->fetch_assoc();			
			//check whether employee request  already exists
			$chkQuery="select * from emprequest where scheduleid='".$shid."' and employeeid='".$employee[$j]."' and (status='open' or status='closed')";			
			$chkResult=$GLOBALS['db']->query($chkQuery);
			if($chkResult->num_rows>0)
			{
				if($empExists!="") {$empExists.=",";}
				$empExists.=$fullnameRow['fullname'];
				//echo	"emp= ".$empExists;			
				//$errorMsg="Employee request for ".$empExists." already marked";
			}
			else
			{
				
				if($empvalues!="") {$empvalues.=",";}
				$empvalues.=$fullnameRow['fullname'];
				$insertQuery="insert into emprequest(scheduleid,deptid,employeeid,request,requestdate,status) 
				values('".$shid."','".$dep."','".$employee[$j]."','".$reqdetails."','".$today."','open')";
				$result=$GLOBALS['db']->query($insertQuery);
			}								
		}
		if($result>0)
		{
			if($empvalues!="")
			{
				require_once('include/class.mail.php');
				$obj=new mail();	
				//send mail  to HOD
				$getHODquery="select e.email
										from employee e,department d
										where d.departmentid='".$dep."'
										and e.employeeid=d.hod
										and e.empstatus='active'
										 ";
				$resultHOD=$GLOBALS['db']->query($getHODquery);			
				$row=$resultHOD->fetch_assoc();
				$data['to']=$row['email'];
				$userid = $_SESSION['USERID'];   
				$emp_power = emp_authority($userid);
				$data['from']=$emp_power['emp_email'];
				$data['subject']="Employee Request from ".$emp_power['emp_name'];
				$data['message']="
										<table>
										<tr><td>Employee Request Details</td></tr>
										<tr>
										<td>Schedule</td><td>:</td><td>".$schRow['description']."</td>
										</tr>
										<tr>
										<td>Department</td><td>:</td><td>".$schRow['depname']."</td>
										</tr>
										<tr>
										<td>Required employees</td><td>:</td><td>".$empvalues."</td>
										</tr>
										<tr>
										<td>Request description</td><td>:</td><td>".$reqdetails."</td>
										</tr>
										</table>			
										";
				$data['ishtml']=true;
				$value=$obj->mailsend($data);
				$msg="Employee request for ".$empvalues." has been sent.";
				//printarray($data);	
			}		
		}		
		//echo "<br/>";
	}
}
//////////////////////


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<title><?php print $company_name;?> Employee request</title>
</head>
<link href="css/reporting.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="./images/icon.gif" >
<script language="JavaScript">
function checkall()
{	
	if(document.getElementById('employeelist').value=='')
	{
		alert("Select employee");
		document.getElementById('employeelist').focus();
		return true;
	}		
	else if(document.getElementById('reqdetails').value=='')
	{
		alert("Enter request details");
		document.getElementById('reqdetails').focus();
		return true;
	}
	document.getElementById('emprequestfrm').submit();
}

</script>
<body>
<form id="emprequestfrm" name="emprequestfrm" method="post" action="emp_request.php">
<input type="hidden" name="schid" value="<?php echo $schid;?>"/>
  <table width="100%" border="0"   class="main_content_table">
    <!--<tr>
      <td>Department</td>
      <td>
	  <select name="department" id="department" onchange="javascript:changeDepart()">
	  <option value="0">Select</option>
	  <?php
	  $deplist=listdepartment($depid);
	  print $deplist;
	  ?>
      </select>	  </td>
    </tr>
    <tr>
      <td>Employee</td>
      <td>
	  <select name="employee" id="employee">
	  <option value="0">Select</option>
	  <?php
	  $emplist=listemployee($depid);
	  print $emplist;
	  ?>
      </select>	  </td>
    </tr>-->		
	<!--<tr height="30px" class="table_head">
	<td colspan="4">Employee Request</td>
	</tr>
	<tr>
	<td class="Form_txt">Choose employees:</td>
	<td>
	<select name="employeelist" id="employeelist" size="10" multiple="multiple" title="Employee list" style='width:150px;height:150px;'>
	<?php 
	//$emplist=get_all_employees();
	//print $emplist;
	 ?>
	</select>
	</td>
	<td>
		<input type="button" style="background-image:url(images/right.jpg);width:35px;height:25px;" value=">>"  title="Move right" onclick="addSelected();" />
		<br />
		<br/>
		<input type="button" style="background-image:url(images/left.jpg);width:35px;height:25px;" value="<<"  title="Move left" onclick="removeSelected();" />
	</td>
	<td>
		<select name="reqemployee[]" id="reqemployee" size="10" multiple="multiple" title="Employee request" style='width:150px;height:150px;'>
		<?php //echo $schactivity ->get_schemployee($schdepartment,$schactrow['scheduleid']); ?>
		<option></option>
		</select>
		</td>
	</tr>-->
	<tr>
	<td colspan="2"><label><?php echo $msg;?></label></td>
	</tr>
	<tr>
	<?php 
	if($empExists!="")
	{
		?>
		<td colspan="2"><label>Employee requests for  <?php echo $empExists; ?> already marked.</label></td>
		<?php
	}
	?>
	</tr>
	<tr>
	  <td colspan="2" align="left"  bgcolor="#DADADA" class="Form_txt">Employee Request</td>
    </tr>
	<tr>
	  <td class="Form_txt" align="right">&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	<td class="Form_txt" align="right">Choose employees:</td>
	<td align="left">	
	<select name="employeelist[]" id="employeelist" size="10" multiple="multiple" title="Employee list" style='width:175px;height:225px;'>
	<?php
	$empQuery="select employeeid from emprequest where scheduleid='".$schid."' and status='open'";	
	$empResult=$GLOBALS['db']->query($empQuery);
	$empRow=array();	
	
	while($rowArray=$empResult->fetch_assoc())
	{
		$empRow[]=$rowArray['employeeid'];
	}	
	$emplist=get_all_employees($depid,$empRow);
	print $emplist;
	?>
	</select>	</td>
	</tr>	
  	<tr>
  	  <td height="10" colspan="2" align="right" ></td>
    </tr>
  	<tr>
      <td class="Form_txt" align="right">Request details:</td>
      <td align="left"><textarea name="reqdetails" id="reqdetails" style='width:220px;height:60px;'></textarea></td>
    </tr>
	<tr>
  	  <td height="10" colspan="2" align="right" ></td>
    </tr>
  	
	<tr>
  	  <td height="10" colspan="2" align="right" ></td>
    </tr>
  	<tr>
  	  <td align="right">
	  <input type="button" name="send" value="send" onclick="javascript:checkall()" <?php if($flag=="1") { ?>disabled="disabled" <?php }?>/>
	  </td>
	  <td align="left"><input type="button" name="close" value="close" onclick="javascript:window.close();"/></td>
    </tr>
  </table>
</form>
</body>
</html>