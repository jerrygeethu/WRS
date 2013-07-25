<?php  
$message="";
require_once('include/include.php'); 
$emp_power=emp_authority($_SESSION['USERID']); 
require_once('include/compose_functions.php');  
$fromoptions= make_from_options($emp_power);
$tooptions= make_to_options($emp_power,$opt);
$opt=($opt=="")?$tooptions['opt']:$opt;
// ########################################################################
// ###################### config ######################################
// ########################################################################  
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php print $company_name;?>-Home </title> 
<link href="css/style.css" rel="StyleSheet">   
</head>
<body   >
<form method="post" action="compose.php" name="mailsform" id="mailsform"  >
<?php 
if($message!="")
 print "<div class=\"error\">".$message."</div>";

?>
<table width="550px" style="padding:2px;">
      <tr>
        <td >
        From
        </td>
        <td >
        <?php 
       print $fromoptions['select'];
       ?>
        <select class="select-style" id="from" name="from">
       <?php 
       print $fromoptions['field'];
       ?>
       </select>
        </td>
    </tr>
    <tr>
        <td colspan="2"> 
        <table>
            <tr>
                <td>To
                </td> 
                <td>
                
                 <select class="select-style" multiple="multiple" name="to_array[]" onClick="javascript:" id="to_array[]" size="7">
       <?php 
       foreach($tooptions['options1'] as $to1){
       print $to1; 
		 }
       ?>
       </select> 
                
                </td> 
                <td>
                 <input type="submit" name="m" id="m" value="<<" class="button-style"> <br/>
                 <input type="submit" name="t" id="t" value=">>" class="button-style"> 
        <input type="hidden" name="to2" id="to2" value="<?php print $opt; ?>" class="button-style">  
                </td> 
                <td>
                
       <select class="select-style" multiple="multiple" name="to_send_array[]"   id="to_send_array[]" size="7">
       <?php 
       foreach($tooptions['options2'] as $to2){
       print $to2;       
		 }
       ?>
       </select> 
       
                </td>
            </tr>
        </table>
        
        
        
       
       
        </td>
    </tr>
 
    
    <tr>
        <td >
        Subject
        </td>
        <td >
        <input type="text" name="sub_field" id="sub_field" class="input-style" value="">
        </td>
    </tr>
    
    
    
    
    <tr>
        <td  align="right"> 
        Message
        </td>
        <td >
        <textarea class="mail_content" name="message_field" id="message_field"></textarea>
        </td>
    </tr>
    
    
    <tr>
        <td  align="center" colspan="2">  
       
        <input type="submit" value="Publish"  id="p"  name="p" class="mail_button">
        <input type="reset" Value="Reset"  class="mail_button">
        </td>
    </tr>
     
</table>  
</form>
</body>
</html>
