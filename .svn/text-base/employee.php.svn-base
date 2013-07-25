<?php
require_once('include/class.employee.php');
require_once('include/parameters.php');
//require_once('include/class.mail.php');
$objemployee = new employee();
//$d=$_POST['dob'];
//echo $d;
//echo "dob=".dmyToymd($_POST['dob'], $needle="/");

$msg = '';
if(isset($_GET['msg']) and $_GET['msg']!=0)
{
$msg = $_GET['msg'];
}
	if(isset($_POST['fullname']) and $_POST['fullname']!='') {
		$date=$_POST['dob'];
		 $dob= dmyToymd($date);		
		// echo "d=".$dob;
		 //echo "hii";
		// To store datas as a Array to insert/edit employee tbl on dily report coded by hmrsqt@gmail.com  
		$temp = array(
			"empno" => trim($_POST['empno']) ,
			"departmentid" => $_POST['departmentid'] ,
			"title" => $_POST['title'] ,
			"fullname" => ucwords($_POST['fullname']) ,
			"empname" => $_POST['empname'] ,
			"dob" => trim($dob) ,
			"contactno" => $_POST['contactno'] ,
			"email" => $_POST['email'] ,
			"address" =>  $_POST['address'],  
			"isadmin" => $_POST['isadmin'] ,
			"starthour" => $_POST['starthour'] ,
			"empstatus" => $_POST['empstatus'] , 
			"designation" => $_POST['designation'] ,
			"createdby" => $_SESSION['NAME']
			);
			if(! empty($_POST['repto'])){
			$ins=array();
			foreach($_POST['repto'] as $row ){
				$ins[]= "".$row."";				
			}
			$temp['repto']= serialize($ins);
			}
			

if($_POST['password']!=""){
			$pwd['pwd']=$_POST['password'] ;

$row=array_merge($temp,$pwd);
}else{

$row=$temp;
}



//printarray($row);echo "</br>";
			// To hold password field and password to user array 
		//if psw is valied 
		//if(isset($_POST['password']) and $_POST['password']!='') {
			//$password=md5($_POST['password']);
			//$row["pwd"]=$password;
		//}

		if($_POST['delid']>1) {
			$objemployee->insertemployee($row,'',$_POST['delid']);
		} else {
			if($_POST['editid']<1) {
				$query = "SELECT `employeeid`,`empname` FROM `employee` WHERE empname='".$row['empname']."'";
				$chkrst = $GLOBALS['db']->query($query);
				if(isset($chkrst) and $chkrst->num_rows>0) {
				$msg = 2;
				}
				else {
					$objemployee->insertemployee($row,$_POST['editid'],$_POST['delid']);
				}	
			} else {
				$objemployee->insertemployee($row,$_POST['editid'],$_POST['delid']);
			}
		}
	}
	
$user_id =  $_SESSION['USERID'];

$emp_power = emp_authority($user_id);
	
	// To cach records from Database Table (DB_TB) to edit user records
		if(isset($_GET['edit']) and $_GET['edit']!='') { 
$edit_user_id =   emp_authority($_GET['edit']);
$reporting_to =explode(",",$edit_user_id['is_repto']);
		}else{
			$reporting_to = array();
		}
		if(isset($_GET['edit']) and $_GET['edit']!='') {
			$row = $objemployee->getData($_GET['edit']);
			
			$row['address'] = str_replace("<pre>", "", $row['address']);
			$row['address'] = str_replace("</pre>", "", $row['address']);
		}
	//To Delete employee
	//if(isset($_GET['del']) and $_GET['del']!='') {
		//$row = $objemployee->deleteuser($_GET['del']);
	//} 
?>
 


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php print $company_name;?> - Activity List</title>
<link href="css/reporting.css" rel="stylesheet" type="text/css" />
<!-- to show a icon in url title icon -->
<link rel="shortcut icon" href="./images/icon.gif" >
<style>

input,textarea {
 width: 225px;
 font: 12px Verdana, Geneva, Arial, Helvetica, sans-serif;
 margin-right: 0px;
 margin-bottom: 2px;
}

select {
 width: 230px;
 margin-right: 0px;
 margin-bottom: 2px;
 font: 12px Verdana, Geneva, Arial, Helvetica, sans-serif;
} 
</style>
<link href="css/calendar.css" rel="StyleSheet">
<script language="JavaScript" src="js/calendar.js"></script>
<script language="JavaScript" src="js/validate.js" type="text/JavaScript"></script>
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

