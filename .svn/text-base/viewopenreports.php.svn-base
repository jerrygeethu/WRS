<?php
require_once('include/include.php');
$_SESSION['SEL_LINK']="OPN";
require_once('include/parameters.php');
$user_id =  $_SESSION['USERID'];
$emp_power = emp_authority($user_id);
//printarray($emp_power);

require_once('include/openreport_functions.php');

if(isset($_GET['msg']))
{
	$msg=$_GET['msg'];
	if($msg==2)
	{
		$message="Report date opened.<br/>Mail has been sent successfully.";
	}
	else if($msg==0)
	{
		$message="Error occured";
	}
}




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
	$no_of_rows=10;
	$pre=$start-$no_of_rows;
	$next=$start+$no_of_rows;	
	
	 $data=getopenreports($start,$no_of_rows); 

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php print $company_name;?>-View Employee</title>
<link href="css/reporting.css" rel="stylesheet" type="text/css" />
<!-- to show a icon in url title icon -->
<link rel="shortcut icon" href="./images/icon.gif" >

<link href="css/calendar.css" rel="StyleSheet">
<script language="JavaScript" src="js/calendar.js"></script>
<script language="JavaScript" type="text/javascript">
<!--
// defult js functions start

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
// defult js functions end



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


    <tr>
      <td width="159" rowspan="2" align="left" valign="top" class="menu_back">
<?php
print show_menu();?></td>
     <td width="100%" height="30"  class="head_with_back_button">
<?php print get_table_link("Open report","empicon.jpg");?>
</td>
	</tr>





<tr>
    <td width="791" height="500" align="center" valign="top" cellpadding="2"  class="main_content_p">
	
    <table width="100%" border="1" cellspacing="0" cellpadding="0" >

<?php if($message!="") {?>
		<tr align="left">
				<td colspan="5" height="30px" style=" color:#FF0000;" ><?php echo $message;?></td>
		</tr>
<?php } ?>

	<tr align="left">
		<td colspan="5" height="30px" class="table_head">
			<?php 
			
			echo (($emp_power['is_admin']=='1') || ($emp_power['is_hod'] =='1') || ($emp_power['is_hr'] =='1') || ($emp_power['is_super'] =='1'))?"<a href=\"openreport.php\" ><img width=\"11\" border=\"0\" height=\"14\" src=\"".$_SESSION['FOLDER']."add_new.jpg\"/></a>&nbsp;<a href=\"openreport.php\" >Add New openreport</a>":"&nbsp;" ?>
		</td>
	</tr>

					
					<tr align="center" valign="middle" style="background-color: rgb(205, 205, 205);">
						<th>Opened to </th><th>Opened by </th><th>Date</th><th>Entered on</th><th>Options</th>						
						</tr>	

     
      	  	 
	  
      <?php 
	   // print getopenreports();
print $data['tables'];
    ?>
    <tr>
												<td align="left" nowrap height="30"> &nbsp;
													<?php
														if($pre>=0)
														{
													?>
															<a href="viewopenreports.php?s=<?php print $pre;?>" title="Go to previous set of data " ><< Pre</a>
													<?php
														} 
													?>
												</td>
												<td colspan="3" align="center">***</td>
												<td align="right" nowrap> &nbsp;
													<?php
														//print $next."".$data['total_count'];
														if($next<$data['total_count'])
														{
													?>
															<a href="viewopenreports.php?s=<?php print $next;?>" title="Go to next set of data " >Next >> &nbsp;&nbsp;</a>
													<?php
														} 
													?>
												</td>
											</tr>
    </table>
</tr>

   <tr>
      <td colspan="4" align="center" valign="middle" class="Footer_txt">
	<?php echo footer();?></td>
   </tr>

</table>

</div>
</body>
</center>
</html>
