<?php 
if(isset($_POST['dept_drop_down'])){
$_SESSION['DPTRV']=$_POST['dept_drop_down'];
$_SESSION['EMPRV']=$_POST['emp_drop_down'];

	} 
else if(isset($_POST['dept_drop_down'])){
$_SESSION['DPTRV']=$_POST['dept_drop_down'];
$_SESSION['EMPRV']=0;
	}
else if(!(isset($_SESSION['DPTRV']))){
//	$_SESSION['DPTRV']=0;
	$_SESSION['EMPRV']=0;
}






















//From date
if(isset($_POST['rdate']))
{
	$date_ar=explode('/',$_POST['rdate']);
	$_SESSION['RVDATE']=$date_ar[2]."-".$date_ar[1]."-".$date_ar[0];
	$_SESSION['RDATESHOW']=$_POST['rdate'];
}
else if(!(isset($_SESSION['RVDATE'])))
{	
	//make starting date of month
	$a = localtime();
	$a[4] += 1;
	$a[5] += 1900;
	$yest="01/".$a[4]."/".$a[5]; //dmy		
	$from=$yest;

	

	// make yesterday date	
	//$yest = mktime(0,0,0,date("m"),date("d")-1,date("Y"));
	//echo "Yest  is ".date("d-m-Y", $yest);
	//$_SESSION['RVDATE']=date("Y-m-d", $yest);
	//$_SESSION['RDATESHOW']=date("d/m/Y", $yest);		

	$_SESSION['RVDATE']=dmyToymd($yest);	
	$_SESSION['RDATESHOW']=$yest;
}

//To date
if(isset($_POST['todate']))	
{
	$to_date_arr=explode('/',$_POST['todate']);
	$_SESSION['TODATE']=$to_date_arr[2]."-".$to_date_arr[1]."-".$to_date_arr[0];
	$_SESSION['TODATESHOW']=$_POST['todate'];
}
else if(!(isset($_SESSION['TODATE'])))
{
	$yest = mktime(0,0,0,date("m"),date("d")-1,date("Y"));
	$_SESSION['TODATE']=date("Y-m-d", $yest);
	$_SESSION['TODATESHOW']=date("d/m/Y", $yest);	
	//$to=date("d/m/Y", $yest);
	//echo "yest=".$yest;
	//echo "<br/>to=".$to;
	//echo "<br/>f=".$from."<br/>t=".$to;
	//compare dates
	$fromdate=strtotime($from);
	$todate=$yest;
	//echo "<br/>strFrom=".$fromdate."<br/>strTo=".$todate;
	if($fromdate > $todate)	
	{		
		//echo "<br/>from greater than to";
		$arr=explode("/",$from);
		$day=$arr[0];
		$month=$arr[1]-1;
		$year=$arr[2];
		$arr_date=$day."/".$month."/".$year;
		$_SESSION['RVDATE']=$arr_date;
		$_SESSION['RDATESHOW']=$arr_date;						
	}
}



