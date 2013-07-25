<?php 
function trunc($string, $start = 0,$length = 100 ,$append="...",$roundof=5)
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
function show_menu()
{
	$emp_power=emp_authority($_SESSION['USERID']);	
	$menu="	
	<table width=\"159\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"menu_display\" >
	<tr>
	<th >Welcome</th>
	</tr>
	<tr>
	<th id=\"username_th\">".$_SESSION['NAME']."</th>
	</tr>"; 
	//Home       
	if($_SESSION['SEL_LINK']=="home")
	{	
	}
	$menu.="<tr><td >&nbsp;</td></tr>";
	$menu.="<tr>
	<td  height=\"28\" >	
	<a href=\"home.php\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image2','','".$_SESSION['FOLDER']."Home_Over.jpg',1)\"  >";
	if($_SESSION['SEL_LINK']=="HOME")
	{
		$menu.="<img src=\"".$_SESSION['FOLDER']."Home_Over.jpg\" name=\"Image2\" width=\"159\" height=\"28\" border=\"0\" id=\"Image2\" />";
	}
	else
	{
		$menu.="<img src=\"".$_SESSION['FOLDER']."Home.jpg\" name=\"Image2\" width=\"159\" height=\"28\" border=\"0\" id=\"Image2\" />";
	} 
	$menu.="</a></td>
	</tr>";
	// mail
	$menu.="<tr>
	<td  height=\"28\" >	
	<a href=\"inbox.php\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image19','','".$_SESSION['FOLDER']."communicate_over.jpg',1)\"  >";
	if($_SESSION['SEL_LINK']=="MAIL")
	{
		$menu.="<img src=\"".$_SESSION['FOLDER']."communicate_over.jpg\" alt=\"MAIL\" name=\"Image19\" width=\"159\" height=\"28\" border=\"0\" id=\"Image19\" />";
	}
	else
	{
		$menu.="<img src=\"".$_SESSION['FOLDER']."communicate.jpg\" name=\"Image19\" alt=\"MAIL\" width=\"159\" height=\"28\" border=\"0\" id=\"Image19\" />";
	} 
	$menu.="</a></td>
	</tr>";
	
	//Workflow
	/*$menu.="<tr>
	<td  height=\"28\" >	
	<a href=\"listWorkflow.php\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image21','','".$_SESSION['FOLDER']."communicate_over1.jpg',1)\"  >";
	if($_SESSION['SEL_LINK']=="WRK")
	{
		$menu.="<img src=\"".$_SESSION['FOLDER']."communicate_over1.jpg\" alt=\"Workflow\" name=\"Image21\" width=\"159\" height=\"28\" border=\"0\" id=\"Image21\" />";
	}
	else
	{
		$menu.="<img src=\"".$_SESSION['FOLDER']."communicate1.jpg\" name=\"Image21\" alt=\"Workflow\" width=\"159\" height=\"28\" border=\"0\" id=\"Image21\" />";
	} 
	$menu.="</a></td>
	</tr>";*/
	
	//Assign Admin 
	if(($emp_power['is_superadmin'] ==1) || (($emp_power['is_hr'] ==1) && ($emp_power['is_adminemp'] ==1)))//if($emp_power['is_superadmin'] ==1)
	{
		$menu.="
		<tr>
		<td ><a href=\"assignadmdept.php\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Images3','','".$_SESSION['FOLDER']."AssAd_Over.jpg',1)\">";
		if($_SESSION['SEL_LINK']=="ASAD")
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."AssAd_Over.jpg\" alt=\" assign admin to departments\"  title=\" assign admin to departments\" name=\"Images3\" width=\"159\" height=\"28\" border=\"0\" id=\"Images3\" />";
		}
		else
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."AssAd.jpg\" alt=\" assign admin to departments\"  title=\" assign admin to departments\" name=\"Images3\" width=\"159\" height=\"28\" border=\"0\" id=\"Images3\" />";	
		}
		$menu.="</a></td>
		</tr>";
	}
	//Assign HOD
	if(($emp_power['is_superadmin'] ==1)||($emp_power['is_admin'] ==1)||(($emp_power['is_adminemp'] ==1) && ($emp_power['is_hr']==1)))
	{
		$menu.="
		<tr>
		<td  ><a href=\"assignhoddep.php\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image3q','','".$_SESSION['FOLDER']."AssHOD_Over.jpg',1)\">";		
		if($_SESSION['SEL_LINK']=="ASHD")
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."/AssHOD_Over.jpg\" alt=\" assign HOD to departments\" title=\" assign HOD to departments\" name=\"Image3q\" width=\"159\" height=\"28\" border=\"0\" id=\"Image3q\" />";
		}
		else
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."AssHOD.jpg\" alt=\" assign HOD to departments\" title=\" assign HOD to departments\" name=\"Image3q\" width=\"159\" height=\"28\" border=\"0\" id=\"Image3q\" />";		
		}		
		$menu.="</a></td>
		</tr>";
	}
	//Assign Adhoc
	if(($emp_power['is_superadmin'] ==1)||($emp_power['is_admin'] ==1)||($emp_power['is_hod'] ==1))
	{
		$menu.="
		<tr>
		<td ><a href=\"addhoc.php\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image18','','".$_SESSION['FOLDER']."Ass_adh_Over.jpg',1)\">";
		if($_SESSION['SEL_LINK']=="ADH")
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."Ass_adh_Over.jpg\"  alt=\"Assign Adhoc\" title=\"Assign Adhoc\" name=\"Image18\" width=\"159\" height=\"28\" border=\"0\" id=\"Image18\" />";
		}
		else
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."Ass_adh.jpg\"  alt=\"Assign Adhoc\" title=\"Assign Adhoc\" name=\"Image18\" width=\"159\" height=\"28\" border=\"0\" id=\"Image18\" />";
		}
		$menu.="</a></td>
		</tr>";
	}
	
