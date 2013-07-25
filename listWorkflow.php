<?php 
require_once('include/include.php');
$_SESSION['SEL_LINK']="WRK";
require_once('include/parameters.php');
require_once('include/workflow_functions.php');
$emp_power=emp_authority($_SESSION['USERID']);	   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Prime Move Technologies (P) Ltd.</title>
<link href="css/reporting.css" rel="stylesheet" type="text/css" />
<!-- to show a icon in url title icon -->
<link rel="shortcut icon" href="./images/icon.gif" >

<script language="JavaScript">
// defult js functions

function MM_swapImgRestore()
{ //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages()
{ //v3.0
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
function newWindow(wid)
{
	window.open('replyWorkflow.php?wid='+wid,'welcome','height=500,width=500,scrollbars=yes,fullscreen=no,location=yes,status=yes');
}
//-->
</script>
</head>
<center>
<body onload="MM_preloadImages('images/Home_Over.jpg','images/Dep_Over.jpg','images/Emp_Over.jpg','images/Sch_Over.jpg','images/Acti_Over.jpg','images/Vali_Over.jpg','images/View_Over.jpg','images/Daily_Over.jpg','images/Change_Over.jpg','images/Log_Over.jpg')">



<div id="main_div">
<table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">

	<tr>
      <td height="101" colspan="2" align="left" valign="middle" class="Head"><img src="images/Compy_logo.jpg" alt="" width="195" height="68" /></td>
      </tr>

    <tr>
      <td width="159" rowspan="2" align="left" valign="top" class="menu_back">
       
      <?php print show_menu(); ?>
      </td>
      <td width="100%" height="30" valign="top"  class="head_with_back_button">
      <?php print get_table_link("Workflow","depicon.jpg");?>
      </td>
	</tr>
<!-- side menu Left end	edietd by **** **** -->
<!-- then form contaminater table in the next row  edietd by **** **** -->
	<tr>
	<td width="100%" height="580"  align="center" valign="top">
	<form action="" method="POST" id="frmdepartment" >
	<table border="1" cellspacing="0" cellpadding="0" width="80%">
					<br>
    <tr>
	 <td valign="top">
					
	<table style="border-color: #595959; border-style:solid; border-width:0px;" cellspacing="1" cellpadding="3" width="100%">

    
 	<tr align="left">
		<td colspan="5" height="30px"  class="table_head">
		<?php echo "<a href=\"workflow.php\" ><img width=\"11\" border=\"0\" height=\"14\" src=\"images/add_new.jpg\"/></a>&nbsp;&nbsp;<a href=\"workflow.php\" >Add New Workflow</a>"; ?></td>
	</tr>
				<?php if(isset($_GET['msg'])) { 
					echo "<tr><td colspan=\"4\" class=\"warn\" align=\"center\" >";
					if($_GET['msg']==1) {
						echo "Workflow edited successfully";
                    }
                    else if($_GET['msg']==0){ echo "Workflow added successfully";
                    } 
                    else if($_GET['msg']==2){ echo "Workflow deleted successfully";
                    }
                    else if($_GET['msg']==3){ echo "Error occured";
                    }
					echo "</td></tr>";} ?>

	<tr  valign="middle" style="background-color:#CDCDCD;">
		<th   align="center">Sl No</th>
		<th  align="center">Subject</th>
		<th  align="center">Description</th>
		<th  align="center">Date</th>
		<th  align="center">Edit/Reply</th>
	</tr>
	<?php 
	$getFlow=viewWorkflow();
	print  $getFlow;
	 ?>
	</table>
	</td>
	</tr>
	</table>
	</form>
	</td>
	</tr>
   <tr>
      <td colspan="5" align="center" valign="middle" class="Footer_txt">
	<?php echo footer();?></td>
   </tr>
<!-- end footer coded by ***  *** -->
  </table>
</div>
</body>
</center>
</html>
