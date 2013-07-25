<?php
require_once('include/include.php'); 
require_once('include/workflow_functions.php');
$flag=$_GET['flag'];
switch($flag)
{
	case '1':
				$view="";
				$emplist=$_GET['list'];
				$emplist1=htmlspecialchars($emplist);
				$_SESSION['WF_EMP'].=",".$emplist1;  
				$data['selected_employees']=$_SESSION['WF_EMP'];
				$view=get_selected_employees($data); 
				break;	
	case '2':
				$view="";				
				$emplist=$_GET['rlist'];
				$emplist1=htmlspecialchars($emplist);
				$arr=explode(",",$emplist1);
				$wfemp=explode(",",$_SESSION['WF_EMP']);
				$tempAray=$wfemp;
				foreach($arr as $value)
				{		
					$key = array_search($value, $tempAray);  
					unset($tempAray[$key]);
				}
				$ss="";
				foreach($tempAray as $value)
				{		
					$ss.=($ss=="")?$value:",".$value;
				}
				$_SESSION['WF_EMP']=$ss;
				$data['selected_employees']=$_SESSION['WF_EMP'];
				$view=get_selected_employees($data); 
				break;					
}
print $view;
?>