function missedreports()
{
	$emp_power = emp_authority($_SESSION['USERID']);
	
/*
	echo "d=".$dpt=$_SESSION['DPTRV'];	
	echo "<br/>e=".$emp=$_SESSION['EMPRV'];		
	
	echo "<br/>From=".$date=$_SESSION['RVDATE'];
	echo "<br/>To=".$to_date=$_SESSION['TODATE'];
*/
	
	$dpt=$_SESSION['DPTRV'];	
	$emp=$_SESSION['EMPRV'];		
	
	$date=$_SESSION['RVDATE'];
	$to_date=$_SESSION['TODATE'];

	$fdate=explode('-',$date);//y-m-d
	$epoch_1=mktime(00,00,01,$fdate[1],$fdate[2],$fdate[0]);//m-d-Y
	
	$tdate=explode('-',$to_date);//y-m-d
	$epoch_2=mktime(00,00,01,$tdate[1],$tdate[2],$tdate[0]);//m-d-Y
	
	$diff_seconds  = $epoch_2 - $epoch_1;
	$diff_days  = floor($diff_seconds/86400);
	
	
	

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$query1="truncate table dates";
	$result1= $GLOBALS['db']->query($query1);
	for($i=0;$i<=$diff_days;$i++)
	{
			$days=mktime(00,00,01,$fdate[1],$fdate[2]+$i,$fdate[0]);	
			$d=date("Y-m-d", $days);
			$query2="insert into dates(date1) values ('".$d."')";
			$result2= $GLOBALS['db']->query($query2);
	}
	$query3="truncate table dateemp";
	$result3= $GLOBALS['db']->query($query3);
	
	
	$query4="insert into dateemp select d.Date1, e.employeeid, ''
	from dates d, employee e
	where e.empstatus = 'active'";
	$result4= $GLOBALS['db']->query($query4);
	
	
	$query5="update dateemp set remarks = 'Leave' where date1 in (select fromdate from leaveapplication where employeeid = dateemp.empid and fromoption='full'
and sanctioned=1 and cancelled=0 and !(leavetypeid = 5 or leavetypeid = 6))"; 
	$result5= $GLOBALS['db']->query($query5);
	
	
	$query6="update dateemp set remarks = 'Leave' where date1 in (select todate from leaveapplication where employeeid = dateemp.empid and tooption='full' and sanctioned=1 and cancelled=0 and !(leavetypeid = 5 or leavetypeid = 6))";
	$result6= $GLOBALS['db']->query($query6);
	
	
	$query7="update dateemp as d, leaveapplication as l set d.remarks = 'Leave1' 
	where (d.date1 between l.fromdate and l.todate )
	and l.leavedays>1.5
	and l.employeeid = d.empid
	and l.sanctioned=1 and l.cancelled=0 and  !(l.leavetypeid = 5 or l.leavetypeid = 6)
	and d.remarks = ''";
	$result7= $GLOBALS['db']->query($query7);
	
	
	$query8="update dateemp set remarks = 'Sunday' where dayname(date1) = 'Sunday' and remarks = ''";
	$result8= $GLOBALS['db']->query($query8);
	$query9="update dateemp set remarks = '3rd Saturday' where dayname(date1) = 'Saturday' and remarks = '' and extract(day from date1) between 15 and 21";
	$result9= $GLOBALS['db']->query($query9);


	$query10="select * from holiday where date between '".$date."' and '".$to_date."' ";
	$result10= $GLOBALS['db']->query($query10);
	if(isset($result10) and $result10->num_rows>0)
	{
		while($row10=$result10->fetch_assoc())
		{
			$descr=$row10['descr'];
			$date1=$row10['date'];
			$query11="update dateemp set remarks = '".$descr."' where date1 = '".$date1."' and remarks = ''";
			$result11= $GLOBALS['db']->query($query11);
		}
  }
	
	
	$query12="update dateemp set remarks = 'Report done.' where remarks = '' and date1 in 
(select a.logdate from schactivity as sa, employee as e, activitylog a
WHERE sa.employeeid = e.employeeid and a.schactivityid = sa.schactivityid and e.employeeid = dateemp.empid
and a.logdate between '".$date."' and '".$to_date."')";
	$result12= $GLOBALS['db']->query($query12);

		$query13="";
		$query13="Select dep.depname as Department, emp.fullname as Employee, d.date1 as MissingDate,  dayname(d.date1) as Day
		from 
		dateemp as d, employee as emp, department as dep		
		where ";
		//if(($dpt!=0)&&($emp!=0))
		if(($dpt!=0))
		{
		$query13.=" dep.departmentid ='".$dpt."'  and";
		}
		if($emp!=0)
		{
		$query13.="  emp.employeeid='".$emp."' and";
		}
		$query13.="
		dep.departmentid = emp.departmentid
		and d.empid = emp.employeeid 
		and emp.empstatus = 'active' and emp.employeeid != 1 and remarks = ''
		and d.date1 between '".$date."' and '".$to_date."'
		order by dep.depname, emp.fullname, d.date1";
		//echo 	$query13;
		$result13= $GLOBALS['db']->query($query13);

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	
	
		$missed_report="";
		$missed_report.="<table border=\"0\"cellspacing=\"2px\" width=\"100%\" class=\"main_content_table\">
			<tr><td colspan=\"5\" class=\"table_heading\">Missed Report</td></tr>
			<tr>
			<th>
			Sl No:
			</th>
			<th>
			Department
			</th>
			<th>
			Employee
			</th>
			<th>
			Missing Date
			</th>
			<th>
			Day
			</th>
			
			</tr>";
			$i=0;
			if(isset($result13) and $result13->num_rows>0)
			{
				while($row13=$result13->fetch_assoc())
				{$i++;
						if(($i%2)<1) $class=" class=\"even\" ";else  $class=" class=\"odd\" ";
					$missed_report.="	
					<tr ".$class.">
					<td>".$i."</td>
					<td>".$row13['Department']."</td>
					<td>".$row13['Employee']."</td>
					<td>".$row13['MissingDate']."</td>
					<td>".$row13['Day']."</td>
					</tr>";
				}
		}else
		{
			$missed_report.="	
			<tr>
			<td colspan='5'>No Records</td>
			</tr>";
		}
			$missed_report.="
			</table>";
	
	return $missed_report;
	
	
}
?>
