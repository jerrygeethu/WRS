<?php
// Database Variables
	$dbhost = "192.168.1.3";
	$dbuser = "root";
	$dbpass = "root123";
	$dbname = "wrsnew";

//online 
/*	$dbhost = "localhost";
	$dbuser = "primemov_primemo";
	$dbpass = "bestindustry";
	$dbname = "primemov_reports";
*/
// To create connection
	$db = new mysqli($dbhost,$dbuser,$dbpass,$dbname);

// to set the time to indian standard time
date_default_timezone_set('Asia/Calcutta');
// to set the time to indian standaerd time

// to set variables
$name_query=" select value from settings where name='company_short_name' ";
		$result_name22 = $GLOBALS['db']->query($name_query);
		$row_name22 = $result_name22->fetch_assoc();
		$company_name=$row_name22['value'];


// To set session
	session_start();
	$_SESSION['USERID'];
	$_SESSION['NAME'];
	
	$_SESSION['FOLDER']="images/";
	 
	
	
	
	if(!(isset($_SESSION['USERID']))&&(!isset($_POST['username']))){
		header("location:index.php?e=3");
		exit;
	}
$ref = getenv('HTTP_REFERER');
if(!($ref)){
	//header("location:index.php?e=5");
}

	require_once('get_emp_power.php');
	require_once('common_functions.php');

	function getsettings($name){
		$setting_query=" select value from settings where name='".$name."' ";
		$result_settings = $GLOBALS['db']->query($setting_query);
		$row_settings = $result_settings->fetch_assoc();
		return $row_settings['value'];
	} 
////////////////////////////////////////////////////////////
//Get all possible values for an ENUM or SET column as an Array
//arguments:tablename,column name
//return: array
function getEnumValues($table,$column){

    $query_enum = "SHOW COLUMNS FROM $table LIKE '$column' ";
	$resultenum = $GLOBALS['db']->query($query_enum);

	if($resultenum->num_rows > 0){
        $rowenum=$resultenum->fetch_row();
        $options=explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2",$rowenum[1]));
    }

	return $options;

}
function getsession($p){
return getsss($p);	
	}
	

