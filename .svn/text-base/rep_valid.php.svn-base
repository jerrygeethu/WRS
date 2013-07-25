<?php
require_once('include/include.php');
$_SESSION['SEL_LINK']="VLR";
$_SESSION['VSTIME']=0;
$_SESSION['VMTIME']=0;
//for download file
//$data['target_path']=getsettings('target_path_to_logFile')."/";	
require_once('include/parameters.php');
$emp_power = emp_authority($_SESSION['USERID']);
require_once('include/rep_valid_functions.php');
require_once('include/rep_valid_query.php');
/*if(isset($_POST['dept_drop_down']))
{
$depSelect=$_POST['dept_drop_down'];
}
if(isset($_POST['sch_drop_down']))
{
$schSelect=$_POST['sch_drop_down'];
}*/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php print $company_name;?>-Validate Reports</title>
<link href="css/reporting.css" rel="stylesheet" type="text/css" />
<link href="css/saxan.css" rel="stylesheet" type="text/css" />
<link href="css/calendar.css" rel="StyleSheet">
<!-- to show a icon in url title icon -->
<link rel="shortcut icon" href="./images/icon.gif" >
<script language="JavaScript" src="js/calendar.js"></script>
<script language="JavaScript" src="js/callAjax.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript"  src="js/validate.js"> </script>
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


function insert_emp_comment(logid,to)
{
	//alert(logid);	
	if(to=="emp")
	{
		report=document.getElementById(logid+"-com2emp").value;
		report=escape(report);
		url="include/getvalues.php?menuid=6&entryfn=1&log_id="+logid+"&report="+report;
		id=logid+"-2emp";		
	}
	else if(to=="adm")
	{
		report=document.getElementById(logid+"-com2adm").value;
		report=escape(report);
		url="include/getvalues.php?menuid=6&entryfn=2&log_id="+logid+"&report="+report;
		id=logid+"-2adm";
	}
	//alert(url);
	fnShowData(url,id,'0','false');		
}
/*function checkall()
{
	
	var datefrom = document.getElementById('rdate').value;
	var dateto = document.getElementById('todate').value;
	if(compareDates(datefrom,'dd/mm/yyyy',dateto,'dd/mm/yyyy')!=0 ) 
	{
		
		alert("Please enter From Date less than To Date !!");
		displayDatePicker('todate');
		return true;
	}
	else
	{
		document.getElementById('getreportdate').submit();
	}
}*/
function checkall(dateField1,dateField2,formid)
{
	var retVal = true;
	dateValue1 = document.getElementById(dateField1).value;
	dateValue2 = document.getElementById(dateField2).value;
	
	var today = new Date();
	today = new Date(today.getFullYear(), today.getMonth(), today.getDate());
	
	if((dateValue1=='') ||( dateValue2==''))
	{
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
			retVal=false;	 
		}	
	}
	if(retVal==true)
	{
		document.getElementById(formid).submit();
	}
}

