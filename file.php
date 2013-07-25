<?php 
	require_once('include/include.php');
	$_SESSION['SEL_LINK']="FIL";
	require_once('include/parameters.php');
	require_once('include/class.file.php');
	$objfile = new fileshare();
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

function edit_file(fileshareid)
{
	if(fileshareid!="")
	{
		document.location.href="editfile.php?edit="+fileshareid;
	}
}


/*
function  fun()
{
	alert("hii");
}
*/




function myPopup(fileshareid) 
{
	//alert(fileshareid);
	window.open('include/readmore.php?pop='+fileshareid,'welcome','height=500,width=500,scrollbars=yes,fullscreen=no,location=yes,status=yes'); 
}

function myPopup1(fileshareid) 
{
	window.open('include/names.php?pop='+fileshareid,'welcome','height=500,width=500,scrollbars=yes,fullscreen=no,location=yes,status=yes'); 
}

// defult js functions

function MM_swapImgRestore() 
{ //v3.0
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
<table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
<!--  Start top banner edietd by  ****  ****	 -->
	<tr>
      <td height="101" colspan="2" align="left" valign="middle" class="Head"><img src="images/Compy_logo.jpg" alt="" width="195" height="68" /></td>
    </tr>
<!-- end top banner  edietd by  ****  **** -->


<!-- side menu Left start edietd by  ****  **** -->
    <tr>
      <td width="159" rowspan="2" align="left" valign="top" class="menu_back">
       
      <?php print show_menu(); ?>
      </td>
      <td width="100%" height="30" valign="top"  class="head_with_back_button">
      <?php print get_table_link("File Upload","depicon.jpg");?>
      </td>
	</tr>
<!-- side menu Left end	edietd by **** **** -->
<!-- then form contaminater table in the next row  edietd by **** **** -->
	<tr>
	<td width="100%" height="580"  align="center" valign="top">
	<form action="file.php" method="POST" id="frmfile" >
	<table border="1" cellspacing="0" cellpadding="0" width="80%">
					<br>
    <tr>
	 <td valign="top">
					
	<table style="border-color: #595959; border-style:solid; border-width:0px;" cellspacing="1" cellpadding="3" width="100%">

    
 	<!--<tr align="left">
		<td colspan="4" height="30px"  class="table_head">
		</tr>-->
		<?php
			if (($emp_power['is_superadmin']=='1')  || ($emp_power['is_admin'] ==1) || ($emp_power['is_hr'] ==1) || ($emp_power['is_hod'] ==1))
			{		
		?>
				<tr align="left">
					<td colspan="10" height="30px"  class="table_head">
						<a href="editfile.php" ><img width="11" border="0" height="14" src="images/add_new.jpg"></a>
						<?php echo "&nbsp;&nbsp;"; ?>
						<a href="editfile.php" >Add New File</a>
						<?php echo "&nbsp;";?>
					</td>
				<tr/>
		<?php
			}
		?>
		
		<tr align="left" bgcolor='#FFFFFF'>
					<td>
						<label for="search">search </label>
					</td>
					<td align="left" colspan="3">
						<input type="text" id="search" maxlength="20"   onkeyup="return ismaxlength(this);" name="search" size="8px" value="<?php ?>" />
						<input type="submit" value="GO" id="btngo" name="btngo"/>
					</td>
				</tr>
		
		
		<tr  valign="middle" style="background-color:#CDCDCD;">
						<th   align="center">Sl No</th>
						<th  align="center">Upload By</th>
						<th  align="center">Upload To</th>
						<th  align="center">Topic</th>
						<th  align="center">Description</th>
						<th colspan="3" align="center">Files</th>
						<!--<th  align="center">File 2</th>
						<th  align="center">File 3</th>-->
						<!--<th  align="center">Privillage</th>-->
						<th  align="center">Expiring Date</th>
						<th  align="center">Edit</th>
		</tr>
		<?php
		
			$empid=$_SESSION['USERID'];
			$deptid=$emp_power['emp_deptid'];
			$currentdate=date("Y-m-d");	
			$query_emp="select fileshareid, employeeid, uploadby from fileshare where privillage='private' and status='active'";
			$result_emp= $GLOBALS['db']->query($query_emp);
			if(isset($result_emp) and $result_emp->num_rows>0) 
			{ 
				$fileshareid="";
				$employeeid_hod="";
				$uploadby="";
				while($row_emp = $result_emp->fetch_assoc())
				{	
					$employeeid="";
					$upload="";	
					$employeeid.=$row_emp['employeeid'].",".$row_emp['uploadby'];
					$upload.=$row_emp['uploadby'];
					$emp=(explode(",",$employeeid));
					//print_r($emp);
					if($employeeid_hod!="")
					{
						$employeeid_hod.=",";
					}
					$employeeid_hod.=$employeeid;
					if($uploadby!="")
					{
						$uploadby.=",";
					}
					$uploadby.=$upload;
					if(in_array($empid,$emp))
					{
						if($fileshareid!="")
						{
							$fileshareid.=",";
						}
						$fileshareid.=$row_emp['fileshareid'];
					}		
				}
			}
			//echo "fileshareid: ".$fileshareid."<br/>";	
			//echo "<br/>".$employeeid_hod."<br/>";
			if($emp_power['is_hod']==1)
			{
				$fileids="";
				$emphod1="";
				$hodemp="select employeeid from employee where employeeid in (".$employeeid_hod.") and departmentid='".$deptid."'";
				$res = $GLOBALS['db']->query($hodemp);
				if(isset($res) and $res->num_rows>0) 
				{
					
					while($row = $res->fetch_assoc())
					{	
						$emphod=$row['employeeid'];
						
						$getPvtFiles="select  fileshareid,employeeid,uploadby from fileshare where privillage='private' and status='active'";
						$res_file = $GLOBALS['db']->query($getPvtFiles);						
						while($row_file = $res_file->fetch_assoc())
						{	
							$pvtEmps=$row_file['employeeid'];
							$arrpvtEmps=explode(",",$pvtEmps);
							if(in_array($emphod,$arrpvtEmps))
							{
								if($fileids!="")
								{
									$fileids.=",";
								}
								$fileids.=$row_file['fileshareid'];
							}
						}							
								
					}
				}
			}	
						

			$query_dept="select distinct emp.departmentid from employee as emp where emp.employeeid in (".$employeeid_hod.")";
			$result_dept= $GLOBALS['db']->query($query_dept);
			if(isset($result_dept) and $result_dept->num_rows>0) 
			{
				$depart="";
				while($row_dept = $result_dept->fetch_assoc())
				{
					//echo $row_dept['departmentid']." ";
					if($depart!="")
					{
						$depart.=",";
					}
					$depart.=$row_dept['departmentid'];
				}
			}
			$query="";
			if(($emp_power['is_superadmin']==1))
			{
				$query.="select emp.fullname, file.uploadby, file.fileshareid, file.title, file.description, length(file.description) as length, file.file1, file.file2, file.file3, 
										 DATE_FORMAT(file.date,'%d-%m-%Y') as date, DATE_FORMAT(file.expiry,'%d-%m-%Y') as expiry, file.privillage,
										 file.uploadby from fileshare as file, employee as emp where file.status = 'active' and '" . $currentdate . "' 
										 <= file.expiry and emp.employeeid=file.uploadby";
			}
			elseif(($emp_power['is_hod']==1) && ($emp_power['is_superadmin']!=1))
			{
				if($fileids=="")
				{		
					$query.="select emp.fullname, file.uploadby, file.fileshareid, file.title, file.description, length(file.description) as length, file.file1, file.file2, file.file3, 
										 DATE_FORMAT(file.date,'%d-%m-%Y') as date, DATE_FORMAT(file.expiry,'%d-%m-%Y') as expiry, file.privillage,
										 file.uploadby from fileshare as file, employee as emp where file.status = 'active' and file.privillage = 'public' 
										 and '" . $currentdate . "' <= file.expiry and emp.employeeid=file.uploadby";
				}
				else
				{
					$query.="(select emp.fullname, file.uploadby, file.fileshareid, file.title, file.description, length(file.description) as length, file.file1, file.file2, file.file3, 
											 DATE_FORMAT(file.date,'%d-%m-%Y') as date, DATE_FORMAT(file.expiry,'%d-%m-%Y') as expiry, file.privillage,
											 file.uploadby from fileshare as file, employee as emp where file.status = 'active' and file.privillage = 'public' 
											 and '" . $currentdate . "' <= file.expiry and emp.employeeid=file.uploadby)
								union
							(select emp.fullname, file.uploadby, file.fileshareid, file.title, file.description, length(file.description) as length, file.file1, file.file2, file.file3, 
											 DATE_FORMAT(file.date,'%d-%m-%Y') as date, DATE_FORMAT(file.expiry,'%d-%m-%Y') as expiry, file.privillage,
											 file.uploadby from fileshare as file, employee as emp where file.status = 'active' and file.privillage = 'private' and
											 file.fileshareid in (".$fileids.") and '" . $currentdate . "' <= file.expiry and emp.employeeid=file.uploadby)
								union
							(select emp.fullname, file.uploadby, file.fileshareid, file.title, file.description, length(file.description) as length, file.file1, file.file2, file.file3, 
											 DATE_FORMAT(file.date,'%d-%m-%Y') as date, DATE_FORMAT(file.expiry,'%d-%m-%Y') as expiry, file.privillage,
											 file.uploadby from fileshare as file, employee as emp where file.status = 'active' and file.privillage = 'private' and
											 emp.departmentid in (".$deptid.") and '" . $currentdate . "' <= file.expiry and emp.employeeid=file.uploadby)";
				}
			}
			else
			{
				//echo $fileshareid."<br/>";
				//print_r($fileshareid);
				//echo "<br/>fileshareid: ".$fileshareid_size=sizeof($fileshareid);	
				//echo "<br/>".$fileshareid."<br/>";
						
			if($fileshareid=="")
			{					
				$query.= "select emp.fullname, file.uploadby, file.fileshareid, file.title, file.description, length(file.description) as length, file.file1, file.file2, file.file3, 
									 DATE_FORMAT(file.date,'%d-%m-%Y') as date, DATE_FORMAT(file.expiry,'%d-%m-%Y') as expiry, file.privillage,
									 file.uploadby from fileshare as file, employee as emp where file.status = 'active' and file.privillage = 'public' 
									 and '" . $currentdate . "' <= file.expiry and emp.employeeid=file.uploadby";
			}
			else
			{
				$query.= "(select emp.fullname, file.fileshareid, file.title, file.description, length(file.description) as length, file.file1, file.file2, file.file3, 
									 DATE_FORMAT(file.date,'%d-%m-%Y') as date, DATE_FORMAT(file.expiry,'%d-%m-%Y') as expiry, file.privillage,
									 file.uploadby from fileshare as file, employee as emp where file.status = 'active' and file.privillage = 'public' 
									 and '" . $currentdate . "' <= file.expiry and emp.employeeid=file.uploadby)
								 union
						 (select emp.fullname,file.fileshareid, file.title, file.description, length(file.description) as length, file.file1, file.file2, file.file3, DATE_FORMAT(file.date,'%d-%m-%Y') 
									 as date, DATE_FORMAT(file.expiry,'%d-%m-%Y') as expiry, file.privillage, file.uploadby from fileshare as file, employee as emp 
									 where file.status='active' and '" . $currentdate . "' <= file.expiry and emp.employeeid=file.uploadby and file.fileshareid in (".$fileshareid."))
								 union 
						 (select emp.fullname, file.fileshareid, file.title, file.description, length(file.description) as length, file.file1, file.file2, file.file3,DATE_FORMAT(file.date,'%d-%m-%Y') 
									 as date, DATE_FORMAT(file.expiry,'%d-%m-%Y') as expiry, file.privillage, file.uploadby from fileshare as file,employee as emp 
									 where file.uploadby='".$empid."' and file.status='active' and '" . $currentdate . "' <= file.expiry and emp.employeeid=file.uploadby)";
				}
			}
										$result= $GLOBALS['db']->query($query);
										//echo $result1->num_rows;
										$total_pages = $result->num_rows;
										//echo "<br/>total_pages : ".$total_pages."<br/>";	
								$adjacents = 3;
								$limit=15;
								$page = $_GET['page'];
								
								
								if($page) 
									$start = ($page - 1) * $limit; 			//first item to display on this page
								else
									$start = 0;
								
								if ($page == 0) 
								{
									$page = 1;								//if no page var is given, default to 1.
								}
								//echo $page;			
								$prev = $page - 1;							//previous page is page - 1
								$next = $page + 1;							//next page is page + 1
								$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
								//echo "lastpage : ". $lastpage;
								$lpm1 = $lastpage - 1;						//last page minus 1
								//echo "total_pages = ".$total_pages ."<br/>";
								//echo "lastpage = ".$lastpage ."<br/>";
								if(isset($_POST['btngo']))
								{
									$search=$_POST['search'];
									$objfile->showfiles($search,$emp_power,$start,$limit);
								}
								else
								{
									
									$search="";
									$objfile->showfiles($search,$emp_power,$start,$limit);
								}
		?>
							
				</table>
				
					</td></tr>
					
				</table>			
				<?php



					$pagination = " ";
					if($lastpage > 1)
					{	
						//previous button
						if ($page > 1) 
						{

						$pagination.= "<a href=\"file.php?page=".$prev."\"><< previous</a>";

						}
						else
						{
							$pagination.= "<span>previous</span>";	
						}
						if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
						{	
							for ($counter = 1; $counter <= $lastpage; $counter++)
							{
								if ($counter == $page)
									$pagination.="";//$pagination.= "<span class=\"current\">$counter</span>";
								else
									$pagination.="";//$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
							}
						}
						
						elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
						{
							//close to beginning; only hide later pages
							if($page < 1 + ($adjacents * 2))		
							{
								for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
								{
									if ($counter == $page)
									{
										$pagination.="";//$pagination.= "<span>".$counter."</span>";
									}
									else
									{
										$pagination.= "<a href=\"file.php?page=".$counter."\">".$counter."</a>";	
									}				
								}
								//$pagination.= "...";
								//$pagination.= "<a href=\"file.php?page=".$lpm1."\">".$lpm1."</a>";
								//$pagination.= "<a href=\"file.php?page=".$lastpage."\">".$lastpage."</a>";		
							}
								//in middle; hide some front and some back
							elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
							{
								//$pagination.= "<a href=\"file.php?page=1\">1</a>";
								//$pagination.= "<a href=\"file.php?page=2\">2</a>";
								//$pagination.= "...";
								for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
								{
									if ($counter == $page)
										$pagination.="";//$pagination.= "<span class=\"current\">".$counter."</span>";
									else
										$pagination.="";//$pagination.= "<a href=\"file.php?page=".$counter."\">".$counter."</a>";					
								}
								//$pagination.= "...";
								//$pagination.= "<a href=\"file.php?page=".$lpm1."\">".$lpm1."</a>";
								//$pagination.= "<a href=\"file.php?page=".$lastpage."\">".$lastpage."</a>";		
							}
							//close to end; only hide early pages
							else
							{
								//$pagination.= "<a href=\"file.php?page=1\">1</a>";
								//$pagination.= "<a href=\"file.php?page=2\">2</a>";
								//$pagination.= "...";
								for ($counter = $lastpage - 4; $counter <= $lastpage; $counter++)
								{
									if ($counter == $page)
									{
										$pagination.="";//$pagination.= "<span class=\"current\">".$counter."</span>";
									}
									else
									{
										$pagination.= "<a href=\"file.php?page=".$counter."\">".$counter."</a>";
									}
								}
							}
						}							
						//next button
						//$pagination.="<div align=\"right\">";
						
						$pagination.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
						if ($page < $counter - 1) 
							$pagination.= "<a href=\"file.php?page=".$next."\">next >></a>";
						else
							$pagination.= "<span>next</span>";
						//$pagination.= "</div>\n";	
						$pagination.= "</div>\n";		
					}
					?>
					<?php echo $pagination;?>	
				
			</form>
     		</td>
	</tr>
<!-- then form contaminater table end. edietd by ****  **** --> 
<!-- start footer coded by ***  *** -->
   <tr>
      <td colspan="4" align="center" valign="middle" class="Footer_txt">
	<?php echo footer();?></td>
   </tr>
<!-- end footer coded by ***  *** -->
  </table>
</div>
<?php 
	if(isset($_GET['del']) and $_GET['del']==1) {
	?><script language="javascript"> alert("One record deleted !"); 
	document.location.href="file.php";
	</script>
<?php } elseif(isset($_GET['del']) and $_GET['del']==0) {?><script language="javascript"> alert("Delete failed !"); </script>
<?php } ?>
</body>
</center>
</html>
