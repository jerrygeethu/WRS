var toid = 0;
function showAlert(msg){
	alert(msg);
}
function pad2(number) { 
	if(number < 10){
		 return  "0"+ number ;
		 }
		 else{ 
		 	return number; 
		 	} 
	}
		function check_date(t1,t2){	
		var one_day=1000*60*60*24; 
		var x=t1.split("/");     
		var y=t2.split("/");
		var date1=new Date(x[2],(x[1]-1),x[0]);
		var date2=new Date(y[2],(y[1]-1),y[0])
		var month1=x[1]-1;
		var month2=y[1]-1;
		Diff=Math.ceil((date2.getTime()-date1.getTime())/(one_day))+1;
		return Diff;
		}
		
		
		function checkType(){ 
			dropValue=document.getElementById("leave_type").value;  
			dropValue=dropValue*1;
			permissionID=document.getElementById("permissionID").value;
				if(dropValue!=0)
				{
				document.getElementById("validate").innerHTML="";
				}			
				if(permissionID==dropValue){
				toid = 0;
				document.getElementById('moredays').checked=false;
				document.getElementById('moreThan1Day').style.display="none";
				document.getElementById('from_date_options').style.display="none";
				document.getElementById('tofield').style.display="none";
				document.getElementById("to_date").value="";
				document.getElementById("days_count").value="";
				document.getElementById('durationField').style.display="";
			}// if permission selected if loop
			else{
document.getElementById('moreThan1Day').style.display="";
document.getElementById('from_date_options').style.display="";
				document.getElementById("duration").value="";
				document.getElementById("durationDrop").value=0;
				document.getElementById('durationField').style.display="none";
			}
			// to show the balance leaves available	
		leaveBalance=document.getElementById("leavebalance").value;   
 
		
		
		leaveType=	leaveBalance.split(","); 
		
			for(i=0;i<leaveType.length;i++){
				leavetypeBalance=leaveType[i].split("=>");   
				if(leavetypeBalance[0] == dropValue){
				leavetypeBalance[1]=leavetypeBalance[1]*1;
				
				if(leavetypeBalance[1] < 0){ 
				leavetypeBalance[1]=-leavetypeBalance[1];
				msg="You have already exceeded eligible leaves by  "+leavetypeBalance[1]+"  days under this type";
				}
				else if(leavetypeBalance[1] == 0){ 
					msg="You have already reached the limit for "+leavetypeBalance[1]+"!!"; 
				}
				else{ 
				msg="You are eligible for  "+leavetypeBalance[1]+" more days under this type";
				} 
					document.getElementById("validate").innerHTML=msg;
				}
				
			}			
		}
function loadto(idto){
	if(toid==0){
		document.getElementById('tofield').style.display="";
		toid = 1;
										
	}
	else{
		document.getElementById('tofield').style.display="none";
		toid = 0;
		document.getElementById("to_date").value="";
		document.getElementById("days_count").value="";
	}	
	}
function count_days(from,to,populate){
	today=document.getElementById("today").value;
	t1=document.getElementById(from).value;
		t2=document.getElementById(to).value;
//		alert("today="+today+"  t1="+t1);
	//	alert("today="+today+"  t1="+t1+"  t2="+t2+"  m="+mindays_toaply);
//	alert(mindays_toaply);
mindays_toaply2=mindays_toaply * -1;
		valid=check_date(today,t1);	
		var error="";
		 if (valid < mindays_toaply2){ 
			error="You are not allowed to apply on this date<br/>";
		}
		else if(t1==""){
			error=" Enter From date <br/>";
		}
		else if((toid==1)&&(t2=="")){
			error=" Enter To date <br/>";
		}
		else{
			Diff=check_date(t1,t2);		
			
			t1_opt=document.getElementById('from_date_options').value; 
			t2_opt=document.getElementById('to_date_options').value;
		if(t1_opt=="second"){
		Diff=Diff-.5;
	}
		if(t2_opt=="first"){
		Diff=Diff-.5;
	}
	if(Diff<.5){
			error=" Check Dates <br/>";
	}else{
		document.getElementById(populate).value=Diff;
		error="";
		}
	}
		document.getElementById('validate').innerHTML=error;
//	return FALSE;
}
function validate(){
	
		today=document.getElementById("today").value;
	t1=document.getElementById('from_date').value;
		t2=document.getElementById('to_date').value;
		dropValue=document.getElementById("leave_type").value;
			permissionID=document.getElementById("permissionID").value;
			
					
		//	if(permissionID==dropValue){
		valid=check_date(today,t1);	
				if((toid==1)&&(t2!="")){
		diff_in_dates=check_date(t1,t2);		
	}
	if((document.getElementById('leave_type').value)==0){
		error="Select Leave Type";
				document.getElementById('leave_type').focus();
	}
	else if((t1)==""){
		error="Enter Date";
				document.getElementById('from_date').focus();
	}
	else if(valid<= -(mindays_toaply)){
		error="Check From Date";
				document.getElementById('from_date').focus();
	}
	else if((permissionID==dropValue)&&((document.getElementById('duration').value)=="")){
				error="Entet From Time";
				document.getElementById('duration').focus();
	}
	else if((permissionID==dropValue)&&((document.getElementById('durationDrop').value)==0)){
				error="Select Duration";
				document.getElementById('durationDrop').focus();
	}
	else if((toid==1)&&(t2=="")){
				error="Enter To Date";
				document.getElementById('to_date').focus();
	}
	else if((toid==1)&&( diff_in_dates<=1)){
				error="Check To Date";
				document.getElementById('to_date').focus();
	}
	else if((toid==1)&&(document.getElementById('days_count').value=="")){
				error="Enter No of Days";
				document.getElementById('days_count').focus();
	}
	else if((toid==1)&&(document.getElementById('days_count').value<.5)){
				error="Check Dates";
				document.getElementById('days_count').focus();
	}
	else if((toid==1)&&((document.getElementById('days_count').value>(diff_in_dates+1))||(document.getElementById('days_count').value<(diff_in_dates-1)))){
				error="Check No of days";
				document.getElementById('days_count').focus();
	}
	else if((document.getElementById('reason').value)==""){
				error="Enter Reason";
				document.getElementById('reason').focus();
	}
	else{
		return true;
	}
	document.getElementById('validate').innerHTML=error;
	return false;
}