// To validate inputs 
function checkall() {
	if(document.getElementById('empno').value=='') {
        alert("Please enter employee no. !!");
        document.getElementById('empno').focus();
        return false;
	}
	if(document.getElementById('fullname').value=='') {
        alert("Please enter full name !!");
        document.getElementById('fullname').focus();
        return false;
	}
	if(document.getElementById('empname').value=='') {
        alert("Please enter employee login name !!");
        document.getElementById('empname').focus();
        return false;
	}
	// To check valid email id format which enterd in username
      	//if(document.getElementById('email').value!='')
      	if(validmail(document.getElementById('email'))==false) {
		return false;
      	}
 	if(document.getElementById('address').value!='') {
//         alert("Please enter address !!");
          document.getElementById('address').value="<pre>"+document.getElementById('address').value+"</pre>";
//         return false;
 	}

//alert(document.getElementById('address').value);

	if(document.getElementById('contactno').value!='')
	{
	//alert(isValidReferencePhone(document.getElementById('contactno').value));
	if(isValidReferencePhone(document.getElementById('contactno').value)==false) {
	 alert("Enter valid  Phone Number");
	 return true;
	}
    } 
	if(document.getElementById('editid').value=='' ) {
		if(document.getElementById('password').value=='') {
		alert("Enter password !!");
		document.getElementById('password').focus();
		return false;
		}
		if((document.getElementById('confirm').value=='') || (document.getElementById('password').value!=document.getElementById('confirm').value)) {
		alert("Re enter password !!");
		document.getElementById('confirm').value='';
		document.getElementById('confirm').select();
		return false;
		}
	}

		if((document.getElementById('password').value!='') || (document.getElementById('confirm').value!=''))  {
		if(document.getElementById('password').value!=document.getElementById('confirm').value) {
			alert("Password Doesn't Match..!! ");
			document.getElementById('confirm').value='';
		}
			if(document.getElementById('password').value=='') {
				document.getElementById('password').focus();
			return false;
			}
			else if(document.getElementById('confirm').value==''){
				 document.getElementById('confirm').focus();
			return false;
		}
		
		}
        if(document.getElementById('isadmin').checked=='true') {
          document.getElementById('isadmin').value='0';
	}
       else {
           document.getElementById('isadmin').value='1';
	   document.getElementById('frmemployee').submit();
	}
}

 function isValidReferencePhone(iNumber)
{
        var returnval = true;
        for (i=0;i<iNumber.length;i++) {
                var c = iNumber.charAt(i);
                if (! (c == ' ' ||c == '+' || c == '-' || isDigit(c))) {
                        returnval =  false;
                        break;
                }
        }
        return returnval;
}
function isDigit(c)
{
                 return ((c >= "0") && (c <= "9"))
}
//max length restricting fun
//obj should have maxlength defined
function ismaxlength(obj){
    var mlength=obj.getAttribute? parseInt(obj.getAttribute("maxlength")) : "";
if (obj.getAttribute && obj.value.length>mlength)
    obj.value=obj.value.substring(0,mlength);
}


// To confirm delete record or not
	function confirmdelete() {
		if(confirm("Are you sure to delete this record ...?")==true){
			//if(document.getElementById('editid').name == "editid"){
				document.getElementById('editid').name = "delid";
				document.getElementById('frmemployee').submit();
			//}
		}
	}

//-->
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

	<?php print get_table_link("Employee","empicon.jpg");?>

	</td>
    </tr>
