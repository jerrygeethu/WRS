<?php 
require_once('include/include.php');
$_SESSION['SEL_LINK']="MET";
require_once('include/parameters.php');
require_once('include/meeting_functions1.php');
//$tab_link="		<a href=\"meetings.php\" class=\"tab_link\"\">Meetings</a> ";







?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php print $company_name;?>-Home </title>
<link href="css/reporting.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="StyleSheet">
<link href="css/calendar.css" rel="StyleSheet" type="text/css" />
<!-- to show a icon in url title icon -->
<link rel="shortcut icon" href="./images/icon.gif" >
<script language="JavaScript" src="js/calendar.js" type="text/JavaScript"></script>
<script language="JavaScript" type="text/javascript"  src="js/validate.js"> </script>



<!-- ========Use a JQuery ThemeRoller theme, in this case 'smoothness'======== -->
    <link rel="stylesheet" type="text/css" href="css/jquery-ui-1.8.4.custom.css">
    <link rel="stylesheet" type="text/css" href="css/ui.dropdownchecklist.themeroller.css"> 
    <script type="text/javascript" src="js/dropdown/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="js/dropdown/jquery-ui-1.8.4.custom.min.js"></script> 
    <script type="text/javascript" src="js/dropdown/ui.dropdownchecklist-1.1-min.js"></script>       
<!-- ====== ================================================= -->
<!-- ====== clockpick  ====== -->
	<link href="jquery.clockpick.1.2.8/jquery.clockpick.1.2.8.css" rel="stylesheet" type="text/css" />
		<!--	<script type="text/javascript" src="js/jquery.min.js"></script>	-->
		<script type="text/javascript" src="jquery.clockpick.1.2.8/jquery.form.js"></script>
		<script language="JavaScript" src="jquery.clockpick.1.2.8/jquery.clockpick.1.2.8.js"></script>
		<script language="JavaScript" src="jquery.clockpick.1.2.8/jquery.clockpick.1.2.8.min.js"></script>
		<script language="JavaScript" src="jquery.clockpick.1.2.8/jquery.clockpick.1.2.8.pack.js"></script>
		<script language="javascript" type="text/javascript">
			$(document).ready(function(){				
				$("#clockpick").clockpick({
					starthour       : 9,
		endhour         : 17,
		showminutes     : true,
		minutedivisions : 4,
		military        : false,
		event           : 'click',
		layout			: 'vertical',
		valuefield		: null,
		useBgiframe		: false,
		hoursopacity	: 1,
		minutesopacity  : 1
		}); 	
		
		 $("#people").dropdownchecklist();							
			});
			</script>
<!-- ================== -->
 
		
		
 <script> 
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
      <td height="101" colspan="2" align="left" valign="middle" class="Head"><img src="images/Compy_logo.jpg" alt="" width="195" height="68" /></td>
      </tr>
    <tr>
      <td width="159" rowspan="2" align="left" valign="top" class="menu_back">
      <?php 
      $menu=show_menu();
      print $menu;
      ?>
      
     
      
      </td>
      <td width="100%" height="30px" valign="top"  class="head_with_back_button"><?php print get_table_link("Meetings","homeicon.jpg");?>
      </td>
    </tr>
    <tr>
      <td height="580" valign="top" class="home_main_td" >   

<!-- ============================================================================================= -->





