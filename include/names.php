<?php
	require_once('class.file.php');
	if(isset($_GET['pop']) and $_GET['pop']!='') 
	{
		$pop = $objfile->getpopnames($_GET['pop']);
		$pop_values="";
		foreach($pop as $value)
		{
			if($pop_values!="") 
			{
				$pop_values.=",";
			}
			$pop_values.=$value;
		}
		$query_fullname="select fullname, employeeid from employee where employeeid in (".$pop_values.") order by fullname";
		$result_fullname= $GLOBALS['db']->query($query_fullname);
		if(isset($result_fullname) and $result_fullname->num_rows>0) 
		{ 
			while($row_fullname = $result_fullname->fetch_assoc())
			{
				echo ucfirst($row_fullname['fullname'])."<br/>";
			}
		}
	}
?>
