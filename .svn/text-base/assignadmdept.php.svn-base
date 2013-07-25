<?php
$res="";
require_once('include/include.php');
$_SESSION['SEL_LINK']="ASAD";
require_once('include/parameters.php');
require_once('include/assign_functions.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php print $company_name;?>-Assign Admin To Department</title>
<link href="css/reporting.css" rel="stylesheet" type="text/css" />
<!-- to show a icon in url title icon -->
<link rel="shortcut icon" href="./images/icon.gif" >

<link href="css/saxan.css" rel="stylesheet" type="text/css" />
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
//-->
</script>
</head>
<center>
<body onload="MM_preloadImages('images/Home_Over.jpg','images/Dep_Over.jpg','images/Emp_Over.jpg','images/Sch_Over.jpg','images/Acti_Over.jpg','images/Vali_Over.jpg','images/View_Over.jpg','images/Daily_Over.jpg','images/Change_Over.jpg','images/Log_Over.jpg')">
<div id="main_div">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" summary=" ">
    <tr>
      <td height="101" colspan="2" align="left" valign="middle" class="Head"><img src="images/Compy_logo.jpg" alt="" width="195" height="68" /></td>
      </tr>
    <tr>
      <td width="159" rowspan="2" align="left" valign="top" class="menu_back">
      
        <?php 
      $menu=show_menu();
      print $menu;
      ?>
      
      </td>
      <td width="100%" height="30" valign="top" class="head_with_back_button">
       <?php print get_table_link("Assign Admin","assignadicon.jpg");?>
      </td>
    </tr>
    <tr>
      <td  height="580px" align="center" valign="top"  class="main_content_p">
      <table border="0" class="data_align" width="95%">
	        <tr>
	            <td valign="top">
              <!-- *************************************  -->
              <!-- *************************************  -->
              <!-- *************************************  -->
              <div class="table_heading">Select Admin</div>
              <table border="0" valign="center" id="adm_list" name="adm_list"  class="main_content_table">
              
                <?php 
                    $adm_result=get_adm_list();
                    print $adm_result;
                ?>
                <tr align="center"  >
                <th colspan="6">***</th></tr>
            </table>
            	<!-- *************************************  -->
              <!-- *************************************  -->
              </td>
              
              <!-- *************************************  -->
              <!-- *************************************  -->
              <!-- *************************************  -->
              <?php 
          // print $res;
           if($e!=""){// if loop of if emploee id is available;
           ?>
           <td  valign="top">
               <div class="table_heading">Assign Departments To Admin :<?php print ucwords($name);?></div>
               <form method="POST" action="assignadmdept.php">
            <table border="0"  id="adm_list" name="adm_list" valign="center"   class="main_content_table">
                    <?php 
                    list($dep_result,$t)=get_dep_list($e,$name);
                    print $dep_result;
                    ?>
<!-- ********************************************** -->
<tr align="center"  bgcolor="#ffffff"><th colspan="3">
<input type="hidden" value="<?php print $e;?>" id="employeeid" name="employeeid" />
<input type="hidden" value="<?php print $t;?>" id="tot_dep" name="tot_dep" />
<input type="submit" class="s_bt" value="   Save  "  title="Click To Update"/>
<input type="Reset"  class="s_bt"  value="  Reset  "  title="Click To Reset "/>


</th></tr>
<tr align="center"><th colspan="3">***</th></tr>
<!-- ********************************************** -->
            </table>
            </form>
              </td>
            <?php 
				 }// if loop of if employee id is available;
				 ?>
              <!-- *************************************  -->
              <!-- *************************************  -->
              <!-- *************************************  -->
          </tr>
      </table>
      
      
      
      
              </td>
          </tr>
      </table>
      
	    
	    
	    
	    </td>
    </tr>
     <tr>
     
      <td height="30" colspan="4" align="center" valign="middle"  class="Footer_txt">
      <?php footer();?>
      </td>
    </tr>
  </table>
</div>
</body>
</center>
</html>
<?php if($res!=""){print "<script>alert(\"".$res."\");</script>";}
