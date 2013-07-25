<?php 
require_once('include/class.department.php');
require_once('include/parameters.php');
$depid = $_SESSION['DEPART'];

$objdepartment = new department();
	//to list supervisor
	//echo $suparrid[] = 0;
	if(isset($_POST['depname']) and $_POST['depname']!='') {
		
		// This function calling from class.department.php to create departments
		$objdepartment->insertdepartment(ucwords($_POST['depname']),$_POST['depdescription'],$_POST['supervisor'],$_POST['editid'],$_POST['delid'],$_POST['hod']);
	}
	
	if(isset($_GET['id']) and $_GET['id']>0) {
		$rows = $objdepartment->getdepartment($_GET['id']);
		$row1 = $rows[0];
		$depid = $_GET['id'];
	}
	else{
		
		
		$depid ="";
	}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php print $company_name;?>-View Employee - Department</title>
<link href="css/reporting.css" rel="stylesheet" type="text/css" />
<!-- to show a icon in url title icon -->
<link rel="shortcut icon" href="./images/icon.gif" >



<script language="JavaScript" type="text/javascript"  src="js/selectbox.js"> </script>
<script  type="text/javascript" language="javascript" >
<!--
// defult js functions

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}


// // // // // // // function addSelected()
// // // // // // // 	{
// // // // // // // 			
// // // // // // // 		var i=0;
// // // // // // // 		while (i<document.frmdepartment.fldemployee.length) {
// // // // // // // 			if (document.frmdepartment.fldemployee.options[i].selected) {
// // // // // // // 				moveSelectedOptions(document.frmdepartment.fldemployee,document.frmdepartment.supervisor);
// // // // // // // 			}
// // // // // // // 			else {i++;}
// // // // // // // 		}
// // // // // // // 	}
// // // // // // // function removeSelected()
// // // // // // // 	{
// // // // // // // 		var i=0;
// // // // // // // 		while (i<document.frmdepartment.supervisor.length) {
// // // // // // // 			if (document.frmdepartment.supervisor.options[i].selected) {
// // // // // // // 				moveSelectedOptions(document.frmdepartment.supervisor,document.frmdepartment.fldemployee);
// // // // // // // 			}
// // // // // // // 			else {i++;}
// // // // // // // 		}
// // // // // // // 	}


	// To validate inputs 
	function checkall() {
		if(document.getElementById('depname').value=="") {
			alert("Please enter name of department !!");
			document.getElementById('depname').focus();
			return false;
		}
// 		if(document.getElementById('depdescription').value=="") {
// 			alert("Please enter a description !!");
// 			document.getElementById('depdescription').focus();
// 			return false;
// 		}
		//To select all Options from supervisor select box on the form submit event
// // // // // // 			var obj = document.getElementById('supervisor');
// // // // // // 			var selectlength = obj.length;
// // // // // // 			for (var i=0; i<obj.options.length; i++) {
// // // // // // 			obj.options[i].selected = true;
		////}
		document.getElementById('frmdepartment').submit();
	}
	
	// To confirm delete record or not
	function confirmdelete() {
		if(confirm("Are you sure to delete this record ...?")==true){
			//if(document.getElementById('editid').name == "editid"){
				document.getElementById('editid').name = "delid";
				document.getElementById('frmdepartment').submit();
			//}
		}
	}
	/*
	function moveright() {
		id = document.getElementById('supervisor').value;
		alert(id);
		
		supervis = document.getElementById('supervisor').item(document.getElementById('supervisor').selectedIndex).text;
		alert(supervis);
		
		document.getElementById('superviser2').options[1] = new Option('supervis', 'id');" /> 
		//document.form04.field01.options[document.form04.field01.length]=
    //new Option('Door Number 4', 'e');" />

		
	}

	*/	

function ismaxlength(obj){
    var mlength=obj.getAttribute? parseInt(obj.getAttribute("maxlength")) : ""
if (obj.getAttribute && obj.value.length>mlength)
    obj.value=obj.value.substring(0,mlength)
}
-->	
</script>
</head>
<center>
<body onload="MM_preloadImages('images/Home_Over.jpg','images/Dep_Over.jpg','images/Emp_Over.jpg','images/Sch_Over.jpg','images/Acti_Over.jpg','images/Vali_Over.jpg','images/View_Over.jpg','images/Daily_Over.jpg','images/Change_Over.jpg','images/Log_Over.jpg')">



<div id="main_div">

  <table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
<!--  Start top banner	 -->
<tr>
      <td height="101" colspan="2" align="left" valign="middle" class="Head"><img src="images/Compy_logo.jpg" alt="" width="195" height="68" /></td>
      </tr>
<!-- end top banner  -->


<!-- side menu Left start edietd by  **** hmsqt@gmail.com **** -->
    <tr>
      <td width="159" rowspan="2" align="left" valign="top">

	<?php print show_menu();?>


	</td>
      	<td width="100%" height="30" align="right" valign="top" bgcolor="#D1D1D3">

	<?php print get_table_link("Department","depicon.jpg");?>

	</td>
    </tr>