function date_calculator(fromfield,tofield,duration,err){
					f=document.getElementById(fromfield).value;
					t=document.getElementById(tofield).value;
					information="";
					if(document.getElementById(fromfield).value.length!=8){
					information="Enter From time (hh:mm:ss)";
					document.getElementById(duration).value="";
					}
						else if(document.getElementById(tofield).value.length!=8){
					information="Enter To time  (hh:mm:ss)";
					document.getElementById(duration).value="";
					}
					else{
					fromtime=f.split(":");
					totime=t.split(":");
					ftime=fromtime[0]+""+fromtime[1]+""+fromtime[2];
					ttime=totime[0]+""+totime[1]+""+totime[2];
					ftime=ftime*1;
					ttime=ttime*1;
					if(ftime>=ttime){
					information="!! To Time is Before From Time";
					document.getElementById(duration).value="";
					}else{
					toh =  totime[0]*1;
					tom =  totime[1]*1;
					tos =  totime[2]*1;
					frh = fromtime[0]*1;
					frm =  fromtime[1]*1;
					frs =  fromtime[2]*1;
					uptod=0;
					uptoh=(toh-frh)*1;
					uptom=(tom-frm)*1;
					uptos=(tos-frs)*1;
					if(uptos<0){
					 uptom=uptom-1;
					 uptos=60-(-uptos);
					}
					if(uptom<0){
					 uptoh=uptoh-1;
						uptom=60-(-uptom);
					}
					if(uptoh<0){
					 uptoh=00;
					}
					uptoh=uptoh*1;
					uptom=uptom*1;
					uptos=uptos*1;
					uptoh11=pad2(uptoh);
					uptom11=pad2(uptom);
					uptos11=pad2(uptos);
					 result=uptoh11+":"+uptom11+":"+uptos11;	
					 document.getElementById(duration).value=result;
					}
					}
					if(information!=""){
					 document.getElementById(err).innerHTML=information;
				 }
				 else{
				 	 document.getElementById(err).innerHTML="&nbsp;";
				}
					 return;
}
function getDetails(id){
idVisible=id+"_div";
idList=document.getElementById("ids_list").value;
ids=idList.split(",");
idd=ids.length-1;
for(i=0;i<idd;i++){
iddd=ids[i]+"_div";
//alert(iddd);
document.getElementById(iddd).style.display="none";
}
document.getElementById(idVisible).style.display="";
}

function new_report_form(newID){
	var validResult="";
	var br="<br/>";
	fromTime=document.getElementById(newID+"_fromfiled").value;
	toTime=document.getElementById(newID+"_tofiled").value;
	durationTime=document.getElementById(newID+"_duration").value;
	reportType=document.getElementById(newID+"_reporttype").value;
	newReport=document.getElementById(newID+"_report").value;
	if(reportType==0){
	activityType=document.getElementById(newID+"_activityType").value;
}
	else{
	activityType="";
}	
	if(fromTime==""){
		validResult+=" Please Enter From time "+br;
	}
	if(toTime==""){
		validResult+=" Please Enter To time "+br;
	}
	if((durationTime=="")&&(validResult=="")){
		validResult+=" Please Re-enter Time "+br;
	}
	if((reportType==0)&&(activityType==0)){
		validResult+=" Please Select Activity Type "+br;
	}
	if((newReport=="")||(newReport=="Enter Your Report")){
		validResult+=" Please Enter Your Report "+br;
	}
	if(validResult==""){
		return true;
	}else{	
	document.getElementById(newID+"_error").innerHTML=validResult;
	return false;
}
	return false;
}




function checkType2(msg){
	leave=msg.split("~");
dropValue=leave[0];
			if(dropValue!=0){
				document.getElementById("validate").innerHTML="";
			}			
	permissionID=document.getElementById("permissionID").value;
	 
	 
		if(permissionID==dropValue){
				toid = 0;
document.getElementById('moredays').checked=false;
document.getElementById('moreThan1Day').style.display="none";
document.getElementById('from_date_options').style.display="none";
document.getElementById('tofield').style.display="none";
				document.getElementById("to_date").value="";
				document.getElementById("days_count").value="";
				document.getElementById('durationField').style.display="";
			}// if permission selected if loop
			else{
document.getElementById('moreThan1Day').style.display="";
document.getElementById('from_date_options').style.display="";
				document.getElementById("duration").value="";
				document.getElementById("durationDrop").value=0;
				document.getElementById('durationField').style.display="none";
			}
			// to show the balance leaves available	

	if(leave[1]>0){
	show="You are eligible for "+leave[1]+" leaves more";
	}
	else if(leave[1]==0){
			show="You are already reached the limit for "+leave[1];
	}
	else{
				show="You are already exceeded the limit by "+(-(leave[1]));
	}
					document.getElementById("validate").innerHTML=show;
}