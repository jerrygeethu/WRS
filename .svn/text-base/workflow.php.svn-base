<?php
require_once('include/include.php');
$_SESSION['SEL_LINK']="WRK";
require_once('include/parameters.php');
require_once('include/workflow_functions.php');
$userid = $_SESSION['USERID'];   
$emp_power = emp_authority($userid);
if(isset($_GET['editID']))
{
	$editid=$_GET['editID'];
	$data=Workflow($editid);
	if(!(isset($_GET['dep'])))
	{
	$_SESSION['WF_EMP']=$data['emps'];	
	}
	$arrFiles=explode(",",$data['file1']);	
}

	$arrFiles1=isset($arrFiles)?$arrFiles:array();
	//on selecting department
	if(isset($_GET['dep']))
	{
		$depid=$_GET['dep'];
	}
	else
	{ 
		$depid=$emp_power['emp_deptid'];	
	}
					

if(isset($_POST['subject']))
{
	$delete=$_POST['delid'];
	$edit=$_POST['editid'];
	$subject=$_POST['subject'];
	$desc=$_POST['description'];
	$emplist=$_POST['wfemployee'];
	$status=$_POST['status'];
	$chk1=isset($_POST['chk1'])?$_POST['chk1']:array();
	$chk2=isset($_POST['chk2'])?$_POST['chk2']:array();
	$chk3=isset($_POST['chk3'])?$_POST['chk3']:array();	
	$chk_merge=array_merge($chk1,$chk2,$chk3);	
	$chk_files=implode(",",$chk_merge);
	
	$random_digit=rand(0,9999);
	$newfile=$HTTP_POST_FILES['newfile']['name'];	
	if($newfile!="")
	{
		$new_file_name=$random_digit.$newfile;
		$target_path1 = "workflow/".$new_file_name;
		move_uploaded_file($_FILES['newfile']['tmp_name'], $target_path1);
	}
	else
	{
		$new_file_name="";
	}
	
	//echo "subject=".$subject."<br/>desc=".$desc."<br/>emplist=".printarray($emplist)."<br/>status=".$status."<br/>chk_files=".$chk_files."<br/>newfile=".$newfile."<br/>edit=".$edit."<br/>del=".$delete;
	$result=insertWorkflow($_POST,$chk_files,$new_file_name,$edit,$delete);	
}


$data['selected_employees']=isset($_SESSION['WF_EMP'])?$_SESSION['WF_EMP']:"";
$data['selected_department']=$depid;
$wf_sel_emp=get_selected_employees($data); 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php print $company_name;?> - Workflow</title>
<link href="css/reporting.css" rel="stylesheet" type="text/css" />
<link href="css/calendar.css" rel="StyleSheet" type="text/css" />
<!-- to show a icon in url title icon -->
<link rel="shortcut icon" href="./images/icon.gif" >
<script language="JavaScript" src="js/calendar.js" type="text/JavaScript"></script>
<script language="JavaScript" type="text/javascript"  src="js/selectbox.js"> </script>
<script language="JavaScript" type="text/javascript"  src="js/validate.js"> </script>
<script language="JavaScript" src="js/callAjax.js" type="text/javascript"></script>

