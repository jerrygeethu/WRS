<?php
require_once('include/include.php');
require_once('include/class.schactivity2.php');
require_once('include/class.mail.php');
require_once('include/parameters.php');

$schactivity = new schactivity();



if(isset($_GET['empid'])){
    $emp_id=$_GET['empid'];
}

if(isset($_GET['sid'])){
    $schid=$_GET['sid'];
}

if(isset($_GET['id']) and $_GET['id']>0) {
		$id = trim($_GET['id']);
		$schactrows = $schactivity->getschactivity($id);
		//$row1 = $rows[0];
		//$depid = $_GET['id'];
		$schid = $schactrows['scheduleid'];
		
	}

	$userid = $_SESSION['USERID'];
    $departid = $_SESSION['DEPART'];

// To store datas as a Array to insert/edit schactivity tbl Coded by hmrsqt@gmail.com 
	if(isset($_POST['activitydesc']) and $_POST['activitydesc']!='') {
	// To protect duplicat endry on refresh
	if( check_submission($_POST['activitydesc'], $_POST['employeeid'], $_POST['activitystatus'])==true){
	$activitytodate = dmyToymd($_POST['activitytodate'], $needle="/");
	$activityfromdate = dmyToymd($_POST['activityfromdate'], $needle="/");
	
	$toassignactivity = array(
		"scheduleid" => $_POST['scheduleid'] ,
		"employeeid" => $_POST['employeeid'] ,
		"activitytypeid" => $_POST['activitytypeid'] ,
		"activitydesc" => trim($_POST['activitydesc']), 
		"activityfromdate" => trim($activityfromdate) ,
		"activitytodate" => trim($activitytodate) ,
		"activitystatus" => trim($_POST['activitystatus']) ,
		"activitycomment" => trim($_POST['activitycomment']));
		
		$sch_desc=$schactivity->get_schedule_desc($toassignactivity['scheduleid']);						
		// This function calling from class.department.php to create departments
		$tablename = "schactivity";
		$result_arr=$schactivity->insertassignactivity($toassignactivity,$tablename,$_POST['editid'],$_POST['delid']);		
		if($result_arr['result']==1)
		{
			$emp_power=emp_authority($_SESSION['USERID']);
			$data['from']=trim($emp_power['emp_email']);
			$to_mail=$schactivity->get_emp_email($toassignactivity['employeeid']);
			$data['to']=array($to_mail);				
			$data['subject']="WRS::Activity Assignment";		
			$data['message']='
			<html>		
			<body>
			  <p>'.$data['subject'].'</p>
			  <table>
				<tr>
				  <td>Schedule:</td><td>'.$sch_desc.'</td>
				</tr>
				<tr>
				  <td>From:</td> <td>'.$_POST['activityfromdate'].'</td> <td>To:</td><td>'.$_POST['activitytodate'].'</td>
				</tr>
				<tr>
				  <td>Status:</td><td>'.$_POST['hd_status'].'</td>			  			 
				</tr>
				<tr>
				<td>Schedule Details:</td><td>'.$toassignactivity['activitydesc'].'</td>
				</tr>
				<tr>
				<td>Comments:</td><td>'.$toassignactivity['activitycomment'].'</td>
				</tr>
			  </table>
			</body>
			</html>';
				
			//call mail class to send activity information		
			$obj=new mail();					
			$data['ishtml']=true;
			//printarray($data);
			$value=$obj->mailsend($data);
			header("Location:assignactivity.php?empid=".$result_arr['empid']);
			exit;
		}
			
		
	}
	}
	// this function from get_emp_power.php , to get employee department
	$emp_power = emp_authority($userid);
	$emp_department = $emp_power['emp_deptid'];
 
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Prime Move Technologies (P) Ltd.</title>
<link href="css/reporting.css" rel="stylesheet" type="text/css" />
<link href="css/calendar.css" rel="StyleSheet">
<!-- to show a icon in url title icon -->
<link rel="shortcut icon" href="./images/icon.gif" >

<script language="JavaScript" src="js/calendar.js"></script>




