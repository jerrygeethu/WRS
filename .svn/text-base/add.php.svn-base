<?php require_once('include/include.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<title>Untitled Document</title>
<script language="JavaScript" src="js/callAjax.js" type="text/javascript"></script>
</head>
<script language="javascript">
function addDept()
{
	dept=document.getElementById('dept').value;
	hod=document.getElementById('hod').value;
	desc=document.getElementById('desc').value;
	
	url="new.php?flag=1&dep="+dept+"&hod="+hod+"&desc="+desc;
	id="result";
	fnShowData(url,id,'0',true);
}
</script>
<body>
  <div id="result">
  </div>
  <table width="200" border="1">
    <tr>
      <td>Department</td>
      <td><input type="text" name="dept"  id="dept"/></td>
    </tr>
    <tr>
      <td>Hod</td>
      <td><input type="text" name="hod" id="hod"/></td>
    </tr>
	<tr>
      <td>Description</td>
      <td><input type="text" name="desc" id="desc"/></td>
    </tr>
    <tr>
      <td colspan="2"><input type="button" name="Submit" value="Submit" onclick="javascript:addDept();"/></td>
    </tr>
  </table>

</body>
</html>
