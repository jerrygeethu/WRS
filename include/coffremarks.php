<?php
	require_once('leavefun.php');
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
						?>
						<tr>
							<td>
								<?php
									if(isset($_GET['pop']) and $_GET['pop']!='') 
									{
										$pop =getpopdata($_GET['pop']);
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
