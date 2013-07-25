<?php 
require_once('include/include.php');
$_SESSION['SEL_LINK']="LVE";
require_once('include/parameters.php');
require_once('include/leave_functions.php');
require_once('include/leave_eligibility.php');  
 
if(isset($_GET['emp']) && $_GET['emp']!='')
{
	$emp_id=intval($_GET['emp']); 
    $employees['list']=$emp_id;
}
else if((isset($_POST['save']))&&($_POST['save']!=""))
{
	$emp_id=	$_POST['employeeid'];
}
else
{ 
	$emp_id=$_SESSION['USERID']; 
}



if(isset($_GET['d']) && $_GET['d']!='')
{
	$departSelected = intval($_GET['d']);
	$dep['list']=$departSelected;
}
else if((isset($_POST['save']))&&($_POST['save']!=""))
{
	$departSelected=	$_POST['departmentid'];
}
else
{  
$departSelected=	$emp_power['emp_deptid'];
}

 
$dep=getDepartmentList($emp_power,$departSelected); 
$employees=employeelist($emp_power,$departSelected,$emp_id);   
$emp_id=$employees['employeeid'];
 
if(isset($_GET['d']) && $_GET['d']!='')
{ 
    $dep['list']=$departSelected;
}

if(isset($_GET['emp']) && $_GET['emp']!='')
{ 
    $employees['list']=$emp_id;
}


//$leaves=get_eligibitlity($emp_id);
//print_r($leaves);
//$leave_type=leave_type($leavetypeid,$leaves,$emp_id);
$timestamp=strftime("%Y-%m-%d %H:%M:%S %Y");
$today=strftime("%Y-%m-%d 23:59:59", strtotime($timestamp));
$leave_type=leave_type($leavetypeid,$emp_id,$today);
$aid=$leaveapplicationid;



if((isset($_GET['s']))&&($_GET['s']!="")){
$start=intval($_GET['s']);
}
else if((isset($_POST['s']))&&($_POST['s']!="")){
$start=intval($_POST['s']);
}
else{
	$start=0;
}
if($start<0)$start=0;
$no_of_rows=5;
$pre=$start-$no_of_rows;
$next=$start+$no_of_rows;

$data=get_leave_details($start,$no_of_rows,$aid,$dep['list'],$employees['list'],$departSelected,$emp_id);
 
$timestamp=strftime("%Y-%m-%d");
$today=strftime("%d/%m/%Y", strtotime($timestamp));
if($fromoption=="full"){
	$ffull= " selected=\"selected\" ";
	$fsecond= "";
	$ffirst= "";
	
}
else if($fromoption=="first"){
	$ffirst= " selected=\"selected\" ";
	$fsecond= "";
	$ffull= "";
	
}
else if($fromoption=="second"){
	
	$fsecond= " selected=\"selected\" ";
	$ffirst= "";
	$ffull= "";
	
}
else if($fromoption==""){
$ffull= " selected=\"selected\" ";
	$fsecond= "";
	$ffirst= "";
}
if($tooption=="full"){
$tfull= " selected=\"selected\" ";
$tfirst= "";

}
else if($tooption=="first"){
	$tfirst= " selected=\"selected\" ";
$tfull= "";
	}
else if($tooption==""){
$tfull= " selected=\"selected\" ";
$tfirst= "";
	}
	
	//print "FFull".$tfull."  ==FFRST  ".$ffirst."  ==FSC  ".$fsecond."  == TFULL ".$tfull."  == TFST ".$tfirst;
$perDrop=getPermissionDrop($duration);


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php print $company_name;?>-Home </title>
<link href="css/reporting.css" rel="stylesheet" type="text/css" />
<!-- to show a icon in url title icon -->
<link rel="shortcut icon" href="./images/icon.gif" >

<link href="css/calendar.css" rel="StyleSheet">
<link href="css/style.css" rel="StyleSheet">
<script language="JavaScript" src="js/validate.js" type="text/javascript"></script>

<script type="text/JavaScript">
<!--
<?php 