/////////////////////////////////
//Job request
/*if($emp_power['is_hod'] ==1){
        $menu.="
        <tr>
          <td ><a href=\"job_request.php\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image16','','".$_SESSION['FOLDER']."Dep_Ovjker.jpg',1)\">";
          if($_SESSION['SEL_LINK']=="JREQ"){
          $menu.="<img src=\"".$_SESSION['FOLDER']."Depj_Over.jpg\"  alt=\"Job Request\" title=\"Job Request\" name=\"Image16\" width=\"159\" height=\"28\" border=\"0\" id=\"Image16\" />";
				}
				else{
					$menu.="<img src=\"".$_SESSION['FOLDER']."Dejup.jpg\"  alt=\"Job Request\" title=\"Job Request\" name=\"Image16\" width=\"159\" height=\"28\" border=\"0\" id=\"Image16\" />";
				}
          $menu.="</a></td>
        </tr>";
}*/
///////////////////////////////
	//Department
	if(($emp_power['is_superadmin'] ==1)||(($emp_power['is_adminemp'] ==1)||($emp_power['is_hr'] ==1)))
	{
		$menu.="
		<tr>
		<td ><a href=\"department.php\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image3','','".$_SESSION['FOLDER']."Dep_Over.jpg',1)\">";
		if($_SESSION['SEL_LINK']=="DEP")
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."Dep_Over.jpg\"  alt=\"Department\" title=\"Department\" name=\"Image3\" width=\"159\" height=\"28\" border=\"0\" id=\"Image3\" />";
		}
		else
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."Dep.jpg\"  alt=\"Department\" title=\"Department\" name=\"Image3\" width=\"159\" height=\"28\" border=\"0\" id=\"Image3\" />";
		}
		$menu.="</a></td>
		</tr>";
	}
	//Employee
	//if(($emp_power['is_superadmin'] ==1)||($emp_power['is_admin'] ==1)||($emp_power['is_hod'] ==1)||($emp_power['is_super'] ==1)||($emp_power['is_hr']==1))
	if( ($emp_power['is_superadmin'] ==1) || ($emp_power['is_admin'] ==1) || ($emp_power['is_hod'] ==1)||($emp_power['is_hr']==1) )
	{
		$menu.="
		<tr>
		<td align=\"left\" valign=\"middle\"><a href=\"viewemployee.php\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image4','','".$_SESSION['FOLDER']."Emp_Over.jpg',1)\">";
		if($_SESSION['SEL_LINK']=="VEMP")
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."Emp_Over.jpg\"   alt=\" view Employee\" title=\" Employee Details\" name=\"Image4\" width=\"159\" height=\"28\" border=\"0\" id=\"Image4\" />";
		}
		else
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."Emp.jpg\"   alt=\" view Employee\" title=\" Employee Details\" name=\"Image4\" width=\"159\" height=\"28\" border=\"0\" id=\"Image4\" />";
		}
		$menu.="</a></td>
		</tr>";
	}
	
