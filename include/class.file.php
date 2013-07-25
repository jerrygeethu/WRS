<?php
	require_once('include.php');
	//require_once('include/upload.php');
	$data['fileSize'] = 100000;
	$current_date=date("Y-m-d");
	$objfile = new fileshare();

	class fileshare 
	{
		// To save OR update departments record to DB Table
		// This function using in editdepartment.php
		
		public function insertfile($arr,$up_date,$file1,$file2,$file3,$editid,$delid)
		{
	/*
			echo "file1 = " . $file1 . "<br/>";
			echo "file2 = " . $file2 . "<br/>";
			echo "file3 = " . $file3 . "<br/>";
	*/


	/*
			foreach ($arr as $key => $value) 
			{
				echo "Key: $key; Value: $value<br />\n";

				//echo $value. "<br />";
			}
			echo "dzgfvk: ".$arr['privillage']."<br />";
			(select emp.fullname, file.fileshareid, file.title, file.description, file.file1, file.file2, file.file3, DATE_FORMAT(file.date,'%d-%m-%Y') as date, DATE_FORMAT(file.expiry,'%d-%m-%Y') as expiry, file.uploadby from fileshare as file, employee as emp where file.status='active' and emp.employeeid=file.uploadby and file.privillage='private' and file.employeeid like'%29%')
	*/


			$emps=$arr['choose_employees'];
			//print_r($emps);

			$emps_values="";
			if($emps)
			{
			foreach($emps as $value)
			{
				if($emps_values!="") { $emps_values.=",";}
				$emps_values.=$value;
			}
	}

			//echo $emps_values;
	/*
			$emps_values1=(explode(",",$emps_values));
			echo "<br />";
			echo $emps_values1[0]."<br />";
				echo $emps_values1[1]."<br />";
					echo $emps_values1[2]."<br />";
						echo $emps_values1[3]."<br />";
							echo $emps_values1[4]."<br />";
	*/
			
				//echo "date = " . $up_date . "<br />" . "file1 = " . $file1. "<br />" . "file2 = " . $file2 . "<br />" ."file3 = " .  $file3 . "<br />" ."editid = " .  $editid;

				$empid=$_SESSION['USERID'];

			//To delete the value using delete button
			if(isset($delid) and $delid>0) 
			{
				$query = "UPDATE fileshare SET status = '" . inactive . "' where fileshareid = '" . $delid ."'";
				$val = $GLOBALS['db']->query($query);
				if(isset($val) and $val==1)
				 {
					header('Location: file.php?del=1');
					exit;
				  } 
				 else 
				 {
				  header('Location: file.php?del=0');
				  exit;
				  }
			 }
			 
			 //To edit the value using save button
			else if(isset($editid) and $editid>0)
			{
				$queryedit="select distinct file.uploadby, emp.departmentid from fileshare as file, employee as emp where file.uploadby=emp.employeeid and  emp.departmentid='".$emp_power['emp_deptid']."' ";
				$resultedit = $GLOBALS['db']->query($queryedit);
				if(isset($resultedit) and $resultedit->num_rows>0) 
				{
					$fileupload="";
					while($rowedit = $resultedit->fetch_assoc())
					{
						//echo $rowedit['uploadby'];
						if($fileupload!="")
					{
						$fileupload.=",";
					}
					$fileupload.=$rowedit['uploadby'];
					}
				}
				//echo "fileupload: ".$fileupload."<br/>";
				$query1="select file1,file2,file3, employeeid from fileshare where fileshareid = '" . $editid . "'";
				$result = $GLOBALS['db']->query($query1);
				if(isset($result) and $result->num_rows>0) 
				{
					$row = $result->fetch_assoc();
				}
				//print_r($row);
				if($file1!="")
				{
					$file11=$file1;
				} 	
				else
				{
					$file11=$row['file1'];
				}
				
				if($file2!="")
				{
					$file22=$file2;
				} 	
				else
				{
					$file22=$row['file2'];
				}
				
				if($file3!="")
				{
					$file33=$file3;
				} 	
				else
				{
					$file33=$row['file3'];
				}
				$current_date=date("Y-m-d");
					$query = "UPDATE fileshare SET referenceid = '".$arr['referenceid']."', title = '".$arr['title']."' , description='".$arr['description']."' , file1= '".$file11."', file2='".$file22."' , file3 = '".$file33."',date ='".$current_date."' , expiry = '".$up_date."' , status = '" . $arr['status'] . "' , privillage='".$arr['privillage']."' , employeeid='".$emps_values."' where fileshareid = '" . $editid ."'";
					$GLOBALS['db']->query($query);
					header('Location: file.php');
					exit;
			}
			 
			 //To inset the value using save button
			else if(isset($arr['title']) and $arr['title']!='') 
			{
				$current_date=date("Y-m-d");
				if($emps_values=="")
					{
						$emps_values=0;
					}
					$query ="insert into fileshare (fileshareid, referenceid, title, description, date, expiry, file1, file2, file3, status, employeeid, privillage, uploadby)
					values ('','" . $arr['referenceid'] . "','" .$arr['title'] ."','".$arr['description']. "','" .$current_date. "','" .$up_date ."', '" .$file1 . "', '".$file2 ."', '".$file3 ."','".$arr['status']."','".$emps_values."','".$arr['privillage']."','".$empid."')";
					$result =$GLOBALS['db']->query($query);
					header('Location: file.php');
					exit;
			}
		}
		
		
		// This function using in view
		// To list department list
		public function showfiles($search,$emp_power,$start,$limit)
		{	
			$empid=$_SESSION['USERID'];
			$deptid=$emp_power['emp_deptid'];
			$currentdate=date("Y-m-d");	
/*
			$query_pub="select fileshareid, employeeid, uploadby from fileshare where privillage='public' and status='active' and uploadby='".$empid."'";
			$result_pub= $GLOBALS['db']->query($query_pub);
			if(isset($result_pub) and $result_pub->num_rows>0) 
			{ 
				$pub_fileid="";
				while($row_pub = $result_pub->fetch_assoc())
				{
					if($pub_fileid!="")
					{
						$pub_fileid.=",";
					}
					$pub_fileid.=$row_pub['fileshareid'];
				}
			}
*/
			$query_emp="select fileshareid, employeeid, uploadby from fileshare where privillage='private' and status='active'";
			$result_emp= $GLOBALS['db']->query($query_emp);
			if(isset($result_emp) and $result_emp->num_rows>0) 
			{ 
				$fileshareid="";
				$employeeid_hod="";
				$uploadby="";
				while($row_emp = $result_emp->fetch_assoc())
				{	
					$employeeid="";
					$upload="";	
					$employeeid.=$row_emp['employeeid'].",".$row_emp['uploadby'];
					$upload.=$row_emp['uploadby'];
					$emp=(explode(",",$employeeid));
					//print_r($emp);
					if($employeeid_hod!="")
					{
						$employeeid_hod.=",";
					}
					$employeeid_hod.=$employeeid;
					if($uploadby!="")
					{
						$uploadby.=",";
					}
					$uploadby.=$upload;
					if(in_array($empid,$emp))
					{
						if($fileshareid!="")
						{
							$fileshareid.=",";
						}
						$fileshareid.=$row_emp['fileshareid'];
					}		
				}
			}
/*
			if(($emp_power['is_superadmin']=='1')  && ($emp_power['is_admin'] ==1))
			{
				$queryadmin="select fileshareid, employeeid, uploadby from fileshare where status='active'";
				$resultadmin= $GLOBALS['db']->query($queryadmin);
				if(isset($resultadmin) and $resultadmin->num_rows>0) 
				{ 
					$flids="";
					while($rowadmin = $resultadmin->fetch_assoc())
					{
						//secho $rowadmin['fileshareid'];
						if($flids!="")
						{
							$flids.=",";
						}
						$flids.=$rowadmin['fileshareid'];
					}	
				}
				//echo "flid: ".$flids."<br/>";
			}
			elseif (($emp_power['is_hr'] ==1) || ($emp_power['is_hod'] ==1))
			{
				//echo "pub_fileid: ".$pub_fileid."<br/>";
				//echo "fileshareid: ".$fileshareid."<br/>";	
				$fileid=$fileshareid.",".$pub_fileid;
				//echo "fileid: ".$fileid."<br/>";	
				//echo "<br/>".$employeeid_hod."<br/>";
			}
*/
			if($emp_power['is_hod']==1)
			{
				$fileids="";
				$emphod1="";
				$hodemp="select employeeid from employee where employeeid in (".$employeeid_hod.") and departmentid='".$deptid."'";
				$res = $GLOBALS['db']->query($hodemp);
				if(isset($res) and $res->num_rows>0) 
				{
					
					while($row = $res->fetch_assoc())
					{	
						$emphod=$row['employeeid'];
						
						$getPvtFiles="select  fileshareid,employeeid,uploadby from fileshare where privillage='private' and status='active'";
						$res_file = $GLOBALS['db']->query($getPvtFiles);						
						while($row_file = $res_file->fetch_assoc())
						{	
							$pvtEmps=$row_file['employeeid'];
							$arrpvtEmps=explode(",",$pvtEmps);
							if(in_array($emphod,$arrpvtEmps))
							{
								if($fileids!="")
								{
									$fileids.=",";
								}
								$fileids.=$row_file['fileshareid'];
							}
						}							
								
					}
				}
			}
			$query_dept="select distinct emp.departmentid from employee as emp where emp.employeeid in (".$employeeid_hod.")";
			$result_dept= $GLOBALS['db']->query($query_dept);
			if(isset($result_dept) and $result_dept->num_rows>0) 
			{
				$depart="";
				while($row_dept = $result_dept->fetch_assoc())
				{
					//echo $row_dept['departmentid']." ";
					if($depart!="")
					{
						$depart.=",";
					}
					$depart.=$row_dept['departmentid'];
				}
			}
/*			
			$result_pagination = $GLOBALS['db']->query($query_pagination);
			$num=$result_pagination->num_rows;	
			$_SESSION['pagination']=$num;
*/
			//echo "num: ".$num;
			
			
			$query="";
			if(($emp_power['is_superadmin']==1))
			{
				$query.="select emp.fullname, file.uploadby, file.employeeid, file.fileshareid, file.title, file.description, length(file.description) as length, file.file1, file.file2, file.file3, 
										 DATE_FORMAT(file.date,'%d-%m-%Y') as date, DATE_FORMAT(file.expiry,'%d-%m-%Y') as expiry, file.privillage,
										 file.uploadby from fileshare as file, employee as emp where file.status = 'active' and '" . $currentdate . "' 
										 <= file.expiry and emp.employeeid=file.uploadby and (emp.fullname LIKE '%".$search."%' or file.title 
										 LIKE '%".$search."%' or file.description LIKE '%".$search."%' or file.file1 LIKE '%".$search."%'
										 or file.file2 LIKE '%".$search."%' or file.file3 LIKE '%".$search."%') order by privillage
										 limit ".$start.",".$limit;
			}
			elseif(($emp_power['is_hod']==1) && ($emp_power['is_superadmin']!=1))
			{
				if($fileids=="")
				{		
					$query.="select emp.fullname, file.uploadby, file.employeeid, file.fileshareid, file.title, file.description, length(file.description) as length, file.file1, file.file2, file.file3, 
										 DATE_FORMAT(file.date,'%d-%m-%Y') as date, DATE_FORMAT(file.expiry,'%d-%m-%Y') as expiry, file.privillage,
										 file.uploadby from fileshare as file, employee as emp where file.status = 'active' and file.privillage = 'public' 
										 and '" . $currentdate . "' <= file.expiry and emp.employeeid=file.uploadby and (emp.fullname LIKE '%".$search."%'
										 or file.title LIKE '%".$search."%' or file.description LIKE '%".$search."%' or file.file1 LIKE '%".$search."%'
										 or file.file2 LIKE '%".$search."%' or file.file3 LIKE '%".$search."%')	
										 limit ".$start.",".$limit;		
				}
				else
				{
					$query.="(select emp.fullname, file.uploadby, file.employeeid, file.fileshareid, file.title, file.description, length(file.description) as length, file.file1, file.file2, file.file3, 
											 DATE_FORMAT(file.date,'%d-%m-%Y') as date, DATE_FORMAT(file.expiry,'%d-%m-%Y') as expiry, file.privillage,
											 file.uploadby from fileshare as file, employee as emp where file.status = 'active' and file.privillage = 'public' 
											 and '" . $currentdate . "' <= file.expiry and emp.employeeid=file.uploadby and (emp.fullname LIKE '%".$search."%'
											 or file.title LIKE '%".$search."%' or file.description LIKE '%".$search."%' or file.file1 LIKE '%".$search."%'
											 or file.file2 LIKE '%".$search."%' or file.file3 LIKE '%".$search."%'))
								union
							(select emp.fullname, file.uploadby, file.employeeid, file.fileshareid, file.title, file.description, length(file.description) as length, file.file1, file.file2, file.file3, 
											 DATE_FORMAT(file.date,'%d-%m-%Y') as date, DATE_FORMAT(file.expiry,'%d-%m-%Y') as expiry, file.privillage,
											 file.uploadby from fileshare as file, employee as emp where file.status = 'active' and file.privillage = 'private' and
											 file.fileshareid in (".$fileids.") and '" . $currentdate . "' <= file.expiry and emp.employeeid=file.uploadby  and 
											 (emp.fullname LIKE '%".$search."%' or file.title LIKE '%".$search."%' or file.description LIKE '%".$search."%' or 
											 file.file1 LIKE '%".$search."%' or file.file2 LIKE '%".$search."%' or file.file3 LIKE '%".$search."%'))
								union
							(select emp.fullname, file.uploadby, file.employeeid, file.fileshareid, file.title, file.description, length(file.description) as length, file.file1, file.file2, file.file3, 
											 DATE_FORMAT(file.date,'%d-%m-%Y') as date, DATE_FORMAT(file.expiry,'%d-%m-%Y') as expiry, file.privillage,
											 file.uploadby from fileshare as file, employee as emp where file.status = 'active' and file.privillage = 'private' and
											 emp.departmentid in (".$deptid.") and '" . $currentdate . "' <= file.expiry and emp.employeeid=file.uploadby  and 
											 (emp.fullname LIKE '%".$search."%' or file.title LIKE '%".$search."%' or file.description LIKE '%".$search."%' or 
											 file.file1 LIKE '%".$search."%' or file.file2 LIKE '%".$search."%' or file.file3 LIKE '%".$search."%'))
											 limit ".$start.",".$limit;
				}
			}
			else
			{
				//echo $fileshareid."<br/>";
				//print_r($fileshareid);
				//echo "<br/>fileshareid: ".$fileshareid_size=sizeof($fileshareid);	
				//echo "<br/>".$fileshareid."<br/>";
						
				if($fileshareid=="")
				{					
					$query.= "select emp.fullname, file.uploadby, file.employeeid, file.fileshareid, file.title, file.description, length(file.description) as length, file.file1, file.file2, file.file3, 
										 DATE_FORMAT(file.date,'%d-%m-%Y') as date, DATE_FORMAT(file.expiry,'%d-%m-%Y') as expiry, file.privillage,
										 file.uploadby from fileshare as file, employee as emp where file.status = 'active' and file.privillage = 'public' 
										 and '" . $currentdate . "' <= file.expiry and emp.employeeid=file.uploadby and (emp.fullname LIKE '%".$search."%'
										 or file.title LIKE '%".$search."%' or file.description LIKE '%".$search."%' or file.file1 LIKE '%".$search."%'
										 or file.file2 LIKE '%".$search."%' or file.file3 LIKE '%".$search."%')
										 limit ".$start.",".$limit;
				}
				else
				{
					$query.= "(select emp.fullname, file.fileshareid, file.employeeid, file.title, file.description, length(file.description) as length, file.file1, file.file2, file.file3, 
										 DATE_FORMAT(file.date,'%d-%m-%Y') as date, DATE_FORMAT(file.expiry,'%d-%m-%Y') as expiry, file.privillage,
										 file.uploadby from fileshare as file, employee as emp where file.status = 'active' and file.privillage = 'public' 
										 and '" . $currentdate . "' <= file.expiry and emp.employeeid=file.uploadby and (emp.fullname LIKE '%".$search."%'
										 or file.title LIKE '%".$search."%' or file.description LIKE '%".$search."%' or file.file1 LIKE '%".$search."%'
										 or file.file2 LIKE '%".$search."%' or file.file3 LIKE '%".$search."%'))
									 union
							 (select emp.fullname,file.fileshareid, file.employeeid, file.title, file.description, length(file.description) as length, file.file1, file.file2, file.file3, DATE_FORMAT(file.date,'%d-%m-%Y') 
										 as date, DATE_FORMAT(file.expiry,'%d-%m-%Y') as expiry, file.privillage, file.uploadby from fileshare as file, employee as emp 
										 where file.status='active' and '" . $currentdate . "' <= file.expiry and emp.employeeid=file.uploadby and file.fileshareid in (".$fileshareid.")
										 and (emp.fullname LIKE '%".$search."%' or file.title LIKE '%".$search."%' or file.description LIKE '%".$search."%' 
										 or file.file1 LIKE '%".$search."%' or file.file2 LIKE '%".$search."%' or file.file3 LIKE '%".$search."%'))
									 union 
							 (select emp.fullname, file.fileshareid, file.employeeid, file.title, file.description, length(file.description) as length, file.file1, file.file2, file.file3,DATE_FORMAT(file.date,'%d-%m-%Y') 
										 as date, DATE_FORMAT(file.expiry,'%d-%m-%Y') as expiry, file.privillage, file.uploadby from fileshare as file,employee as emp 
										 where file.uploadby='".$empid."' and file.status='active' and '" . $currentdate . "' <= file.expiry and emp.employeeid=file.uploadby and 
										 (emp.fullname LIKE '%".$search."%' or file.title LIKE '%".$search."%' or file.description LIKE '%".$search."%' 
										 or file.file1 LIKE '%".$search."%' or file.file2 LIKE '%".$search."%' or file.file3 LIKE '%".$search."%'))
										 limit ".$start.",".$limit;
				}
			}
			$result = $GLOBALS['db']->query($query);
			//echo "num: ".$num=$result->num_rows;	
			$query1="select expiry from fileshare";
			$result1 = $GLOBALS['db']->query($query1);
			if(isset($result1) and $result1->num_rows>0) 
			{
				while($row1 = $result1->fetch_assoc())
				{
					$expirydate=$row1['expiry'];
					if(isset($result) and $result->num_rows>0) 
					{
						$i=$start;			
						while($row2 = $result->fetch_assoc()) 
						{	
							$i++;
							//echo "<br/>privillage: ".count($row2)."<br/>";
							if($row2['privillage']=='private')
							{
								$query_fullname="select fullname, employeeid from employee";
								$result_fullname= $GLOBALS['db']->query($query_fullname);
								if(isset($result_fullname) and $result_fullname->num_rows>0) 
								{ 
									$names="";
									$emps=$row2['employeeid'];
									$employees=(explode(",",$emps));
									//print_r($employees);
									//echo "<br/>";
									while($row_fullname = $result_fullname->fetch_assoc())
									{
										$fullname=$row_fullname['fullname'];
										$empy=$row_fullname['employeeid'];
										//echo $fullname."<br/>";
										if(in_array($empy,$employees))
										{
											if($names!="")
											{
												$names.=",";
											}
											$names.=$fullname;
										}
									}
								}
								$row2['length'];
								$descript=ucfirst($row2['description']);
								$len=strlen($descript);
								$len1=strlen($names);
								$name=truncate($names,0,50);
								$description=truncate($descript,0,50);
								$date_diffFrom=dateDiff($expirydate,$currentdate,'-');
								if($date_diffFrom>=0)
								{
									$showfile1="<a href=\"fileshare/".$row2['file1']."\" >".$row2['file1']."</a>";
									$showfile2="<a href=\"fileshare/".$row2['file2']."\" >".$row2['file2']."</a>";
									$showfile3="<a href=\"fileshare/".$row2['file3']."\" >".$row2['file3']."</a>";
									$fileshareid=$row2['fileshareid'];
									if(($i%2)<1) 
										$class=" class=\"even\" ";
									else  
										$class=" class=\"odd\" ";
									$len=$row2['length'];
									echo "<tr".$class.">";
									echo "<td><font color=\"red\">" . ' * ' . "</font>" . $i . "</td>";
									echo "<td>" . ucwords($row2['fullname']) . "</td>";
									//echo "<td>" . ucwords($names) . "</td>";
									if($len1>50)
									{
										echo "<td>" .ucwords($name) . "....<a href=\"#\" onclick=\"return myPopup1('".$fileshareid."');\">". readmore ."</a> </td>";
									}
									else 
									{
										echo "<td>" . ucwords($name)."</td>";
									}
									echo "<td>" . ucwords($row2['title']) . "</td>";
									if($len>50)
									{
										echo "<td>" . $description . "....<a href=\"#\" onclick=\"return myPopup('".$fileshareid."');\">". readmore ."</a> </td>";
									}
									else 
									{
										echo "<td>" . $description."</td>";
									}	
									echo "<td>" . $showfile1 . "</td>";
									echo "<td>" . $showfile2 . "</td>";
									echo "<td>" . $showfile3 . "</td>";
									echo "<td>" . $row2['expiry']. "</td>";
									echo "<td align=\"center\">";
									$set="select distinct file.uploadby,emp.departmentid from employee as emp,fileshare as file where emp.employeeid=file.uploadby and file.uploadby ='".$row2['uploadby']."'";
									$result1 = $GLOBALS['db']->query($set);	
									if(isset($result1) and $result1->num_rows>0) 
									{
										$deprow1 = $result1->fetch_assoc();
									}
									if( ($row2['uploadby']==$_SESSION['USERID']) || ( ($emp_power['is_hod']=='1') && ($emp_power['emp_deptid']== $deprow1['departmentid']) ) || ( $emp_power['is_superadmin']=='1' ) )
									{
										print "<input type=\"button\" name=\"editfile\" id=\"editfile\" onclick=\"javascript:edit_file(".$row2['fileshareid'].");\" value=\"Edit\"/>";
									}
									else
									{
										print "<input type=\"button\" name=\"editfile\" id=\"editfile\" disabled=\"disabled\" onclick=\"javascript:edit_file(".$row2['fileshareid'].");\" value=\"Edit\"/>";
									}
									echo "</td>";
								}
							}
							else
							{
								$row2['length'];
								$descript=ucfirst($row2['description']);
								//$len=strlen($descript);
								$description=truncate($descript,0,50);
								$date_diffFrom=dateDiff($expirydate,$currentdate,'-');
								if($date_diffFrom>=0)
								{
									$showfile1="<a href=\"fileshare/".$row2['file1']."\" >".$row2['file1']."</a>";
									$showfile2="<a href=\"fileshare/".$row2['file2']."\" >".$row2['file2']."</a>";
									$showfile3="<a href=\"fileshare/".$row2['file3']."\" >".$row2['file3']."</a>";
									$fileshareid=$row2['fileshareid'];
									if(($i%2)<1) 
										$class=" class=\"even\" ";
									else  
										$class=" class=\"odd\" ";
									$len=$row2['length'];
									echo "<tr".$class.">";
									echo "<td>" . $i . "</td>";
									echo "<td>" . ucwords($row2['fullname']) . "</td>";
									echo "<td> All Employees </td>";
									echo "<td>" . ucwords($row2['title']) . "</td>";
									if($len>50)
									{
										echo "<td>" . $description . "....<a href=\"#\" onclick=\"return myPopup('".$fileshareid."');\">". readmore ."</a> </td>";
									}
									else 
									{
										echo "<td>" . $description."</td>";
									}	
									echo "<td>" . $showfile1 . "</td>";
									echo "<td>" . $showfile2 . "</td>";
									echo "<td>" . $showfile3 . "</td>";
									echo "<td>" . $row2['expiry']. "</td>";
									echo "<td align=\"center\">";
									$set="select distinct file.uploadby,emp.departmentid from employee as emp,fileshare as file where emp.employeeid=file.uploadby and file.uploadby ='".$row2['uploadby']."'";
									$result1 = $GLOBALS['db']->query($set);	
									if(isset($result1) and $result1->num_rows>0) 
									{
										$deprow1 = $result1->fetch_assoc();
									}
									if( ($row2['uploadby']==$_SESSION['USERID']) || ( ($emp_power['is_hod']=='1') && ($emp_power['emp_deptid']== $deprow1['departmentid']) ) || ( $emp_power['is_superadmin']=='1' ) )
									{
										print "<input type=\"button\" name=\"editfile\" id=\"editfile\" onclick=\"javascript:edit_file(".$row2['fileshareid'].");\" value=\"Edit\"/>";
									}
									else
									{
										print "<input type=\"button\" name=\"editfile\" id=\"editfile\" disabled=\"disabled\" onclick=\"javascript:edit_file(".$row2['fileshareid'].");\" value=\"Edit\"/>";
									}
									echo "</td>";
								}
							}
						}
					}
				}
			}
		}								 
		public function listfilestatus($status) 
		{
			echo $status;
			$table = "fileshare";
			$column = "status";
			$options = getEnumValues($table,$column);
			for($i=0; $i<count($options); $i++) 
			{
				echo "<option value=\"" . $j=$i+1 . "\"";
				if($options[$i]==$status) 
					echo " selected=\"selected\"";
				echo ">" . $options[$i] . "</option>";
			}
			
		}
			

		public function listfileprivillage($privillage) 
		{
			echo $privillage;
			$table = "fileshare";
			$column = "privillage";
			$options = getEnumValues($table,$column);
			for($i=0; $i<count($options); $i++) 
			{
				echo "<option value=\"" . $j=$i+1 . "\"";
				if($options[$i]==$privillage) 
					echo " selected=\"selected\"";
				echo ">" . $options[$i] . "</option>";
			}
		}	

		
		public function listemployees($arrEmp)
		{                
			//$employees=explode(",",$emps);
			//$employees=$emps;
			$depquery="select distinct d.departmentid,d.depname
											from department d,employee e
											where e.departmentid=d.departmentid
											order by d.depname        
										   ";        
			$depresult=$GLOBALS['db']->query($depquery);
			if($depresult->num_rows>0)
			{
				while($deprow=$depresult->fetch_assoc())
				{
					$view.="<optgroup label=\" ".$deprow['depname']."\">";
					$empquery="select employeeid,fullname
									  from employee
									  where departmentid='".$deprow['departmentid']."'
									  and empstatus='active' order by fullname
									  ";
					$empresult=$GLOBALS['db']->query($empquery);
					if($empresult->num_rows>0)
					{
						while($emprow=$empresult->fetch_assoc())
						{
							$view.="<option value=\"".$emprow['employeeid']."\" ";                                

							if(in_array($emprow['employeeid'],$arrEmp))
							{
								$view.="selected=\"selected\" ";                
							}

							$view.="         >".$emprow['fullname']."</option>";
						}
					}
					else
					{
						$view.="<option>No employees</option>";
					}
					$view.="</optgroup>";
				}
			}
			else
			{
				$view.="<option>No records</option>";
			}
			return $view;
		}                                                                                                                                  

	 

		
		public function getData($id) 
		{
			$emp_power=emp_authority($_SESSION['USERID']);
			$empid=$_SESSION['USERID'];
			$dept=$emp_power['departmentid'];		 
			$set="select distinct file.uploadby,emp.departmentid from employee as emp,fileshare as file where emp.employeeid=file.uploadby";
			$result1 = $GLOBALS['db']->query($set);	
			$query_upload="select uploadby from fileshare where status='active'";
			$result_upload= $GLOBALS['db']->query($query_upload);	
			if(isset($result_upload) and $result_upload->num_rows>0) 
			{
				while($row_upload = $result_upload->fetch_assoc())
				{
					if(isset($result1) and $result1->num_rows>0) 
					{
						$deprow1 = $result1->fetch_assoc();
					}
					if( ($row_upload['uploadby']==$_SESSION['USERID']) || ( ($emp_power['is_hod']=='1') && ($emp_power['emp_deptid']== $deprow1['departmentid']) ) || ( $emp_power['is_superadmin']=='1' ) )
					{
						$query = "select fileshareid,title,referenceid,description,file1,file2,file3,status,DATE_FORMAT(date,'%Y-%m-%d') as date, DATE_FORMAT(expiry,'%Y-%m-%d') as expiry, employeeid, privillage from fileshare file where fileshareid = '".$id."'";
						$result = $GLOBALS['db']->query($query);
						if(isset($result) and $result->num_rows>0) 
						{
							return $row = $result->fetch_assoc();
						}
					}
				}
			}
		}
		public function getpopdata($pop)
		{
			$query = "select description from fileshare where fileshareid = '".$pop."'";
			$result = $GLOBALS['db']->query($query);
			if(isset($result) and $result->num_rows>0) 
			{
				return $pop = $result->fetch_assoc();
			}
		}
		
		public function getpopnames($pop)
		{
			$query = "select employeeid from fileshare where fileshareid = '".$pop."'";
			$result = $GLOBALS['db']->query($query);
			if(isset($result) and $result->num_rows>0) 
			{
				return $pop = $result->fetch_assoc();
			}
		}
		
	}
	function dateDiff($expirydate,$currentdate,$dformat='-')
	{
		$current=explode($dformat,$currentdate);
		$expiry=explode($dformat,$expirydate);
		$current_date = mktime(00,00,01,$current[1],$current[2],$current[0]);
		$expiry_date = mktime(00,00,01,$expiry[1],$expiry[2],$expiry[0]);
		$diff_seconds  = $expiry_date - $current_date;
		$diff_days     = floor($diff_seconds/86400);
		//echo $diff_days;
		return $diff_days ;
	} 	

	function truncate($string, $start = 0,$length = 100 ,$append="...",$roundof=5)
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
?>
