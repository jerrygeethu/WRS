<?php 


if(isset($_POST['btnsave'])){
 		$target_path = $target_path . basename( $_FILES['uploadedfile']['name']);  
		 $fileName = $target_path  ; 
			$pattern = ".+(csv)";     
      if (eregi($pattern,$_FILES['uploadedfile']['type'] )){ 
						if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) { 
								$fileflag=1;
								$msg="The file ".  basename( $_FILES['uploadedfile']['name']). 
								" has been uploaded";
						}else{
							$fileflag=0;
								$msg="There was an error uploading the file, please try again!";
						}
			}
			else{
				$msg="File type is not allowed to upload";
			} 
} 


					
					function deleteattendance(){ 
$query1=" delete from attendance  ";
	 $result_action_entry = $GLOBALS['db']->query($query1); 
					}
					function inserttodb($data){ 
$fileds[0]="department";
$fileds[1]="empid";
$fileds[2]="name";
$fileds[3]="date";
$fileds[4]="shift";
$fileds[5]="timein1";
$fileds[6]="timeout1";
$fileds[7]="timein2";
$fileds[8]="timeout2";
$fileds[9]="timein3";
$fileds[10]="timeout3";
$fileds[11]="hour"; 
$number_of_cols_to_read=12;  
$ff ="";
$vv ="";
for ($i=0; $i < $number_of_cols_to_read; $i++){ 
$h= $data[$i]; 
 if($i == 0) {
	 		$h="'".$h."'";
}else if($i == 1) { 		 
	$g=explode('"',$h);
	$h=$g[1] * 1;
}else if($i == 3) { 		
	$s=explode('"',$h);
$t= explode('/',trim($s[1]));
$h="'".$t[2]."-".$t[0]."-".$t[1]."'";  
}  else if( $i == 11 ){
	$s=explode('"',$h);
	$h=$s[1]+0;
}
$ff.= " , ".$fileds[$i]; 
 $vv .=" , ".$h; 
}    
$query=" 	INSERT INTO attendance ( attid ".$ff.") VALUES (NULL ".$vv .")  "; 
$result_action_entry = $GLOBALS['db']->query($query);  
 } 
 
					 	function updateattendance(){
					 		
					 		
					 		 
					 $query0="	 update attendance set leavetype = 'Sunday' where dayname(date) = 'Sunday' ";
	 $result_action_entry = $GLOBALS['db']->query($query0);  
	 
					 $query01="		update attendance set leavetype = '3rd Saturday' where dayname(date) = 'Saturday' and extract(day from date) between 15 and 21 ";
	 $result_action_entry = $GLOBALS['db']->query($query01);   
					 		
					 $query1="		update attendance set employeeid = (select employeeid from employee where empno = attendance.empid) 
where empid > 0 ";
	 $result_action_entry = $GLOBALS['db']->query($query1);  
					 $query2="	update attendance as a, leaveapplication as l, leavetype as lt set a.remarks = l.employeeremarks, a.leavetype = lt.name, a.days = (case when l.leavetypeid=5 then l.duration else  l.leavedays end)  where a.date = l.fromdate and l.employeeid = a.employeeid and l.sanctioned=1 and l.cancelled=0 and l.leavetypeid = lt.leavetypeid ";
	 $result_action_entry = $GLOBALS['db']->query($query2);  
	 $query3="	update attendance as a, leaveapplication as l, leavetype as lt set a.remarks = l.employeeremarks, a.leavetype = lt.name, a.days = (case when l.leavetypeid=5 then l.duration else  l.leavedays end)  where a.date between l.fromdate and l.todate and l.employeeid = a.employeeid and l.sanctioned=1 and l.cancelled=0 and l.leavetypeid = lt.leavetypeid ";
	 $result_action_entry = $GLOBALS['db']->query($query3);  
					 $query4="	update attendance as a, leaveapplication as l, leavetype as lt set a.remarks = l.employeeremarks, a.leavetype = lt.name + ' (Not Sanctioned)', a.days = (case when l.leavetypeid=5 then l.duration else  l.leavedays end)  where a.date = l.fromdate and l.employeeid = a.employeeid and l.sanctioned=0 and l.cancelled=0 and l.leavetypeid = lt.leavetypeid ";
	 $result_action_entry = $GLOBALS['db']->query($query4);  
	 $query5="	update attendance as a, leaveapplication as l, leavetype as lt set a.remarks = l.employeeremarks, a.leavetype = lt.name + ' (Not Sanctioned)', a.days = (case when l.leavetypeid=5 then l.duration else  l.leavedays end)  where a.date between l.fromdate and l.todate and l.employeeid = a.employeeid and l.sanctioned=0 and l.cancelled=0 and l.leavetypeid = lt.leavetypeid ";
	 $result_action_entry = $GLOBALS['db']->query($query5);  
						}

 function readcsvfile($csvfile){
$row = 1;
$file = fopen($csvfile, "r");
while (($data = fgetcsv($file, 8000, ",")) !== FALSE) {
    $num = count($data);
    $row++;
    for ($c=0; $c < $num; $c++) {
        $filedata[]=$data[$c];
        }
        
        }
fclose($file);
return $filedata;
}
?>
