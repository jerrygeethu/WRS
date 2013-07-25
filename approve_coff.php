<?php 
require_once('include/include.php');
$_SESSION['SEL_LINK']="APCFF";
require_once('include/parameters.php');
require_once('include/approvecoff_fns.php');

//$data=get_leave_list();
$data=show();

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
<script language="JavaScript" src="js/calendar.js"></script>
<script language="JavaScript" src="js/effects.js"></script>
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
						<td width="100%" height="30px" valign="top"  class="head_with_back_button"><?php print get_table_link("Approve Coff","approve_lvicon.gif");?>
						</td>
					</tr>
					<tr>
						<td height="580" valign="top" class="back_td"   class="leave_table" > 
							<div  class="leave_table"  valign="top">
								<table border="1" width="100%">
									<tr>
										<td>
								<!-- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% -->
											<table border="1"  class="approve_table">
												<tr>
													<th colspan="6">Details of Coff</th>
												</tr>    
												<tr>
													<td colspan="6" id="validate" name="validate">
														<?php 
															// print $message;
															if(isset($data['save']))
															{
																	echo $data['message'];
															}
														?>
													</td>
												</tr>
												<tr>
													<th>Sl no:</th>
													<th>Employee Name</th>
													<th>Created Date</th>
													<th>Worked Date</th>
													<th>Reason</th>
													<th>Status</th>
												</tr>
												<?php 
													print $data['table'];
												?>
											</table>
					  <!--  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ -->
										</td>
							  <!-- 888888888888888888888888888888888888888888888888888
							  <td>
							  <table>
								  <tr>
									  <td>
									  </td>
								  </tr>
							  </table>
							  </td> 
							  888888888888888888888888888888888888888888888888888 -->
									</tr>
								</table>
							</div>
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
