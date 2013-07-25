<?php
require_once('include/include.php');
$userid = $_SESSION['USERID']; 
if(isset($_POST['chk1']))
{	
	$chk1=$_POST['chk1'];
	$chk2=$_POST['chk2'];
	$chk3=$_POST['chk3'];
	$chk_merge=array_merge($chk1,$chk2,$chk3);	
	$chk_files=implode(",",$chk_merge);
	echo "files=".$chk_files;
	$_SESSION['file1']=$chk_files;
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<title>Untitled Document</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="wfFile.php">
  <table width="100%" border="0"   class="main_content_table">
  <tr>
	  <td colspan="2" align="left"  bgcolor="#DADADA" class="Form_txt">Select files:</td>
   </tr>
  <?php
  $fileQuery="select file1,file2,file3 from fileshare where uploadby='".$userid."' ";
  $fileResult=$GLOBALS['db']->query($fileQuery);
  while($fileRow=$fileResult->fetch_assoc())
  {
	 
	 	if($fileRow['file1'])
		{
		 ?>
		<tr>
		  <td width="50%"><?php echo $fileRow['file1'];?></td>
		  <td width="50%"><input type="checkbox" name="chk1[]"  value="<?php echo $fileRow['file1'];?>"/></td>		 
		</tr>
		<?php
		}
		if($fileRow['file2'])
		{
		?>
		<tr>
		  <td width="50%"><?php echo $fileRow['file2'];?></td>		 
		  <td width="50%"><input type="checkbox" name="chk2[]" value="<?php echo $fileRow['file2'];?>" /></td>	
		</tr>
		<?php
		}
		if($fileRow['file3'])
		{
		?>
		<tr>
		  <td width="50%"><?php echo $fileRow['file3'];?></td>	
		  <td width="50%"><input type="checkbox" name="chk3[]" value="<?php echo $fileRow['file3'];?>" /></td>		 
		</tr>		
		<?php 
		}
	}
	?>
    <tr>
      <td colspan="2"><input type="submit" name="Submit" value="Submit" /></td>
    </tr>
  </table>
</form>
</body>
</html>
