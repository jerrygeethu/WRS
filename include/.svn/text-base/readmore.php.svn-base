<?php
	require_once('class.file.php');
?>
<html>
	<head>
		<title>
			<?php 
				print $company_name;
			?>
			- Description - File
		</title>
	</head>
	<body>
		<form  action="readmore.php" name="readmore" id="readmore">
			<table class="Tbl_Txt_bo" width="100%" cellspacing="1" cellpadding="3"  border="0">
				<tr>
					<td>
						<?php
							$empid=$_SESSION['USERID'];
							$pop=$_GET['pop'];
							$query="select emp.fullname,file.title from employee as emp,fileshare as file where file.fileshareid='".$pop."' and emp.employeeid=file.uploadby";
							$result = $GLOBALS['db']->query($query);
							if(isset($result) and $result->num_rows>0) 
							{
								$row = $result->fetch_assoc();
							}
							echo "<tr colspan='2'><td align='center'><font face='Times New Roman' size='5'><b>".ucfirst($row['title'])."</b></font><tr/>";
						?>
						<tr>
							<td>
								<?php
									if(isset($_GET['pop']) and $_GET['pop']!='') 
									{
										$pop = $objfile->getpopdata($_GET['pop']);
										//print_r($pop);
										$pop_values="";
										foreach($pop as $value)
										{
											if($pop_values!="") 
											{
												$pop_values.=".";
											}
											$pop_values.=$value;
										}
										$pops=explode(".",$pop_values);
										$size_pop=sizeof($pops);
										for($i=0;$i<$size_pop;$i++)
										{
											echo ucfirst($pops[$i]).".&nbsp;";
										}
									}
								?>
							</td>
						</tr>
					</td>
				</tr>
			</form>
		</table>
	</body>
</html>