<script type="text/javascript" language="JavaScript">
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
	function checkall() {
			
		if(document.getElementById('activitytypeid').value==0)
		{
			alert("Please Select Activity Type");
			document.getElementById('activitytypeid').focus();
			return true;
		}
		
		else if(document.getElementById('activitydesc').value=='' ){
			alert("Please Enter Activity Details");
			document.getElementById('activitydesc').focus();  
			return true;
		}
		else if(document.getElementById('activityfromdate').value!='' && document.getElementById('editid').value=='0'  ) {
			today = document.getElementById('today').value;
			fromdate = document.getElementById('activityfromdate').value;
			if(fromdate < today) {
				alert("Please Enter From date Equal or Grater than Today !!");
				displayDatePicker('activityfromdate');
				return true;
			}
		}
		var ind = document.getElementById('activitystatus').value;	
		ind = ind - 1;
		var statusvalue = document.getElementById('activitystatus').options[ind].text;	
		document.getElementById('hd_status').value = statusvalue;
		if( dateValidate('activityfromdate','activitytodate')==true ) {
			return true;
		}
			document.getElementById('frmassignactivity').submit();
	}
	
	// To confirm delete record or not
	function confirmdelete() {
		if(confirm("Are you sure to delete this record ...?")==true){
			//if(document.getElementById('editid').name == "editid"){
				document.getElementById('editid').name = "delid";
				document.getElementById('frmassignactivity').submit();
			//}
		}
	}

	
function dateValidate(dateField1,dateField2)
{
  var retVal = false;
  dateValue1 = document.getElementById(dateField1).value;
  dateValue2 = document.getElementById(dateField2).value;
     
  //var dateObj = getFieldDate(dateValue);
  var today = new Date();
  today = new Date(today.getFullYear(), today.getMonth(), today.getDate());

  if(dateValue1=='' || dateValue2=='')  {// Add one day schedule work if no date ranges selected
    
    
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
     
      if(dateObj1 > dateObj2 || dateObj1 == dateObj2 ){
         alert("To Date should be greater than From Date ");
         displayDatePicker(dateField2);
         retVal=true;
     
    }
  }
     //alert(retVal);
     return retVal;
}
function editschedule()
{
    //alert(document.getElementById('scheduleid').value);
    document.location.href="assignschwork.php?sid="+document.getElementById('scheduleid').value;
}
function changeEmployee(employee){
if(employee){
  if(confirm('Do you want to change employee')){
   document.location.href="assignactivity?empid="+employee.value+"&sid="+document.getElementById('scheduleid').value;
}else{
    return false;
}
}
}

