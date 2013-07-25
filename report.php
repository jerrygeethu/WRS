<?php 
$message="";
$data['fileSize'] = 100000;	
require_once('include/include.php');
$_SESSION['SEL_LINK']="DLR";
require_once('include/parameters.php');
if(isset($_POST['style'])){
$_SESSION['FOLDER']=$_POST['style'];
}
//this is from home page.on selecting  the date to enter daily report from home page
if(isset($_GET['home']))
{
$arr=$_GET['home'];
$arr1=explode(",",$arr);
$homeDate=$arr1[0];
$_SESSION['REP_DATE']=$homeDate;
}
//echo $_POST['timedata'];
$diff_days=0;
$data['target_path'] = getsettings('target_path_to_logFile')."/";
$days_to_edit_report=getsettings('days_to_edit_report');
if(isset($_POST['get_pre_report_date1']))
{
	$_SESSION['REP_DATE']=$_POST['get_pre_report_date1'];
}
else if(!((isset($_SESSION['REP_DATE']))&&($_SESSION['REP_DATE']!="")))
{
	/*if($homeDate!="")
	{
		$_SESSION['REP_DATE']=$homeDate;
	}
	else
	{
		
	}*/$_SESSION['REP_DATE']=date('d/m/Y');	
}
require_once('include/report_functions.php');
edit_check(); // function to set session variable "EDIT" to enable and disable edit options
if($_SESSION['EDIT']==0){
	$message="Report of ".$_SESSION['REP_DATE']." is Locked!!";
}
require_once('include/report_database_functions.php');
$new_field_id="new";
$enter_report=get_schedules($new_field_id);
$reportData=get_report_view($data);
$time_data=get_time_fields("00:00:01","00:00:02",$time,$new_field_id);
 //echo min2hms($reportData['timeWorked']);
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
<script language="JavaScript" src="js/validate.js" type="text/javascript"></script>
<link href="css/style.css" rel="StyleSheet">
<script type="text/JavaScript">
<!--

var mindays_toaply=1;
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

function clearText(field){
    if (document.getElementById(field).value==document.getElementById(field).defaultValue) {
	document.getElementById(field).value = "";
	}
  else if (document.getElementById(field).value == "") {
  document.getElementById(field).value = document.getElementById(field).defaultValue;
  }
}