</head>
<center>
<body onload="MM_preloadImages('images/Home_Over.jpg','images/Dep_Over.jpg','images/Emp_Over.jpg','images/Sch_Over.jpg','images/Acti_Over.jpg','images/Vali_Over.jpg','images/View_Over.jpg','images/Daily_Over.jpg','images/Change_Over.jpg','images/Log_Over.jpg')">
<div id="main_div">
<table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
	<tr>
		<td height="101" colspan="2" align="left" valign="middle" class="Head">
		<img src="images/Compy_logo.jpg" alt="" width="195" height="68" />		</td>
      </tr>
    <tr>
      <td width="159" rowspan="2" align="left" valign="top" class="menu_back">
        <?php        
        $menu = show_menu();
        print $menu;
       ?>      </td>
      <td width="100%" height="30"   class="head_with_back_button">			      
       <?php 
      print get_table_link("Workflow","scheicon.jpg");
      ?>      </td>
    </tr>	
	<tr>
	<td align="center" valign="top">	
	 <form  action="workflow.php" method="POST" enctype="multipart/form-data" name="frmWrkflow" id="frmWrkflow">		 
	   <table width="60%" class="Tbl_Txt_bo"  cellspacing="1" cellpadding="2" border="0" id="list_employees">
        <tr align="left">
		<td height="30px" colspan="4" class="table_head">
	<a href="listWorkflow.php" ><img width="11" border="0" height="14" src="<?php echo $_SESSION['FOLDER'];?>add_new.jpg"/></a>&nbsp;<a href="listWorkflow.php" >Back to Workflow</a></td>
		</tr>	
		 
         <tr>
           <td align="right" class="Form_txt">Department :</td>
           <td colspan="3"><select name="dept" id="dept" title="Department list" style='width:170px;' onchange="javascript:changeDepart();" >
               <?php
				$depList=depList($depid);
				print $depList;
				?>
             </select>           </td>
         </tr>
         <!-- multiple select box -->
         <tr>
			<td align="right" class="Form_txt">Choose Employees :</td>
			<td width="34%"  align="left">
			<select name="fldemployee" id="fldemployee" size="10" multiple="multiple" title="Employee list" style='width:170px;height:160px;'>
			<?php
			$viewemp=empList($depid);
			print $viewemp;
			?>
			</select>
			</td>
			<td width="14%"><input name="button" type="button" style="background-image:url(images/right.jpg);width:35px;height:25px;"  title="Move right" onclick="addSelected();" value="+"/>   <!-- onclick="addSelected();"-->
			<br/>
			<br/>
			<input name="button" type="button" style="background-image:url(images/left.jpg);width:35px;height:25px;"  title="Move left" onclick="removeSelected();" value="-"/>       <!-- onclick="removeSelected();"-->
			</td>
			<td width="28%" align="left">
			<div id="selected_employees">
				<?php 
				print empty($wf_sel_emp)?"":$wf_sel_emp;	
				?>	 
			</div>
			</td>
         </tr>
         <!-- select box-->
         <tr>
           <td width="24%" align="right" class="Form_txt">Subject :</td>
           <td colspan="3">
		   <input type="text" name="subject" id="subject" value="<?php echo (isset($data['subject']))?$data['subject']:""; ?>"/>
		   <input type="hidden" name="hdSubject" id="hdSubject" value="<?php echo (isset($data['subject']))?$data['subject']:""; ?>"/>
		   </td>
         </tr>
         <tr>
           <td align="right" class="Form_txt">Description :</td>
           <td colspan="3"><textarea id="description" name="description" style='width:220px;height:60px;' ><?php echo (isset($data['description']))?$data['description']:""; ?></textarea>           </td>
         </tr>
         <tr>
           <td  align="right" class="Form_txt">File :</td>
		   <td colspan="3">
		   <div style='width:220px;height:200px;overflow:auto;border:1px solid #000000;'>
		   <?php
		   
			  $fileQuery="select file1,file2,file3 from fileshare where uploadby='".$userid."' and status='active'";
			  $fileResult=$GLOBALS['db']->query($fileQuery);
			  while($fileRow=$fileResult->fetch_assoc())
			  {
			   
					if($fileRow['file1']) { echo "<input type=\"checkbox\" name=\"chk1[]\" value=\" ".$fileRow['file1']."\" ";
					if(inarraycheck($fileRow['file1'],$arrFiles1)){ 
					echo "checked=\"true\" "; 
					} 
					 echo " /> ".$fileRow['file1']."<br/>";  
					 }
					if($fileRow['file2']) { echo "<input type=\"checkbox\" name=\"chk2[]\" value=\" ".$fileRow['file2']."\"  ";
					if(inarraycheck($fileRow['file2'],$arrFiles1)) { 
					echo "checked=\"true\" "; 
					} 
					 echo " /> ".$fileRow['file2']."<br/>";
					 }			
					 if($fileRow['file3']) { echo "<input type=\"checkbox\" name=\"chk3[]\" value=\" ".$fileRow['file3']."\" ";
					if(inarraycheck($fileRow['file3'],$arrFiles1)) { 
					echo "checked=\"true\" "; 
					} 
					echo " /> ".$fileRow['file3']."<br/>"; }
			   } 
			   ?>
		 	</div>
			</td>         
			</tr>
			<tr>
			<td class="Form_txt"></td><td colspan="3">
			<?php if($data['newfile']) { ?><a href="workflow/<?php echo $data['newfile'];?>" target="_blank"><?php echo $data['newfile']; ?></a> <?php } ?>
			<input type="file" name="newfile" id="newfile"/>
			</td>
			</tr>
			<tr>
			<td  align="right" class="Form_txt">Status :</td>
			<td>			
		   <select name="status">
            <?php
			$status=isset($data['status'])?$data['status']:"";			
			$list=liststatus($status);
			print $list;
			 ?>
            </select>
			</td>
         </tr>
         <tr>
           <td colspan="4" align="center">
		   <input name="button" type="button" id="btnsave" title="Send Workflow"  onclick="javascript:checkall();" value="Save"/>
		   <input type="hidden" name="editid" id="editid" value="<?php echo $editid;?>"/>
		   <?php 										
			if($_GET['editID']!="")
			{
				echo "<input type=\"button\" id=\"btndel\" value=\"Delete\" onclick=\"deleteWf()\" />";
			} 
			?>
			<input type="hidden" name="delid" id="delid" 	value="" />
		   </td>
         </tr>
         <br />
       </table>
	 </form>
    <br>
    <!-- <table class="Tbl_Txt_bo" cellspacing="0" cellpadding="0" border="0" width="60%">
        <tr>
            <td width="100%">
                <table cellspacing="0" cellpadding="0" border="0" style="border-color:#339900;" width="100%" align="center" >
           <?php if(isset($_GET['error'])){
             	echo "<tr>
                <td class=\"warn\" colspan=\"6\" align=\"center\"  >";
                echo ($_GET['error']=='del')?"Cannot be Deleted":"";
                echo "</td></tr>";
           } ?>
           
           
            <tr width="100%">
                  <td colspan="6" height="30px" align="center" class="subhead" >Workflow List</td>
            </tr>            
            <tr width="100%">
             <td  align="center">
               <div width="98%" align="center" style="overflow:auto;WIDTH: 100%; HEIGHT: 330px; ">
           		 <table width="99%" border="1"  cellspacing="0" cellpadding="2" align="center"  id="data">
                 <tr width="100%"  >
                <th align="center"  width="50px">No:</th>
                <th align="center"  width="200px">Subject</th>
                <th align="center"  width="200px">Description </th>
                <th align="center"  width="210px"> Date</th>               
                <th align="center"  width="200px">Status</th>           
             	</tr>                       
				<?php
				$getFlow=getWorkflow();
				print  $getFlow;
				 ?>                        
                </table>
		        </div></td> </tr></table> </td> </tr></table>	-->
               
    </td>
	</tr>
