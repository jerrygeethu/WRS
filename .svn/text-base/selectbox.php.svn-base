<?php
require_once('include/include.php'); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<title>Untitled Document</title>
</head>
<script language="JavaScript" type="text/javascript"  src="js/selectbox.js"> </script>
<script language="javascript">
//add selected values to 		
function addSelected()
{	
	var i=0;
	while (i<document.form1.fldemployee.length)
	 {		
		if (document.form1.fldemployee.options[i].selected) 
		{								
			moveSelectedOptions(document.form1.fldemployee,document.form1.schemployee);
		}
		else {i++;}
	}
	
	copyAllOptions(document.form1.schemployee,document.form1.employeeid);
}
function removeSelected()
{
	var i=0;
	while (i<document.form1.schemployee.length) {
		if (document.form1.schemployee.options[i].selected) {
			moveSelectedOptions(document.form1.schemployee,document.form1.fldemployee);
			
		}
		else {i++;}
	}
	removeAllOptions(document.form1.employeeid);
	copyAllOptions(document.form1.schemployee,document.form1.employeeid);
}		
</script>
<body>
<form id="form1" name="form1" method="post" action="selectbox.php">
  <table width="200" border="1">
    <tr>
				<td align="right" class="Form_txt">Choose Employees :</td>
				<td  align="left">
				<select name="fldemployee" id="fldemployee" size="10" multiple="multiple" title="Employee list" style='width:150px;height:80px;'>
				<optgroup label="employee">
				<option value="1">ima</option>
				<option value="2">geethu</option>
				<option value="3">smitha</option>
				<option value="4">mahi</option>
				<option value="5">anju</option>
				</optgroup>
				</select>
				</td>
				<td>
				<input type="button"  value=">>"  title="Move right" onclick="addSelected();"/>
				<br />
				<br/>
				<input type="button"  value="<<"  title="Move left" onclick="removeSelected();"/>
				</td>
				<td align="left" >
				<select name="schemployee[]" id="schemployee" size="10" multiple="multiple" title="Scheduled employee list" style='width:150px;height:80px;'>
				
				</select>
				</td>
			</tr>			
	<tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>