<div class="leave_table"  valign="top" height="100%">
<table width="99%" height="100%" class="leave_table"  border="0" cellspacing="1" cellpadding="1">
    <tr>
        <td width="400px"  valign="top" align="center">
				<form name="frmeeting" id="frmeeting" method="POST" action="meetings.php"  enctype="multipart/form-data">
				<table width="100%">
						<tr><td colspan="2" style="color:#FF0000"><?php echo $msgmeeting.$message.$meetingexists;?></td></tr>
						<tr>
								<td>
								Subject
								</td>
							 <td><textarea style="width:400px; height:50px;" name="meetingtitle" id="meetingtitle" <?php if($flag==1) {echo "readonly=\"yes\"";}?> wrap="hard"><?php echo (!empty($row['title']))?$row['title']:$_POST['meetingtitle'];?></textarea>
								</td>								
						</tr>
						<tr>
								<td colspan="2" align="center"><?php if($errTitle!="") { echo $errTitle; }?></td>
						</tr>
						<tr>
								<td>
								Agenda
								</td>
								<td><textarea style="width:400px; height:100px;" name="objective" id="objective"  <?php if($flag==1) {echo "readonly=\"yes\"";}?>><?php echo (!empty($row['descr']))?$row['descr']:$_POST['objective'];?></textarea>
								</td>
						</tr>
						<tr>
								<td colspan="2" align="center"><?php  if($errObj!="") { echo $errObj; }?></td>
						</tr>
						
						<tr>
								<td>
						 Date
								</td>
								<td>
								<!--<input type="text"  style="width:150px;"  name="dateTimeCust" id="dateTimeCustom" size="30px" maxlength="12" readonly="true"  value="<?php echo (!empty($row['schdate']))?$row['schdate']:"";?>"/> <button type="button">PICKER</button>-->
								<input type="text"   id="fromdate" name="fromdate" maxlength="12"  value="<?php print (!empty($row['schdate']))?ymdToDmy($row['schdate']):$_POST['fromdate'];?>"  readonly="true" class="date_text"  />
   <img onclick="displayDatePicker('fromdate');" value="select" src="<?php print $_SESSION['FOLDER'];?>/cal.gif" title="Calender"/>
								<input type="text" id="clockpick" name="clockpick" readonly="true" value="<?php echo (!empty($row['schtime']))?$row['schtime']:$_POST['clockpick'];?>"/>
								</td>
								<td>
								
								</td>
						</tr>
						<tr>
								<td colspan="2" align="center"><?php  if($errDate!="") { echo $errDate; }?></td>
						</tr>
						
						<tr>
								<td>
						 Duration
								</td>
								<td>
								<select id="durationDrop" name="durationDrop"  style="width:125px;">
                       <option value="0">Duration</option>
								<?php 
								$select_dur=(!empty($row['duration']))?$row['duration']:$_POST['durationDrop'];
								$dur=getdurations($select_dur);
								print 	$dur;
								?>
								</select>
								</td>
						</tr>
						<tr>
								<td colspan="2" align="center"><?php  if($errDuration!="") { echo $errDuration; }?></td>
						</tr>
						
						
						<tr>
								<td>
						 People
								</td>
								<td>	<div id="content">
								<?php if($flag==1){?>
								<?php 
									$emps=(!empty($row['people']))?$row['people']:"";
									$getrow=unserialize($emps);
									$select_emps="";$viewemp="";
									if(!empty($getrow)){
										$viewemp.="<div name=\"selected_emp\" id=\"selected_emp\" readonly=\"yes\" style=\"width:400px; height:150px; overflow:auto; background-color:#FFFFFF\" >";
										foreach($getrow as $dep=>$value)
										{
												$querydep="select depname from department where departmentid='".$dep."'";
												$resultdep = $GLOBALS['db']->query($querydep);
												$rowdep = $resultdep->fetch_assoc();
												$viewemp.="<br/><b>".$rowdep['depname']."</b>";
												foreach($value as $k)	
												{
													//$select_emps[]=$k;
													$query1="select fullname from employee where employeeid='".$k."'";
													$result1 = $GLOBALS['db']->query($query1);
													$row1 = $result1->fetch_assoc();
													$viewemp.="<br/>".$row1['fullname'];
												}																			
										}
										$viewemp.="</div>";				
								  }
									print $viewemp;
								?>
							  
								<?php }else {?>					
								<select name="people[]" id="people" multiple="true">
								
								<?php
								print deptlist();
								?>
								</select>	
								<?php } ?>	
								</td>
						</tr>
						<tr>
								<td colspan="2" align="center"><?php  if($errPeople!="") { echo $errPeople; }?></td>
						</tr>
						
						
						
						
							<?php
						if(isset($_POST['editBtn'])){
						?>	
						<tr>
								<td>
						 File
								</td>
								<td>
								<input type="file" name="uploadedfile" id="uploadedfile"/>
								<?php if(!empty($row['file'])) {?>
								<a href="<?php echo $row['file'];?>">view file</a>
								<?php } ?>
								</td>
						</tr>
						
						<tr>
								<td>
						 Feedback
								</td>
								<td>
								<textarea style="width:400px; height:100px;" name="feedback" id="feedback"><?php echo (!empty($row['conv']))?$row['conv']:"";?></textarea>								
								</td>
						</tr>
						
						
						<tr>
								<td>
						 Comments
								</td>
								<td>
								<textarea style="width:400px; height:100px;" name="comments" id="comments"><?php echo (!empty($row['comments']))?$row['comments']:"";?></textarea>								
								</td>
						</tr>
						<!--<tr>
								<td>
						 Feedback by 
								</td>
								<td>
									<?php ?>						
								</td>
						</tr>-->
						<?php }?>
						
						
						<tr>
						<td colspan="2" align="center">	
						<?php
						if(isset($_POST['editBtn'])){
						?>	
						<input type="submit"  name="update" id="update" value="Update" <?php if($row['status']=="deny") {  echo "disabled=\"true\"";}?> />  
						<!--<input type="submit"  name="delete" id="delete" value="Delete" <?php if($row['status']=="deny") {  echo "disabled=\"true\"";}?>/>-->  
						<input type="hidden" name="meetid" id="meetid" value="<?php echo $row['meetingid']; ?>"/>
						<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
						<?php 
						}else{
						?>	
			<input type="submit"  name="btnsave" id="btnsave" value="Save" <?php if(isset($_POST['meetid'])) {  echo "disabled=\"true\"";}?>  />   
						<?php } ?>
						</td></tr>
				</table>
				</form>


        </td>
        <td valign="top" align="center">
      
				<table  border="1" class="leave_detials" width="98%" >
						<tr>
						<td>From</td><td>Title</td><td>Date</td><td>Options</td>						
						</tr>	
						<?php print viewmeetings(); ?>						
				</table>
			

         
        </td>
    </tr>
</table>



</div>






























<!-- ============================================================================================= -->

 

     </td>	
    </tr>	
     <tr>
      <td height="30px" colspan="4" align="center" valign="middle"  class="Footer_txt"><?php footer();?></td>
    </tr>
  </table>
</div>
</body>
</center>
</html>