$emp_power['is_hod']=(intval($emp_power['from_rep'])>0)? 1 : 0;
	
	//File Uploadinguuuu	
		/*$menu.="
		<tr>
		<td ><a href=\"file.php\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image20','','".$_SESSION['FOLDER']."Dep_Over11.jpg',1)\">";
		if($_SESSION['SEL_LINK']=="FIL")
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."Dep_Over11.jpg\"  alt=\"File Upload\" title=\"File Upload\" name=\"Image20\" width=\"159\" height=\"28\" border=\"0\" id=\"Image20\" />";
		}
		else
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."Dep11.jpg\"  alt=\"File Upload\" title=\"File Upload\" name=\"Image20\" width=\"159\" height=\"28\" border=\"0\" id=\"Image20\" />";
		}
		$menu.="</a></td>
		</tr>";*/	
	//Schedules 
	if(($emp_power['is_superadmin'] ==1)||($emp_power['is_admin'] ==1)||($emp_power['is_hod'] ==1))
	{
		$menu.="
		<tr>
		<td ><a href=\"assignschwork.php\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image5','','".$_SESSION['FOLDER']."Sch_Over.jpg',1)\">";
		if($_SESSION['SEL_LINK']=="SCH")
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."Sch_Over.jpg\"  alt=\" Assign or edit schedules\" title=\" Assign or edit schedules\" name=\"Image5\" width=\"159\" height=\"28\" border=\"0\" id=\"Image5\" />";
		}
		else
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."Sch.jpg\"  alt=\" Assign or edit schedules\" title=\" Assign or edit schedules\" name=\"Image5\" width=\"159\" height=\"28\" border=\"0\" id=\"Image5\" />";
		}
		$menu.="</a></td>
		</tr>";
	}	
	
	
	
	
	
	
	
	
	
		$menu.="
		<tr>
		<td ><a href=\"meetings.php\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image30','','".$_SESSION['FOLDER']."Sch_Over1.jpg',1)\">";
		if($_SESSION['SEL_LINK']=="MET")
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."Sch_Over1.jpg\"  alt=\" Assign or edit meetings\" title=\" Assign or edit meetings\" name=\"Image30\" width=\"159\" height=\"28\" border=\"0\" id=\"Image30\" />";
		}
		else
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."Sch1.jpg\"  alt=\" Assign or edit meetings\" title=\" Assign or edit meetings\" name=\"Image30\" width=\"159\" height=\"28\" border=\"0\" id=\"Image30\" />";
		}
		$menu.="</a></td>
		</tr>"; 
	

	if($emp_power['is_superadmin'] ==1)
	{	 
		$menu.="
		<tr>
		<td ><a href=\"meetingapprove.php\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image31','','".$_SESSION['FOLDER']."approvemeeting_Over.jpg',1)\">";
		if($_SESSION['SEL_LINK']=="MAP")
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."approvemeeting_Over.jpg\"  alt=\"Approve meetings\" title=\" Approve meetings\" name=\"Image31\" width=\"159\" height=\"28\" border=\"0\" id=\"Image31\" />";
		}
		else
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."approvemeeting.jpg\"  alt=\" Approve meetings\" title=\" Approve meetings\" name=\"Image31\" width=\"159\" height=\"28\" border=\"0\" id=\"Image31\" />";
		}
		$menu.="</a></td>
		</tr>"; 
	}
	
	
	
	
	
	
	
	
	
	
	
	if(($emp_power['is_superadmin'] ==1)||($emp_power['is_hod'] ==1)||($emp_power['is_hr']==1)||($emp_power['is_admin']==1))
	{
		//Missing Reports
		$menu.="
		</tr>";
			$menu.="
		<tr>
		<td ><a href=\"missingreports.php\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image32','','".$_SESSION['FOLDER']."missingrpt_Over.jpg',1)\">";
		if($_SESSION['SEL_LINK']=="MSR")
		{		 
			$menu.="<img src=\"".$_SESSION['FOLDER']."missingrpt_Over.jpg\" name=\"Image32\" width=\"159\" height=\"28\"  alt=\"Missing Reports \" title=\"Missing Reports\"  border=\"0\" id=\"Image32\" />";
		}
		else
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."misiingrpt.jpg\" name=\"Image32\" width=\"159\" height=\"28\"  alt=\"Missing Reports \" title=\"Missing Reports \"  border=\"0\" id=\"Image32\" />";
		}
		$menu.="</a></td>
		</tr>";
		
		
		
		//OpenReports Analytics
		$menu.="
		</tr>";
			$menu.="
		<tr>
		<td ><a href=\"openreport_analytics.php\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image33','','".$_SESSION['FOLDER']."openreportanlytics_over.jpg',1)\">";
		if($_SESSION['SEL_LINK']=="OSR")
		{		 
			$menu.="<img src=\"".$_SESSION['FOLDER']."openreportanlytics_over.jpg\" name=\"Image33\" width=\"159\" height=\"28\"  alt=\"OpenReports Analytics \" title=\"OpenReports Analytics\"  border=\"0\" id=\"Image33\" />";
		}
		else
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."openreportanlytics.jpg\" name=\"Image33\" width=\"159\" height=\"28\"  alt=\"OpenReports Analytics \" title=\"OpenReports Analytics \"  border=\"0\" id=\"Image33\" />";
		}
		$menu.="</a></td>
		</tr>";
		
		
	//Compensatory Off 
		$menu.="
		</tr>";
			$menu.="
		<tr>
		<td ><a href=\"coff.php\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image23','','".$_SESSION['FOLDER']."entercoff_over.jpg',1)\">";
		if($_SESSION['SEL_LINK']=="CFF")
		{		 
			$menu.="<img src=\"".$_SESSION['FOLDER']."entercoff_over.jpg\" name=\"Image23\" width=\"159\" height=\"28\"  alt=\"Compensatory Off \" title=\"Compensatory Off \"  border=\"0\" id=\"Image23\" />";
		}
		else
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."entercoff.jpg\" name=\"Image23\" width=\"159\" height=\"28\"  alt=\"Compensatory Off \" title=\"Compensatory Off \"  border=\"0\" id=\"Image23\" />";
		}
		$menu.="</a></td>
		</tr>";

	}
	//approve coff
	if(($emp_power['is_superadmin'] ==1)||($emp_power['is_admin']==1))
	{
	
		$menu.="
		</tr>";
			$menu.="
		<tr>
		<td ><a href=\"approve_coff.php\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image24','','".$_SESSION['FOLDER']."appcoff_over.jpg',1)\">";
		if($_SESSION['SEL_LINK']=="APCFF")
		{		 
			$menu.="<img src=\"".$_SESSION['FOLDER']."appcoff_over.jpg\" name=\"Image24\" width=\"159\" height=\"28\"  alt=\"Approve COff \" title=\"Approve COff \"  border=\"0\" id=\"Image24\" />";
		}
		else
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."appcoff.jpg\" name=\"Image24\" width=\"159\" height=\"28\"  alt=\"Approve COff \" title=\"Approve COff \"  border=\"0\" id=\"Image24\" />";
		}
		$menu.="</a></td>
		</tr>";
	}
	
	
	
	
	
	
	
	
	
	//Assign Activity
	if(($emp_power['is_superadmin'] ==1)||($emp_power['is_admin'] ==1)||($emp_power['is_hod'] ==1)||($emp_power['is_super'] ==1))
	{
		$menu.="
		<tr>
		<td ><a href=\"addactivity.php\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image20','','".$_SESSION['FOLDER']."Assign_acti_Over.jpg',1)\">";
		if($_SESSION['SEL_LINK']=="ACT")
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."Assign_acti_Over.jpg\"  alt=\" Assign Activity\" title=\" Assign Activity\" name=\"Image20\" width=\"159\" height=\"28\" border=\"0\" id=\"Image20\" />";
		}
		else
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."Assign_acti.jpg\"  alt=\" Assign Activity\" title=\" Assign Activity\" name=\"Image20\" width=\"159\" height=\"28\" border=\"0\" id=\"Image20\" />";
		}
		$menu.="</a></td>
		</tr>";
	}	
	//Activity Type
	if($emp_power['is_superadmin'] ==1 || $emp_power['is_admin'] ==1 || (($emp_power['is_hr'] ==1 )&&($emp_power['is_adminemp'] ==1 )))
	{
		$menu.="
		<tr>
		<td ><a href=\"activity.php\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image6','','".$_SESSION['FOLDER']."ActiType_Over.jpg',1)\">";
		if($_SESSION['SEL_LINK']=="ASACT")
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."ActiType_Over.jpg\" alt=\"Activity Type\" title=\"Activity Type\"  name=\"Image6\" width=\"159\" height=\"28\" border=\"0\" id=\"Image6\" />";
		}
		else 
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."ActiType.jpg\" alt=\"Activity Type\" title=\"Activity Type\"  name=\"Image6\" width=\"159\" height=\"28\" border=\"0\" id=\"Image6\" />";
        }
		$menu.="</a></td>
        </tr>";
	}
	//Validate reports
	if(($emp_power['is_superadmin'] ==1)||($emp_power['is_admin'] ==1)||($emp_power['is_hod'] ==1)||($emp_power['is_super'] ==1))
	{
		$menu.="
		<tr>
		<td><a href=\"rep_valid.php\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image7','','".$_SESSION['FOLDER']."Vali_Over.jpg',1)\">";
		if($_SESSION['SEL_LINK']=="VLR")
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."Vali_Over.jpg\" alt=\" Validate reports\" title=\" Validate reports\" name=\"Image7\" width=\"159\" height=\"28\" border=\"0\" id=\"Image7\" />";
		}
		else
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."Vali.jpg\" alt=\" Validate reports\" title=\" Validate reports\" name=\"Image7\" width=\"159\" height=\"28\" border=\"0\" id=\"Image7\" />";
		}
		$menu.="</a></td>
		</tr>";
		//View reports
		$menu.="
		<tr>
		<td ><a href=\"viewreport.php\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image8','','".$_SESSION['FOLDER']."View_Over.jpg',1)\">";
		if($_SESSION['SEL_LINK']=="VWR")
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."View_Over.jpg\" alt=\" view reports\" title=\" view reports\" name=\"Image8\" width=\"159\" height=\"28\" border=\"0\" id=\"Image8\" />";
		}
		else
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."View.jpg\" alt=\" view reports\" title=\" view reports\" name=\"Image8\" width=\"159\" height=\"28\" border=\"0\" id=\"Image8\" />";
		}
		$menu.="</a></td>
		</tr>";
	
		//Open reports
			if(($emp_power['is_superadmin'] ==1)||($emp_power['is_admin'] ==1)||($emp_power['is_hod'] ==1)||($emp_power['is_super'] ==1))
			{
				$menu.="
				<tr>
				<td ><a href=\"viewopenreports.php\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image26','','".$_SESSION['FOLDER']."openre_over.jpg',1)\">";
				if($_SESSION['SEL_LINK']=="OPN")
				{
					$menu.="<img src=\"".$_SESSION['FOLDER']."openre_over.jpg\" alt=\" open reports\" title=\" open reports\" name=\"Image26\" width=\"159\" height=\"28\" border=\"0\" id=\"Image26\" />";
				}
				else
				{
					$menu.="<img src=\"".$_SESSION['FOLDER']."openre.jpg\" alt=\" open reports\" title=\" open reports\" name=\"Image26\" width=\"159\" height=\"28\" border=\"0\" id=\"Image26\" />";
				}
				$menu.="</a></td>
				</tr>";
			}
		
		
	}
	/*	//if($_SESSION['USERID']>1)
		//{
		// $menu.="
		//        <tr>
		//          <td align=\"left\" valign=\"middle\"><a href=\"schedule.php\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image14','','".$_SESSION['FOLDER']."Daily_Over.jpg',1)\">";
		//          if($_SESSION['SEL_LINK']=="DLR"){
		//          $menu.="<img src=\"".$_SESSION['FOLDER']."Daily_Over.jpg\"  alt=\"Enter Daily reports\" title=\"Enter Daily reports\" name=\"Image14\" width=\"159\" height=\"29\" border=\"0\" id=\"Image14\" />";
		//				}
		//				else{
		//          $menu.="<img src=\"".$_SESSION['FOLDER']."Daily.jpg\"  alt=\"Enter Daily reports\" title=\"Enter Daily reports\" name=\"Image14\" width=\"159\" height=\"29\" border=\"0\" id=\"Image14\" />";
		//				}
						
				  $menu.="</a></td>
				</tr>";
		}
	*/
		
	//Daily reports
	//if($_SESSION['USERID']>1)
	//{
		$menu.="
		<tr>
		<td align=\"left\" valign=\"middle\"><a href=\"report.php\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image15','','".$_SESSION['FOLDER']."Daily_Over.jpg',1)\">";
		if($_SESSION['SEL_LINK']=="DLR")
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."Daily_Over.jpg\"  alt=\"Enter Daily reports\" title=\"Enter Daily reports\" name=\"Image15\" width=\"159\" height=\"28\" border=\"0\" id=\"Image15\" />";
		}
		else
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."Daily.jpg\"  alt=\"Enter Daily reports\" title=\"Enter Daily reports\" name=\"Image15\" width=\"159\" height=\"28\" border=\"0\" id=\"Image15\" />";
		}		
		$menu.="</a></td>
		</tr>";
	//}
	//Employee List
	$menu.="
	<tr>
	<td ><a href=\"employeelist.php\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image140','','".$_SESSION['FOLDER']."Emp_list_Over.jpg',1)\">";
	if($_SESSION['SEL_LINK']=="EMPL")
	{
		$menu.="<img src=\"".$_SESSION['FOLDER']."Emp_list_Over.jpg\" name=\"Image140\" width=\"159\" height=\"28\"  alt=\"Employee List\" title=\"Employee List\"  border=\"0\" id=\"Image140\" />";
	}
	else
	{
		$menu.="<img src=\"".$_SESSION['FOLDER']."Emp_list.jpg\" name=\"Image140\" width=\"159\" height=\"28\"  alt=\"Employee List\" title=\"Employee List\"  border=\"0\" id=\"Image140\" />";
	}
	$menu.="</a></td>
	</tr>";
	//Change password
	$menu.="
	<tr>
	<td ><a href=\"changepass.php\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image10','','".$_SESSION['FOLDER']."Change_Over.jpg',1)\">";
	if($_SESSION['SEL_LINK']=="CHP")
	{
		$menu.="<img src=\"".$_SESSION['FOLDER']."Change_Over.jpg\" name=\"Image10\" width=\"159\" height=\"28\"  alt=\"Change password\" title=\"Change password\"  border=\"0\" id=\"Image10\" />";
	}
	else
	{
		$menu.="<img src=\"".$_SESSION['FOLDER']."Change.jpg\" name=\"Image10\" width=\"159\" height=\"28\"  alt=\"Change password\" title=\"Change password\"  border=\"0\" id=\"Image10\" />";
	}
	$menu.="</a></td>
	</tr>";
	//Approve Leave
	if($emp_power['is_superadmin'] ==1 || $emp_power['is_admin'] ==1 || ($emp_power['is_hod'] ==1)||(($emp_power['is_adminemp'] ==1) && ($emp_power['is_hr']==1)))
	{
		$menu.="
		<tr>
		<td ><a href=\"approveleave.php\" onmouseout=\"MM_swapImgRestore()\" //onmouseover=\"MM_swapImage('Image13','','".$_SESSION['FOLDER']."approve_lv_Over.jpg',1)\">";		
		if($_SESSION['SEL_LINK']=="APL")
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."approve_lv_Over.jpg\" name=\"Image13\" width=\"159\" height=\"28\"  alt=\"Approve Leave\" title=\"Approve Leave\"  border=\"0\" id=\"Image13\" />";
		}			
		else
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."approve_lv.jpg\" name=\"Image13\" width=\"159\" height=\"28\"  alt=\"Approve Leave\" title=\"Approve Leave\"  border=\"0\" id=\"Image13\" />";
		}
		$menu.="</a></td>
		</tr>";
	}
	//Apply Leave
	$menu.="
	<tr>
	<td ><a href=\"applyleave.php\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image12','','".$_SESSION['FOLDER']."apply_lv_Over.jpg',1)\">";
	if($_SESSION['SEL_LINK']=="LVE")
	{		 
		$menu.="<img src=\"".$_SESSION['FOLDER']."apply_lv_Over.jpg\" name=\"Image12\" width=\"159\" height=\"28\"  alt=\"Apply Leave\" title=\"Apply Leave\"  border=\"0\" id=\"Image12\" />";
	}
	else
	{
		$menu.="<img src=\"".$_SESSION['FOLDER']."apply_lv.jpg\" name=\"Image12\" width=\"159\" height=\"28\"  alt=\"Apply Leave\" title=\"Apply Leave\"  border=\"0\" id=\"Image12\" />";
	}
	
	
	
	//View Leave
	if($emp_power['is_superadmin'] ==1 || $emp_power['is_admin'] ==1 || ($emp_power['is_hod'] ==1)||(($emp_power['is_adminemp'] ==1) || ($emp_power['is_hr']==1)))
	{
		$menu.="
		<tr>
		<td ><a href=\"viewleave.php\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image22','','".$_SESSION['FOLDER']."vew_lv_Over.jpg',1)\">";
		if($_SESSION['SEL_LINK']=="VLVE")
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."vew_lv_Over.jpg\"  alt=\"View Leave\" title=\"View Leave\" name=\"Image22\" width=\"159\" height=\"28\" border=\"0\" id=\"Image22\" />";
		}
		else
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."vew_lv.jpg\"  alt=\"View Leave\" title=\"View Leave\" name=\"Image22\" width=\"159\" height=\"28\" border=\"0\" id=\"Image22\" />";
		}
		$menu.="</a></td>
		</tr>";
	}