function menu(){
/*
	
	//print $_SESSION['ISADMIN'];
	$emp_power=emp_authority($_SESSION['USERID']);
	//print_r($emp_power);
	$menu="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\">"
	."<a href='home.php'>Home</a></td></tr>";



//this if loop for links to be viewable upto super administrator power...
if($emp_power['is_superadmin'] =='1'){
	$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\"><a href='department.php'>Department</a></td></tr>";
	//$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\" nowrap=\"true\"><a href='assignadmdept.php'>Assign Dep To Admin</a></td></tr>";
}

//this if loop for links to be viewable upto 3rd stage of power...
if(($emp_power['is_superadmin'] =='1')||($emp_power['is_admin'] =='1')||($emp_power['is_hod'] =='1')){
	$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\"><a title=\"Edit an employee or assign work\" href=\"viewemployee.php\">Employee</a></td></tr>";
	//	$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\"><a href='assignschwork.php'>Schedules</a></td></tr>";
}

	$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\"><a title=\"Edit an employee or assign work\" href=\"employeelist.php\">Employee List</a></td></tr>";






//this if loop for links to be viewable upto super administrator power...
if($emp_power['is_superadmin'] =='1'){
	$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\" nowrap=\"true\"><a href='assignadmdept.php'>Assign Dep To Admin</a></td></tr>";
}

//this if loop for links to be viewable upto 2nd stage of power...
if(($emp_power['is_superadmin'] =='1')||($emp_power['is_admin'] =='1')){
    $menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\" nowrap=\"true\"><a href='assignhoddep.php'>Assign HOD To Dep </a></td></tr>";
}

//this if loop for links to be viewable upto 3rd stage of power...
if(($emp_power['is_superadmin'] =='1')||($emp_power['is_admin'] =='1')||($emp_power['is_hod'] =='1')){
	//$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\"><a title=\"Edit an employee or assign work\" href=\"viewemployee.php\">Employee</a></td></tr>";
	  $menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\"><a href='assignschwork.php'>Schedules</a></td></tr>";
}

//activity list Add/Edit
if($emp_power['is_superadmin'] =='1'){
	
	$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\" nowrap=\"true\"><a href='activity.php'>Activity List</a></td></tr>";
}



//this if loop for links to be viewable upto 4th stage of power...
if(($emp_power['is_superadmin'] =='1')||($emp_power['is_admin'] =='1')||($emp_power['is_hod'] =='1')||($emp_power['is_super'] =='1')){
//$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\"><a href=\"report_validation.php\">Validate Reports</a></td></tr>";
$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\"><a href=\"rep_valid.php\">Validate Reports</a></td></tr>";
$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\"><a href='viewreport.php'>View Reports</a></td></tr>";
}

// here comes the common page access to super admin, admin, hod, spervisor
$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\"><a title=\"Enter your daily work details\" href='schedule.php'>Daily Report</a></td></tr>";
$menu.="<tr><td height=\"20\" nowrap align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\"><a href='changepass.php' title=' Change Your Login Password'>Change Password</a></td></tr>";
	$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\"><a href='logout.php'>Logout</a></td></tr>";




*/



/*
	if($emp_power['is_superadmin'] =='1'){
	$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\">"
	."<a href='department.php'>Department</a></td></tr>";
	
	$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\"><a title=\"Edit an employee or assign work\" href=\"viewemployee.php\">View Employee</a></td></tr>";
	$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\"><a href='assignschwork.php'>Schedules</a></td></tr>";
	$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\" nowrap=\"true\"><a href='assignadmdept.php'>Assign Dep To Admin</a></td></tr>";
	$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\" nowrap=\"true\"><a href='assignhoddep.php'>Assign Hod to Dep </a></td></tr>";
	$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\">
	<a href='viewreport.php'>View Report</a></td></tr>";
   $menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\"><a href=\"report_validation.php\">Validate Reports</a></td></tr>";
    $menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\"><a title=\"Enter your daily work details\" href='schedule.php'>Daily Report</a></td></tr>";

	}
	else if($emp_power['is_admin']=='1' ){
	//$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\">"
	//."<a href='department.php'>Department</a></td></tr>";
	$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\"><a title=\"Edit an employee or assign work\" href=\"viewemployee.php\">View Employee</a></td></tr>";
	$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\"><a href='assignschwork.php'>Schedules</a></td></tr>";
	//$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\" nowrap=\"true\"><a href='assignadmdept.php'>Assign Dep To Admin</a></td></tr>";
	$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\" nowrap=\"true\"><a href='assignhoddep.php'>Assign Hod to Dep </a></td></tr>";
	$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\"><a href='viewreport.php'>View Report</a></td></tr>";
   $menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\"><a href=\"report_validation.php\">Validate Reports</a></td></tr>";
    $menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\"><a title=\"Enter your daily work details\" href='schedule.php'>Daily Report</a></td></tr>";

	}

else if($emp_power['is_admin']=="0" && $emp_power['is_super']!='1'){
	$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\"><a title=\"Enter your daily work details\" href='schedule.php'>Daily Report</a></td></tr>";
}

else if($emp_power['is_super']=='1'){
	$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\"><a href=\"viewreport.php\">View Reports</a></td></tr>";
	$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\"><a href=\"report_validation.php\">Validate Reports</a></td></tr>";
	//$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\">Employee</td></tr>";
	$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\"><a title=\"Edit an employee or assign work\" href='viewemployee.php'>View Employee</a></td></tr>";
	$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\"><a href='assignschwork.php'>Schedules</a></td></tr>";
	$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\"><a title=\"Enter your daily work details\" href='schedule.php'>Daily Report</a></td></tr>";
}
	$menu.="<tr><td height=\"20\" nowrap align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\"><a href='changepass.php' title=' Change Your Login Password'>Change Password</a></td></tr>";
	$menu.="<tr><td height=\"20\" align=\"left\" valign=\"middle\" background=\"images/tbl_bg1.jpg\" class=\"menu_txt\"><a href='logout.php'>Logout</a></td></tr>";
	*/
	return ucwords($menu);
} 