<!-- side menu Left end	edietd by **** hmsqt@gmail.com **** -->


   
  <tr >
    <td  height="580"  align="center" valign="top" >
    <form  action="editdepartment.php" method="POST" name="frmdepartment" id="frmdepartment" >
    <table class="Tbl_Txt_bo" width="50%" cellspacing="1" cellpadding="3"  border="0">
		<br><br><br>
		<tr align="left" >
		<td colspan="4" class="Date_txt" bgcolor="#D6D6D7" style="border-bottom:#666666 1px solid;">
		<a href="department.php" ><img width="25" border="0" height="26" src="images/back_list.jpg"/></a><a href="department.php" >Back to Department List</a></td>
		</tr>

		<tr><td class="menu_txt" align="right" >
			<label for="depname"> Department Name :<span class="error">*</span> </label>
			</td><td align="left" colspan="3">
			<input type="text" id="depname" maxlength="45"   onkeyup="return ismaxlength(this);" name="depname" size="20px" value="<?php if(isset($row1['depname'])) echo $row1['depname']; ?>" />
			</td></tr>
		<tr><td class="menu_txt" align="right" >
			<label for="hod"> Head Of Department  : </label>
			</td><td align="left" colspan="3">
			<select name="hod" id="hod" style="width:145px;" > 
			<?php 
			
			if($depid!=""){
			 $list_emp_dep=$objdepartment->listallemployees($depid);
			print  $list_emp_dep;
		}
		else{
			print " <option value=\"0\">Currently No Employees</option> ";
		}
			 ?>
			</select> 
			</td></tr>
		
		<tr align="center"><td class="menu_txt" align="right">
			<label for="depdescription"> Description : </label>
			</td><td align="left" colspan="3">
			<textarea id="depdescription" maxlength="255"  onkeyup="return ismaxlength(this);" name="depdescription" style="width: 180px; height: 100px;"><?php if(isset($row1['depdescription'])) echo $row1['depdescription']; ?></textarea>
			</td></tr>




<!--		<tr><td colspan="3" align="center"><label for="supervisor"> Supervisor </label></td></tr>
		<tr align="center"><td align="left">
		<select name="fldemployee" id="fldemployee" size="10" multiple="multiple">
		<?php //$objdepartment->listallemployees($_GET['id']);?>
		</select>
		</td>
		<td>
		<input type="button" style="background-image:url(images/right.jpg);width:35px;height:25px;"  title="" onclick="addSelected();" />
		<br />
		<br/>
		<input type="button" style="background-image:url(images/left.jpg);width:35px;height:25px;"  title="" onclick="removeSelected();" />
		</td>
		<td align="left">
		<select name="supervisor[]" id="supervisor" size="10" multiple="multiple">
		<?php //$objdepartment->listallemployees($row1['employeeid']);
// 		if(isset($rows[1]) and $rows[1]!='') {
// 		$i=0;
// 		foreach($rows[1] as $key=>$val){
		//print( "".$rows[1][$key]."\n");
		//print( "".$val."\n");
// 		echo "<option value=\"" . $key . "\"";
// 		if($row['employeeid']==$id[$i]) echo " selected=\"selected\"";
// 		echo ">" . $val . "</option>";
// 		$suparrid[$i] .= $key;
// 		$i++;
// 		}
// 		}
		?>
		</select>
		</td>
		</tr>
		<?php /*if(isset($rows[1]) and $rows[1]!=0){ */?> 
		<tr><td><textarea id="super" name="super" rows="10" cols="31" readonly="readonly">-->
		<?php 
// 			if(isset($rows[1]) and $rows[1]!='') {
// 				foreach($rows[1] as $key=>$val){
// 					print( "".$rows[1][$key]."\n");
// 					print( "".$key."\n");
// 					}
// 				}
// 				 ?><!--</textarea>-->
		<!--</td></tr>		-->	<?php/* } else { */
// 				if(isset($_GET['id']) and $_GET['id']>0) { ?>
			<!--<tr><td colspan="3" align="center" class="error"> No supervisor assigned.....! </td></tr>-->			<?php/* } }*/?>

			<tr><td align="right" colspan="1">
			<input type="button" onclick="checkall()" value="Save" />
			<input type="hidden" id="editid" name="editid" value="<?php echo $row1['departmentid']?>" />
			</td>
			<td align="left" colspan="2">
			<?php 
			if($depid!=""){
			print  "<input type=\"button\" value=\"Delete\" onclick=\"javascript:confirmdelete();\" />";
			}
			?>
			<input type="reset" value="Cancel" /></td>
			</tr>
		
	</table>
    </form> 
        </td>
</tr>
</td>
</tr>
<!-- start footer coded by *** hmrsqt@gmail.com *** -->
   <tr>
      <td colspan="4" align="center" valign="middle" class="Footer_txt">
	<?php echo footer();?></td>
   </tr>
<!-- end footer coded by *** hmrsqt@gmail.com *** -->
</table>
</div>
</body>
</center>
</html>
