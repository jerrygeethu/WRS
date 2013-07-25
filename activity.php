<?php

require_once('include/include.php');
$_SESSION['SEL_LINK']="ASACT";
require_once('include/parameters.php');
require_once('include/class.schactivity.php');

$schactivity = new schactivity();

if(isset($_GET['dep']))
{
     $departid = $_GET['dep'];
}



$userid = $_SESSION['USERID'];   

$emp_power = emp_authority($userid);

//print_r( $emp_power);
//$schactivity ->getDepartmentForSch($emp_power);
	//print_r($_POST['schemployee']);

if(isset($_GET['actid']) || isset($_POST['editid'])){

   $actid=$_GET['actid']?$_GET['actid']:$_POST['editid'];
   $actrow  = $schactivity->getActivity($actid);
   
}

 $actdepart =(isset($actrow['departmentid']) && $actrow['departmentid']!='')?$actrow['departmentid']:$departid;
 
    if (isset($_POST['editid'])  AND $_POST['delid']=='')     {
		
	
      
      //`scheduleid``supervisorid``description``schfromdate``schtodate``schstatus``schcomment`
       $actid = isset($actid)?$actid:null;
       $actname = isset($_POST['activityname'])?$_POST['activityname']:null;
       $actdesc = isset($_POST['activitydesc'])?$_POST['activitydesc']:null;
       $actissch = isset($_POST['isschedule'])?$_POST['isschedule']:null;
       $depid = isset($_POST['departmentid'])?$_POST['departmentid']:null;
      
  
      $schactivity->saveActvityData($actid,$actname,$actdesc,$actissch,$depid);
      
	
	}
 if(isset($_POST['delid']) AND $_POST['delid']!=''){
          
          $schactivity->deleteActData($_POST['delid']);
      }
 
 
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
		
	
function deleteSch()
{
    	if(confirm("Are you sure to delete this record ...?")==true){
			if(document.getElementById('editid').value != ""){
				document.getElementById('delid').value=document.getElementById('editid').value;
				document.getElementById('editid').value = "";
				document.getElementById('frmactivity').submit();
			}
		}
}
function ChangeDepart(){
    
//alert("here="+document.getElementById('editid').value);
if(document.getElementById('editid').value=="0")
	document.location.href="activity.php?dep="+document.getElementById('departmentid').value;

}

</script>



</head>
<center>
<body onload="MM_preloadImages('images/Home_Over.jpg','images/Dep_Over.jpg','images/Emp_Over.jpg','images/Sch_Over.jpg','images/Acti_Over.jpg','images/Vali_Over.jpg','images/View_Over.jpg','images/Daily_Over.jpg','images/Change_Over.jpg','images/Log_Over.jpg')">




<div id="main_div">

<table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">

<!--  Start top banner	edietd  by **** hmsqt@gmail.com **** -->
	<tr>
      		<td height="101" colspan="2" align="left" valign="middle" class="Head">
			<img src="images/Compy_logo.jpg" alt="" width="195" height="68" />
		</td>
      </tr>
<!-- end top banner edietd by **** hmsqt@gmail.com **** -->



<!-- side menu Left start edietd by  **** hmsqt@gmail.com **** -->
    <tr>
      <td width="159" rowspan="2" align="left" valign="top">

	<?php print show_menu();?>


	</td>
      	<td width="100%" height="30" align="right" valign="top" bgcolor="#D1D1D3">

	<?php print get_table_link("Activity Type","acticon.jpg");?>

	</td>
    </tr>
<!-- side menu Left end	edietd by **** hmsqt@gmail.com **** -->