////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
function check_submission($first,$second,$third){
					if(isset($_SESSION['FIRST_VALUE'])){
						if(($_SESSION['FIRST_VALUE']==$first)&&($_SESSION['SECOND_VALUE']==$second)&&($_SESSION['THIRD_VALUE']==$third)){
							return false;
						}
					else{
						$_SESSION['FIRST_VALUE']=$first;
						$_SESSION['SECOND_VALUE']=$second;
						$_SESSION['THIRD_VALUE']=$third;
						return true;
					}
	}
	else{
						$_SESSION['FIRST_VALUE']=$first;
						$_SESSION['SECOND_VALUE']=$second;
						$_SESSION['THIRD_VALUE']=$third;
						return true;
					}
}

////////////////////////////////////////////////////////////
//Convert date format from d/m/y to y-m-d
//Arguments:String,char
//return: String
function dmyToymd($dmydate, $needle="/")
	{
		$darr = array();
		$darr = split($needle, $dmydate);
		if (count($darr) == 3)
		return date("Y-m-d", mktime(0,0,0,$darr[1],$darr[0],$darr[2]));
		else
			return "2009-01-01";
	}
////////////////////////////////////////////////////////////
//Convert date format  from y-m-d to d/m/y
function ymdToDmy($ymddate, $needle="-",$bit=0)
	{
		
		if($bit==1)
		$data=explode(" ",$ymddate);
		else
		$data[0]=$ymddate;
		
		
		$dat=explode($needle,$data[0]);
		$dmydate=$dat[2]."/".$dat[1]."/".$dat[0];
		
		
/*
		
		
		$darr = array();
		$darr = split($needle, $ymddate);
		if($darr[0]!="0000") {
			if (count($darr) == 3)
				return date("d/m/Y", mktime(0,0,0,$darr[1],$darr[2],$darr[0]));
			else
				return "01/01/2009";
		}
*/
		return $dmydate;
	}
////////////////////////////////////////////////////////////
function printarray($arr){
	print "<pre>";
	print_r($arr);
	print "</pre>";
}

function from24to12($time)

{

return date('g:i:sa', strtotime($time));

}
function inarraycheck($v,$arr,$k=0)
{
$flag=FALSE;$v=trim($v);foreach ($arr as $key=>$value){  if(($k==0) &&($v==trim($value))){ $flag=$v;}if(($k==1)&&($v==trim($value))){$flag=TRUE;} } return $flag;
}
 

/*
function trunc($string, $start = 0,$length = 100 ,$append="...",$roundof=5)
	{  
		if (strlen($string) < $length)
		{ 
			return $string; 
		}
		else
		{  
			$around=$length-$roundof; 
			$whitespaceposition = strpos($string," ",$around); 
			$truncated = substr($string, 0, $whitespaceposition); 
			$truncated.=$append; 
			return $truncated; 
		} 
		return true; 
	}

*/

////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////// PAGINATION ///////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////TO ACCESS PAGINATION, PLEASE INCLUDE THE CODE  PASTED BELOW THIS FUNCTION ////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////


function qooqle($url,$start,$num,$pre,$nxt,$count)
{


	$show=$start+$count;
	if($num<=$show){
$count_show=$num-$start;
	}
	else{
$count_show=$count;
	}

	$cur=$start+1;
print <<<HTML
<table  border="1" width="100%"  cellpadding="3" cellspacing="3" >
    <tr align="center">
        <td width="10%" nowrap>
HTML;
if($pre>=0){
			print "<a href='".$url."?start=".$pre."&count=".$count."'><font color='yellow'> << Previous</font></a>";
			}
			else{
	    print "&nbsp;";
            }
print "</td>";
print "<td width=\"80%\">";
		print "<font color='yellow' >Displaying ".$count_show." rows from a total of ".$num." rows </font>";

        print"</td>";

	print "<td width=\"10%\" nowrap>";

			if($nxt<$num){

			print "<a href='".$url."?start=".$nxt."&count=".$count."'><font color='yellow'>Next >> </font></a>";

		}

		print "</td> </tr></table>";







		}


//print qooqle("http://www.google.com",25,25,15,35,10);

////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////// Include this code for pagination ///////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
