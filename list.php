<?php require_once('include/include.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<title>Untitled Document</title>
<script language="JavaScript" src="js/callAjax.js" type="text/javascript"></script>
</head>
<script language="javascript">
function addDept1()
{
document.location.href="add.php";
}
</script>
<body>
  <div id="result">
  </div>
  
  <table width="200" border="1">
   <tr>
      <td colspan="3"><input type="button" name="Submit" value="Add department" onclick="javascript:addDept1();"/></td>
    </tr>
    <tr>
      <td>Department</td>
	  <td>Hod</td>
	  <td>Description</td>      
    </tr>
	<?php
	$query="select * from department";
	$result=$GLOBALS['db']->query($query);	
	while($row=$result->fetch_assoc())
	{
		?>
		<tr>
		<td><?php echo $row['depname'];?></td>
		<td><?php echo $row['hod'];?></td>
		<td><?php echo $row['depdescription'];?></td>
		</tr>
		<?php
	}
	?>
  </table>

</body>
</html>