<tr>
<td height="30" colspan="4" align="center" valign="middle" bgcolor="#D1D1D3" class="Footer_txt">
Copyright &copy; 2009 Prime Move Technologies (P) Ltd. All Rights Reserved.</td>
</tr>
</table>
</td>
</tr>
</table>
</div>
</body>
</center>

<script language="JavaScript">
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
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function addSelected()
{	
	var list="";	
	var aOptions=document.frmWrkflow.fldemployee.options;
	for(var i=0; i<aOptions.length; i++)
	{		
	  	if(aOptions[i].selected)
		{ 
			if(list!=""){list+=",";}
			list+=aOptions[i].value; //arrlist[i]=aOptions[i].value;										
        }	
    }
	list=escape(list);
	url="new.php?flag=1&list="+list;
	id="selected_employees";
	fnShowData(url,id,'0',true);
}
function removeSelected()
{
	var rlist="";
	var aOptions=document.frmWrkflow.wfemployee.options;
	for(var i=0; i<aOptions.length; i++)
	{		
	  	if(aOptions[i].selected)
		{ 
			if(rlist!=""){rlist+=",";}
			rlist+=aOptions[i].value; //arrlist[i]=aOptions[i].value;										
        }	
    }	
	rlist=escape(rlist);
	url="new.php?flag=2&rlist="+rlist;
	id="selected_employees";
	fnShowData(url,id,'0',true);
}
function checkall()
{

	var otherdep=document.getElementById('wfemployee');	
	if(otherdep!=null)
	{
		for(var k=0;k<otherdep.options.length;k++)
		{
			otherdep.options[k].selected=true;
		}
	}


	if(document.getElementById('wfemployee').value=="")
	{
		alert("Select employees");
		document.getElementById('wfemployee').focus();
		return true; 
	}
	else if(document.getElementById('subject').value=="")
	{
		alert("Enter subject");
		document.getElementById('subject').focus();
		return true; 
	}
	else if(document.getElementById('description').value=="")
	{
		alert("Enter description");
		document.getElementById('description').focus();
		return true; 
	}	
	document.getElementById('frmWrkflow').submit();
}
 		

function changeDepart()
{
	/*hdSubject=document.getElementById('hdSubject').value;	
	if(hdSubject!="")
	{
		document.getElementById('subject').value=hdSubject;
	}*/
	depid=document.getElementById('dept').value;
	//editid=document.getElementById('editid').value
	document.location.href="workflow.php?dep="+depid+"<?php print ($editid=="")?"":"&editID=".$editid."";?>";
}
function deleteWf()
{
    	if(confirm("Are you sure to delete this record ...?")==true)
		{
			if(document.getElementById('editid').value != "")
			{
				document.getElementById('delid').value=document.getElementById('editid').value;
				document.getElementById('editid').value = "";
				document.getElementById('frmWrkflow').submit();
			}
		}
}



function newWindow()
{
window.open('wfFile.php','welcome','height=500,width=500,scrollbars=yes,fullscreen=no,location=yes,status=yes');
}

</script>
</html>
