<?php
require_once('include/include.php');
require_once('include/workflow_functions.php');
$emp_power=emp_authority($_SESSION['USERID']);	
if(isset($_GET['wid']))
{
	$wfid=$_GET['wid'];			
}

if(isset($_POST['btnsave']))
{	
	$wfid=$_POST['wid'];
	$desc=trim($_POST['description']);
	$subject=trim($_POST['subject']);
	$date=date('Y-m-d');
	$status=$_POST['status'];
	$commentby=$_SESSION['USERID'];
	$random_digit=rand(0,9999);
	$newfile=$HTTP_POST_FILES['newfile']['name'];	
	if($newfile!="")
	{
		$new_file_name=$random_digit.$newfile;
		$target_path1 = "workflow/".$new_file_name;
		move_uploaded_file($_FILES['newfile']['tmp_name'], $target_path1);
	}
	else
	{
		$new_file_name="";
	}

	$insertQuery="insert into workflow(subject,description,file1,newfile,parentwfid,createdby,date,wstatus)
						values('$subject','$desc','','$new_file_name','$wfid','$commentby','$date','$status')
						";
	$result=$GLOBALS['db']->query($insertQuery);		
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<title><?php print $company_name;?> - Reply Workflow</title>
<link href="css/reporting.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="./images/icon.gif" >
<script language="javascript">
function showHideDiv()
{
	divstyle = document.getElementById('div1').style.display;
	if(divstyle=="none" || divstyle == "")
	{
	   document.getElementById('div1').style.display = "block";	
	}
	else
	{
		document.getElementById('div1').style.display = "none";
	}
}
</script>
</head>

<body>
<form id="approveFrm" name="approveFrm" method="post" action="replyWorkflow.php" enctype="multipart/form-data">
<input type="hidden" name="wid"  value="<?php echo $wfid;?>"/>
<input type="hidden" name="subject"  value="<?php echo $wfRow['subject'];?>"/>
<input type="hidden" name="date"  value="<?php echo $wfRow['date'];?>"/>
<input type="hidden" name="status"  value="<?php echo $wfRow['wstatus'];?>"/>

<?php
$getWfQuery="select 
						w.*,e.fullname															
					from
						workflow as w,employee as e				
					where	
						w.createdby=e.employeeid
						and						
						(w.workflowid='".$wfid."'
						or 
						w.parentwfid='".$wfid."')			
						";
$getWfResult=$GLOBALS['db']->query($getWfQuery);	
while($wfRow=$getWfResult->fetch_assoc())
{
	?>	
	<div class="table_heading1"><?php echo $wfRow['subject'];?></div>
	<div class="table_heading1"><?php echo $wfRow['description'];?></div>
	<div class="table_heading1"><a href="workflow/<?php echo $wfRow['newfile'];?>" target="_blank"><?php echo $wfRow['newfile'];?></a></div>
	<div class="table_heading1">By &nbsp;&nbsp;<?php echo $wfRow['fullname'];?> &nbsp;&nbsp;on&nbsp;&nbsp;<?php echo ymdtodmy($wfRow['date'])?></div>
	<br/>
	<?php
}
?>

<div><label><a href="#" onclick="javascript:showHideDiv();">Add Comments</a></label></div>

<div id="div1" class="divStyle2">
<?php if($err==1) { echo "<label>Enter comments</label><br/>"; } ?>
<textarea id="description" name="description" style='width:300px;height:60px;'></textarea>
<br/>
<input type="file" name="newfile" id="newfile"/>
<br/>
<input name="btnsave" type="submit" id="btnsave" title="Post comments" value="Post"/>
</div>
</form>
</body>
</html>
