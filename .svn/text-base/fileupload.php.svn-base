<?php
require_once('include/include.php');
$_SESSION['SEL_LINK']="FLV";
require_once('include/parameters.php');
$userid = $_SESSION['USERID'];   
$emp_power = emp_authority($userid);  
$target_path = "attendance/".rand(0,99999999); // no trailing slash coz we need to prepend a random number with the file name to make it unique.
require_once('include/attendance_function.php'); 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php print $company_name;?> - Activity List</title>
<link href="css/reporting.css" rel="stylesheet" type="text/css" />
<!-- to show a icon in url title icon -->
<link rel="shortcut icon" href="./images/icon.gif" >
<script language="JavaScript" src="js/validate.js" type="text/JavaScript"></script>


<link href="css/viewreport.css" rel="stylesheet" type="text/css" />
<link href="css/calendar.css" rel="stylesheet" type="text/css" />

<script language="JavaScript" type="text/JavaScript"> 
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
        if(document.getElementById('activityname').value=='')
           {
               alert("Please enter Activity Name");
		       return true;    
           } 
		    document.getElementById('delid').value='';
		    document.getElementById('frmactivity').submit(); 
}		
</script>
</head>
<center>
<body onload="MM_preloadImages('images/Home_Over.jpg','images/Dep_Over.jpg','images/Emp_Over.jpg','images/Sch_Over.jpg','images/Acti_Over.jpg','images/Vali_Over.jpg','images/View_Over.jpg','images/Daily_Over.jpg','images/Change_Over.jpg','images/Log_Over.jpg')">
<div id="main_div">
<table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
		<tr>
		<td height="101" colspan="2" align="left" valign="middle" class="Head">
		<img src="images/Compy_logo.jpg" alt="" width="195" height="68" />
		</td>
		</tr>
			
			
		<tr>
		<td width="159" rowspan="2" align="left" valign="top">
		<?php print show_menu();?>
		</td>
		<td width="100%" height="30" align="right" valign="top" bgcolor="#D1D1D3">
		<?php print get_table_link("File Upload","acticon.jpg");?>
		</td>
		</tr>

<tr>
<td width="659" height="500" align="center" valign="top">
					<br>
	<table class="Tbl_Txt_bo" width="70%" cellspacing="1" cellpadding="3" border="0" id="list_activity">
					<tr>
						<td colspan="8" class="Date_txt" bgcolor="#D6D6D7" style="border-bottom:#666666 1px solid;" align="left" >
						<a href="activity.php?actid=0"><img width="11" border="0" height="14" src="<?php print $_SESSION['FOLDER'];?>add_new.jpg"/></a>&nbsp;&nbsp;<a href="activity.php?actid=0">Add new file</a>
					</td>
					</tr> 
					<tr>
					<td align="right"   class="menu_txt"><label for="activitydesc">
					File Upload :</label>
					</td>
					 <td colspan="1"> 
					 		<?php
		if($emp_power['is_superadmin'] ==1 || $emp_power['is_admin'] ==1 ||  ($emp_power['is_hr']==1)) { ?>
					<form id="frmfile" name="frmfile" method="POST" action="fileupload.php" enctype="multipart/form-data">
					 <input type="file" name="uploadedfile" id="uploadedfile" />
					<input type="submit" id="btnsave" name="btnsave" value="Submit For Validation"  />
						<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
</form>
<?php } ?>
						</td>
					</tr> 
					<tr><td colspan="2"><?php 
					if($fileflag == 1){ 
					 $fil=readcsvfile($fileName ); 
					 deleteattendance();
					 for($i=1; $i < (sizeof($fil)-1) ; $i++ ){
					 	$data=explode(';', $fil[$i]); 
					 	inserttodb($data);
					 	updateattendance();
					}
		}		 
					?>
					
					<style >
					.tdat{		background-color:#D3D3D3; 	font-size:11px; font-weight:normal;	}
					.tdat:hover{		background-color:#DAE4E7; 			font-size:11px; font-weight:normal;}
					.in{ color :#199D00; }
					.out{ color:#E16B00; }
					.less{  color: #E1000C;}
					.oke{  color:  #006A03;  }
					</style>
					<hr></hr>
					<div align="right"> 
					<input type="button" value="Print this page"  onClick="window.print();"/>
					<a href="attendance/index.php" />
					<input type="button" value="Export as EXCEL File" />
					</a>
					</div>
					<table width="100%" border="0"cellspacing="2"> 
					<tr>
					<th align="center" >Dept</th>
					<th align="center" >Name</th>
					<th align="center" >Date</th>
					<th align="center" >Shift</th>
					<th align="center" >In 1</th>
					<th align="center" >Out 1</th>
					<th align="center" >In 2</th>
					<th align="center" >Out 2</th>
					<th align="center" >In 3</th>
					<th align="center" >Out 3</th>
					<th align="center" >Hour</th>
					<th align="center" >Leave / Permission</th>
					<th align="center" >Remarks</th>
					<th align="center" >Day / Time</th>
					</tr>
					<?php 
		$getdata =" select * from attendance order by date ";
$view_result = $GLOBALS['db']->query($getdata); 
 if(isset($view_result) and $view_result->num_rows>0) { 
					while($view = $view_result->fetch_assoc()){			
						?>
						 <tr class="trat">
					        <td class="tdat" align="center"  ><?php print  $view ['department'];?></td>
					        <td class="tdat" align="center"  ><?php print  $view ['name'];?></td>
					        <td class="tdat" align="center"  ><?php print  ymdtodmy($view ['date']);?></td>
					        <td class="tdat" align="center"  ><?php print  $view ['shift'];?></td>
					        <td class="tdat in" align="center"  ><?php print  $view ['timein1'];?></td>
					        <td class="tdat out" align="center"  ><?php print  $view ['timeout1'];?></td>
					        <td class="tdat in" align="center"  ><?php print  $view ['timein2'];?></td>
					        <td class="tdat out" align="center"  ><?php print  $view ['timeout2'];?></td>
					        <td class="tdat in" align="center"  ><?php print  $view ['timein3'];?></td>
					        <td class="tdat out" align="center"  ><?php print  $view ['timeout3'];?></td>
					        <td class="tdat  <?php print (intval( $view ['hour']) < 8 )? "less": "oke" ;?>" align="center"  ><?php print  $view ['hour'];?></td>
					        <td class="tdat" align="center"  ><?php print  $view ['leavetype'];?></td>
					        <td class="tdat" align="center"  ><?php if($view ['remarks'] != ""){ print " <textarea readonly=\"true\">".$view ['remarks']."</textarea>"; 	} else{	print "&nbsp;";	} ?></td>
					        <td class="tdat" align="center"  ><?php print  $view ['days'];?></td>
					         
					    </tr>
						
						<?
					} // while
				}// if
				?>
					   
					</table> 
					<tr><td> 
					</td></tr>
			     </table>    
            </td>
        </tr>
    </table>
    </td>
      </tr>
   <tr>
      <td colspan="4" align="center" valign="middle" class="Footer_txt">
	<?php echo footer();?></td>
   </tr>
    </td>
  </tr>
</table> 
</div>
</body></center>


</html>