function changeSchedule(schedule){
if(schedule){
    if(confirm('Do you want to change schedule')){
    document.location.href="assignactivity.php?empid="+document.getElementById('employeeid').value+"&sid="+schedule.value;
}else{
    return false;
}
}
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
      <td width="159" rowspan="2" align="left" valign="top" bgcolor="#9D9EA2"><table width="159" border="0" cellspacing="0" cellpadding="0">
        <?php 
        
        $menu = show_menu();
        print $menu;
      ?>  
       
      </td>
      <td width="100%" height="30" align="right" valign="top" bgcolor="#D1D1D3">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
       
       <?php 
      print get_table_link("Assign Activity","acticon.jpg");
      ?>
      </td>
    </tr>
<!-- side menu Left end	edietd by **** hmsqt@gmail.com **** -->
	<tr>
	<td align="center">
	
	 <form action="assignactivity.php" method="POST" id="frmassignactivity" name="frmassignactivity" >
			            
	  <table width="50%"  class="Tbl_Txt_bo" cellspacing="2" cellpadding="2" border="0" id="list_employees">
					
				
		<!--<tr align="left" >
		<td colspan="6" class="Date_txt" bgcolor="#D6D6D7" style="border-bottom:#666666 1px solid;">
		<a href="viewemployee.php<?php echo ($_GET['d']!='')?"?d=".$_GET['d']:""?>" ><img width="25" border="0" height="26" src="images/back_list.jpg"/></a><a href="viewemployee.php<?php echo ($_GET['d']!='')?"?d=".$_GET['d']:""?>" >Back to Employee List</a></td>
		</tr>-->
			
     	<tr>
            <td align="right" class="Form_txt">
             Employee :
            </td>
             <td colspan="4" align="left">
           <?php
           $sch = $schactivity->get_emplForAssignActvitiy(isset($schactrows['employeeid'])?$schactrows['employeeid']:$emp_id,$schid);
           print $sch;
           ?>
		  
            </td>
     	</tr>
		
		<tr>
                <td align="right" class="Form_txt">
                Select The Schedule :
                </td>
             <td align="left" colspan="4"> 
               <?php
               $sch = $schactivity->get_scheduleForActivity($emp_power,$userid,$schid,$emp_id);
               print $sch;
               ?>			 
            </td>
					
     	</tr>
		
        <tr>
            <td align="right" class="Form_txt">
            Select The Category :
            </td>
             <td colspan="4" align="left">
           <?php
           $act = $schactivity->get_activity($emp_id,$schactrows['activitytypeid']);
           print $act;
           ?>
            </td>
     	</tr>
     	<tr>
            <td align="right" class="Form_txt">
            Enter Details of the activity :
            </td>
             <td colspan="4" align="left">
         <textarea name="activitydesc" id="activitydesc" style='width:220px;height:60px;'><?php echo isset($schactrows['activitydesc'])?$schactrows['activitydesc']:'' ?></textarea>
            </td>
     	</tr>
     	<tr><td  align="right" class="Form_txt">
            <label for="validfrom" >From Date : </label></td>
				<td align="left" ><input type="hidden" id="today"  value="<?php echo date("d/m/Y");?>" />
				<input type="text"  id="activityfromdate"  name="activityfromdate" size="30px" maxlength="12" readonly="true"
				 value="<?php echo isset($schactrows['activityfromdate'])?ymdToDmy($schactrows['activityfromdate']):'' ?>" style="width: 80px;" /> 
				 <img onclick="displayDatePicker('activityfromdate');" value="select" src="images/cal.gif"/>
				 </td>
            <td align="right" class="Form_txt" ><label for="validto"  >To Date : </label></td>
				<td colspan="2" align="left" >
				<input type="text"  id="activitytodate"  name="activitytodate" size="30px" maxlength="10"  readonly="true"
				 value="<?php echo isset($schactrows['activitytodate'])?ymdToDmy($schactrows['activitytodate']):'' ?>" style="width: 80px;" /> 
				 <img onclick="displayDatePicker('activitytodate');" value="select" src="images/cal.gif"/>
           </td>
		</tr>
		
      <tr>
            <td align="right" class="Form_txt">
            Status :
            </td>
             <td colspan="4" align="left">
             <select id="activitystatus" name="activitystatus" title='Activity Status'  style='width:150px;' >
           <?php
		$status = isset($schactrows['activitystatus'])?$schactrows['activitystatus']:'';
			$schactivity->listactivitystatus($status);
          
           ?>
           </select>
		   <input type="hidden" name="hd_status"  id="hd_status" value=""/>
            </td>
     	</tr>
     	<tr>
            <td align="right" class="Form_txt">
            Enter Activity Comment :
            </td>
             <td colspan="4" align="left">
           <textarea name="activitycomment" id="activitycomment" style='width:220px;height:60px;'><?php echo isset($schactrows['activitycomment'])?$schactrows['activitycomment']:'' ?></textarea>
            </td>
     	</tr>
     	<tr>
			<td colspan="5" align="center">
			<input type="button" id="btnsave" value="Save" onclick="javascript:checkall();" />
			<!-- To delete -->
			<?php 
			if($_GET['id']!=""){
			print  "<input type=\"button\" value=\"Delete\" onclick=\"javascript:confirmdelete();\" />";
			}
			?>
			<!-- To delete -->
			<input type="reset" value="Clear" />
			<input type="hidden" name="editid" id="editid" 
			value="<?php if(isset($schactrows['schactivityid'])) echo $schactrows['schactivityid']; ?>" />
			</td>
		</tr>
		<br>
				
		 </table>
   
    </form>
    <br>
     <table class="Tbl_Txt_bo" cellspacing="0" cellpadding="0" border="0" width="80%">
        <tr>
            <td>
                <table cellspacing="0" cellpadding="0" border="0" style="border-color:#339900;" width="100%" align="center" >
           <?php if(isset($_GET['error'])){
             echo "<tr>
                  <td class=\"warn\" colspan=\"6\" align=\"center\"  >";
                  echo ($_GET['error']=='del')?"Cannot be Deleted":"";
                  echo "</td></tr>";
           } ?>
            <tr>
                  <td colspan="6" align="center" class="subhead" >List of Assigned Works</td>
            </tr>
         <tr height="20px" class="subhead" align="center" valign="middle">
                <td width="50px" class="Link_txt" > No </td>
                <td width="200px" class="Link_txt" >Employee Name</td>
             <td width="200px" class="Link_txt" >Activity type</td>
                <td width="200px" class="Link_txt" >Details </td>
                <td width="100px" class="Link_txt" >Dates from, to</td>
            <td width="100px" class="Link_txt" >Status</td>
      </tr>
            <tr>
              <td width="100%" colspan="6" align="center">
                <div width="100%" align="center" style="overflow:-moz-scrollbars-vertical;overflow-y:scroll; WIDTH: 100%; HEIGHT: 330px; ">
            <table width="100%"  border="1"  cellspacing="0" cellpadding="2" align="center"   cellpadding="1" id="data">
                                              
                    	<?php $schactivity->listschactivity($userid,$_GET['empid'],$_GET['sid']); ?>
                        
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
      <td colspan="4" align="center" valign="middle" class="Footer_txt">
	<?php echo footer();?></td>
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
