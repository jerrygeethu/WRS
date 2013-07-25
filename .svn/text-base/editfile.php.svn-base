<?php 
	require_once('include/class.file.php');
	//require_once('include/readmore.php');
	require_once('include/parameters.php');
	//$file1=$_FILES['file1']['name'];
	//$file2=$_FILES['file2']['name'];
	//$file3=$_FILES['file3']['name'];
	//echo $editid;
	$objfile = new fileshare();
	//To convert date in dd/mm/yy to yy/mm/dd
	$title=$_POST['title'];
	$referenceid=$_POST['referenceid'];
	$description=$_POST['description'];
	$up_date=dmytoymd($_POST['update']);
	/*
		echo "update  ".$_POST['update']."<br/>";
		echo "up_date  ".$up_date;
	*/
		//echo "yugyuyu". $row['privillage'];
		//echo $printemp;;
	/*
		if(isset($_POST['btnsave']))
		{
			echo "h0000h";
		}
	*/
	//$empid=$_SESSION['USERID'];
	//print_r($_POST);

	if((isset($_POST['title']) and $_POST['title']!='') || (isset($_POST['btnsave']) and $_POST['btnsave']!=''))
	{	
		//echo "hh";
		$title=$_POST['title'];
		$referenceid=$_POST['referenceid'];
		$description=$_POST['description'];
		$up_date=dmytoymd($_POST['update']);
	
		if($title=="")
		{
			$error_msg_name="Please enter name of File !!";
			$error=1;
		}
		if($referenceid=="")
		{
			$error_msg_ref="Please enter reference!!";
			$error=1;
		}
		if($description=="")
		{
			$error_msg_des="Please enter a description of File !!";
			$error=1;
		}
		$timestamp=strftime("%Y-%m-%d"); 
		$today=strftime("%Y-%m-%d", strtotime($timestamp));
		if($up_date<$today)
		{
			$error_msg="Sorry, Invalid date. Please enter correct date!!";
			$error=1;
		}
/*
		if($choose_emp=="")
		{
			$error_msg_emp="Sorry, Invalid selection. Please reenter employees!!";
			$error=1;
		}
*/
		if($error!=1)
		{
			

		
			//Code for file uploading
		
			// Your file name you are uploading
			$file_name1 = $HTTP_POST_FILES['file1']['name'];
			$file_name2 = $HTTP_POST_FILES['file2']['name'];
			$file_name3 = $HTTP_POST_FILES['file3']['name'];
			// random 4 digit to add to our file name
			// some people use date and time in stead of random digit
			$random_digit=rand(0000,9999);
			//combine random digit to you file name to create new file name
			//use dot (.) to combile these two variables
			if($file_name1!="")
			{
				$new_file_name1=$random_digit.$file_name1;
				$target_path1 = "fileshare/".$new_file_name1;
				move_uploaded_file($_FILES['file1']['tmp_name'], $target_path1);
			}
			else
			{
				$new_file_name1="";
			}
		
			if($file_name2!="")
			{
				$new_file_name2=$random_digit.$file_name2;
				$target_path2 = "fileshare/".$new_file_name2;
				move_uploaded_file($_FILES['file2']['tmp_name'], $target_path2);
			}
			else
			{
				$new_file_name2="";
			}
		
			if($file_name3!="")
			{
				$new_file_name3=$random_digit.$file_name3;
				$target_path3 = "fileshare/".$new_file_name3;
				move_uploaded_file($_FILES['file3']['tmp_name'], $target_path3);
			}
			else
			{
				$new_file_name3="";
			}
			//$new_file_name2=$random_digit.$file_name2;
			//$new_file_name3=$random_digit.$file_name3;
	
			//set where you want to store files
			//in this example we keep file in folder upload
			//$new_file_name = new upload file name
			//for example upload file name cartoon.gif . $path will be upload/cartoon.gif
		
		
		
			//$target_path1 = $target_path . basename( $_FILES['file1']['name']);
			//move_uploaded_file($_FILES['file1']['tmp_name'], $target_path1);
		
			//$target_path2 = $target_path . basename( $_FILES['file2']['name']);
			//move_uploaded_file($_FILES['file2']['tmp_name'], $target_path2);
		
			//$target_path3 = $target_path . basename( $_FILES['file3']['name']);
			//move_uploaded_file($_FILES['file3']['tmp_name'], $target_path3);
			$editid=$_POST['editid'];
			$delid=$_POST['delid'];	
		
			$objfile->insertfile($_POST,$up_date,$new_file_name1,$new_file_name2,$new_file_name3,$editid,$delid);
			//$objfile->fileview($data);
		
			/*
			$target_path = $target_path . basename( $_FILES['file1']['name']) ;
			if(move_uploaded_file($_FILES['file1']['tmp_name'], $target_path)) {
				echo "The file ".  basename( $_FILES['file1']['name']). 
				" has been uploaded";
			} 
			else
			{
				echo "There was an error uploading the file, please try again!";
			}
			*/
		}
	
	}
	if(isset($_GET['edit']) and $_GET['edit']!='') 
	{
		$row = $objfile->getData($_GET['edit']);
		$emp=$row['employeeid'];
		//echo "emp=".$emp;
		$arrEmp=array();
		$arrEmp=$emp;
		$arrEmp=explode(",",$emp);
		//print_r($arrEmp);
	}	
		

	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
			<title><?php print $company_name;?>-Upload File - File</title>
			<link href="css/reporting.css" rel="stylesheet" type="text/css"/>
			<!-- to show a icon in url title icon -->
			<link rel="shortcut icon" href="./images/icon.gif"/>

			<!--calender code-->
			<link href="css/calendar.css" rel="StyleSheet"/>
			<script language="JavaScript" type="text/javascript" src="js/calendar.js"></script>

			<script language="JavaScript" type="text/javascript"  src="js/selectbox.js"> </script>
			<script  type="text/javascript" language="javascript" >
			<!--
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

			function MM_findObj(n, d) 
			{ //v4.01
			  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
				d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
			  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
			  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
			  if(!x && d.getElementById) x=d.getElementById(n); return x;
			}

			function MM_swapImage() 
			{ //v3.0
			  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
			   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
			}

			function showHideOthers()
			{
				//alert(document.uploadfile.privillage.selectedIndex);
				if (document.uploadfile.privillage.selectedIndex==0) //Hide others drop-down list if myself is selected
				{
					document.getElementById("others").style.display='none';
				}
				else //show drop-down list of others
				{
					document.getElementById("others").style.display='block';
				}
			}

			// To validate inputs 
			function checkall() 
			{

				//alert(today);
				if(document.getElementById('title').value=="") 
				{
					alert("Please enter name of File !!");
					document.getElementById('title').focus();
					return false;
				}
				if(document.getElementById('description').value=="") 
				{
					alert("Please enter a description !!");
					document.getElementById('description').focus();
					return false;
				}
				
				

		/*
				if(document.getElementById('update').value=="") {
					alert("Please enter date!!");
					document.getElementById('update').focus();
					return false;
				}
				

				var currentTime = new Date()
				var month = currentTime.getMonth() + 1
				var day = currentTime.getDate()
				var year = currentTime.getFullYear()
				//document.write(day + "/" + month + "/" + year)
				var currentdate=day + "/" + month + "/" + year
		*/

				//alert('currentdate');


				//alert(currentdate);
				//alert('update');
				//alert(document.getElementById('update').value);

		/*
				if(document.getElementById('update').value<currentdate)
				{
					alert("Sorry, Invalid date. Please enter correct date!!");
					document.getElementById('update').focus();
					return false;
				}
		*/
					  
		/*
					style="width:250px;height:300px;"
					if(document.getElementById('file1').value=="") {
					alert("Please enter the path of File !!");
					document.getElementById('file1').focus();
					return false;
				}
		*/


				document.getElementById('uploadfile').submit();
			}
			
			// To confirm delete record or not
			function confirmdelete() 
			{
				if(confirm("Are you sure to delete this record ...?")==true)
				{
					//if(document.getElementById('editid').name == "editid"){
						document.getElementById('editid').name = "delid";
						document.getElementById('uploadfile').submit();
					//}
				}
			}


			function ismaxlength(obj){
				var mlength=obj.getAttribute? parseInt(obj.getAttribute("maxlength")) : "235"
			if (obj.getAttribute && obj.value.length>mlength)
				obj.value=obj.value.substring(0,mlength)
			}
		-->	
		</script>
	</head>
	<body onload="MM_preloadImages('images/Home_Over.jpg','images/Dep_Over.jpg','images/Emp_Over.jpg','images/Sch_Over.jpg','images/Acti_Over.jpg','images/Vali_Over.jpg','images/View_Over.jpg','images/Daily_Over.jpg','images/Change_Over.jpg','images/Log_Over.jpg')">



		<div id="main_div">

			<table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
				<!--  Start top banner	 -->
				<tr>
					<td height="101" colspan="2" align="left" valign="middle" class="Head"><img src="images/Compy_logo.jpg" alt="" width="195" height="68" /></td>
				</tr>
				<!-- end top banner  -->


				<!-- side menu Left start edietd by  **** hmsqt@gmail.com **** -->
				<tr>
					<td rowspan="2" align="left" valign="top">
						<?php print show_menu();?>
					</td>
					<td width="100%" height="30" align="right" valign="top" bgcolor="#D1D1D3">
						<?php print get_table_link("File Upload","depicon.jpg");?>
					</td>
				</tr>
			<!-- side menu Left end	edietd by **** hmsqt@gmail.com **** -->


			   
				<tr>
					<td  height="580"  align="center" valign="top">
						<form  action="editfile.php" method="post" name="uploadfile" id="uploadfile" enctype="multipart/form-data">
							<table class="Tbl_Txt_bo" width="50%" cellspacing="1" cellpadding="3"  border="0">
						
								<tr align="left">
									<td colspan="2" class="Date_txt" bgcolor="#D6D6D7" style="border-bottom:#666666 1px solid;">
										<a href="file.php" ><img border="0" height="26" src="images/back_list.jpg" alt="file"/></a>
										<a href="file.php" >Back to File List</a>
									</td>
								</tr>


								<tr>
									<td width="49%" align="right" class="menu_txt" >
										<label for="title"> Topic : <span class="error">*</span> </label>
								  </td>
									<td width="51%" align="left">
										<input type="text" id="title" maxlength="45" onkeyup="return ismaxlength(this);" name="title" size="20px" value="<?php if(isset($row['title'])) echo $row['title']; else echo $title;?>"/>
								  </td>
								</tr>
						
								
								<?php
									if($error ==1)
									{
								?>
									<tr>
										<td colspan="2" align="right">
											<?php echo $error_msg_name;?>
										</td>
									</tr>
								<?php	
									}
								?>
								
								
								<tr>
									<td class="menu_txt" align="right" >
										<label for="referenceid"> Reference Id : <span class="error">*</span> </label>
									</td>
									<td align="left">
										<input type="text" id="referenceid" maxlength="45" onkeyup="return ismaxlength(this);" name="referenceid" size="20px" value="<?php if(isset($row['referenceid'])) echo $row['referenceid']; else echo $referenceid;?>"/>
									</td>
								</tr>
					
					
					
								<?php
									if($error ==1)
									{
								?>
									<tr>
										<td colspan="2" align="right">
											<?php echo $error_msg_ref;?>
										</td>
									</tr>
								<?php	
									}
								?>
								
							
								<tr align="center">
									<td class="menu_txt" align="right">
										<label for="description"> Description : <span class="error">*</span> </label>
									</td>
									<td align="left">
										<textarea name="description" id="description" rows="9" cols="50" onkeyup="return ismaxlength(this);"><?php if(isset($row['description'])) echo $row['description']; else echo $description;?></textarea>
									</td>
								</tr>
						
								<?php
									if($error ==1)
									{
								?>
									<tr>
										<td colspan="2" align="right">
											<?php echo $error_msg_des;?>
										</td>
									</tr>
								<?php	
									}
								?>
								
								
												
								<tr>
									<td align="right">
										<label for="update">Expiring Date : <span class="error">*</span></label>
									</td>
									<td align="left">
										<input type="text" name="update" id="update" size="30px" readonly="true" value="<?php if(isset($row['expiry'])) echo ymdToDmy($row['expiry']);?>" class="date_text" style="width:85px;"/>
										<!--calender code-->
										<img onclick="displayDatePicker('update');" alt="calender" src="<?php print $_SESSION['FOLDER'];?>/cal.gif" title="Calender"/> 
									</td>
								</tr>
									
								
								<?php
									if($error ==1)
									{
								?>
									<tr>
										<td colspan="2" align="right">
											<?php echo $error_msg;?>
										</td>
									</tr>
								<?php	
									}
								?>
									
								
							
								<tr>
									<td align="right" class="menu_txt">
										<label for="privillage">Privillage : </label>
									</td>
									<td align="left">
										<select name="privillage" id="privillage" onchange="showHideOthers()">
											<!--<option value="#">value="select"  Select </option>-->
											<?php $objfile->listfileprivillage($row['privillage']);?>
										</select>			
									</td>
								</tr>
						
								<?php 
									if($row['privillage']=="private")
									{
										$choose_emp="style=\"display:block\"";
										//$choose_private=$choose_emp;
									}
									else
									{
										$choose_emp="style=\"display:none\"";
									}
								?>
							
								<tr id="others" <?php echo $choose_emp;?> >
									<td align="right" colspan='2'>
										<label for="choose_employees">Choose Employees : </label>
									</td>
									<td align="left">
										<select name="choose_employees[]" id="choose_employees" size="10" multiple="multiple">
										<!--<option value="0"> Select </option>-->
											<?php 
												$printemp=$objfile->listemployees($arrEmp);//81
												echo $printemp;
											?>
										</select>			
									</td>
								</tr>
							
								<?php
