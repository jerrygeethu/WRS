<?php   
if($_POST['t']){ 
	$opt="";
	if($_POST['to2']!="")
	$opt=$_POST['to2'];
	else
	$opt="";
	if($_POST['to_array']!=""){
	$to_array = $_POST['to_array'];
	foreach($to_array as $toadd){
		$opt.=($opt!="")?",":"";
		$opt.=$toadd;
	}  
	} 
}
else if($_POST['m']){ 
	$opt=$_POST['to2']; 
	if($opt!=""){
		$nn=explode(",",$opt);
		foreach($nn as $n){
		$curr[$n]="sendmail";
	}   
	if(!empty($_POST['to_send_array'])){ 
		$pp=$_POST['to_send_array'];    
				foreach($pp as $no){
					if(isset($curr[$no])){ 
						unset($curr[$no]);
					}  
				}  
		}
		$opt=""; 
	foreach($curr as $kk=>$vv){ 
		$opt.=($opt!="")?",":"";
		$opt.=$kk;
		
	} 
	} 
}else if($_POST['p']){  
	if(($_POST['sub_field']=="")||($_POST['message_field']=="")){
		$message=" Please enter subject / message";
	} else{
	$result=sendmessage($_POST);
	if($result==TRUE){ 

		print " 
		<script type=\"text/javascript\"> 
		alert(\"Mail send successfully\");
		window.close(); 
		</script> 
		"; 

	}
}
	}
 
 function sendmessage($data){
 	
	$mails['fromOption']=$data['fromOption'];
	$mails['from']=$data['from'];
	$mails['to']=$data['to2'];
	$mails['subject']=$data['sub_field'];
	$mails['message']=$data['message_field'];
 	
 	
 	$to=explode(",",$mails['to']);
 	foreach($to as $k=>$v){
 	 
 	if($v=="all"){
 		$emp['table']=" employee ";
 		$emp['fields']=" employeeid,email ";
 		$emp['where']= " where empstatus='active' ";
 		$query =" select ".$emp['fields']." from ".$emp['table']."   ".$emp['where']." ";
	$result = $GLOBALS['db']->query($query);   
 		while($row =$result->fetch_assoc()){
 			$empid[$row['employeeid']]=$row['employeeid'];
 			$mailids[$row['employeeid']]=$row['email'];
		}
	}else if($v=="admin"){
 		$emp['table']=" admindepart , employee ";
 		$emp['fields']=" employeeid ,email ";
 		$emp['where']= " where admindepart.employeeid =employee.employeeid ";
 		$query =" select ".$emp['fields']." from ".$emp['table']."   ".$emp['where']." ";
	$result = $GLOBALS['db']->query($query);   
 		while($row =$result->fetch_assoc()){
 			$empid[$row['employeeid']]=$row['employeeid'];
 			$mailids[$row['employeeid']]=$row['email'];
		}
	}else if($v=="hod"){
 		$emp['table']=" department,employee ";
 		$emp['fields']=" hod, email ";
 		$emp['where']= " where hod =employee.employeeid ";
 		$query =" select ".$emp['fields']." from ".$emp['table']."   ".$emp['where']." ";
	$result = $GLOBALS['db']->query($query);   
 		while($row =$result->fetch_assoc()){
 			$empid[$row['hod']]=$row['hod'];
 			$mailids[$row['hod']]=$row['email'];
		}
	}else if($v=="supervisor"){
 		$emp['table']=" schedule, employee ";
 		$emp['fields']=" supervisorid, email ";
 		$emp['where']= "  where  schstatus!='completed' and  supervisorid =employee.employeeid ";
 		$query =" select ".$emp['fields']." from ".$emp['table']."   ".$emp['where']." ";
	$result = $GLOBALS['db']->query($query);   
 		while($row =$result->fetch_assoc()){
 			$empid[$row['supervisorid']]=$row['supervisorid'];
 			$mailids[$row['supervisorid']]=$row['email'];
		}
	}
	else if($v>0){
		$empid[$v]=$v;
		$mailids[$v]=getemail($v);
		
	}
	$empids = array_values(array_unique($empid));	
}// foreach  
 	$timestamp=strftime("%Y-%m-%d %H:%M:%S %Y"); 
  $today=strftime("%Y-%m-%d %H:%M:%S", strtotime($timestamp));
  $insertmail="INSERT INTO email (emailid,sendertype, sender, subject, message, attachment1, attachment2, attachment3, senddate, status, prevmailids) VALUES (NULL, '".$mails['fromOption']."', '".$_SESSION['USERID']."', '".$mails['subject']."', '".$mails['message']."', '', '', '', '".$today."', 'sent', '0')"; 
 	$result = $GLOBALS['db']->query($insertmail);   
  $emailid=$GLOBALS['db']->insert_id;
  $flag=TRUE;
 	foreach($empids as $emp){
 		 $insertto="INSERT INTO emaildet (emaildetid, 	emailid ,	emailto ,	emailstatus) VALUES (NULL, '".$emailid."', '".$emp."', 'unread') "; 
  $resultTo = $GLOBALS['db']->query($insertto);   
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
    
	$flag=($resultTo==TRUE)?$flag:FALSE;
	}// foreach mail to 
 	
 	return $flag; 
}
function getemail($id){
	$query =" select email from employee where employeeid='".$id."'";
	$result = $GLOBALS['db']->query($query);   
 	$row =$result->fetch_assoc();
	return $row['email'];
}
function make_from_options($emp_power){ 
	$data['options']="";
	
	
	
	if($emp_power['is_superadmin']==1){
		$data['options'] .="<option value=\"MD\">Mail from Managing Director</option>";
	} 
	if($emp_power['is_admin']==1){
		$data['options'] .="<option value=\"admin\">Mail from Adminstrator</option>";
	} 
	if($emp_power['is_hod']==1){
		$data['options'] .="<option value=\"hod\">Mail from HOD</option>";
	} 
	if($emp_power['is_super']==1){
		$data['options'] .="<option value=\"supervisor\">Mail from Supervisor</option>";
	}
	
	if($emp_power['is_hr']==1){
		$data['options'] .="<option value=\"hr\">Mail from HR</option>";
	}
	
	$select ="<select  class=\"select-style\" id=\"fromOption\" name=\"fromOption\" ";
	$select .=($data['options']=="")?" style=\"display:none;\" ":"";
	$select .=" > ";
	$data['options'] .="<option value=\"employee\">Casual Mail</option>";
			$select .=	$data['options'];
	$select .="</select>";
	$data['select']=$select;
	 
	
	$data['field']="";
	
	
	
	if($emp_power['is_hr']==1){
		$data['mail']=getsettings('hremail'); 
		$mm=explode(",",$data['mail']); 
	$data['field'] .="<option value=\"".$emp_power['emp_id']."\">".$mm[0]."</option>"; 
	} 	
	$data['field'] .="<option value=\"".$emp_power['emp_id']."\">".$emp_power['emp_email']."</option>"; 
	return $data;	
}
 
function getdata($data){
	$table=$data['table'];
	$fields=$data['fields'];
	$where=$data['where'];
	$query =" select ".$fields." from ".$table."   ".	$where." ";
	$result = $GLOBALS['db']->query($query);  
	return $result->fetch_assoc(); 
}  
// if admin
function make_to_options($emp_power,$opt=""){  
	$data['options1']=array();
	$data['options2']=array();
	if($opt==""){
		$data['options2']['all']= "<option value=\"all\"  >All Employees</option>";
		$data['opt']= "all";
		
	}else{
	$opt23=explode(",",$opt);	
	foreach($opt23 as $oo){
		$opt2[$oo]="set";
	}
}  

	if (($opt!="")&&(isset($opt2['all']))) {
		$data['options2']['all']=  "<option value=\"all\"  >All Employees</option>";
	}else{ 
	$data['options1']['all']=    "<option value=\"all\" >All Employees</option>"; 
}   
	if (($opt!="")&&(isset($opt2['admin']))) {
		$data['options2']['admin']=  "<option value=\"admin\"  >All Administrators</option>";
	}else{ 
	$data['options1']['admin']=    "<option value=\"admin\" >All Administrators</option>"; 
}   
	if (($opt!="")&&(isset($opt2['hod']))) {
		$data['options2']['hod']=  "<option value=\"hod\"  >All HODs</option>";
	}else{ 
	$data['options1']['hod']=    "<option value=\"hod\" >All HODs</option>"; 
}   
	if (($opt!="")&&(isset($opt2['super']))) {
		$data['options2']['super']=  "<option value=\"super\"  >All Supervisors</option>";
	}else{ 
	$data['options1']['super']=    "<option value=\"super\" >All Supervisors</option>"; 
}   
	$query =" select employeeid,fullname from employee   where  empstatus ='active' order by fullname";
	$result = $GLOBALS['db']->query($query);
	while($row = $result->fetch_assoc()){ 
		$id=$row['employeeid'];
		if (($opt!="")&&(isset($opt2[$id]))) {
		$data['options2'][$id]=    "<option value=\"".$id."\" >".ucwords($row['fullname'])."</option>";	  
	}else{ 
	$data['options1'][$id]=    "<option value=\"".$id."\" >".ucwords($row['fullname'])."</option>"; 
} 
} 
if(empty($data['options1'])){
	$data['options1']['x']="<option value=\"0\">No More Employees</option>";
}
return $data; 
}

?>
