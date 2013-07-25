<?php

$query="
			select 
			sa.schactivityid as actid,
			sa.activitydesc as actdesc,
			sa.activitystatus as actstatus,
			sa.activitytypeid as acttypeid,
			s.description as sc_desc,
			s.supervisorid as sc_super,
			e.fullname as fullname
		from 
			schedule as s,
			schactivity as sa,
			employee as e	
		where
		 	sa.scheduleid=s.scheduleid															
			and sa.employeeid!=".$_SESSION['USERID']."
			and sa.employeeid=e.employeeid
			and s.departmentid in ($dpt)";
			
			if(($emp_power['is_superadmin']!=1)&&($emp_power['is_admin']!=1)&&($emp_power['is_hod']!=1)&&($emp_power['is_super']==1))
			{
			$query.="and sa.scheduleid in (".$emp_power['issup_schid'].")";
			}
			$query.="and sa.employeeid = e.employeeid";
							//s.description,
						//	sa.schactivityid,
						//	sa.employeeid,
			
			$query="select 
							s.scheduleid,
							s.departmentid,
							s.supervisorid,							
							act.schactivityid,
							act.logdate,
							e.fullname
							
						from
							schedule as s,
							schactivity as sa,
							activitylog as act,
							employee as e
							
						where
							s.departmentid=2
							and
							s.scheduleid=sa.scheduleid							
							and
							sa.schactivityid=act.schactivityid	
							and
							sa.employeeid=e.employeeid	
							and
							act.loglock=0
							
												
							
						";
			
?>