<!-- side menu Left end	edietd by **** hmsqt@gmail.com **** -->
	<tr>
	<td align="center" height="580">
	<form action="employee.php" method="POST" id="frmemployee" class="Form_txt" >
    	<table class="Tbl_Txt_bo" width="50%" cellspacing="1" cellpadding="3" border="0">
		
        <tr align="left">
		<td colspan="3" class="Date_txt" bgcolor="#D6D6D7" style="border-bottom:#666666 1px solid;"><a href="viewemployee.php<?php if($_GET['d']!='') echo "?d=".$_GET['d'];echo "\"" ?>"<img width="25" border="0" height="26" src="images/back_list.jpg"/></a>&nbsp;&nbsp;<a href="viewemployee.php<?php if($_GET['d']!='') echo "?d=".$_GET['d'];echo "\"" ?>" >
		Back to Employee List</a></td>
	</tr>
		
		<tr>
			<td colspan="3" align="center">
				<?php 
					if(isset($_GET['del']) and $_GET['del']!='') {
					if($_GET['del'] == 1) {  echo "<p><font color=\"Red\">One record deleted successful !!</font></p>"; } else {
					  echo "<p><font color=\"Red\">Record can not be deleted, Related records existing     !!</font></p>";
						}
					}
					
					if(isset($msg) and $msg!=0) {
					
				    if( $msg==1) 
					    echo "<p><font color=\"Red\">Employee registration successful !!</font></p>";
					if( $msg==2)
					    echo "<p class=\"error\"><font color=\"Red\">Employee Login Name already exists.!!</font></p>";
					} ?>			</td>
		</tr>
		
		<tr>
			<td  align="right"><label for="fullname">Full Name <span class="error">*</span>:</label>			</td>
			<td colspan="2" align="left">			
			<select name="title" id="title" style="width:50px;">
					<?php $objemployee->list_title($row['title']);?>
			</select>
				<input type="text" name="fullname" id="fullname" maxlength="100" style="width:173px;"
				value="<?php if(isset($row['fullname'])) echo $row['fullname']; ?>"/>			</td>
			</tr>
		<tr>
		  <td  align="right"><label for="empno">Employee No.<span class="error">*</span>:</label></td>
		  <td colspan="2" align="left"><input type="text" name="empno" id="empno" maxlength="10" style="width:100px;"
		  value="<?php if(isset($row['empno'])) echo $row['empno']; ?>"/></td>
		  </tr>
		<tr>
			<td width="282" align="right"><label for="empname">Designation :</label></td>
			<td width="276" align="left">
			<input type="text" name="designation" id="designation" maxlength="25" value="<?php if(isset($row['designation'])) echo $row['designation']; ?>"/>			</td>
		</tr>
		<tr>
			<td width="282" align="right"><label for="departmentid">Department <span class="error">*</span>:</label></td>
			<td width="276" colspan="3" align="left"><select name="departmentid" id="departmentid">
				<?php 
				echo $depart = ($row['departmentid']!='')?$row['departmentid']:$_GET['d'];
				$objemployee->listalldepartment($emp_power,$depart);?>
			</select></td>
		</tr>
		<tr>
			<td width="282" align="right"><label for="empname">Login Name<span class="error">*</span>:</label></td>
			<td width="276" align="left">
			<input type="text" name="empname" id="empname" maxlength="25" size="28px"
			value="<?php if(isset($row['empname'])) echo $row['empname']; ?>"/>			</td>
		</tr>
		<tr>
			<td width="282" align="right"><label for="email">E-mail <span class="error">*</span>:</label></td>
			<td width="276" align="left">
			<input type="text" name="email" id="email" maxlength="320"
			value="<?php if(isset($row['email'])) echo $row['email']; ?>"/>			</td>
		</tr>

		
		<tr>
			<td width="282" align="right"><label for="address">Address :</label></td>
			<td width="276" align="left">
			<textarea name="address" id="address" wrap="soft"   maxlength="255" rows="3" onkeyup="return ismaxlength(this);" ><?php if(isset($row['address'])) echo $row['address']; ?></textarea>			</td>
		</tr>
		<tr>
		  <td width="282" align="right"><label for="dob">Date of birth (dd/mm/yyyy) : </label></td>
		  <td width="276" align="left"><input type="text" name="dob" id="dob" size="30px" maxlength="12"  value="<?php if(isset($row['dob'])) echo ymdTodmy($row['dob']); ?>" style="width:75px;" />
		   <img onclick="displayDatePicker('dob');" value="select" src="<?php print $_SESSION['FOLDER'];?>/cal.gif" title="Calender"/> </td>
		  </tr>
			
		<tr>
			<td width="282" align="right"><label for="contactno">Phone :</label></td>

			<td width="276" align="left">
			<input type="text" name="contactno" id="contactno" size="28px" value="<?php if(isset($row['contactno'])) echo $row['contactno']; ?>"/>			</td>
		</tr>
		<tr>
			<td align="right"><label for="password">Password <span class="error">*</span>: </label></td>
			<td align="left"><input type="password" autocomplete="off" size="28px" name="password" id="password" maxlength="30"  onkeyup="return ismaxlength(this);" /></td>
		</tr>
		<tr>
			<td align="right"><label for="confirm">Confirm Password <span class="error">*</span>: </label></td>
			<td align="left"><input type="password" name="confirm" size="28px" id="confirm" maxlength="30"  onkeyup="return ismaxlength(this);" /></td>
		</tr>

		
		<!--<tr>
			<td align="right">&nbsp;<label for="starthour">Start hour : </label></td>
			<td align="left"><input type="hidden" name="starthour" id="starthour" 	value="<?php// if(isset($row['starthour'])) echo $row['starthour']; ?>" /></td>
		</tr>-->
		<tr>
		<td align="right"><label for="isadmin">Is Admin :</label></td>
		<td  align="left">
		<input type="checkbox"  name="isadmin" id="isadmin"  value="1" <?php if($emp_power['is_superadmin']!=1) echo "disabled=\"true\"";  if(isset($row['isadmin']) && $row['isadmin']=="1")  echo "checked=\"true\"";?> ></td>
		</tr><?php 