// echo 'var n = new array("', join($leaves,'","'), '");'; 
?>
var mindays_toaply=<?php print getsettings('applyleavegap'); ?> * 1;
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
//-->
function changeDepart()
{
	if(document.getElementById('departmentid').value!=null)
	document.location.href="applyleave.php?d="+document.getElementById('departmentid').value;
}
function changeEmp()
{
	if(document.getElementById('employeeid').value!=null)
	document.location.href="applyleave.php?emp="+document.getElementById('employeeid').value+"&d="+document.getElementById('departmentid').value;
}
</script>
<script language="JavaScript" src="js/calendar.js"></script>
<script language="JavaScript" src="js/effects.js"></script>
</head>
<center>
<body onload="MM_preloadImages('images/Home_Over.jpg','images/Dep_Over.jpg','images/Emp_Over.jpg','images/Sch_Over.jpg','images/Acti_Over.jpg','images/Vali_Over.jpg','images/View_Over.jpg','images/Daily_Over.jpg','images/Change_Over.jpg','images/Log_Over.jpg')">
<div id="main_div">
  <form name="leave_form" id="leave_form" action="applyleave.php" method="post" onsubmit="return validate();">
  <table width="100%" border="0" cellspacing="1" cellpadding="0" summary="">
    <tr>
      <td height="101" colspan="2" align="left" valign="middle" class="Head"   ><img src="images/Compy_logo.jpg" alt="" width="195" height="68" /></td>
      </tr>
    <tr>
      <td width="159" rowspan="2" align="left" valign="top" class="menu_back">
      <?php 
      $menu=show_menu();
      print $menu;
	  ?>
      </td>
      <td width="100%" height="30px" align="left" valign="top"  class="head_with_back_button"><?php  print get_table_link("Apply Leave","apply_lvicon.gif");?>      </td>
    </tr> 
    <tr >
      <td  valign="top" class="back_td">
      <table width="50%" height="20px" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td>Select Department</td>
		  <td>
		  <select id="departmentid" name="departmentid" title='Select Department' style="width:184px"  onChange="javascript:changeDepart();">
			<!--<option value="0">Select</option>-->
			<?php
			print $dep['dept_option'];
			?>
			</select>
          </td>
          <td>Employee</td>
		  <td>
		  <select name='employeeid'  id='employeeid' title='Select Employee'  style='width:150px;' onChange="javascript:changeEmp();">
		<!--	<option value="0">Select</option>-->
			<?php
			print $employees['options'];			
			?>
			</select>
		  </td>
		  
        </tr>
      </table><br/> 
      
        <div class="leave_table"  valign="top" height="100%">
      	<table width="99%" height="100%" class="leave_table"  border="0" cellspacing="1" cellpadding="1">
          <tr>
              <td width="400px" valign="top">
                <?php 
        if($emp_id!=""){
        ?>
              <!--<form name="leave_form" id="leave_form" action="applyleave.php" method="post" onsubmit="return validate();">-->
              <table  border="0" class="leave_apply">
			  
              <tr>
              <td colspan="2" align="center" ><h3>
              Leave Application Form<?php 
                if($employees['selected']!=""){
                	print " for ".$employees['selected'];
								}
                
                ?>
              </h3>
			<!--  Hold employee id as hidden for cancel leave-->
			  <input type="hidden" name="eid" id="eid" value="<?php echo $emp_id;?>"/>
              </td>
              </tr>
                <tr>
              <td colspan="2" id="validate" name="validate"><?php 
              print $message;
              ?></td>
              </tr>
              <tr>
              <td  nowrap align="left"  >Type of leave
              </td><td nowrap align="left" >
              <select id="leave_type" name="leave_type" onChange="javascript:checkType2(this.value);" <?php echo $disabled;?>>
			  <?php print $leave_type;?>              
              </select>
              
             
              </td></tr>
              <tr id="moreThan1Day" name="moreThan1Day">
              <td nowrap align="left" >More than 1 day ..?</td><td nowrap align="left" >
   <input type="checkbox" name="moredays" id="moredays" value="more" onClick="javascript:loadto('tofield');" > 
              </td>
              </tr>
                  <tr>
                      <td   nowrap align="left" >
                      Date : 
                      </td><td nowrap align="left" >
                      <input type="text"   id="from_date" name="from_date"  onFocus="javascript:count_days('from_date','to_date','days_count');"   maxlength="12"  value="<?php print $fromdate;?>"  readonly="true" class="date_text"/>
   <img onclick="displayDatePicker('from_date');" value="select" src="<?php print $_SESSION['FOLDER'];?>/cal.gif" title="Calender"/> 
   <select class="leave_select" id="from_date_options" name="from_date_options"  onChange="javascript:count_days('from_date','to_date','days_count');" >
   <option  <?php print $ffull;?>  value="full">Full day</option>
   <option  <?php print $ffirst;?> value="first">First Half</option>
   <option  <?php print $fsecond;?> value="second">Second Half</option>
   </select>

               </td>
                  </tr>
                  <tr  id="tofield"  name="tofield" style="display:none;">
                  
                <td  nowrap align="left" >
                      To :</td><td nowrap align="left" >
<input type="text"   id="to_date" name="to_date" maxlength="12"  value="<?php print $todate;?>"  readonly="true" class="date_text" onFocus="javascript:count_days('from_date','to_date','days_count');" />
   <img onclick="displayDatePicker('to_date');" value="select" src="<?php print $_SESSION['FOLDER'];?>/cal.gif" title="Calender"/> 
   <select  class="leave_select" id="to_date_options" name="to_date_options"  onChange="javascript:count_days('from_date','to_date','days_count');" >
   <option <?php print $tfull;?> value="full">Full day</option>
   <option <?php print $tfirst;?>  value="first">First Half</option>
   </select>
   <input type="text"  class="date_text1" value="<?php print $leavedays;?>" name="days_count" id="days_count"   />
   
   <?php
   	$permissionID=getsettings('permissionid');
   ?>
   <input type="hidden" value="<?php print $permissionID;?>" name="permissionID" id="permissionID"   />
   <input type="hidden" value="<?php print $today;?>" name="today" id="today"   />
   <input type="hidden" value="<?php print $leaveapplicationid;?>" name="leaveapplicationid" id="leaveapplicationid"   />
   <input type="hidden" value="<?php print $start;?>" name="s" id="s"   />
   <!--<input type="hidden" value="<?php print $leaves['leaveArray'];?>" name="leavebalance" id="leavebalance"   />-->
   
   
   Days
                      </td>
                  </tr>
                  
                   <tr  id="durationField"  name="durationField" style="display:none;">
                  
                <td  nowrap align="left" >
                       Time :</td>

                       <td nowrap align="left" >
                       <select name="duration" id="duration" style="width:85px;">
					   <?php
					   	$start1 = strtotime('9:00am');
						$end = strtotime('5:00pm');
						for ($i = $start1; $i <= $end; $i += 1800)
						{   
					    ?>
					   <option value="<?php echo date('h:i:s', $i);?>" 
					   <?php if($fromtime==date('h:i:s', $i)) {?>  selected="selected" <?php }?>					 
					   >					   
					   <?php echo date('g:i a', $i);?></option>
					   <?php
					   	}
					    ?>
					   </select>
<!--<INPUT type="text" maxlength="8" class="date_field" style="width:65px;" value="<?php //print $fromtime;?>"  title="hh:mm:ss" onBlur="Time_Validate(this,this.value);"   onKeyup="Time_Format(this,this.value);" id="duration" name="duration">-->

                       <select id="durationDrop" name="durationDrop"  style="width:100px;" >
                       <option value="0">Duration</option>
                     <?php print $perDrop; ?>
                       </select>
                       
                       
                      </td>
                  </tr>
                  <tr>
                  <td nowrap align="left" >
                  Reason
                  </td>
                  <td nowrap align="left" >
                  <textarea class="leave_text" id="reason" name="reason"><?php print $employeeremarks;?></textarea>
                  </td>
                  </tr>
                  <tr><td colspan="2"  nowrap align="center" >
                  <input type="submit" value="<?php 
                 if((isset($_GET['aid']))&&($_GET['aid']!=""))
				 {				 
					print "Update";					
				 }
				 else
				 {
					print "Save";
				 }
                  ?>"  <?php
                  
                  if($sanctioned==1){
                  	print " disabled=\"true\" ";
                  print " title=\"Sanctioned leaves are not allowed to edit. \" ";
								}
                  ?> id="save" name="save"   />
				  <?php
				  //cancel button
				 if((isset($_GET['aid']))&&($_GET['aid']!="")&&($_GET['aid']!="nil"))
				  {
				  ?>
				  <input type="submit" name="cancelBtn" id="cancelBtn" value="Cancel" <?php if(($sanctioned==1)||($sanctioned==3)) print "disabled=\"true\" "?>/>
				  <?php				  
				  }
				  ?>
                  </td>
                  </tr>
                  
                  <?php 
                	if((isset($_GET['aid']))&&($_GET['aid']!="")&&($_GET['aid']!="nil"))
                {
                  ?>
                  <tr>
                  <td nowrap>
                  Applied on :
                  </td>
                  <td nowrap>
                 <?php print $entrydatetime;?>
                  </td>
                  </tr>
                  <tr>
                  <td nowrap>
                  Status :
                  </td>
                  <td nowrap>
                 <?php 
                 if($sanctioned==1)
                 print "Sanctioned";
                 else  if($sanctioned==2)
                 print "Rejected";
				 else if($sanctioned==3)
				 print "Cancelled";
                 else
                 print "Pending";
                 ?>
                  </td>
                  </tr>
                  <?php 
                 if($sanctioned>0){
                 	?>
                  <tr>
                  <td nowrap>
                  Validated By : 
                  </td>
                  <td><label>
                  <?php print $sanctionedby;?></label>
                  </td>
                  </tr>
                  <tr>
                  <td>
                  Remarks :
                  </td>
                  <td>
                  <div class="remarks">
                   <?php print $sanctionremarks;?>
                   </div>
                  </td>
                  </tr>
                  
                  <?php } ?>
                  <?php } ?> 
              </table>
              
                  <?php } ?>
              
              
              </form>
              <!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ -->
              
              </td>
              <td valign="top">
              
              <!-- ############################################### -->
			  <?php 
			  if($data['total_count']>0){
			  ?>
            <table border="1" class="leave_detials" width="98%">
                <tr>
                <th colspan="6">Applied Leave Details
                
                <?php 
                if($employees['selected']!=""){
                	print " of ".$employees['selected'];
								}
                
                ?>
                </th>
                
                </tr>
                <tr>
              <td colspan="6" align="center">Showing 
                <?php 
                $shoo=$start+1;
                print $shoo." to ".$data['last_count']." rows of data from total of ".$data['total_count']." data ( ".$data['found_rows']." data row )";
                ?></td>
                </tr>
                <tr>
                  <th>
                    Sl no:
                    </th>
                    <th>
                    Date
                    </th>
                    <th>
                    Type
                    </th>
                    <th>
                   Employee Name
                    </th>
                    <th>
                    Reason
                    </th>
                    <th>
                    Status
                    </th>
                </tr>
                <?php 
                print $data['table'];
                ?>
                <tr>
               
                <td align="left" nowrap> &nbsp;
                <?php
                if($pre>=0){
                	?>
                <a href="applyleave.php?aid=<?php print $aid;?>&s=<?php print $pre;?>&d=<?php print $departSelected;?>&emp=<?php print $emp_id;?>"   title="Go to previous set of data " ><< Pre</a>
                <?php } ?>
                </td>
                <td colspan="4" align="center">
                ***
                </td>
                <td align="right" nowrap> &nbsp;
                <?php
                //print $next."".$data['total_count'];
                if($next<$data['total_count']){
                	?>
                <a href="applyleave.php?aid=<?php print $aid;?>&s=<?php print $next;?>&d=<?php print $departSelected;?>&emp=<?php print $emp_id;?>"  title="Go to next set of data " >Next >> </a>
                <?php } ?>
                </td>
                
                </tr>
            </table>
			<?php }
			else{
				?>
				
				<h3>No Records found <?php 
                if($employees['selected']!=""){
                	print " for ".$employees['selected'];
								}
                
                ?></h3>
				<?php 
			}
			
			 ?>
              <!-- ############################################### -->
              </td>
          </tr>
      </table>
      </div>
      
      <!--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@ -->
  </td>
    </tr>
     <tr>
      <td height="30px" colspan="4" align="center" valign="middle"  class="Footer_txt"><?php footer();?></td>
    </tr>
  </table>
  <!--</form>-->
</div>
</body>
</center>
</html>
<?php
if($todate!=""){
	?>
<script type="text/JavaScript">
toid = 1;
document.getElementById('moredays').checked=true;
document.getElementById('tofield').style.display="";
</script>
	<?php 
}
if($leavetypeid==$permissionID){
?>

<script type="text/JavaScript">
	toid = 0;
document.getElementById('moredays').checked=false;
document.getElementById('moreThan1Day').style.display="none";
document.getElementById('from_date_options').style.display="none";
document.getElementById('tofield').style.display="none";
document.getElementById("to_date").value="";
document.getElementById("days_count").value="";
document.getElementById('durationField').style.display="";
</script>
<?php 
}
?>
