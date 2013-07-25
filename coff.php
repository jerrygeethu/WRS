<?php
	require_once('include/include.php');
	require_once('include/leavefun.php');
	$_SESSION['SEL_LINK']="CFF";
	require_once('include/parameters.php');	
	$emp_power=emp_authority($_SESSION['USERID']);	
	$empid=$_SESSION['USERID'];

	if(isset($_POST['edit']) and $_POST['edit']!='') 
	{
		$row = getData($_POST['edit_id']);
		$editDepid=$row['departmentid'];
		$editempid=$row['employeeid'];
		$days= $row['days'];
	}
	else
	{
		$days=0;
	}
	
	if((isset($_POST['departmentid']) and $_POST['departmentid']!=''))
	{
    	$departSelected = $_POST['departmentid'];
	}
	else if(isset($_GET['d']) && $_GET['d']!='')
	{
    	$departSelected = $_GET['d'];
	}
	else if((isset($_POST['edit']) and $_POST['edit']!=''))
	{
		 $departSelected=$editDepid;
	}
	else
	{
		 $departSelected=$emp_power['emp_deptid'];
	}	
	
	if(isset($_POST['employeeid']) && $_POST['employeeid']!='')
	{
		$emp_id=intval($_POST['employeeid']);
	}
	else if(isset($_GET['emp']) && $_GET['emp']!='')
	{
   	$emp_id = $_GET['emp'];
	}
	else if(isset($_POST['edit']) and $_POST['edit']!='') 
	{
		$emp_id=$editempid;
	}
	else
	{
		$emp_id="";		
	}
	
	$_SESSION['REP_DATE']=$_POST['from_date'];
	
	if((isset($_GET['s']))&&($_GET['s']!=""))
	{
		$start=$_GET['s'];
	}
	else if((isset($_POST['s']))&&($_POST['s']!=""))
	{
		$start=$_POST['s'];
	}
	else
	{
		$start=0;
	}
	
	if($start<0)
		$start=0;
	$no_of_rows=5;
	$pre=$start-$no_of_rows;
	$next=$start+$no_of_rows;	
	
	$depView=getDepartmentList1($emp_power,$departSelected,$editDepid);
	$allemployees=getemployeelist1($emp_power,$departSelected,$emp_id,$editempid);
	
	$dep_id=$emp_power['emp_deptid'];
	$emd=$_POST['employeeid'];
	$emp=$_GET['emp'];
			
	$lvdate=dmytoymd($_POST['from_date']);
	$current_date=date("Y-m-d h-i-s");
	$currentdate=date("Y-m-d");
	$remark=$_POST['remarks'];
	$default='2009-01-01';
	
	if(((isset($_POST['btnup1']) and $_POST['btnup1']!='')) and (($lvdate < $currentdate) && ($lvdate!=$default)) and (isset($remark) and $remark!=''))
	{
		edit_check(); // function to set session variable "EDIT" to enable and disable edit options
		if(isset($_POST['from_date']))
		{
			$_SESSION['REP_DATE']=$_POST['from_date'];
		}
		if(($_SESSION['EDIT']==0) and ($_SESSION['EDIT']!=1))
		{
			$error_msg="You are exceeding the limit to apply Coff";
			 $error=1;
		}
		if($_SESSION['EDIT']==1)
		{
			$edt1=1;
			$editid=$_POST['editid'];
			$msg=editleave($_POST,$empid,$lvdate,$editid);
		}
	}
	
	if((isset($_POST['delid']) and $_POST['delid']!='')&&($_POST['btnup1']=="")&&($_POST['edit']==''))
	{
		$delid=$_POST['delid'];
		$msg=delleave($_POST,$lvdate,$delid);
	}
	
	if((isset($_POST['btnsave']) and $_POST['btnsave']!='') || (isset($_POST['btnup1']) and $_POST['btnup1']!=''))
	{	
		if(($_POST['departmentid']=="") || ($_POST['departmentid']==0))
		{
			$error_dept="Please select department!!";
			$error=1;
		}
		
		if(($_POST['employeeid']=="") || ($_POST['employeeid']==0))
		{
			$error_emp="Please select Employee!!";
			$error=1;
		}
		
		if(($lvdate >= $currentdate) || ($lvdate==$default))
		{
			$error_msg="Sorry, Invalid date. Please enter date less than current date!!";
			$error=1;
		}
				
		if($remark=="")
		{
			$error_msg_remarks="Please enter the remarks!!";
			$error=1;
		}
	}
	if((isset($_POST['btnsave']) and $_POST['btnsave']!='') && (($_POST['departmentid']!="") && ($_POST['departmentid']>0)) && (($_POST['employeeid']!="") && ($_POST['employeeid']>0)) && ($lvdate < $currentdate) && ($lvdate!=$default) &&(isset($remark) && ($remark!="")) and $_POST['delbtn']=='' )
	{
		edit_check(); // function to set session variable "EDIT" to enable and disable edit options
		if(isset($_POST['from_date']))
		{
			$_SESSION['REP_DATE']=$_POST['from_date'];
		}
		if(($_SESSION['EDIT']==0) and ($_SESSION['EDIT']!=1))
		{
			$error_msg="You are exceeding the limit to apply Coff";
			 $error=1;
		}
		$msg=insertleave($_POST,$empid,$lvdate);
		//echo $msg['flag'];
	}
	$data=showfiles($emp_power,$_POST,$departSelected,$emp_id,$start,$no_of_rows,$dep_id,$emd,$emp);
	//print_r($data);
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
			function myPopup(leavecoffid) 
			{
				window.open('include/coffremarks.php?pop='+leavecoffid,'welcome','height=500,width=500,scrollbars=yes,fullscreen=no,location=yes,status=yes'); 
			}
			function changeDepart()
			{
				if(document.getElementById('departmentid').value!=null)
				document.location.href="coff.php?d="+document.getElementById('departmentid').value;
			}
			function changeEmp()
			{
				if(document.getElementById('employeeid').value!=null)
				document.location.href="coff.php?emp="+document.getElementById('employeeid').value+"&d="+document.getElementById('departmentid').value;
			}	
				// To confirm delete record or not
			function confirmdelete() 
			{
				if(confirm("Are you sure to delete this record ...?")==true)
				{
				//if(document.getElementById('editid').name == "editid"){
				document.getElementById('delid').name = "delid";
				document.getElementById('coff').submit();
				//}
			}
		}		
		</script>
		<script language="JavaScript" src="js/calendar.js"></script>
		<script language="JavaScript" src="js/effects.js"></script>
	</head>
	<body  onload="MM_preloadImages('images/Home_Over.jpg','images/Dep_Over.jpg','images/Emp_Over.jpg','images/Sch_Over.jpg','images/Acti_Over.jpg','images/Vali_Over.jpg','images/View_Over.jpg','images/Daily_Over.jpg','images/Change_Over.jpg','images/Log_Over.jpg')">
	<table width="100%" border="0" cellspacing="1" cellpadding="0" summary=" ">
		<tr>
			 <td height="101" colspan="2" align="left" valign="middle" class="Head">
				<img src="images/Compy_logo.jpg" alt="" width="195" height="68" />
			</td>
		</tr>
		<tr>
			<td width="159" rowspan="2" align="left" valign="top" class="menu_back">
				<?php 
					$menu=show_menu();
			 		print $menu;
				?>
			</td>
			<td width="100%" height="30px" align="left" valign="top"  class="head_with_back_button">
				<?php  
					print get_table_link(" Compensatory Off ","apply_lvicon.gif");
				?>
			</td>
		</tr> 
		<tr>
			<td  height="580"  align="center" valign="top">
				<form name="coff" id="coff" action="coff.php" method="post" onsubmit="return validate();">
					<p>&nbsp;</p>
					<table width="97%" height="300"  border="1" cellpadding="0" cellspacing="0" class="Tbl_Txt_bo">
						<tr >
							<td width="49%"  valign="top" class="back_td">
								<table width="575"  height="204" border="0" cellpadding="0"  cellspacing="1">
									<tr>
										<td colspan="2" align="center" >
											<h2>
												Compensatory Off
											</h2>	
										</td>
									</tr>
									<?php 
										if($msg['flag']==1)
										{
									?>
											<tr>
												<td align="center" colspan="2" style="color:#CC3300">
													<?php echo "Data has been successfully entered."; ?>
													<br/><br/>	
												</td>
											</tr>
											<tr>
												<td align="left" colspan="2" style="color:#CC3300">
													<?php
															echo $msg['message'];
													?>
													<br/>	
												</td>
											</tr>
									<?php
										}
										else if($msg['flag']==3)
										{
									?>
											<tr>
												<td align="center" colspan="2" style="color:#CC3300">
													<?php echo "Data has been successfully deleted."; ?>
													<br/><br/>	
												</td>
											</tr>
									<?php		
										}
										else if($msg['flag']==2)
										{
									?>
											<tr>
												<td align="center" colspan="2" style="color:#CC3300">
													<?php echo "Data has been successfully updated."; ?>
													<br/><br/>	
												</td>
											</tr>
									<?php		
										} 
									?>

									<tr>
										<td width="49%" align="right" class="menu_txt" >
											<label for="title"> Select Department : </label>	
										</td>
													
										<td width="212">
											<label>
												<select id="departmentid" name="departmentid" style="width:184px"  onChange="javascript:changeDepart();">
													<?php
														print $depView;
													?>
												</select>
											</label>
										</td>
									</tr>
									
									<?php
										if($error ==1) 
										{
									?>
											<tr>
												<td colspan="2" align="right" style="color:#CC3300">
													<?php echo $error_dept;?>
												</td>
											</tr>
									<?php	
										}
									?>
									
									<tr>
										<td width="49%" align="right" class="menu_txt" >
											<label for="title"> Select Employee : </label>	
										</td>
													
										<td width="212">
											<label>
												<select id="employeeid" name="employeeid" style="width:184px" onChange="javascript:changeEmp();" >
												<?php
													print $allemployees;
												?>
												</select>
											</label>
										</td>
									</tr>
									
									<?php
										if(($error ==1) )
										{
									?>
											<tr>
												<td colspan="2" align="right" style="color:#CC3300">
													<?php echo $error_emp;?>
												</td>
											</tr>
									<?php	
										}
									?>
									
									<tr>
										<td width="49%" align="right" class="menu_txt" >
											<label for="title"> Worked Date : </label>	
										</td>
										<td width="212">
											<label>				
												<input type="text" name="from_date" id="from_date" size="30px" readonly="true" value="<?php if(isset($row['dateworked'])) {echo ymdToDmy($row['dateworked']);}else if($msg['flag']==''){echo $_POST['from_date'];}?>" class="date_text" style="width:85px;"/>
															<!--calender code-->
												<img onclick="displayDatePicker('from_date');" alt="calender" src="<?php print $_SESSION['FOLDER'];?>/cal.gif" title="Calender"/> 
											</label>
										</td>
									</tr>
									<?php
										if(($error ==1) )
										{
									?>
											<tr>
												<td colspan="2" align="right" style="color:#CC3300">
													<?php echo $error_msg;?>
												</td>
											</tr>
									<?php	
										}
									?>
									<tr>
										<td width="49%" align="right" class="menu_txt" >
											<label for="remark"> Remarks : </label>				
										</td>
										<td width="212">
											<label>
												<textarea name="remarks" id="remarks" rows="5" cols="30"><?php if(isset($row['remarks'])){echo $row['remarks'];}else if($msg['flag']==''){echo $_POST['remarks'];}?></textarea>
											</label>
										</td>
									</tr>
									<?php
										if($error ==1)
										{
									?>
											<tr>
												<td colspan="2" align="right" style="color:#CC3300">
													<?php echo $error_msg_remarks;?>
												</td>
											</tr>
									<?php	
										}
									?>	
									<tr>
										<td width="49%" align="right" class="menu_txt" >
											<label for="day"> Days : </label>
										</td>
										<td width="212">
											 
											<input type="radio"  name="days" value="1.00" checked <?php if($row['days']==1) { ?> checked="checked" <?php }else if($_POST['days']==1){ ?> checked="checked" <?php }?> >Full day
											<input type="radio"  name="days" value="0.50" <?php if($row['days']==.5) { ?> checked="checked" <?php }else if($_POST['days']==.5){ ?> checked="checked" <?php }?>>Half day 
										 
										</td>
									</tr>
									<tr>
										<td align="center" colspan="2">
											<?php 
												if(isset($_POST['edit']))
												{ 
														echo "<input type=\"submit\" id=\"btnup1\" name=\"btnup1\" style=\"width:75px;\" value=\"Update\"/>";
														echo "<input type=\"button\" name=\"delbtn\" id=\"delbtn\" style=\"width:73px;\" value=\"Delete\"  onclick=\"javascript:confirmdelete();\" />";
											?>
														<input type="hidden" name="editid" id="editid" value="<?php if(isset($row['leavecoffid'])) echo $row['leavecoffid'];else echo $_POST['editid'];?>"/>		
														<input type="hidden" name="delid" id="delid" value="<?php if(isset($row['leavecoffid'])) echo $row['leavecoffid'];?>"/>
											<?php 
												}	
												else if((isset($_POST['btnup1'])) and (($remark=="") or ($lvdate >= $currentdate) or ($_SESSION['EDIT']!=1)))
												{
														echo "<input type=\"submit\" id=\"btnup1\" name=\"btnup1\" style=\"width:75px;\" value=\"Update\"/>";
														echo "<input type=\"button\" name=\"delbtn\" id=\"delbtn\" style=\"width:73px;\" value=\"Delete\"  onclick=\"javascript:confirmdelete();\" />";
											?>
														<input type="hidden" name="editid" id="editid" value="<?php if(isset($row['leavecoffid'])) echo $row['leavecoffid'];else echo $_POST['editid'];?>"/>		
														<input type="hidden" name="delid" id="delid" value="<?php if(isset($row['leavecoffid'])) echo $row['leavecoffid'];?>"/>
											<?php 			
												}										
												else 
												{			
													
											?>
													
													<input type="submit" id="btnsave" name="btnsave" style="width:75px;" value="Save"/>
													<input type="reset" id="canselbtn" value="Cancel" title="Cancel" style="width:75px;"/>					
											<?php
												}
												
											?>
										</td>			
									</tr>		
								</table>
							</td>
							<td width="50%"  valign="top" align ="center" class="back_td">	
								<?php
									if($data['total_count']>0)
									{
								?>
										<table width="614" border="0" align="center" cellpadding="0" cellspacing="1" ><br/>
											<tr  valign="middle" style="background-color:#FFFFFF;">
												<th height="30"  align="center">Sl No</th>
												<th    align="center">Department</th>
												<th   align="center">Employee </th>
												<th  align="center">Date</th>
												<th  align="center">Remarks</th>
												<th  align="center">Days</th>
												<th  align="center">Status</th>
												<th  align="center">Applied By</th>
											</tr>
											<?php 
												print $data['tables'];
											?>
											<tr>
												<td align="left" nowrap height="30"> &nbsp;
													<?php
														if($pre>=0)
														{
													?>
															<a href="coff.php?s=<?php print $pre;?>&d=<?php print $departSelected;?>&emp=<?php print $emp_id;?>"   title="Go to previous set of data " ><< Pre</a>
													<?php
														} 
													?>
												</td>
												<td colspan="6" align="center">***</td>
												<td align="right" nowrap> &nbsp;
													<?php
														//print $next."".$data['total_count'];
														if($next<$data['total_count'])
														{
													?>
															<a href="coff.php?s=<?php print $next;?>&d=<?php print $departSelected;?>&emp=<?php print $emp_id;?>"  title="Go to next set of data " >Next >></a>
													<?php
														} 
													?>
												</td>
											</tr>
										</table>	
								<?php 
									}
									else
									{
								?>
										<h3> No Records found </h3>
								<?php
									}
								?>
							</td>
						</tr>
					</table>
				</form>
			</td>
		</tr>
		<tr>
			<td align="center" valign="middle" class="Footer_txt" colspan="2"> <?php echo footer();?> </td>
		</tr>
	</table>
	</body>
</html>