/*
			if(isset($row['isadmin']) && $row['isadmin']=="0")  
			echo "true";
			else echo "false"; 
*/
			?>
		<tr>
			<td align="right"><label for="empstatus">Employee status : </label></td>
			<td align="left">
			<select name="empstatus" id="empstatus">
			<!--<option value="0"> Select </option>-->
				<?php $objemployee->listemployeestatus($row['empstatus']);?>
			</select>			</td>
		</tr>
		<tr>
			<td align="right"><label for="empstatus">Reporting to : </label></td>
			<td align="left"> 
			<select name="repto[]" id="repto[]" multiple="multiple" size="10">
			<!--<option value="0"> Select </option>-->
				<?php 
			 $query_1_1="select employeeid,	title ,	fullname, d.depname, d.hod from employee as e, department as d where e.departmentid = d.departmentid  and empstatus='active' order by d.depname,fullname "; 
		
    $result_1_1 = $GLOBALS['db']->query($query_1_1);
   if(isset($result_1_1) and $result_1_1->num_rows>0) {
	   $depname=""; 
while($row_1_1 = $result_1_1->fetch_assoc()){
				if(($depname !="") && ($depname !=$row_1_1['depname'] ))
				print "</optgroup>";
				if($depname != $row_1_1['depname'] )
				print "<optgroup label='".$row_1_1['depname']."' >";
				$depname = $row_1_1['depname'] ; 
				$sel="";
				if(( ! empty($reporting_to))  &&  in_array(  $row_1_1['employeeid'] , $reporting_to)){
					$sel =" selected=\"selected\" ";
				}
				$hd = ($row_1_1['employeeid'] == $row_1_1['hod'])? ' (HOD) ': '' ;
				
				print "<option value=\"".$row_1_1['employeeid']."\" ".$sel." >".$row_1_1['title'].": ".$row_1_1['fullname'].$hd." </option>"; 
				
			}
		}
				
				 
				?>
			</select>			</td>
		</tr>
		<tr>
			<td colspan="3" align="center">
			<input type="button" id="btnsave" style="width:75px;" value="Save" onclick="checkall()" />
			
			<?php 
				if(($_GET['edit']!="")&&($_GET['edit']!=$_SESSION['USERID'])){
					echo "<input type=\"button\" style=\"width:73px;\" value=\"Delete\" onclick=\"javascript:confirmdelete();\" />";
				
				} 
			?>
			 <input type="reset" value="Cancel" title="Cancel" style="width:75px;" />
			<input type="hidden" name="editid" id="editid" 
			value="<?php if(isset($row['employeeid'])) echo $row['employeeid']; ?>" />			</td>
		</tr>
	</table>
    </form>

		</td>
	</tr>
<!-- start footer coded by *** hmrsqt@gmail.com *** -->
   <tr>
      <td colspan="4" align="center" valign="middle" class="Footer_txt">
	<?php echo footer();?></td>
   </tr>
<!-- end footer coded by *** hmrsqt@gmail.com *** -->


 </table>
</td>
 </tr>
</table>
</div>
</body>
</center>
</html>