////////////////////////////////////
//File Upload
	if($emp_power['is_superadmin'] ==1 || $emp_power['is_admin'] ==1 || (($emp_power['is_adminemp'] ==1) || ($emp_power['is_hr']==1)))
	{
		$menu.="
		<tr>
		<td ><a href=\"fileupload.php\" onmouseout=\"MM_swapImgRestore()\"   onmouseover=\"MM_swapImage('Image30','','".$_SESSION['FOLDER']."Att_Over.jpg',1)\">";
		if($_SESSION['SEL_LINK']=="FLE")
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."Att_Over.jpg\"  alt=\"File Upload\" title=\"File Upload\" name=\"Image30\" width=\"159\" height=\"28\" border=\"0\" id=\"Image30\" />";
		}
		else
		{
			$menu.="<img src=\"".$_SESSION['FOLDER']."Att.jpg\"  alt=\"File Upload\" title=\"File Upload\" name=\"Image30\" width=\"159\" height=\"28\" border=\"0\" id=\"Image30\" />";
		}
		$menu.="</a></td>
		</tr>";
	}
	//Logout
	$menu.="
	<tr>
	<td ><a href=\"logout.php\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('Image11','','".$_SESSION['FOLDER']."Log_Over.jpg',1)\">";
	$menu.="<img src=\"".$_SESSION['FOLDER']."Log.jpg\" name=\"Image11\" width=\"159\" height=\"29\" border=\"0\" id=\"Image11\"  alt=\"Logout\" title=\"Logout\"/>";
	$menu.="</a></td>
	</tr>";

	//$menu .="<tr><td><textarea rows=\"50\">".print_r($emp_power, true)."</textarea></td></tr>";	
	$menu.="
	<tr>
	<td height=\"300\" align=\"left\" valign=\"middle\" background=\"".$_SESSION['FOLDER']."manu_Bg.jpg\" style=\"background-repeat:repeat-x;\"           
	>&nbsp;</td>
	</tr>";
	$menu.="
	</table>";	
	return ucwords($menu);
} //show_menu() ends

