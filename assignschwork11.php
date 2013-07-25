<?php
require_once('include/include.php');
$_SESSION['SEL_LINK']="SCH";
require_once('include/parameters.php');
require_once('include/class.schactivity.php');
$schactivity = new schactivity();
if(isset($_GET['dep']))
{
     $departid = $_GET['dep'];
}
$userid = $_SESSION['USERID'];   
$emp_power = emp_authority($userid);
//echo $emp_power['isadmin'];
//$schactivity ->getDepartmentForSch($emp_power);
//print_r($_POST['schemployee']);
if(isset($_GET['schid']) || isset($_POST['editid']))
{
   $schid=$_GET['schid']?$_GET['schid']:$_POST['editid'];  
   $schactrow  = $schactivity->getData($schid);  
}
$schdepartment=(isset($schactrow['departmentid']) && $schactrow['departmentid']!='')?$schactrow['departmentid']:$departid; 
if(isset($_POST['editid'])  AND $_POST['delid']=='')     
{
	//`scheduleid``supervisorid``description``schfromdate``schtodate``schstatus``schcomment`
	$schid = isset($schid)?$schid:null;
	$suprid = isset($_POST['employeeid'])?$_POST['employeeid']:null;
	$desc = isset($_POST['description'])?$_POST['description']:null;
	$schfrom = isset($_POST['schfromdate'])?dmyToymd($_POST['schfromdate']):null;
	$schto = isset($_POST['schtodate'])?dmyToymd($_POST['schtodate']):null;
	$schstatus = isset($_POST['schstatus'])?$_POST['schstatus']:null;
	$schcomment = isset($_POST['schcomment'])?$_POST['schcomment']:null;
	$schdepart = isset($_POST['departmentid'])?$_POST['departmentid']:null;
	$schempls = isset($_POST['schemployee'])?$_POST['schemployee']:null; 	
	$schactivity->saveSchData($schid, $suprid,$desc, $schfrom, $schto,$schstatus,$schcomment,$schdepart,$schempls);		
}
 if(isset($_POST['delid']) AND $_POST['delid']!='')
{          
	$schactivity->deleteSchData($_POST['delid']);
} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php print $company_name;?> - Activity List</title>
<link href="css/reporting.css" rel="stylesheet" type="text/css" />
<link href="css/calendar.css" rel="StyleSheet" type="text/css" />
<!-- to show a icon in url title icon -->
<link rel="shortcut icon" href="./images/icon.gif" >
<script language="JavaScript" src="js/calendar.js" type="text/JavaScript"></script>
<script language="JavaScript" type="text/javascript"  src="js/selectbox.js"> </script>
<script language="JavaScript" type="text/javascript"  src="js/validate.js"> </script>
<script language="JavaScript">
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
// To validate inputs 
function checkall()
{
	var NotMember=true;//supervisor must belog to sch employee list
	var obj = document.getElementById('schemployee');
	var selectlength = obj.length;
	for (var i=0; i<obj.options.length; i++)
	{
		obj.options[i].selected = true;//before submitting multiple list value should be selected
		//alert(obj.options[i].value);
		if(document.getElementById('employeeid').value==obj.options[i].value)
		{
			NotMember=false;
		}
	}
	if(NotMember==true)
	{
		alert("Supervisor not a Member of Schedule");
		document.getElementById('employeeid').focus();
		return true;
	}   
	//alert(document.getElementById('employeeid').value);
	if(document.getElementById('employeeid').value=='')
	{     
		alert("Please select Supervisor");
		return true;    
	}
	if(document.getElementById('description').value=='')
	{
		alert("Please enter Schedule Details");
		return true;    
	}
	if(document.getElementById('schfromdate').value!='' && document.getElementById('editid').value=='0')
	{		
		today = document.getElementById('today').value;			
		fromdate = document.getElementById('schfromdate').value;		
		if(compareDates(today,'dd/mm/yyyy',fromdate,'dd/mm/yyyy')!=true ) 		
		{
			alert("Please enter From Date equal to or greater than Today !!");
			displayDatePicker('schfromdate');
			return true;
		}
	}
	if( dateValidate('schfromdate','schtodate')==true)
	{
		return true;
	}
	document.getElementById('delid').value='';	
	document.getElementById('frmschwork').submit();
}
//Date validation		
function dateValidate(dateField1,dateField2)
{
	var retVal = false;
	dateValue1 = document.getElementById(dateField1).value;
	dateValue2 = document.getElementById(dateField2).value;	 	
	var today = new Date();
	today = new Date(today.getFullYear(), today.getMonth(), today.getDate());
	if(dateValue1=='' || dateValue2=='')
	{// Add one day schedule work if no date ranges selected
		var fromDateField = document.getElementsByName (dateField1).item(0);
		fromDateField.value = getDateString(today);     
		var toDateField = document.getElementsByName (dateField2).item(0);
		today.setTime(today.getTime() + (1 * 24 * 60 * 60 * 1000));
		toDateField.value = getDateString(today);
		retVal= false;
	}
	else
	{
		var dateObj1 = getFieldDate(dateValue1);
		var dateObj2 = getFieldDate(dateValue2);		
		if(dateObj1 > dateObj2 || dateObj1 == dateObj2 )
		{
			alert("To Date should be greater than From Date ");
			displayDatePicker(dateField2);
			retVal=true;	
		}
	}   
    return retVal;
}
//add selected values to 		
function addSelected()
{ 			
	var i=0;
	while (i<document.frmschwork.fldemployee.length)
	{
		if (document.frmschwork.fldemployee.options[i].selected)
		{
			moveSelectedOptions(document.frmschwork.fldemployee,document.frmschwork.schemployee);		
		}
		else
		{
			i++;
		}
	}
	copyAllOptions(document.frmschwork.schemployee,document.frmschwork.employeeid);
}
function removeSelected()
{
	var i=0;
	while (i<document.frmschwork.schemployee.length)
	{
		if (document.frmschwork.schemployee.options[i].selected)
		{
			moveSelectedOptions(document.frmschwork.schemployee,document.frmschwork.fldemployee);	
		}
		else
		{
			i++;
		}
	}
	removeAllOptions(document.frmschwork.employeeid);
	copyAllOptions(document.frmschwork.schemployee,document.frmschwork.employeeid);
}		
//Delete Schedules
function deleteSch()
{
	if(confirm("Are you sure to delete this record ...?")==true)
	{
		if(document.getElementById('editid').value != "")
		{
			document.getElementById('delid').value=document.getElementById('editid').value;
			document.getElementById('editid').value = "";
			document.getElementById('frmschwork').submit();
		}
	}
}
function ChangeDepart()
{    	
	document.location.href="assignschwork11.php?dep="+document.getElementById('departmentid').value;
}
/*function changeEmployee(empObj)
{    
}*/
function newWindow()
{
	window.open('job_request.php','welcome','height=500,width=500,scrollbars=yes,fullscreen=no,location=yes,status=yes');
}
</script>
</head>
<center>
<body onload="MM_preloadImages('images/Home_Over.jpg','images/Dep_Over.jpg','images/Emp_Over.jpg','images/Sch_Over.jpg','images/Acti_Over.jpg','images/Vali_Over.jpg','images/View_Over.jpg','images/Daily_Over.jpg','images/Change_Over.jpg','images/Log_Over.jpg')">
<div id="main_div">
<table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
<!--  Start top banner	edietd  by **** hmsqt@gmail.com **** -->
	<tr>
		<td height="101" colspan="2" align="left" valign="middle" class="Head">
		<img src="images/Compy_logo.jpg" alt="" width="195" height="68" />
		</td>
      </tr>
