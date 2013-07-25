<?php
require_once('include/include.php');
$_SESSION['SEL_LINK']="DLR";

if(isset($_POST['style'])){
$_SESSION['FOLDER']=$_POST['style'];
}
$_SESSION['STIME']=0;
$_SESSION['MTIME']=0;

require_once('include/parameters.php');
require_once('include/schedule_functions.php');

$diff_days=0;
$days_to_edit_report=getsettings('days_to_edit_report');
if(isset($_POST['get_pre_report_date'])){
$_SESSION['date_sel_rep_entry']=$_POST['get_pre_report_date'];
}
else if(!((isset($_SESSION['date_sel_rep_entry']))&&($_SESSION['date_sel_rep_entry']!=""))){
$_SESSION['date_sel_rep_entry']=date('d/m/Y');	
}
/*
else if((isset($_SESSION['date_sel_rep_entry']))&&($_SESSION['date_sel_rep_entry']!="")){
	
}
else{
$_SESSION['date_selected']=date('Y-m-d');	
}
*/
$get_date=$_SESSION['date_sel_rep_entry'];
$date=explode('/',$get_date);
$date_format=$date[2]."-".$date[1]."-".$date[0];
$a = localtime( );
$a[4] += 1;
$a[5] += 1900;
$epoch_2 = mktime(00,00,01,$date[1],$date[0],$date[2]);
// 4:29:11 am on November 20, 1962
$epoch_1 =  mktime(00,00,01,$a[4],$a[3],$a[5]);
$diff_seconds  = $epoch_1 - $epoch_2;
$diff_days     = floor($diff_seconds/86400);
if(($diff_days<=$days_to_edit_report)&&($diff_days>=0)){
	$editable="";
}
else{
	$editable=" readonly=true ";
}