<tr>
    <td width="659" height="500" align="center" valign="top">
    <br>
    <form id="frmactivity" name="frmactivity" method="POST" action="activity.php">
	<table class="Tbl_Txt_bo" width="70%" cellspacing="1" cellpadding="3" border="0" id="list_activity">
		

		<tr>
			<td colspan="8" class="Date_txt" bgcolor="#D6D6D7" style="border-bottom:#666666 1px solid;" align="left" >
			<a href="activity.php?actid=0"><img width="11" border="0" height="14" src="<?php print $_SESSION['FOLDER'];?>add_new.jpg"/></a>&nbsp;&nbsp;<a href="activity.php?actid=0">Add new Activity</a>
			</td>
		</tr>
		
		



			      <?php 
			      echo '<tr>
			                <td width="200px" align="right"  class="menu_txt" ><label for="departmentid">
			                 Department  :</label>
			              </td>
			             <td colspan="7" align="left">';
			         // if($emp_power['isadmin']==1 || $emp_power['is_superadmin']==1){
			             
			             echo $schactivity->getDepForActivity($emp_power,$actdepart);
                      
                     // }
			      echo '</td>
			            </tr>';
			           
			          
			      ?>
		               <tr>
			            <td align="right"  class="menu_txt"><label for="activityname">
			            Activity Name :</label>
			            </td>
			             <td colspan="1">
			             <input type="text" style="width:250px;" id="activityname" name="activityname" value="<?php echo $actrow['activityname'] ?>" /> 
			            </td>
			           
			     		</tr> 
			           <tr>
			            <td align="right"   class="menu_txt"><label for="activitydesc">
			            Activity Description :</label>
			            </td>
			             <td colspan="1">
			             <textarea id="activitydesc" name="activitydesc" style='width:250px;height:80px;'><?php echo $actrow['activitydesc'] ?></textarea>
			            </td>
			           
			     		</tr>
			 <tr>
			    <td align="right" class="menu_txt"><label for="isschedule">Activity Schedulable : </label></td>
                <td align="left">
			    <input type="checkbox" name="isschedule" id="isschedule"   value="1" 
			     <?php /*if($emp_power['is_superadmin']!=1) echo "disabled=\"true\"";*/  if(isset($actrow['isschedule']) && $actrow['isschedule']=="1")  echo "checked=\"true\""; ?> >			</td>
		</tr>	
			         
			     <tr>
						<td colspan="4" align="center">
						<input type="button" id="btnsave" value="Save" onclick="checkall()" />
						<?php
						if(isset($_GET['actid'])) echo "<input type=\"button\" id=\"btndel\" value=\"Delete\" onclick=\"deleteSch()\" />";
						?>
						<input type="reset" value="Clear" />
						<input type="hidden" name="editid" id="editid" 	value="<?php echo isset($actid)?$actid:'0'; ?>" />
						<input type="hidden" name="delid" id="delid" 	value="" />
											
						</td>
					</tr>
					
					<?php if(isset($_GET['ins'])) { 
					echo "<tr><td colspan=\"4\" class=\"warn\" align=\"center\" >";
					if($_GET['ins']==1) {
						echo "Schedule Added Successfully";
                    }
                    else if($_GET['ins']==0){ echo "Insert Failed";
                    } 
					echo "</td></tr>";} ?>
			     </table>
   
    </form>

    <br>
	
    <table align="center" width="100%">
        <tr>
         <td  align="center">
         <table class="Tbl_Txt_bo" width="75%" align="center" cellspacing="0" cellpadding="0" border="0" id="list_activity">
           <?php if(isset($_GET['error'])){
             echo "<tr>
                  <td class=\"warn\" colspan=\"6\" align=\"center\"  >";
                  echo ($_GET['error']=='del')?"Cannot be Deleted":"";
                  echo "</td></tr>";
           } ?>
            <tr>
                  <td height="20px" colspan="6" align="center" class="table_heading" >List of Activity Type</td>
            </tr>
             
            <tr width="100%">
              <td colspan="6" align="center">
           <div align="center" style="overflow:-moz-scrollbars-vertical;overflow-y:scroll; WIDTH: 99%; HEIGHT: 330px; " width="100%">
                <table width="97%" border="1"  cellspacing="0" cellpadding="2" align="center"   cellpadding="1" id="data">
                      
				<tr width="100%"  bgcolor="#cdcdcd" >
                <td align="center" class="main_matter_txt" width="50px">Sl No</td>
                <td align="center" class="main_matter_txt" width="200px">Activity</td>
                <td align="center" class="main_matter_txt" width="200px">Description </td>
                <td align="center" class="main_matter_txt" width="210px">Is Schedulable</td>
                <td align="center" class="main_matter_txt" width="210px">Department</td>
                 
                </tr>                        
                        <?php  $schactivity->viewActivityList($actdepart,$emp_power); ?>
                        
                 </table>
		        </div>
		       
                </td>
            </tr>
		</table>
            </td>
        </tr>
    </table>
    </td>
      </tr>
<!-- start footer coded by *** hmrsqt@gmail.com *** -->
   <tr>
      <td colspan="4" align="center" valign="middle" class="Footer_txt">
	<?php echo footer();?></td>
   </tr>
<!-- end footer coded by *** hmrsqt@gmail.com *** -->
    </td>
  </tr>
</table>

</div>
</body></center>


</html>