<!-- end top banner edietd by **** hmsqt@gmail.com **** -->
<!-- side menu Left start edietd by  **** hmsqt@gmail.com **** -->
    <tr>
      <td width="159" rowspan="2" align="left" valign="top" class="menu_back"><!--
			<table width="159" border="0" cellspacing="0" cellpadding="0"> 
			-->
        <?php         
        $menu = show_menu();
        print $menu;
      ?>         
    </td>
     <td width="100%" height="30"  class="head_with_back_button">
			<!--
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			-->       
       <?php 
      print get_table_link("Schedules","scheicon.jpg");
      ?>
      </td>
    </tr>
<!-- side menu Left end	edietd by **** hmsqt@gmail.com **** -->
	<tr>
	<td align="center">	
	 <form id="frmschwork" name="frmschwork" method="POST"  action="assignschwork.php"  >			            
			    <table width="60%" class="Tbl_Txt_bo"  cellspacing="1" cellpadding="2" border="0" id="list_employees">
				<tr align="left">
		        <td colspan="4" height="30px" class="table_head">
<a href="assignschwork.php?schid=0" ><img width="11" border="0" height="14" src="<?php echo $_SESSION['FOLDER'];?>add_new.jpg"/></a>&nbsp;<a href="assignschwork.php?schid=0" >Add new Schedule</a></td>
	            </tr>	
			  	<?php if(isset($_GET['ins'])) { 
					echo "<tr><td colspan=\"4\" class=\"warn\" align=\"center\" >";
					if($_GET['ins']==1) {
						echo "Schedule Added Successfully";
                    }
                    else if($_GET['ins']==0){ echo "Insert Failed";
                    } 
                    else if($_GET['ins']==2){ echo "Updated Successfully";
                    }
                    else if($_GET['ins']==3){ echo "Updated Failed";
                    }
					echo "</td></tr>";} ?>
			        
			        
			      <?php 
			      echo '<tr >
			                <td   align="right" class="Form_txt"  >
			                 Department  :
			              </td>
			             <td colspan="3" align="left">';
			            // if($emp_power['isadmin']==1 || $emp_power['is_superadmin']==1){			             
			             echo $schactivity->getDepartmentForSch($emp_power,$schdepartment);
                        // }
			            // else{
			            //  echo "<input type=\"hidden\" name=\"departmentid\" id=\"departmentid\"  value='".$departid."'  /> "; 
			            //  echo "<input type=\"text\" name=\"department\" id=\"department\" readonly=\"true\" value='".$emp_power['emp_deptname']."'  /> "; 
                     // }
			      echo '</td>
			            </tr>';  
			      ?>			     
			<!-- multiple select box -->
		<tr>
		<td align="right" class="Form_txt">
			             Choose Employees :
			            </td>
		<td  align="left" >
		<select name="fldemployee" id="fldemployee" size="10" multiple="multiple" title="Employee list" style='width:150px;height:80px;'>
		<?php echo $schactivity ->get_nonschemployee($schdepartment,$schactrow['scheduleid']); ?>
		</select>
		
		</td>
		<td  >
		<input type="button" style="background-image:url(images/right.jpg);width:35px;height:25px;" value=">>"  title="Move right" onclick="addSelected();" />
		<br />
		<br/>
		<input type="button" style="background-image:url(images/left.jpg);width:35px;height:25px;" value="<<"  title="Move left" onclick="removeSelected();" />
		</td>
		
		<td align="left" >
		<select name="schemployee[]" id="schemployee" size="10" multiple="multiple" title="Scheduled employee list" style='width:150px;height:80px;'>
		<?php echo $schactivity ->get_schemployee($schdepartment,$schactrow['scheduleid']); ?>
		</select>
		</td>
		</tr>
			
		<!-- select box-->
		 <tr>
			      		 <td width="200px" colspan="1" align="right" class="Form_txt" >
			             The Supervisor :
			            </td>
			             <td colspan="3" align="left">
				   <?php
					$supid = isset($schid)?$schactrow['supervisorid']:"";
					$departid = isset($schid)?$schactrow['departmentid']:$departid;
			        // if($_SESSION['TYPE']=='admin'){
			                    $empl = $schactivity->get_depemployee( $supid,$departid,$schactrow['scheduleid']);
			                    print $empl;
                      // } 
                      // else
                      // {
                      //     echo "<input type=\"hidden\" name=\"employeeid\" id=\"employeeid\"  value='".$supid."'  /> ";
                      //     echo "<input type=\"text\" name=\"employeename\" id=\"employeename\" readonly=\"true\" value='".$_SESSION['NAME']."'  /> ";
                      // }                       
			           ?>
			            </td>
			  </tr>		
			  <tr>
					<td  align="right" class="Form_txt">
					Enter Schedule Details :
					</td>
					 <td colspan="1">
					 <textarea id="description" name="description" style='width:220px;height:60px;'><?php echo $schactrow['description'] ?></textarea>
					</td>
					<td colspan="2" align="left"  class="Form_txt">
					<select name="jobreq[]" id="jobreq" size="10" multiple="multiple" title="Select  job request" style='width:150px;height:80px;' onchange="javascript:newWindow();">
					<option>Job Request</option>
					<?php
					$jobreq=$schactivity->get_jobreq($schid);
					print $jobreq;
					?>
					</select>
					</td>
				</tr>
				<tr>
					<td align="right" class="Form_txt">
					 <label for="schfromdate" >Valid from : </label>
					 </td>
					<td colspan="1" align="left" ><input type="hidden" id="today" name="today" value="<?php echo date("d/m/Y");?>" />
					<input type="text"  id="schfromdate"  name="schfromdate" size="30px" maxlength="12" readonly="true" 
					 value="<?php echo  isset($schid)?ymdToDmy($schactrow['schfromdate']):'Select Date' ?>" style="width: 80px;" /> 
					 <img onclick="displayDatePicker('schfromdate');" value="select" src="images/cal.gif"/>
					 </td>				
					<td align="right" class="Form_txt"  ><label for="schtodate" >Valid to : </label></td>
					<td colspan="1" align="left">
					<input type="text"  id="schtodate"  name="schtodate" size="30px" maxlength="10"  readonly="true"
					 value="<?php echo  isset($schid)?ymdToDmy($schactrow['schtodate']):'Select Date' ?>" style="width: 80px;" /> 
					 <img onclick="displayDatePicker('schtodate');" value="select" src="images/cal.gif"/>		 
					</td>
				</tr>
				<tr>
					<td align="right" class="Form_txt">
					Schedule Comment :
					</td>
					<td colspan="1" align="left">
					<textarea id="schcomment" name="schcomment" style='width:220px;height:60px;'><?php echo $schactrow['schcomment'] ?></textarea>
					</td>
					<td colspan="2">&nbsp;</td>
				</tr>
			   <tr>
					<td align="right" class="Form_txt"><label for="schstatus" >
					Status:</label>
					</td>
					<td colspan="3" align="left"><select name="schstatus" id="schstatus">
					<?php
					$status = isset($schid)?$schactrow['schstatus']:'';
					$schactivity->listschstatus('$status');
					?>
					</select>
					</td>
		 </tr>
		 <tr>
				<td colspan="4" align="center">
				<input type="button" id="btnsave" title="Save Schedule" value="Save" onclick="checkall()" />
				<?php
				if(isset($_GET['schid'])) echo "<input type=\"button\" id=\"btndel\" value=\"Delete\" onclick=\"deleteSch()\" />";
				?>
				<input type="reset" value="Clear" title="Clear Changes" />
				<input type="hidden" name="editid" id="editid" 	value="<?php echo isset($schid)?$schid:'0'; ?>" />
				<input type="hidden" name="delid" id="delid" 	value="" />							
				</td>
			</tr>
			<br>		
		 </table>   
    </form>
    <br>
     <table class="Tbl_Txt_bo" cellspacing="0" cellpadding="0" border="0" width="60%">
        <tr>
            <td width="100%">
                <table cellspacing="0" cellpadding="0" border="0" style="border-color:#339900;" width="100%" align="center" >
           <?php if(isset($_GET['error']))
		   {
             	echo "<tr>
                  <td class=\"warn\" colspan=\"6\" align=\"center\"  >";
                  echo ($_GET['error']=='del')?"Cannot be Deleted":"";
                  echo "</td></tr>";
           } ?>
           
           
            <tr width="100%">
                  <td colspan="6" height="30px" align="center" class="subhead" >Schedule List</td>
            </tr>
            
            <tr width="100%">
             <td  align="center">
               <div width="98%" align="center" style="overflow:-moz-scrollbars-vertical;overflow-y:scroll; WIDTH: 100%; HEIGHT: 330px; ">
            <table width="99%" border="1"  cellspacing="0" cellpadding="2" align="center"  id="data">
                 <tr width="100%"  >
                <th align="center"  width="50px">No:</th>
                <th align="center"  width="200px">Supervisor</th>
                <th align="center"  width="200px">Description </th>
                <th align="center"  width="210px">From-To Date</th>
                <th align="center"  width="210px">Department</th>
                <th align="center"  width="200px">Status</th>           
                 
             </tr>                       
                      <?php  $schactivity->viewschedules($userid,$emp_power,$departid); ?>
                        
                    </table>
		        </div>
		       
                </td>
            </tr>
		</table>
            </td>
        </tr>
    </table>
    
	</td>
	</tr>
<!-- start footer coded by *** hmrsqt@gmail.com *** -->
<tr>
  <td height="30" colspan="4" align="center" valign="middle" bgcolor="#D1D1D3" class="Footer_txt">
Copyright &copy; 2009 Prime Move Technologies (P) Ltd. All Rights Reserved.</td>
</tr>
<!-- end footer coded by *** hmrsqt@gmail.com *** -->
 </table>
</td>
 </tr>
</table>
</div>
</body>
</center>
</html>