function changeDepart()
{
	document.rptForm.submit();
	//var dep=document.getElementById('dept_drop_down').value;
	//document.location.href="rep_valid.php?dep="+dep;
}
function changeSchedule()
{
	document.rptForm.submit();
	//var dep=document.getElementById('dept_drop_down').value;
	//var sch=document.getElementById('sch_drop_down').value;
	//document.location.href="rep_valid.php?sch="+sch+"&dep="+dep;
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
      <td width="100%" height="30" align="right" valign="top" class="head_with_back_button"><?php 
			print get_table_link("Validate Report","valiicon.jpg");?></td>
    </tr>
    <tr>
      <td height="580px" align="center" valign="top"  class="main_content_p">
      <table class="main_content_table" border="0">
          <tr align="center">
              <td colspan="2">
             <div class="table_head">&nbsp;&nbsp;&nbsp;Select Employee</div>
              </td>
          </tr>
          
          <tr >
         <td colspan="2"  class="table_head" >
         
         	<?php 
	/*if(($emp_power['is_superadmin'] =='1')||($emp_power['is_admin'] =='1')||($emp_power['is_hod'] =='1'))
	{
		$list=get_dept_list($_SESSION['DPTRV']);
		// $list.=get_sch_list($_SESSION['SCH'],$_SESSION['DPTRV']);
		if($_SESSION['DPTRV']!=0)
		{			
			$list.=get_emp_list($_SESSION['EMPRV'],$_SESSION['DPTRV']);			
			//$list.=get_sch($_SESSION['DPTRV']);					
		}
	}
	else if($emp_power['is_super'])
	{
		$_SESSION['DPTRV']=$emp_power['emp_deptid'];
		$list.=get_emp_list($_SESSION['EMPRV'],$_SESSION['DPTRV']);
	}
		print $list; */
		if(($emp_power['is_superadmin'] =='1')||($emp_power['is_admin'] =='1')||($emp_power['is_hod'] =='1')||($emp_power['is_super']))
		{
			?>
			<form method="POST" id="rptForm" name="rptForm" action="rep_valid.php" >
			<table border="0">
			<tr>
			<td  nowrap ><label style="width:150px;">Department&nbsp;&nbsp;&nbsp;</label>:		        
			<select name="dept_drop_down" id="dept_drop_down" onchange="javascript:changeDepart();" 
			title="Select Department To Validate Report" style="width:180px;">
			<?php
/*
			if($emp_power['is_superadmin'] =='1')
			{
				$view_dept_query="select departmentid,depname from department order by depname asc ";
			}
			else if($emp_power['is_admin'] =='1')
			{
				$view_dept_query=" select departmentid,depname from department where departmentid in (".$emp_power['isadm_deptid'].")  order by depname asc ";
			}
			else if($emp_power['is_hod'] =='1')
			{
				$view_dept_query=" select departmentid,depname from department where departmentid in (".$emp_power['ishod_deptid'].")  order by depname asc ";
			}
*/
			
			
		//	$result_dept_query = $GLOBALS['db']->query($view_dept_query);			
			$result_dept_query=get_new_dept_list($emp_power['emp_id'],$emp_power) ;			
			if(isset($result_dept_query) and $result_dept_query->num_rows>0)
			{
			?>
				<option value="0">Select</option>
				<?php
				while($row_dept_query = $result_dept_query->fetch_assoc())
				{
				?>
					<option value="<?php echo $row_dept_query['departmentid']?>"
					<?php if($row_dept_query['departmentid']==$_SESSION['DPTRV1']) {//if($row_dept_query['departmentid']==$depSelect) { ?> selected="selected"  <?php } ?>					
					title="Department Name :<?php echo ucwords($row_dept_query['depname'])?>" ><?php echo ucwords($row_dept_query['depname'])?></option>
					<?php
				}
			}			
			?>
		
			</select>
			</td>
			<!--Schedule  &nbsp;&nbsp;&nbsp;-->			
			<td nowrap><label style="width:150px;">Schedule&nbsp;&nbsp;&nbsp;</label>:		  
			<select name="sch_drop_down" id="sch_drop_down" onchange="javascript:changeSchedule();" 
			title="Select Schedule To Validate Report" style="width:200px;">
			<option value="0">Select schedule</option>
			<?php
			
				$nemps = gne($emp_power);
			if(($emp_power['is_superadmin'] =='1')||($emp_power['is_admin'] =='1')||($emp_power['is_hod'] =='1')||($emp_power['from_rep'] !="")||($emp_power['is_super'] =='1'))
			{
			 	$view_sch_query="select s.scheduleid,s.description from schedule as s , schemployee as se   where se.scheduleid=s.scheduleid  and s.departmentid='".$_SESSION['DPTRV1']."' and se.employeeid in (".$nemps.") ";
			 		if(($emp_power['is_superadmin'] !='1')||($emp_power['is_admin']!='1')||($emp_power['is_hod'] !='1'))
							 $view_sch_query .=" and s.supervisorid ='".$_SESSION['USERID']."'  "; 
			 	$view_sch_query .="order by s.schfromdate ";
			}
			else if($emp_power['is_super'] =='1')
			{
				//$view_sch_query="select scheduleid,description from schedule where scheduleid in (".$depSelect.")";
			}
		//	print "<textarea>".$view_sch_query."</textarea>";
			$result_sch_query = $GLOBALS['db']->query($view_sch_query);
			if(isset($result_sch_query) and $result_sch_query->num_rows>0)
			{				
				while($row_sch_query = $result_sch_query->fetch_assoc())
				{
					?>
					<option value="<?php echo $row_sch_query['scheduleid'];?>"
					<?php if($row_sch_query['scheduleid']==$_SESSION['SCH1']) { ?>selected="selected" <?php }?>
					><?php echo $row_sch_query['description'];?></option>
					<?php
				}
			}
			?>
			<option value="unsch" <?php if($_SESSION['SCH1']=='unsch') {?> selected="selected" <?php } ?>>Unscheduled Reports</option>
			</select>   
			<!--Employee  &nbsp;&nbsp;&nbsp;-->						
			<td nowrap><label style="width:150px;">Employee&nbsp;&nbsp;&nbsp;</label>:		        
<select name="emp_drop_down" id="emp_drop_down" title="Select Employee To Validate Report" style="width:200px;"  onchange="javascript:changeSchedule();" >
			<option value="0">select</option>
			<?php
			

			if($_SESSION['SCH1']=="unsch")
			{
				$getEmp="select employeeid,fullname from employee where departmentid='".$_SESSION['DPTRV1']."' and e.employeeid in (".$nemps.") ";
$resultEmp= get_new_employee_list($_SESSION['DPTRV1'],$emp_power); 
			}
			else
			{
				 $getEmp="select schemp.scheduleid,schemp.employeeid,e.fullname,e.departmentid,dep.depname
							from
							schemployee schemp,employee e,department dep
							where
							e.employeeid=schemp.employeeid 
							and
							e.departmentid=dep.departmentid
							and
							schemp.scheduleid='".$_SESSION['SCH1']."'
							and
							e.employeeid!='".$_SESSION['USERID']."' ";
/*
								if(($emp_power['is_superadmin'] !='1')||($emp_power['is_admin']!='1')||($emp_power['is_hod'] !='1'))
							 $getEmp .=" 
*/
							
							 $getEmp .=" order by dep.depname
							";
			$resultEmp=$GLOBALS['db']->query($getEmp);
			}
			if(isset($resultEmp) and $resultEmp->num_rows>0)
			{						
				while($rowEmp=$resultEmp->fetch_assoc())
				{
					?>
					<option value="<?php echo $rowEmp['employeeid'];?>" 
					<?php if($rowEmp['employeeid']==$_SESSION['EMPRV1']) { ?>selected="selected" <?php } ?>><?php echo $rowEmp['fullname'];?></option>
					<?php
				}
			}
			else
			{
			?>
			<option value="0">No employees</option>
			<?php
			}
			?>
			</select>
			</td>			
			</tr>
			</table>
			</form>
			<?php
		}
		
		?>
         </td>
         </tr>
      	</table> 
      	 <div id="show_report" name="show_report">
		<?php 
		
		if(($_SESSION['EMPRV1']!=0))
		{		
				?><br />
				<table width="100%" border="0" id="show_date" name="show_date" class="main_content_table">
		   		<tr>
		        <td align="left">
		        Report Between: <?php  print $_SESSION['RDATESHOW'];?> To <?php  print $_SESSION['TODATESHOW'];?>
		        </td>
		        <td width="25%" nowrap>
		        <form id="getreportdate" name="getreportdate" method="post" action="rep_valid.php" >				
		        From 
				<input type="text"  id="rdate"  name="rdate" size="30px" maxlength="12" value="<?php print $_SESSION['RDATESHOW'];?>" style="width: 90px;"  readonly="true"/>
				<img onclick="displayDatePicker('rdate');" value="select" src="images/cal.gif" title="Click Here To Select Date .."/>
				&nbsp;&nbsp;&nbsp;				
				To 
				<input type="text" id="todate" name="todate" size="30px" maxlength="12" value="<?php print $_SESSION['TODATESHOW'];?>" style="width: 90px;" readonly="true"/>
				<img onclick="displayDatePicker('todate');" value="select" src="images/cal.gif" title="Click Here To Select Date .."/>
				&nbsp;&nbsp;&nbsp;
		
				<input type="button" value="GO" onclick="checkall('rdate','todate','getreportdate');" name="get_pre_report" class="s_bt" id="get_pre_report"/>	
				
				<input type="hidden" value="<?php print $_SESSION['DPTRV1'];?>" name="dept_drop_down"  id="dept_drop_down"/>	
				<input type="hidden" value="<?php print $_SESSION['SCH1'];?>"  name="sch_drop_down" id="sch_drop_down"/>	
				<input type="hidden" value="<?php print $_SESSION['EMPRV1'];?>" name="emp_drop_down"  id="emp_drop_down"/>				
				</form>
		        </td>
		    	</tr>
				</table>
				<?php
				if(($emp_power['is_superadmin'] =='1')||($emp_power['is_admin'] =='1')||($emp_power['is_hod'] =='1')||($emp_power['is_super'] =='1'))
				{			
					$report=get_schedule_report();
					//$report.=get_misc_report();
					print $report;
				}
		}
		?>
		</div>      
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
</html>
