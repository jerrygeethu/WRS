<?php
$pass_result="";
require_once('include/include.php');
$_SESSION['SEL_LINK']="CHP";
require_once('include/parameters.php');
$timestamp=strftime("%Y-%m-%d %H:%M:%S %Y");
$today=strftime("%Y-%m-%d %H:%M:%S", strtotime($timestamp));

if(isset($_POST['new_pass'])){
	
$new_password=$_POST['new_pass'];
$con_password=$_POST['con_pass'];
$cur_password=$_POST['cur_pass'];


if(($new_password=="")||($con_password=="")){
			$pass_result="Please Enter New Password..!! ";
			
		}
		else if($cur_password==""){
			$pass_result="Please Enter Current Password..!! ";
		}
		else if($cur_password==$new_password){
			$pass_result="Current Password And New Password Are Same";
		}
		else if($new_password!=$con_password){
			$pass_result="Password Doesn't Match..!! ";
			$new_password="";
			$con_password="";
		}
		else if(($new_password==$con_password)&&($cur_password!="")){
			//return true;
			
$curpassword = md5($cur_password);
$query = "select employeeid,departmentid,empname,pwd from employee where employeeid='".$_SESSION['USERID']."'  and pwd = \"".$curpassword."\" ";
	$result_pass = $GLOBALS['db']->query($query);
	if(isset($result_pass) and $result_pass->num_rows<=0) {
		$pass_result="Your Current Password Is Wrong..!!";
		$cur_password="";
	}
	else{
		// condition when everything is alright.. and going to change password
			
			
$newpassword = md5($new_password);
$data_up=check_submission($newpassword,$curpassword,$_SESSION['USERID']);
	if($data_up== true){
		 $action_query=" 	UPDATE "
		
													." employee "
		
											." SET "
											
													." pwd = '".$newpassword."' "
													." ,pwdchangedt = '".$today."' "
											." where "
											
													." employeeid='".$_SESSION['USERID']."' "
													
													." and pwd = \"".$curpassword."\" ";
													
													
			$result_action_entry = $GLOBALS['db']->query($action_query);
									if ($result_action_entry){
											$pass_result=" Password Changed ";
									}
											else{
											$pass_result=" Error Occured.. Please Try Again ";	
									}
		}
		else{
		$pass_result=" Password Already Changed..!! ";	
		}
		}
		}
		else{
		}
}
else{
	
$new_password="";
$con_password="";
$cur_password="";	
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php print $company_name;?>-Change Password</title>
<link href="css/reporting.css" rel="stylesheet" type="text/css" />
<link href="css/saxan.css" rel="stylesheet" type="text/css" />
<!-- to show a icon in url title icon -->
<link rel="shortcut icon" href="./images/icon.gif" >
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

function validate(){
	cur_pass=document.getElementById('cur_pass').value;
		if(cur_pass==""){
			alert("Please Enter Current Password..!! ");
			document.getElementById('cur_pass').focus();
			return false;
		}
	new_pass=document.getElementById('new_pass').value;
	con_pass=document.getElementById('con_pass').value;
		if(new_pass==""){
			alert("Please Enter New Password..!! ");
			document.getElementById('new_pass').value="";
			document.getElementById('con_pass').value="";
			return false;
		}
		if(con_pass==""){
			alert("Please Enter Confirmation Password..!! ");
			document.getElementById('new_pass').value="";
			document.getElementById('con_pass').value="";
			return false;
		}
		
		if(new_pass!=con_pass){
			alert("Password Doesn't Match..!! \nPlease Re-enter ");
			document.getElementById('new_pass').value="";
			document.getElementById('con_pass').value="";
			document.getElementById('cur_pass').value="";
			return false;
		}
		if((new_pass==con_pass)&&(cur_pass!="")){
			return true;
		}
		else{
				return false;
		}
}

//-->
</script>
</head>
<center>
<body onload="MM_preloadImages('images/Home_Over.jpg','images/Dep_Over.jpg','images/Emp_Over.jpg','images/Sch_Over.jpg','images/Acti_Over.jpg','images/Vali_Over.jpg','images/View_Over.jpg','images/Daily_Over.jpg','images/Change_Over.jpg','images/Log_Over.jpg'),document.getElementById('cur_pass').focus();">
<div id="main_div">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" summary=" ">
    <tr>
      <td height="101" colspan="2" align="left" valign="middle" class="Head"><img src="images/Compy_logo.jpg" alt="" width="195" height="68" /></td>
      </tr>
    <tr>
      <td width="159" rowspan="2" align="left" valign="top"  class="menu_back">
      
        <?php 
      $menu=show_menu();
      print $menu;
      ?>
      
      </td>
      <td width="100%" height="30" align="right" valign="top"  class="head_with_back_button">
      
      <?php print get_table_link("Change Password","changeicon.jpg");?>
      </td>
    </tr>
    <tr>
      <td height="580px" align="center" valign="top"   class="main_content_p">
              <!-- *************************************  -->
              <!-- *************************************  -->
              <!-- *************************************  -->
             <table>
                 <tr>
                     <td width="60%">
					 <br/>
                     <form method="POST" action="changepass.php" autocomplete="off"  onsubmit = "return validate();">
    <table  class="main_content_table" border="0">
            <tr align="center">
            <th colspan="2">Change Password
            </th>
        </tr>  <tr align="center">
           
        </tr> 
        <tr class="even">
            <td align="right">
            Enter Current Password
            </td>
            <td align="left">
            <input type='password' id="cur_pass" name="cur_pass"  value="<?php print $cur_password;?>"/>
            </td>
        </tr>
        <tr class="even">
            <td align="right">
            Enter New Password
            </td>
            <td align="left">
            <input type='password' id="new_pass" name="new_pass" value="<?php print $new_password;?>"/>
            </td>
            </tr>
            <tr class="even">
            <td align="right">
            Confirm New Password
            </td>
            <td align="left">
            <input type='password' id="con_pass" name="con_pass"  value="<?php print $con_password;?>"/>
            </td>
        </tr>
           <tr align="center" >
            <th colspan="2">
            <input type="submit" class="s_bt" value=" Update "/>
            <input type="Reset"  class="s_bt" value=" Reset "/>
            </th>
        </tr>
    </table>
    </form>
                     </td>
                 </tr>
             </table>
    
              
              
              <!-- *************************************  -->
              <!-- *************************************  -->
              <!-- *************************************  -->
      
      
      
              </td>
          </tr>
      </table>
      
	    
	    
	    
	    </td>
    </tr>
     <tr>
      <td height="30" colspan="4" align="center" valign="middle" class="Footer_txt">
      <?php footer();?>
      </td>
    </tr>
  </table>
</div>
</body>
</center>
</html>
<?php if($pass_result!=""){print "<script>alert(\"".$pass_result."\");</script>";}