if(isset($_POST['get_pre_report_date'])){
$get_date=$_SESSION['date_sel_rep_entry'];
$date=explode('/',$get_date);
$date_format=$date[2]."-".$date[1]."-".$date[0];



$a = localtime( );
$a[4] += 1;
$a[5] += 1900;
$epoch_2 = mktime(00,00,01,$date[1],$date[0],$date[2]);
// 4:29:11 am on November 20, 1962
$epoch_1 =  mktime(00,00,01,$a[4],$a[3],$a[5]);
$diff_seconds  = $epoch_1 - $epoch_2;
$diff_days     = floor($diff_seconds/86400);
if(($diff_days<=$days_to_edit_report)&&($diff_days>=0)){
	$editable="";
}
else{
	$editable=" readonly=true ";
}

// not today 
 $enter_report_query =  " select "
																." sca.schactivityid as actid, "
																." sca.activitytypeid as type, "
																." sch.supervisorid as supid, "
																." sca.scheduleid as schid, "
																." sca.activitydesc as descr , "
																." sca.activitycomment as comment1 , "
																." sca.activitystatus as status, "
																." sch.description as schdescr "
														." from "
																." schactivity as sca, "
																." schedule as sch  "
														." where "
															."  ( sca.activitystatus = 'running' OR sca.activitystatus = 'pending') "
															." and sca.employeeid='".$_SESSION['USERID']."' "
															." and sca.activityfromdate<='".$date_format."'  "
															." and sca.activitytodate>='".$date_format."' "
															." and sca.scheduleid=sch.scheduleid ";
	          						
							          	

$select_misc_report_query = " select "
																." act.activitylogid as logid, "
																." act.activitytypeid as type, "
																." act.timespent as time, "
																." act.empactivitylog as emplog, "
																." act.loglock as loglock, "
																." act.supremarks1 as sup1 "
															." from  "
																." activitylog as act, "
																." schactivity as sact "
															." where "
																." sact.schactivityid=act.schactivityid "
																." and "
																." sact.employeeid='".$_SESSION['USERID']."' "
																." and "
																." act.logdate like '".$date_format."%' "
																." and "
																." sact.scheduleid is NULL ";
	          						
	          						
	          				
}
else{
	$get_date= " Today";
	$editable="";

	 $enter_report_query = " select "
													." sca.schactivityid as actid, "
													." sca.activitytypeid as type, "
													." sca.scheduleid as schid, "
													." sch.supervisorid as supid, "
													." sca.activitydesc as descr , "
													." sca.activitycomment as comment1 , "
													." sca.activitystatus as status, "
													." sch.description as schdescr "
							        ." from "
							            ." schactivity as sca, "
							            ." schedule as sch  "
							        ." where "
							        	."  ( sca.activitystatus = 'running' OR sca.activitystatus = 'pending') "
						  	        ." and sca.employeeid='".$_SESSION['USERID']."' "
						  	        ." and sca.activityfromdate<='".$date_format."'  "
	          						." and sca.activitytodate>='".$date_format."' "
	          						." and  sca.scheduleid=sch.scheduleid";
	          						
$select_misc_report_query = " select "
																." act.activitylogid as logid, "
																." act.activitytypeid as type, "
																." act.timespent as time, "
																." act.empactivitylog as emplog, "
																." act.loglock as loglock, "
																." act.supremarks1 as sup1 "
															." from  "
																." activitylog as act, "
																." schactivity as sact "
															." where "
																." sact.schactivityid=act.schactivityid "
																." and "
																." sact.employeeid='".$_SESSION['USERID']."' "
																." and "
																."  DATE_FORMAT( act.logdate, '%Y-%m-%d' )= '".$date_format."' "
																." and "
																." sact.scheduleid is NULL ";
																
																
							          
}

	/*

	 $enter_report_query = " select "
													." sca.schactivityid as actid, "
													." sca.activitytypeid as type, "
													." sca.scheduleid as schid, "
													." sch.supervisorid as supid, "
													." sca.activitydesc as descr , "
													." sca.activitycomment as comment1 , "
													." sca.activitystatus as status, "
													." sch.description as schdescr "
							        ." from "
							            ." schactivity as sca, "
							            ." schedule as sch  "
							        ." where "
							        	."  ( sca.activitystatus = 'running' OR sca.activitystatus = 'pending') "
						  	        ." and sca.employeeid='".$_SESSION['USERID']."' "
						  	        ." and sca.activityfromdate<='".$date_format."'  "
	          						." and sca.activitytodate>='".$date_format."' "
	          						." and  sca.scheduleid=sch.scheduleid";
	          						
$select_misc_report_query = " select "
																." act.activitylogid as logid, "
																." act.activitytypeid as type, "
																." act.timespent as time, "
																." act.empactivitylog as emplog, "
																." act.loglock as loglock, "
																." act.supremarks1 as sup1 "
															." from  "
																." activitylog as act, "
																." schactivity as sact "
															." where "
																." sact.schactivityid=act.schactivityid "
																." and "
																." sact.employeeid='".$_SESSION['USERID']."' "
																." and "
																."  DATE_FORMAT( act.logdate, '%Y-%m-%d' )= '".$date_format."' "
																." and "
																." sact.scheduleid is NULL ";
																
																
							          

*/
/*
if(isset($_POST['get_pre_report_date'])){
	$current_date=$date_format;	
}
else{
	$current_date=date('Y-m-d');	
}

$dateeee=explode('-',$current_date);
$show_date_text=$dateeee[2]."/".$dateeee[1]."/".$dateeee[0];
*/
$current_date=$date_format;
$show_date_text=$_SESSION['date_sel_rep_entry'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php print $company_name;?>-Daily Reports</title>

<link href="css/reporting.css" rel="stylesheet" type="text/css" />



<!-- to show a icon in url title icon -->
<link rel="shortcut icon" href="./images/icon.gif" >


              <!-- *************************************  -->
              <!-- *************************************  -->


              <!-- *************************************  -->
              <!-- *************************************  -->

<script language="JavaScript" src="js/callAjax.js" type="text/javascript"></script>
<link href="css/calendar.css" rel="StyleSheet">
<script language="JavaScript" src="js/calendar.js"></script>
<script type="text/JavaScript">
<!--
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
</script>
</head>
<center>
<body onload="MM_preloadImages('images/Home_Over.jpg','images/Dep_Over.jpg','images/Emp_Over.jpg','images/Sch_Over.jpg','images/Acti_Over.jpg','images/Vali_Over.jpg','images/View_Over.jpg','images/Daily_Over.jpg','images/Change_Over.jpg','images/Log_Over.jpg')">
<div id="main_div">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" summary=" ">
    <tr>
      <td height="101" colspan="2" align="left" valign="middle" class="Head"><img src="<?php print $_SESSION['FOLDER'];?>/Compy_logo.jpg" alt="" width="195" height="68" /></td>
      </tr>
    <tr>
      <td width="159" rowspan="2" align="left" valign="top"  class="menu_back">
      
        <?php 
      $menu=show_menu();
      print $menu;
      ?>      </td>
      <td width="100%" height="30" align="right" valign="top" class="head_with_back_button">
      
      <?php 
      
      print get_table_link("Enter Your Daily Reports","dailyicon.jpg");
      ?>
      
      </td>
    </tr>
    <tr>
      <td  align="left" valign="top" class="main_content_p">
              
              <table  border="0" class="main_content_table"  name="schedule" id="schedule" >
      
      <tr>
      <td align="center" valign="middle" class="table_heading">
        <label>
        <?php
        print $get_date." 's work report.<br/>";
        //if(( 
       // print "===". $diff_days ."<=". $days_to_edit_report." ==";
       //)&&($diff_days >=0)){
        
        if(($diff_days>$days_to_edit_report)&&($diff_days>=0)){
				 print "You Are Not Allowed <br/> To Alter Your Reports <br/> Of ".$days_to_edit_report." Days Back.!!"; 
				}
				
        ?>
        </label>
        </td>
        <td align="right"  colspan="4" nowrap="nowrap"  class="table_head_date"/>
   <form id="getreportdate" name="getreportdate" method="post" action="schedule.php" >
   Select date to view / edit your reports
        <input type="text"  id="get_pre_report_date" name="get_pre_report_date" size="30px" maxlength="12" readonly="true" value="<?php print $show_date_text;?>" style="width:75px;" />
   <img onclick="displayDatePicker('get_pre_report_date');" value="select" src="<?php print $_SESSION['FOLDER'];?>/cal.gif" title="Calender"/> 
        <input type="button" onClick="javascript:check_date();" value=" GO " class="s_bt"  name="get_pre_report" id="get_pre_report"/>
        </form>
        </td>
      </tr>
      <tr><td colspan="5" class="table_heading" > Scheduled Work Report </td></tr>
     <tr>
        <th   >Scheduled Work </th>
        <th  >Enter Your Report</th>
        <th  >Total Time spent</th>
        <th   >Report Comments</th>
      </tr>
      
      		<!--
////////////////////////////////////////////////////////////////////
//////////// This is the case to edit daily report /////////////////
////////// when he / she  has entered report as  ///////////////////
//////////////////////scheduled work ///////////////////////////////
////////////////////////////////////////////////////////////////////
-->
      
      <?php 
            
							
			$result = $GLOBALS['db']->query($enter_report_query);
			$act_log="";
			$num_c=0;
				if(isset($result) and $result->num_rows>0) {
					while($row = $result->fetch_assoc()) {
      $num_c++;
      if(($num_c%2)<1) $class=" class=\"even\" ";else  $class=" class=\"odd\" ";
      		$act_id=$row['actid'];
      		$sch_desc=ucwords($row['descr']);
      		$sch_supid=$row['supid'];// supervisor id
      		$act_type=$row['type'];
      		$act_schid=$row['schid'];
     			$act_comment=ucwords($row['comment1']);
     			$status=ucwords($row['status']);
     			$schdescr=ucwords($row['schdescr']);
												$query_log=" select 
																														al.activitylogid, 
																														al.timespent, 
																														al.empactivitylog, 
																														al.loglock, 
																														al.supremarks1 as com_emp 
																								from 
																													 activitylog as al
																								where 
																													 al.schactivityid='".$act_id."' and 
																													 al.logdate like '".$current_date."%' ";
										$result_2 = $GLOBALS['db']->query($query_log);
										$row_2 = $result_2->fetch_assoc();
										$logid=$row_2['activitylogid'];
										$act_log=ucwords($row_2['empactivitylog']);
										$time_spent=$row_2['timespent'];
										$_SESSION['STIME']=$_SESSION['STIME']+$time_spent;
										$com_emp=$row_2['com_emp'];
										$loglock=$row_2['loglock'];
	
				$sup_name_query=" select fullname from employee where employeeid='".$sch_supid."' ";
				$result_name_query = $GLOBALS['db']->query($sup_name_query);
				$row_name_query = $result_name_query->fetch_assoc();
				$super_name=$row_name_query['fullname'];
				$super_name=ucwords($super_name);
      ?>
      <tr <?php print $class; ?> >
        <td align="center" valign="middle" id="three"  >
         <div >
         <?php 
         if($act_schid=='0'){
         $activity=get_activity($act_id."-activity_detail",$act_type);
      print $activity;
		}
				else{
					?>
         <textarea id="<?php print $act_id;?>-schwork" name="sch_work" class="text_area" onChange="javascript:textarea_alert('<?php print $act_id;?>-schwork');"><?php 
         print "Status: ".$status."\nAssigned By: ".$super_name."\nSchedule: ".$schdescr."\nDescription: ";
         print $sch_desc;
         ?></textarea>
         <?php } ?></div></td>
         
         
       <td align="center" valign="middle"
        class="main_matter_txt" title=" Your Work Report"
        id="<?php print $act_id;?>_td_1"><?php 
        if((isset($act_log))&&($act_log!="")){
        	 print "Edit Your Report Here <br/>";
        	$textarea_chek="<TEXTAREA name=\"".$act_id."-report\" id=\"".$act_id."-report\" ".$editable." ";
        	
        	if(($loglock==0)&&($editable=="")){
	$textarea_chek.= " onkeyup=\"javascript:get_update('".$act_id."',1);\" ";
	}
	
        	$textarea_chek.= "  >".$act_log."</TEXTAREA>";
				print $textarea_chek;
				if(($loglock==1)||($editable!="")){
print " <br> <div style=\"color:red;\" title=\"Report is locked by HOD or Supervisor after validating your report\">Report Locked </div>";
	}
				}
				else{
					
					if(($diff_days <= $days_to_edit_report)&&($diff_days >=0)){
						 print "Enter Your Report Here <br/>";
					?>
					
					
					<textarea  
					<?php if(($loglock==0)&&($editable=="")){?>
					onkeyup="javascript:get_update1('<?php print $act_id;?>',0);"  
				<?php }?>
					id="<?php print $act_id;?>-report"  name="<?php print $act_id;?>-report" ></textarea>
				<?php 
				}
				else{
					print "<div> You Are Not Allowed To Enter Your report for ".ymdtodmy($current_date)."</div>";
				}
			}
				?>
				
        </td>
        <td align="center" valign="middle" id="four"><div >
        <?php 
         print "Time Spent <br/>";
if(($act_log!="")&&($loglock==0)&&($editable=="")&&($diff_days <= $days_to_edit_report)&&($diff_days >=0)){
$en=1;}else{$en=0;}
         //print $en;
    		 $time=get_time($act_id."-time_worked",$time_spent,$en);
      		print $time."<br>";
      if($act_schid!='0'){
      	print "Activity Type <br/>";
      $activity=get_activity_2($act_id."-activity_detail",$act_type," disabled='true' ");
      print $activity;
		}
      ?>
        </div>
				<br/>
				<input type="hidden" value="hallo+<?php print $logid;?>" name="<?php print $act_id;?>-log_id_exist" id="<?php print $act_id;?>-log_id_exist" />
         <input type="hidden" value="<?php print $current_date;?>" name="current_date" id="current_date" />
         <div id="<?php print $act_id;?>-result"  class="result_set" ></div>
        <div id="<?php print $act_id;?>-update"><?php 
         
         if($en==1){
         	print "<input type=\"button\" name=\"".$act_id."del_button\" id=\"".$act_id."del_button\" value=\"Delete\" class=\"s_bt\" onClick=\"javascript:delete_report('".$act_id."');\" title=\"Click here to Delete Report\"/>";
				}
         
         ?></div>
        </td>
         <td align="center" valign="middle" ><label>
         <?php if($com_emp!=""){?><textarea name="textfield" readonly="true"><?php 
           
           print $com_emp."</textarea>";}else{ print "No Comments";}?>
         </label></td>
      </tr>
      <?php 
        
					}
				}
				else{?>
					<tr align="center">
					<td colspan="5" class="warn">
					You Have No Assigned Work For This Day !!
					</td>
					</tr>
					
					
					
					
				<?php }?>
				 <tr>
				 <td  colspan="5" align="right"  id="time_message">Spent :
      <?php $tt=round($_SESSION['STIME']/60,2);
      print $tt." Hrs ";
      ?> For Scheduled Work
      </td></tr>
			<tr><th colspan="5" >***</th></tr>
			<tr><td colspan="5" class="table_heading" >Non-Scheduled Reports</td></tr>
			
			<!--
////////////////////////////////////////////////////////////////////
//////////// This is the case to edit daily report /////////////////
////////// when he / she  has entered as misc work /////////////////
////////////////////////////////////////////////////////////////////
-->
<tr>
        <th  >Work Type</th>
        <th >Enter Your Report</th>
        <th  >Total Time spent</th>
        <th  >Report Comments</th>
      </tr>
<?php 
//print $select_misc_report_query;
				
				$result_200 = $GLOBALS['db']->query($select_misc_report_query);
			$act_log="";
				if(isset($result_200) and $result_200->num_rows>0) {
					while($row_misc = $result_200->fetch_assoc()) {
 $num_c++;
      if(($num_c%2)<1) $class=" class=\"even\" ";else  $class=" class=\"odd\" ";
$logid=$row_misc['logid'];
$act_id=$logid;
$act_id1=$row_misc['type'];
$time=$row_misc['time'];
$_SESSION['MTIME']=$_SESSION['MTIME']+$time;
$emplog=ucwords($row_misc['emplog']);
$sup1=$row_misc['sup1'];
$loglock=$row_misc['loglock'];

print "
<tr ".$class.">
        <td align=\"center\" valign=\"middle\" id=\"three\"   >
         <div >";
         print "Activity type <br/>";
         $activity=get_activity($act_id."-activity_detail",$act_id1);
      print $activity;
print <<<HTML
		</div></td>
       <td align="center" valign="middle" 
HTML;
?>
        id="<?php print $act_id;?>_td_1">
        <?php 
         print "Edit Your Report Here <br/>";
        $text_1111="<TEXTAREA name=\"".$act_id."-report\" id=\"".$act_id."-report\" ".$editable." ";
if(($loglock==0)&&($editable=="")){
	$text_1111.=" onkeyup=\"javascript:get_update('".$act_id."');\" ";
}
        
        $text_1111.="  >".$emplog."</TEXTAREA>";
        
        
        
				print $text_1111;
				if(($loglock==1)||($editable!="")){
	print " <br><div style=\"color:red;\"> Report Locked </div>";
}
				?>
				
        </td>
        <td align="center" valign="middle" id="four" 
         class="main_matter_txt"><div >
        <?php 
        if(($emplog!="")&&($loglock==0)&&($editable=="")&&($diff_days <= $days_to_edit_report)&&($diff_days >=0)){
        	$en=1;
        	}
        	else{
        		 $en=0;
					 }
         print "Time Spent <br/>";
         //print $time;
     $time=get_time($act_id."-time_worked",$time,$en);
      print $time;
      ?>
        </div><br/><br/>
				<input type="hidden" value="<?php print $current_date;?>" name="current_date" id="current_date" />
        <input type="hidden" value="hallo+<?php
         print $logid;
         ?>" name="<?php print $act_id;?>-log_id_exist" id="<?php print $act_id;?>-log_id_exist" />
        <div id="<?php print $act_id;?>-result"  class="result_set" ></div>
        <div id="<?php print $act_id;?>-update"><?php 
        
        if($en==1){
        print "<input type=\"button\" name=\"".$act_id."del_button\" id=\"".$act_id."del_button\" value=\"Delete\" class=\"s_bt\" onClick=\"javascript:delete_report('".$act_id."');\" title=\"Click here to Delete Report\"/>";
			}
        
        ?></div>
				</td>
         <td align="center" valign="middle" ><label>
         <?php if($sup1!=""){?>
           <textarea name="textfield" class="text_area" readonly="true"><?php 
           print $sup1."</textarea>";}else{ print " No Comments";}?>
         </label></td>
      </tr>
		<?php 
}
}
?>
<tr>
				 <td  colspan="5" align="right"  id="time_message">Spent :
      <?php $tt=round($_SESSION['MTIME']/60,2);
      print $tt." Hrs ";
      ?> For Non-Scheduled Works
      </td>
      </tr>
<tr>
				 <td  colspan="5" align="right" id="time_message">Total Time Worked :
      <?php 
      
$_SESSION['TTIME']=$_SESSION['MTIME']+$_SESSION['STIME'];
$tt=round($_SESSION['TTIME']/60,2);
      print $tt." Hrs ";
      ?> 
      </td>
      </tr>
<!--
////////////////////////////////////////////////////////////////////
//////////// This is the case to insert daily report ///////////////
////////// when he / she is not assigned with any work /////////////
////////////////////////////////////////////////////////////////////
-->
<?php
      $count_misc=500;
      $report_id="NEW".$count_misc;
      $send="NEW";
      //$report_id="NEW";
      $act_id=$report_id;
      //print " === ".$diff_days." === ".$days_to_edit_report." === ";
if(($diff_days<=$days_to_edit_report)&&($diff_days>=0)){
	$num_c++;
      if(($num_c%2)<1) $class=" class=\"even\" ";else  $class=" class=\"odd\" ";
      ?>
      <tr><th colspan="5" >***</th></tr>
      <tr><td colspan="5" class="table_heading" >Add New Report</td></tr>
      <tr <?php print $class; ?> >
        <td align="center" valign="middle" id="three" >
         <div >
      <?php 
      print "Activity type <br/>";
      $activity=get_activity($act_id."-activity_detail",$act_id);
      print $activity;
      ?>
        </div></td>
       <td align="center" valign="middle" 
        id="<?php print $act_id;?>_td_1" name="<?php print $act_id;?>_td_1">
        
        
         <?php print "Enter Your Non-Scheduled Report Here<br/>";?>
					<textarea id="<?php print $act_id;?>-report"   onkeyup="javascript:get_update('<?php print $act_id;?>');"  name="<?php print $act_id;?>-report" ></textarea>
					
					
        </td>
        <td align="center" valign="middle" id="four"  ><div >
        <?php 
        print "Time Spent <br/>";
     $time=get_time($act_id."-time_worked","0","0");
      print $time;
      ?>
        </div>
        
        </td>
         <td align="center" valign="middle"  id="<?php print $report_id;?>-com_addmore_td"  name="<?php print $report_id;?>-com_addmore_td">
         
         <input type="hidden" value="hallo+" name="<?php print $act_id;?>-log_id_exist" id="<?php print $act_id;?>-log_id_exist" />
        <input type="hidden" value="<?php print $current_date;?>" name="current_date" id="current_date" />
        <div id="<?php print $act_id;?>-result"  name="<?php print $act_id;?>-result" class="result_set" ></div>
        <div id="<?php print $act_id;?>-update"></div>
         
         
         <!--Click To Add New Report<br/> 
        <input type="button" value=" Add New " id="<?php 
        //print $report_id;
        ?>" onclick="javascript:addmore_report_test('<?php 
        //print $send;
        ?>','<?php 
        //print $count_misc;
        ?>');" title="Click Here To Add New Miscellineous Work Report" class="s_bt"/> -->
        <?php } ?>
        </td>
      </tr>
      
      <tr><th colspan="5" >***</th></tr>
      <tr>
      
      </tr>
    </table>
              
              
              <!-- *************************************  -->
              <!-- *************************************  -->
              <!-- *************************************  -->
              <!-- *************************************  -->
              <!-- *************************************  -->
              <!-- *************************************  -->
              
              
              
              
              
              
              
              <!-- *************************************  -->
              <!-- *************************************  -->
              <!-- *************************************  -->
      
      
      
      
              </td>
          </tr>
      </table>
      
	    
	    
	    
	    </td>
    </tr>
     <tr>
      <td height="30" colspan="4" align="center" valign="middle"  class="Footer_txt">
      <?php footer();?>
      </td>
    </tr>
  </table>
</div>
</body>
</center>
<script language="JavaScript" type="text/javascript">
function textarea_alert(id){
	//alert(document.getElementById(id).defaultValue);
alert("You Are Not Allowed To Edit your Scheduled Work !! \n Please Contact Your Supervisor To Edit Scheduled work ");

document.getElementById(id).value=document.getElementById(id).defaultValue;
}

function activity_select(id){
alert("You Are Not Allowed To Edit your Scheduled Work !! \n Please Contact Your Supervisor To Edit Scheduled work ");
alert(document.getElementById(id).selectedText);
document.getElementById(id).value=document.getElementById(id).selectedIndex;
}
function get_textarea(act_id,to_let_id,clicked_id,logg){
	name=act_id+to_let_id;
	click=act_id+clicked_id;
	default_val=document.getElementById(click).innerHTML;
	act=act_id+"-update";
	document.getElementById(click).innerHTML="<TEXTAREA name=\""+name+"\" id=\""+name+"\"  class=\"text_area\" onBlur=\"javascript:check_report(name,click,default_val,act);\">"+logg+"</TEXTAREA>";

	get_update(act_id);
 document.getElementById(name).focus();
}


function get_update(act_id){
	
	var save_btn="<input type=\"button\" name=\""+act_id+"save_button\" id=\""+act_id+"save_button\" value=\"SAVE\" class=\"s_bt\" onClick=\"javascript:insert_report('"+act_id+"');\" title=\"Click here to Save your reports\"/>   ";
	if(!(/(NEW).+/.test(act_id))){
		save_btn+="<input type=\"button\" name=\""+act_id+"del_button\" id=\""+act_id+"del_button\" value=\"Delete\" class=\"s_bt\" onClick=\"javascript:delete_report('"+act_id+"');\" title=\"Click here to Delete Report\"/>";
		
	}
	document.getElementById(act_id+"-update").innerHTML=save_btn;
}


function get_update1(act_id){
	
	var save_btn=" <input type=\"button\" name=\""+act_id+"save_button\" id=\""+act_id+"save_button\" value=\"SAVE\" class=\"s_bt\" onClick=\"javascript:insert_report('"+act_id+"');\" title=\"Click here to Save your reports\"/> ";
	document.getElementById(act_id+"-update").innerHTML=save_btn;
}





function check_date(){
	date=document.getElementById('get_pre_report_date').value;
	if(/(Enter).+/.test(date)){
		alert(" Please Enter Date To Search !!");
		return;
	}
	else{
		document.getElementById('getreportdate').submit();
		
	}
}

function check_report(id,click,def,act){
	time_worked=document.getElementById(id).value;
	if(time_worked==""){
		document.getElementById(click).innerHTML=def;
		document.getElementById(act).innerHTML="";
	}
}
   	
   
   
function insert_report(id){
//alert(id);
	activity_detail=document.getElementById(id+"-activity_detail").value;
if(activity_detail=='0'){
	alert(" Please Select Your Activity Type.. ");
	document.getElementById(id+"-activity_detail").focus();
return;
}
	if(/(<div).+/.test(document.getElementById(id+'_td_1').innerHTML)){
			alert(" Please Enter Your Report !!");
			return;
	}
//alert(document.getElementById(id+'_td_1').innerHTML);
	if((/(<TEXTAREA).+/.test(document.getElementById(id+'_td_1').innerHTML))||(/(<textarea).+/.test(document.getElementById(id+'_td_1').innerHTML))){
	
	report=document.getElementById(id+"-report").value;
if(report==""){
	alert(" Please Enter Your Report !!");
return;
}
//alert(report);
time_worked=document.getElementById(id+"-time_worked").value;
var time=document.getElementById(id+"-time_worked").selectedIndex;
var selected_text = document.getElementById(id+"-time_worked").options[time].text;

if(confirm("Are You Sure You Spent "+selected_text+" For This Work ?" )){
report=escape(report);
//alert(report);
log_id=document.getElementById(id+'-log_id_exist').value;

//alert(document.getElementById('current_date').value);
cur_date=document.getElementById('current_date').value;
//alert(cur_date);
//alert(log_id);
log_test=log_id;
if(/(NEW).+/.test(id)){
	// case of entering new non scheduled work
	//alert(" hallo");
	url="include/getvalues.php?menuid=1&entryfn=3&sch_id="+id+"&report="+report+"&time_worked="+time_worked+"&activity_detail="+activity_detail+"&logid="+log_id+"&current_date="+cur_date;
	//return;
	//alert(url);
}
else if(log_id!="hallo+"){
	// case of editing already entered misc work report
	split_string=log_id.split('+');
	
	log_id=split_string[1];	// since log id is appended with a string, here the log id is extracted here
	url="include/getvalues.php?menuid=1&entryfn=2&sch_id="+id+"&report="+report+"&time_worked="+time_worked+"&activity_detail="+activity_detail+"&logid="+log_id+"&current_date="+cur_date;
	
}
else{
	// case when normal work report entry to schedule work
	
url="include/getvalues.php?menuid=1&entryfn=1&sch_id="+id+"&report="+report+"&time_worked="+time_worked+"&activity_detail="+activity_detail+"&current_date="+cur_date;
}
//alert(url);

//document.getElementById(id+"save_button").disabled=true;
idtest=id;
id=id+"-result";
//alert(id);
//fnShowData(url,id,'0',true);
fnShowData(url,id,'0',false);
//location.reload(true);
	if(/(NEW).+/.test(idtest)){
location.reload(true);
}
else if(log_id!="hallo+"){
	location.reload(true);
}
else{
	location.reload(true);
}
}else{
return; // returns if he is not sure about the time
}
}// if text area exists!!! textarea ends here
}



   function addmore_report_test(){
//location.reload(true);
	}
   
   
  function delete_report(act_id){
			if(confirm("Are you sure to delete your Work Report ?")){
				 log_id=document.getElementById(act_id+'-log_id_exist').value;
				 split_string=log_id.split('+');
				 log_id=split_string[1];
				 if(log_id==""){
				 	return;
				}
				 url="include/getvalues.php?menuid=5&logid="+log_id;
				 id=act_id+"-result";
				 //fnShowData(url,id,'0',true);	
				 fnShowData(url,id,'0',false);	
				 location.reload(true);
			}
	}
</script>
</html>
