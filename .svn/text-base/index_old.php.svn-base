<?php
session_start();
session_destroy(); 

function get_table_link($show,$image){
	//$bgcolor="  bgcolor=\"#D1D1D3\"  ";
	$folder="images/";
	$t="	
	 <table width=\"100%\" border=\"0\"     height=\"30\"  cellpadding=\"0\" cellspacing=\"0\" class=\"gen_class\">
        <tr>
          <td align=\"left\"  valign=\"middle\"  nowrap  class=\"Head_txt\">
          
          <img src=\"".$folder."".$image."\" height=\"25px\" width=\"25px\"/>
          
          &nbsp;".$show."</td>
          <td height=\"30\"align=\"right\" valign=\"middle\"   class=\"Date_txt\" nowrap>
          ".date('l, d/m/Y')."</td><td width=\"50px\" >
									<a href=\"http://www.primemoveindia.com\">
									<img src=\"".$folder."icon1.jpg\" alt=\"Go to home page\"  title=\"Click here to go to Home Page\"  border=\"0\" width=\"29\" height=\"27\" /></a>
					</td>
        </tr>
      </table>";
      
      return $t;
}
function footer(){
	print "<div class=\"footer\">Copyright &copy; 2009 Prime Move Technologies (P) Ltd. All Rights Reserved.</div>";
};
$image_folder="images/";
if(isset($_GET['e'])){
		$e=$_GET['e'];
		if($e==1){
	$error_made="Username or Password is wrong";
}
else if($e==2){
	$error_made="Please Enter Your Username And Password";
}
else if($e==3){
	$error_made="Please Re-enter Your Username And Password";
}
else if($e==5){
	$error_made="Due To Security Reasons You Are Not Allowed To Navigate Through URL Please Re-Login";
}
else{
	$error_made="";
}
}
//print $error_made;
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Prime Move Technologies Pvt Ltd</title>
<link href="css/reporting.css" rel="stylesheet" type="text/css" />
<!-- to show a icon in url title icon -->
<link rel="shortcut icon" href="./<?php print $image_folder;?>icon.gif" >

<script type="text/JavaScript">
<!--



function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function checkenter(e)
{
	
	var characterCode; //literal character code will be stored in this variable

	if(e && e.which){ 	//if which property of event object is supported (NN4)
		e = e;
		characterCode = e.which; //character code is contained in NN4's which property
		}
	else{
		e = event;
		characterCode = e.keyCode; //character code is contained in IE's keyCode property
		}

	if(characterCode == 13){ //if generated character code is equal to ascii 13 (if enter key)
		checkall(); //submit the form
		return false
		}
	else{
		return true
	}

}

function checkall() {
		
		
		
			if(document.getElementById('username').value=='') {
        alert("Enter User name !!");
        document.getElementById('username').focus();
        return false;
			}
			else if(document.getElementById('password').value=='') {
			  alert("Enter Password !!");
		    document.getElementById('password').focus();
		    return false;
			}
			else {document.getElementById('frmlogin').submit();}
		}
function clearall(){
			document.getElementById('error').innerHTML="";
		}
//-->
</script>
</head>
<center>
<body onLoad="document.getElementById('username').focus();">
<div id="main_div">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" summary=" ">
    <tr>
      <td height="101" colspan="4" align="left" valign="middle" class="Head"><img src="<?php print $image_folder;?>Compy_logo.jpg" alt="" width="195" height="68" /></td>
      </tr>
    <tr>
      <td width="100%" height="30" align="right" valign="top"  class="head_with_back_button">
      
      
      
       <?php 
      print get_table_link("Login","veiwicon.jpg");  
      ?>
      </td>
    </tr>
    <tr>
      <td  height="500"  colspan="4" align="center" valign="middle">
      <form action="logincheck.php" autocomplete="off" method="post" enctype="multipart/form-data" id="frmlogin">
        <table width="30%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="30" colspan="2" align="center" valign="middle" bgcolor="#FFB86E" class="Tbl_txt" style="border:#666666 1px solid;">Employee  Login</td>
          </tr>
          
          <tr>
            <td width="34%" height="158" align="center" valign="middle" background="<?php print $image_folder;?>tbl_bg.jpg"  style="border-bottom:#666666 1px solid; border-left:#666666 1px solid;"><img src="<?php print $image_folder;?>login_img.jpg" width="84" height="101" alt="" /></td>
            <td width="66%" background="<?php print $image_folder;?>tbl_bg.jpg"  style="border-bottom:#666666 1px solid; border-right:#666666 1px solid;"><table width="100%" border="0" cellspacing="5" cellpadding="0">
              <tr>
                <td width="50%" align="right" valign="middle" class="Date_txt" nowrap>Username :</td>
                <td width="50%" align="left" valign="middle" nowrap><label>
                  <input type="text" name="username" id="username"  onkeypress="checkenter(event);">
                </label></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="Date_txt" nowrap>Password :</td>
                <td align="left" valign="middle" nowrap><label>
                  <input type="password" name="password" id="password"  onkeypress="checkenter(event);">
                </label></td>
              </tr>
              <tr>
                <td align="right" valign="middle" nowrap>&nbsp;</td>
                <td align="left" valign="middle" nowrap><label>
                  <input name="button" type="button"   class="s_bt"  title=" Click To Login" onclick="javascript:checkall()" value="Login" />
                  </label>
                    <label>
                    <input type="reset" name="Submit2"  class="s_bt" value="Cancel" title="Click To Reset" />
                  </label></td>
              </tr>
            </table></td>
          </tr>
        </table>
          </form></td>
      </tr>
    <tr>
      <td height="30" colspan="4" align="center" valign="middle" class="Footer_txt"><?php footer();?></td>
    </tr>
  </table>
</div>
</body>
</center>
</html>
<?php  if($error_made!=""){print "<script type=\"text/JavaScript\">alert(\"".$error_made."\");</script>";}?>