/*
									if($error ==1)
									{
*/
								?>
										<!--<tr>
											<td colspan="2" align="right">
												<?php //echo $error_msg_emp;?>
											</td>
										</tr>-->
								<?php	
									//}
								?>
									
								<tr>
									<td class="menu_txt" align="right">
									<label for="files" id="files"> Attach Files </label><br/>
										<label for="file1"> File 1 : 
											<?php
												if(isset($row['file1']) and $row['file1']!="")
												{
													echo $showfile1="<a href=\"fileshare/".$row['file1']."\" >".$row['file1']."</a>";
												}
											?>
										</label>
									</td>
									<td align="left" >
										<input type="file" name="file1" id="file1"/>
									</td>
								</tr>
							
								<tr>
									<td class="menu_txt" align="right">
										<label for="file2"> File 2 : 
											<?php
												if(isset($row['file2']) and $row['file2']!="")
												{
													echo $showfile2="<a href=\"fileshare/".$row['file2']."\" >".$row['file2']."</a>";
												}
											?>
										</label>
									</td>
									<td align="left">
										<input type="file" name="file2" id="file2"/>
									</td>
								</tr>
						
								<tr>
									<td class="menu_txt" align="right">
										<label for="file3"> File 3 : 
											<?php
												if(isset($row['file3']) and $row['file3']!="")
												{
													echo $showfile3="<a href=\"fileshare/".$row['file3']."\" >".$row['file3']."</a>";
												}
											?>
										</label>
									</td>
									<td align="left">
										<input type="file" name="file3" id="file3"/>
									</td>
								</tr>
						
								<tr>
									<td  align="right"><label for="status">File Status : </label></td>
									<td align="left">
										<select name="status" id="status">
											<!--<option value="0"> Select </option>-->
											<?php $objfile->listfilestatus($row['status']);?>
										</select>			
									</td>
								</tr>
									
							

								<tr>
									<td align="center" colspan="2">
										<input type="submit" id="btnsave" name="btnsave" style="width:75px;" value="Save"/>
										<?php 
										//onclick="checkall()"
											if(($_GET['edit']!="")&&($_GET['edit']!=$_SESSION['USERID']))
											{
												echo "<input type=\"submit\" style=\"width:73px;\" value=\"Delete\" onclick=\"javascript:confirmdelete();\"/>";
											} 
										?>
										<input type="reset" value="Cancel" title="Cancel" style="width:75px;"/>
										<input type="hidden" name="editid" id="editid" value="<?php if(isset($row['fileshareid'])) echo $row['fileshareid'];?>"/>
									</td>		
								</tr>
								
									
							</table>
						</form> 
					</td>
				</tr>
				<!-- start footer coded by *** hmrsqt@gmail.com *** -->
				<tr>
					<td colspan="2" align="center" valign="middle" class="Footer_txt">
						<?php echo footer();?>
					</td>
				</tr>
			<!-- end footer coded by *** hmrsqt@gmail.com *** -->
			</table>
		</div>
	</body>
</html>
