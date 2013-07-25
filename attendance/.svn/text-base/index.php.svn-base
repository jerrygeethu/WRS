<?php   
$newFileName = "attendance.csv";  

require_once('../include/include.php');
$nameStr = ""; 

		$getdata =" select * from attendance order by name ";
$view_result = $GLOBALS['db']->query($getdata); 
				while($record = $view_result->fetch_assoc()){			 
    $name1="";
     foreach($record as $row){
     	$name1 .= ($name1 !="")? ",".$row:$row; 
		}
     $name=$name1; 
     
    $nameArray = explode(",",$name);  
    if(count($nameArray) > 1) 
    { 
            $nameTemp = "\n"; 
            for($i=0;$i < count($nameArray); $i++) 
            { 
                $nameTemp = $nameTemp . $nameArray[$i]; 
                 
                if($i != (count($nameArray) - 1)) {
                    $nameTemp = $nameTemp . ","; 
									}
            } 
            $name = $nameTemp; 
    } 
     
    $nameStr = $nameStr.$name.","; 
}  
$fpWrite = fopen($newFileName, "w"); 
fwrite($fpWrite,$nameStr);  
 header("Location:".$newFileName);  
?>