function getText(field){
     if (document.getElementById(field).value == "") document.getElementById(field).value = document.getElementById(field).defaultValue;
}
//-->
</script>
<script language="JavaScript" src="js/calendar.js"></script>
<script language="JavaScript" src="js/effects.js"></script>
</head>
<center>
<body onload="MM_preloadImages('images/Home_Over.jpg','images/Dep_Over.jpg','images/Emp_Over.jpg','images/Sch_Over.jpg','images/Acti_Over.jpg','images/Vali_Over.jpg','images/View_Over.jpg','images/Daily_Over.jpg','images/Change_Over.jpg','images/Log_Over.jpg')">
<div id="main_div">
  
  <table width="100%" border="0" cellspacing="1" cellpadding="0" summary=" ">
    <tr>
      <td height="101" colspan="2" align="left" valign="middle" class="Head"><img src="images/Compy_logo.jpg" alt="" width="195" height="68" /></td>
      </tr>
    <tr>
      <td width="159" rowspan="2" align="left" valign="top" class="menu_back">
      <?php 
      $menu=show_menu();
      print $menu;
      ?>
      </td>
      <td width="100%" height="30px" valign="top"  class="head_with_back_button"><?php print get_table_link("Enter Your Daily Reports","dailyicon.jpg");?>
      </td>
    </tr>
    <tr>
      <td height="580" valign="top" class="back_td"> 
      <div class="main_section">
      <div class="table_head_date">
      <table width="98%">
          <tr>
              <td align="center" width="250px" valign="top"> 
              <form id="getreportdate" name="getreportdate" method="post" action="report.php" >
   Select date
        <input type="text"  id="get_pre_report_date1" name="get_pre_report_date1" size="30px" maxlength="12" readonly="true" value="<?php print $_SESSION['REP_DATE'];?>" style="width:85px;" class="date_field"  />
   <img onclick="displayDatePicker('get_pre_report_date1');" value="select" src="<?php print $_SESSION['FOLDER'];?>/cal.gif" title="Calender"/> 
        <input type="submit" value=" GO " class="s_bt"  name="get_pre_report" id="get_pre_report"/>
        </form>
              </td>
              <td width="50%">
              <div  class="message" id="message" name="message"><?php print $message;?></div>
              </td>
              <td  class="hoursWorked" align="right">
               <?php 
               $minsworked=$reportData['timeWorked'];
               $_SESSION['time']=$minsworked;
              if($reportData['timeWorked']!=0){
              print "You worked for about <label  class=\"hoursWorkedL\" >".min2hms($reportData['timeWorked'])."</label> Hours on ".$_SESSION['REP_DATE'];
						}
						
              
              ?>
              </td>
          </tr>
      </table>
       
      </div>
      
      <div class="table_head_date">
        <?php $edit=(($_SESSION['EDIT']==0) || ($minsworked > 1439 ))?" style=\"display:none;\" ":"  style=\"display:block;\"  ";?>
      <div class="schedule_table_div" <?php print $edit;?> >
      <form method="post" action="report.php" onSubmit="return new_report_form('<?php print $new_field_id;?>');">
      <table border="0"  width="98%"  class="schedule_table">
          <tr>
              <th class="firstTD">
            Time 
              </th>
              <th class="secondTD" >
             Select Type
              </th>
              <th class="thirdTD">
             Report Details
              </th>
              <th  class="fourthTD">
             Options
              </th>
          </tr>
          
          
          
          <tr>
									<td colspan="4"> 
														<div class="error" id="<?php print $new_field_id;?>_error" name="<?php print $new_field_id;?>_error"></div>
									</td>
          </tr>
          
          
          
          
          <tr><td nowrap valign="center" align="center"class="firstTD">
          
          <?php 
          print $time_data['table'];
     			$time_data = get_duration(0);
          print "<select id=\"".$new_field_id."_durationNEW\" name=\"".$new_field_id."_durationNEW\" class=\"time_drop\" >".$time_data."</select>";
          ?>
       
          </td>
          <td nowrap="nowrap" valign="top"  align="center"  onMouseOver="javascript:date_calculator('<?php print $new_field_id;?>_fromfiled','<?php print $new_field_id;?>_tofiled', '<?php print $new_field_id;?>_duration','error');"   class="secondTD" >
          Select Report Type<br/><select onChange="javascript:getDetails(this.value);" id="<?php print $new_field_id;?>_reporttype"  name="<?php print $new_field_id;?>_reporttype"  onFocus="javascript:date_calculator('<?php print $new_field_id;?>_fromfiled','<?php print $new_field_id;?>_tofiled', '<?php print $new_field_id;?>_duration','error');"  class="dropSelect">
          <?php print $enter_report['options'];?>
          </select><br/><br/>
          <div id="description"><?php print $enter_report['divs'];?></div>
          </td>
          
          
          
          <td nowrap="nowrap" valign="center"  align="center" class="thirdTD">
          <textarea class="schedule_textarea" onFocus="javascript:clearText('<?php print $new_field_id;?>_report');"  onBlur="javascript:getText('<?php print $new_field_id;?>_report');" id="<?php print $new_field_id;?>_report" name="<?php print $new_field_id;?>_report">Enter Your Report</textarea>
          </td>
          
          
          
	<td  valign="center"  align="center" onMouseOver="javascript:date_calculator('<?php print $new_field_id;?>_fromfiled','<?php print $new_field_id;?>_tofiled', '<?php print $new_field_id;?>_duration','error');"   class="fourthTD">
	
          <input type="hidden" name="ids_list" id="ids_list" value="<?php print $enter_report['ids'];?>" />
          <input type="hidden" name="fieldID" id="fieldID" value="<?php print $new_field_id;?>" />
          <?php $edit=($_SESSION['EDIT']==0)?" disabled=\"true\" ":" ";?>
          <div class="date">Report of <?php print $_SESSION['REP_DATE'];?></div>
	<input type="submit" value="Save" <?php print $edit;?> />
</td>
          </tr>
      </table>
      </form>
      
      </div>
      
      <!-- ######################################################### -->
      <div id="editReportsDiv" name="editReportsDiv">
      <?php 
      print $reportData['view'];
      ?>
      </div>
      
      <!-- ######################################################### -->
      
      </div>
      
      
      <!-- ######################################################### -->
      
      
      <!-- ######################################################### -->
</div>
</body>
</center>
</html>
