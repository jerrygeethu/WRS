// copyright owned by Mr.Sukesh (2007)
var xmlHttp = false;
	try {
	  	xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch (e) {
	  	try {
			xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	  	}
	  	catch (e2) {
			xmlHttp = false;
	  	}
	}
	if (!xmlHttp && typeof XMLHttpRequest != 'undefined') 
	{
		xmlHttp = new XMLHttpRequest();
	}
	
	var targId;
	var targType = 0;
	var flag=true;
	function fnShowData(url,tagetId,targetType,flag)
	{    
		targId=tagetId;
		targType=targetType;
		xmlHttp.open("GET", url, flag);
		xmlHttp.onreadystatechange = updateTable;
		xmlHttp.send(null);
	}

	function updateTable() 
	{   
		if (xmlHttp.readyState == 4) 
		{    
			document.getElementById(targId).innerHTML = xmlHttp.responseText;
			if (targType > 0)
				setTarget(targType);
		}
		if (xmlHttp.readyState < 4) 
		{    
			document.getElementById(targId).innerHTML = "<div style='color:#000000;'>&nbsp;&nbsp;&nbsp;<img src='images/earth.gif' width='25px' height='25px'/>&nbsp;&nbsp; Please wait... </div>";
			if (targType > 0)
				setTarget(targType);
		}
	}
	var getData;
	function fnGetData(url,flag)
	{    
		xmlHttp.open("GET", url, flag);
		xmlHttp.onreadystatechange = updateData;
		xmlHttp.send(null);
		return getData;
	}

	function updateData() 
	{   
		if (xmlHttp.readyState == 4){
			getData = xmlHttp.responseText;
		}
	}