//Get Table link
function get_table_link($show,$image)
{
	//$bgcolor="  bgcolor=\"#D1D1D3\"  ";
	if(isset($_SESSION['FOLDER']))$folder=$_SESSION['FOLDER'];else $folder="images/";
	$t="<table width=\"100%\" border=\"0\"     height=\"30\"  cellpadding=\"0\" cellspacing=\"0\" class=\"gen_class\">
	<tr>
	<td align=\"left\" width=\"75%\" valign=\"middle\"    class=\"Head_txt\">	
	<img src=\"".$folder."".$image."\" height=\"25px\" width=\"25px\"/>	
	&nbsp;".$show."</td>
	<td height=\"30\" align=\"left\" valign=\"middle\"   class=\"Date_txt\" nowrap>
	".date('l, d/m/Y')."
	</td>
	<td height=\"30\" align=\"center\" valign=\"middle\"    >
	<a href=\"javascript:void(0);\">
	<img src=\"".$folder."G_back.jpg\"  onClick=\"history.go(-1);return false;\" alt=\"Go Back\"  title=\"Click here to go back\"  border=\"0\" width=\"29\" height=\"27\" /></a>
	</td>
	<td height=\"30\" align=\"center\" valign=\"middle\"   >
	<a href=\"home.php\">
	<img src=\"".$folder."icon1.jpg\" alt=\"Go to home page\"  title=\"Click here to go to Home Page\"  border=\"0\" width=\"29\" height=\"27\" /></a>
	</td>
	<td height=\"30\" align=\"center\" valign=\"middle\"   >
	<a href=\"logout.php\"><img src=\"".$folder."icon2.jpg\" title=\"Click here to Logout\" alt=\"Logout\" border=\"0\" width=\"29\" height=\"27\" /></a>
	</td>
	<td height=\"30\" align=\"center\" valign=\"middle\"    >
	<a href=\"javascript:void(0);\">
	<img src=\"".$folder."G_next.jpg\" title=\"Click here to go forward\" onClick=\"history.go(+1);return false;\" alt=\"Go Back\"  border=\"0\" width=\"29\" height=\"27\" /></a>
	</td>
	</tr>
	</table>";	
	return $t;
}
//Get Footer
function footer()
{
	print "<div class=\"footer\">Copyright &copy; 2009 Prime Move Technologies (P) Ltd. All Rights Reserved.</div>";
}





function userinfo(){
$data['ip'] = $_SERVER['REMOTE_ADDR'];
$data['hostaddress'] = "";//gethostbyaddr($ip);
$data['browser'] = $_SERVER['HTTP_USER_AGENT'];
$data['referred'] = $_SERVER['HTTP_REFERER']; // a quirky spelling mistake that stuck in php
$data['message']="User IP address:".$data['ip']."\nMore detailed host address:".$data['hostaddress']."\nDisplay browser info".$data['browser'] ."\nWhere you came from ".$data['referred'] ;
return $data;
}

	













?>
