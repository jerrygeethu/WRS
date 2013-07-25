///////////////////////////////////////// Date utilities //////////////////////////////////////////////////////////////

// ------------------------------------------------------------------
//  The format string consists of the following abbreviations:
//
// Field        | Full Form          | Short Form
// -------------+--------------------+-----------------------
// Year         | yyyy (4 digits)    | yy (2 digits), y (2 or 4 digits)
// Month        | MMM (name or abbr.)| MM (2 digits), M (1 or 2 digits)
//              | NNN (abbr.)        |
// Day of Month | dd (2 digits)      | d (1 or 2 digits)
// Day of Week  | EE (name)          | E (abbr)
// Hour (1-12)  | hh (2 digits)      | h (1 or 2 digits)
// Hour (0-23)  | HH (2 digits)      | H (1 or 2 digits)
// Hour (0-11)  | KK (2 digits)      | K (1 or 2 digits)
// Hour (1-24)  | kk (2 digits)      | k (1 or 2 digits)
// Minute       | mm (2 digits)      | m (1 or 2 digits)
// Second       | ss (2 digits)      | s (1 or 2 digits)
// AM/PM        | a                  |
//
// NOTE THE DIFFERENCE BETWEEN MM and mm! Month=MM, not mm!
// Examples:
//  "MMM d, y" matches: January 01, 2000
//                      Dec 1, 1900
//                      Nov 20, 00
//  "M/d/yy"   matches: 01/20/00
//                      9/2/00
//  "MMM dd, yyyy hh:mm:ssa" matches: "January 01, 2000 12:30:45AM"
// ------------------------------------------------------------------
////Mail id validation
//function validmail(mail)
//function getDateFromFormat(val,format) 
//function isDate(val,format)
//// Return true when date2 is greater than date1.
//function compareDates(date1,dateformat1,date2,dateformat2)

var MONTH_NAMES=new Array('January','February','March','April','May','June','July','August','September','October','November','December','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
var DAY_NAMES=new Array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sun','Mon','Tue','Wed','Thu','Fri','Sat');
function LZ(x) {return(x<0||x>9?"":"0")+x}

// ------------------------------------------------------------------
// isDate ( date_string, format_string )
// Returns true if date string matches format of format string and
// is a valid date. Else returns false.
// It is recommended that you trim whitespace around the value before
// passing it to this function, as whitespace is NOT ignored!
// ------------------------------------------------------------------
function isDate(val,format) {
	var date=getDateFromFormat(val,format);
	if (date==0) { return false; }
	return true;
	}

// -------------------------------------------------------------------
// compareDates(date1,date1format,date2,date2format)
//   Compare two date strings to see which is greater.
//   Returns:
//   1 if date1 is greater than date2
//   0 if date2 is greater than date1 of if they are the same
//  -1 if either of the dates is in an invalid format
// -------------------------------------------------------------------
// Return true when date2 is greater than date1.
function compareDates(date1,dateformat1,date2,dateformat2) {

	var d1=getDateFromFormat(date1,dateformat1);
	var d2=getDateFromFormat(date2,dateformat2);
	var validateDate =0
	if (d1==0 || d2==0) {
		return false;
		}
	else if (d1 > d2) {

		return false;
		}
	return true;
	}

// ------------------------------------------------------------------
// formatDate (date_object, format)
// Returns a date in the output format specified.
// The format string uses the same abbreviations as in getDateFromFormat()
// ------------------------------------------------------------------
function formatDate(date,format) {
	format=format+"";
	var result="";
	var i_format=0;
	var c="";
	var token="";
	var y=date.getYear()+"";
	var M=date.getMonth()+1;
	var d=date.getDate();
	var E=date.getDay();
	var H=date.getHours();
	var m=date.getMinutes();
	var s=date.getSeconds();
	var yyyy,yy,MMM,MM,dd,hh,h,mm,ss,ampm,HH,H,KK,K,kk,k;
	// Convert real date parts into formatted versions
	var value=new Object();
	if (y.length < 4) {y=""+(y-0+1900);}
	value["y"]=""+y;
	value["yyyy"]=y;
	value["yy"]=y.substring(2,4);
	value["M"]=M;
	value["MM"]=LZ(M);
	value["MMM"]=MONTH_NAMES[M-1];
	value["NNN"]=MONTH_NAMES[M+11];
	value["d"]=d;
	value["dd"]=LZ(d);
	value["E"]=DAY_NAMES[E+7];
	value["EE"]=DAY_NAMES[E];
	value["H"]=H;
	value["HH"]=LZ(H);
	if (H==0){value["h"]=12;}
	else if (H>12){value["h"]=H-12;}
	else {value["h"]=H;}
	value["hh"]=LZ(value["h"]);
	if (H>11){value["K"]=H-12;} else {value["K"]=H;}
	value["k"]=H+1;
	value["KK"]=LZ(value["K"]);
	value["kk"]=LZ(value["k"]);
	if (H > 11) { value["a"]="PM"; }
	else { value["a"]="AM"; }
	value["m"]=m;
	value["mm"]=LZ(m);
	value["s"]=s;
	value["ss"]=LZ(s);
	while (i_format < format.length) {
		c=format.charAt(i_format);
		token="";
		while ((format.charAt(i_format)==c) && (i_format < format.length)) {
			token += format.charAt(i_format++);
			}
		if (value[token] != null) { result=result + value[token]; }
		else { result=result + token; }
		}
	return result;
	}
// ------------------------------------------------------------------
// Utility functions for parsing in getDateFromFormat()
// ------------------------------------------------------------------
function _isInteger(val) {
	var digits="1234567890";
	for (var i=0; i < val.length; i++) {
		if (digits.indexOf(val.charAt(i))==-1) { return false; }
		}
	return true;
	}
function _getInt(str,i,minlength,maxlength) {
	for (var x=maxlength; x>=minlength; x--) {
		var token=str.substring(i,i+x);
		if (token.length < minlength) { return null; }
		if (_isInteger(token)) { return token; }
		}
	return null;
	}
// ------------------------------------------------------------------
// getDateFromFormat( date_string , format_string )
//
// This function takes a date string and a format string. It matches
// If the date string matches the format string, it returns the
// getTime() of the date. If it does not match, it returns 0.
// ------------------------------------------------------------------
function getDateFromFormat(val,format) {
	val=val+"";
	format=format+"";
	var i_val=0;
	var i_format=0;
	var c="";
	var token="";
	var token2="";
	var x,y;
	var now=new Date();
	var year=now.getYear();
	var month=now.getMonth()+1;
	var date=1;
	var hh=now.getHours();
	var mm=now.getMinutes();
	var ss=now.getSeconds();
	var ampm="";

	while (i_format < format.length) {
		// Get next token from format string
		c=format.charAt(i_format);
		token="";
		while ((format.charAt(i_format)==c) && (i_format < format.length)) {
			token += format.charAt(i_format++);
			}
		// Extract contents of value based on format token
		if (token=="yyyy" || token=="yy" || token=="y") {
			if (token=="yyyy") { x=4;y=4; }
			if (token=="yy")   { x=2;y=2; }
			if (token=="y")    { x=2;y=4; }
			year=_getInt(val,i_val,x,y);
			if (year==null) { return 0; }
			i_val += year.length;
			if (year.length==2) {
				if (year > 70) { year=1900+(year-0); }
				else { year=2000+(year-0); }
				}
			}
		else if (token=="MMM"||token=="NNN"){
			month=0;
			for (var i=0; i<MONTH_NAMES.length; i++) {
				var month_name=MONTH_NAMES[i];
				if (val.substring(i_val,i_val+month_name.length).toLowerCase()==month_name.toLowerCase()) {
					if (token=="MMM"||(token=="NNN"&&i>11)) {
						month=i+1;
						if (month>12) { month -= 12; }
						i_val += month_name.length;
						break;
						}
					}
				}
			if ((month < 1)||(month>12)){return 0;}
			}
		else if (token=="EE"||token=="E"){
			for (var i=0; i<DAY_NAMES.length; i++) {
				var day_name=DAY_NAMES[i];
				if (val.substring(i_val,i_val+day_name.length).toLowerCase()==day_name.toLowerCase()) {
					i_val += day_name.length;
					break;
					}
				}
			}
		else if (token=="MM"||token=="M") {
			month=_getInt(val,i_val,token.length,2);
			if(month==null||(month<1)||(month>12)){return 0;}
			i_val+=month.length;}
		else if (token=="dd"||token=="d") {
			date=_getInt(val,i_val,token.length,2);
			if(date==null||(date<1)||(date>31)){return 0;}
			i_val+=date.length;}
		else if (token=="hh"||token=="h") {
			hh=_getInt(val,i_val,token.length,2);
			if(hh==null||(hh<1)||(hh>12)){return 0;}
			i_val+=hh.length;}
		else if (token=="HH"||token=="H") {
			hh=_getInt(val,i_val,token.length,2);
			if(hh==null||(hh<0)||(hh>23)){return 0;}
			i_val+=hh.length;}
		else if (token=="KK"||token=="K") {
			hh=_getInt(val,i_val,token.length,2);
			if(hh==null||(hh<0)||(hh>11)){return 0;}
			i_val+=hh.length;}
		else if (token=="kk"||token=="k") {
			hh=_getInt(val,i_val,token.length,2);
			if(hh==null||(hh<1)||(hh>24)){return 0;}
			i_val+=hh.length;hh--;}
		else if (token=="mm"||token=="m") {
			mm=_getInt(val,i_val,token.length,2);
			if(mm==null||(mm<0)||(mm>59)){return 0;}
			i_val+=mm.length;}
		else if (token=="ss"||token=="s") {
			ss=_getInt(val,i_val,token.length,2);
			if(ss==null||(ss<0)||(ss>59)){return 0;}
			i_val+=ss.length;}
		else if (token=="a") {
			if (val.substring(i_val,i_val+2).toLowerCase()=="am") {ampm="AM";}
			else if (val.substring(i_val,i_val+2).toLowerCase()=="pm") {ampm="PM";}
			else {return 0;}
			i_val+=2;}
		else {
			if (val.substring(i_val,i_val+token.length)!=token) {return 0;}
			else {i_val+=token.length;}
			}
		}
	// If there are any trailing characters left in the value, it doesn't match
	if (i_val != val.length) { return 0; }
	// Is date valid for month?
	if (month==2) {
		// Check for leap year
		if ( ( (year%4==0)&&(year%100 != 0) ) || (year%400==0) ) { // leap year
			if (date > 29){ return 0; }
			}
		else { if (date > 28) { return 0; } }
		}
	if ((month==4)||(month==6)||(month==9)||(month==11)) {
		if (date  > 30) { return 0; }
		}
	// Correct hours value
	if (hh<12 && ampm=="PM") { hh=hh-0+12; }
	else if (hh>11 && ampm=="AM") { hh-=12; }
	var newdate=new Date(year,month-1,date,hh,mm,ss);
	return newdate.getTime();
	}

	function Time_Format(vTimeName,vTimeValue)
	{
		var strTime =vTimeValue;
		for (var i=0; i<strTime.length; i++)
		{
			var strCheck =strTime.substring(i,i+1);
			var alphaCheck = " abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ/\\-\"`~!@#$%^&*()_+={}[]|;',.?<>";
			if (alphaCheck.indexOf(strCheck) >= 1) 
			{
				vTimeName.value = strTime.substring(0,i)+strTime.substring(i+1,strTime.length);
				return false;
			}
			else
			{		
				if (i == 0)
				{
					if (strCheck != 0 && strCheck != 1 && strCheck != 2)
						vTimeName.value =strTime.substring(0,i)+strTime.substring(i+1,strTime.length);
					else	
						vTimeName.value = strTime;
				}
				else if (i == 1)
				{
					if (strTime.substring(0,i) == 2 )
					{
						if (strCheck != 0 && strCheck != 1 && strCheck != 2 && strCheck != 3)
							vTimeName.value = strTime.substring(0,i)+strTime.substring(i+1,strTime.length);
						else
							vTimeName.value = strTime+':';
					}
					else
					{
						if (strCheck != 0 && strCheck != 1 && strCheck != 2 && strCheck != 3 && strCheck != 4 && strCheck != 5 && strCheck != 6 && strCheck != 7 && strCheck != 8 && strCheck != 9)					
							vTimeName.value = strTime.substring(0,i)+strTime.substring(i+1,strTime.length);
						else
							vTimeName.value = strTime+':';
					}
				}
				else if (i == 2)
				{
					if (strCheck == ':')
						vTimeName.value = strTime;
					else
						vTimeName.value = strTime.substring(0,i)+strTime.substring(i+1,strTime.length);
				}
				else if (i == 3)
				{
					if (strCheck != 0 && strCheck != 1 && strCheck != 2 && strCheck != 3 && strCheck != 4 && strCheck != 5 )
						vTimeName.value = strTime.substring(0,i)+strTime.substring(i+1,strTime.length);
					else
						vTimeName.value = strTime;
				}
				else if (i == 4)
				{
					if (strCheck != 0 && strCheck != 1 && strCheck != 2 && strCheck != 3 && strCheck != 4 && strCheck != 5 && strCheck != 6 && strCheck != 7 && strCheck != 8 && strCheck != 9)
						vTimeName.value = strTime.substring(0,i)+strTime.substring(i+1,strTime.length);
					else
						vTimeName.value = strTime+':';
				}
				else if (i == 5)
				{
					if (strCheck == ':')
						vTimeName.value = strTime;
					else
						vTimeName.value = strTime.substring(0,i)+strTime.substring(i+1,strTime.length);
				}
				else if (i == 6)
				{
					if (strCheck != 0 && strCheck != 1 && strCheck != 2 && strCheck != 3 && strCheck != 4 && strCheck != 5 )
						vTimeName.value = strTime.substring(0,i)+strTime.substring(i+1,strTime.length);
					else
						vTimeName.value = strTime;
				}
				else if (i == 7)
				{
					if (strCheck != 0 && strCheck != 1 && strCheck != 2 && strCheck != 3 && strCheck != 4 && strCheck != 5 && strCheck != 6 && strCheck != 7 && strCheck != 8 && strCheck != 9)
						vTimeName.value = strTime.substring(0,i)+strTime.substring(i+1,strTime.length);
					else
						vTimeName.value = strTime;
				}
				else if (i > 7)
				{
					vTimeName.value = strTime.substring(0,8);
				}
//				return false;			
			}		
		}
		
		if (strTime.length == 1)
		{
			if(strTime >2 )
				vTimeName.value ="0"+strTime+":";
			else	
				vTimeName.value = strTime;
		}
		else if (strTime.length == 2)
		{
			if (strTime.substring(0,strTime.length-1) == 2 )
			{
				if (strTime.substring(strTime.length-1,strTime.length) > 3 )
					vTimeName.value = strTime.substring(0,strTime.length-1);
				else
					vTimeName.value = strTime+':';
			}
			else
				vTimeName.value = strTime+':';
		}
		else if (strTime.length == 3)
		{
			if (strTime.substring(strTime.length-1,strTime.length) == ':')
				vTimeName.value = strTime;
			else
				vTimeName.value = strTime.substring(0,strTime.length-1)+':';
		}
		else if (strTime.length == 4)
		{ 
			if (strTime.substring(strTime.length-1,strTime.length) >5 )
				vTimeName.value = strTime.substring(0,strTime.length-1);
			else
				vTimeName.value = strTime;
		}
		else if (strTime.length == 5)
		{
			vTimeName.value = strTime+':';
		}
		else if (strTime.length == 6)
		{
			if (strTime.substring(strTime.length-1,strTime.length) == ':')
				vTimeName.value = strTime;
			else
				vTimeName.value = strTime.substring(0,strTime.length-1)+':';
		}
		else if (strTime.length == 7)
		{ 
			if (strTime.substring(strTime.length-1,strTime.length) >5 )
				vTimeName.value = strTime.substring(0,strTime.length-1);
			else
				vTimeName.value = strTime;
		}
		else if (strTime.length > 8)
		{
			vTimeName.value = strTime.substring(0,8);
		}
		return false;
	}
	
	function Time_Validate(vTimeName,vTimeValue)
	{
		var strTime =vTimeValue;
		if (strTime.length == 1)
		{
			vTimeName.value = "0"+strTime+":00:00"
		}
		else if (strTime.length == 2 )
		{
			vTimeName.value = strTime+":00:00"
		}
		else if (strTime.length == 3 )
		{
			vTimeName.value = strTime+"00:00"
		}
		else if (strTime.length == 4 )
		{
			vTimeName.value = strTime+"0:00"
		}
		else if (strTime.length == 5 )
		{
			vTimeName.value = strTime+":00"
		}
		else if (strTime.length == 6 )
		{
			vTimeName.value = strTime+"00"
		}
		else if (strTime.length == 7 )
		{
			vTimeName.value = strTime+"0"
		}
		if (strTime.length > 8 )
		{
				vTimeName.value = ""
				alert("Invalid Time\nPlease Re-Enter");
				vTimeName.focus();
				vTimeName.select();
				return false;
		}
		for (var i=0; i<strTime.length; i++)
		{
			var strCheck =strTime.substring(i,i+1);
			var alphaCheck = " abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ/\\-\"`~!@#$%^&*()_+={}[]|;',.?<>";
			if (alphaCheck.indexOf(strCheck) >= 1) 
			{
				vTimeName.value = ""
				alert("Invalid Time\nPlease Re-Enter");
				vTimeName.focus();
				vTimeName.select();
				return false;
			}
		}
		for (var i=0; i<strTime.length; i++)
		{
			var strCheck =strTime.substring(i,i+1);
			var alphaCheck = ":";
			if (i == 0)
			{
				if (strCheck != 0 && strCheck != 1 && strCheck != 2)
				{
					vTimeName.value = ""
					alert("Invalid Time\nPlease Re-Enter");
					vTimeName.focus();
					vTimeName.select();
					return false;
				}
				if (alphaCheck.indexOf(strCheck) == 0) 
				{
					vTimeName.value = ""
					alert("Invalid Time\nPlease Re-Enter");
					vTimeName.focus();
					vTimeName.select();
					return false;
				}
			}
			else if (i == 1 )
			{
				if (strTime.substring(0,strTime.length-1) == 2 )
				{	
					if (strCheck != 0 && strCheck != 1 && strCheck != 2 && strCheck != 3 )
					{
						vTimeName.value = ""
						alert("Invalid Time\nPlease Re-Enter");
						vTimeName.focus();
						vTimeName.select();
						return false;
					}
				}
				else	
				{
					if (strCheck != 0 && strCheck != 1 && strCheck != 2 && strCheck != 3 && strCheck != 4 && strCheck != 5 && strCheck != 6 && strCheck != 7 && strCheck != 8 && strCheck != 9)
					{
						vTimeName.value = ""
						alert("Invalid Time\nPlease Re-Enter");
						vTimeName.focus();
						vTimeName.select();
						return false;
					}
				}
				if (alphaCheck.indexOf(strCheck) == 0) 
				{
					vTimeName.value = ""
					alert("Invalid Time\nPlease Re-Enter");
					vTimeName.focus();
					vTimeName.select();
					return false;
				}
			}
			else if (i == 2)
			{
				if (strCheck != ":") 
				{
					vTimeName.value = ""
					alert("Invalid Time\nPlease Re-Enter");
					vTimeName.focus();
					vTimeName.select();
					return false;
				}
				if (alphaCheck.indexOf(strCheck) != 0) 
				{
					vTimeName.value = ""
					alert("Invalid Time\nPlease Re-Enter");
					vTimeName.focus();
					vTimeName.select();
					return false;
				}
			}
			else if (i == 3)
			{
				if (strCheck != 0 && strCheck != 1 && strCheck != 2 && strCheck != 3 && strCheck != 4 && strCheck != 5 )
				{
					vTimeName.value = ""
					alert("Invalid Time\nPlease Re-Enter");
					vTimeName.focus();
					vTimeName.select();
					return false;
				}
				if (alphaCheck.indexOf(strCheck) == 0) 
				{
					vTimeName.value = ""
					alert("Invalid Time\nPlease Re-Enter");
					vTimeName.focus();
					vTimeName.select();
					return false;
				}
			}
			else if (i == 4 )
			{
				if (strCheck != 0 && strCheck != 1 && strCheck != 2 && strCheck != 3 && strCheck != 4 && strCheck != 5 && strCheck != 6 && strCheck != 7 && strCheck != 8 && strCheck != 9)
				{
					vTimeName.value = ""
					alert("Invalid Time\nPlease Re-Enter");
					vTimeName.focus();
					vTimeName.select();
					return false;
				}
				if (alphaCheck.indexOf(strCheck) == 0) 
				{
					vTimeName.value = ""
					alert("Invalid Time\nPlease Re-Enter");
					vTimeName.focus();
					vTimeName.select();
					return false;
				}
			}
			else if (i == 5)
			{
				if (strCheck != ":") 
				{
					vTimeName.value = ""
					alert("Invalid Time\nPlease Re-Enter");
					vTimeName.focus();
					vTimeName.select();
					return false;
				}
				if (alphaCheck.indexOf(strCheck) != 0) 
				{
					vTimeName.value = ""
					alert("Invalid Time\nPlease Re-Enter");
					vTimeName.focus();
					vTimeName.select();
					return false;
				}
			}
			else if (i == 6)
			{
				if (strCheck != 0 && strCheck != 1 && strCheck != 2 && strCheck != 3 && strCheck != 4 && strCheck != 5 )
				{
					vTimeName.value = ""
					alert("Invalid Time\nPlease Re-Enter");
					vTimeName.focus();
					vTimeName.select();
					return false;
				}
				if (alphaCheck.indexOf(strCheck) == 0) 
				{
					vTimeName.value = ""
					alert("Invalid Time\nPlease Re-Enter");
					vTimeName.focus();
					vTimeName.select();
					return false;
				}
			}
			else if (i == 7 )
			{
				if (strCheck != 0 && strCheck != 1 && strCheck != 2 && strCheck != 3 && strCheck != 4 && strCheck != 5 && strCheck != 6 && strCheck != 7 && strCheck != 8 && strCheck != 9)
				{
					vTimeName.value = ""
					alert("Invalid Time\nPlease Re-Enter");
					vTimeName.focus();
					vTimeName.select();
					return false;
				}
				if (alphaCheck.indexOf(strCheck) == 0) 
				{
					vTimeName.value = ""
					alert("Invalid Time\nPlease Re-Enter");
					vTimeName.focus();
					vTimeName.select();
					return false;
				}
			}
		}
	}
//Mail id validation
function validmail(mail)
{
		var str= mail.value;
		var locSpace= str.indexOf(" ");
		var locAt= str.indexOf("@");
		var tmpStr= str.substring(locAt+1);
		var locDot= tmpStr.indexOf(".");

		locSpace= str.indexOf(" ");

	// check if the email address contains " " ( space ). If it does, give an error message.
  if ( locSpace> -1 )
   {
	 alert("The e-mail address cannot contain a space character.");
	 mail.focus();
	 mail.select();
	 return false;
   }

		locSpace= str.indexOf(",");

	// check if the email address contains ",". If it does, give an error message.
  if ( locSpace> -1 )
   {
	alert("The e-mail address cannot contain a \',\' character.");

	mail.focus();
	mail.select();
	return false;
   }

		locAt= str.indexOf("@");

	// check if the email address contains "@". If it doesn't, give an error message.
  if ( locAt< 1 )
    {
	 alert("The e-mail address must be in the form \'username@domain.name\'.");

	 mail.focus();
	 mail.select();
	 return false;
	}

		tmpStr= str.substring(locAt+1);
		locAt= tmpStr.indexOf("@");

	// check if the email address contains a second "@". If it does, give an error message.
  if ( locAt> -1 )
   {
	alert("The e-mail address can contain only one \'@\' symbol.");

	mail.focus();
	mail.select();
	return false;
   }

		locAt= str.indexOf("@");
		tmpStr= str.substring(locAt+1);
		locDot= tmpStr.indexOf(".");
	// check if the email address domain contains at least one "." character. If not, give an error message
  if ( (locDot<0) )
   {
	alert("The domain must contain at least one \'.\' character.");

	mail.focus();
	mail.select();
	return false;
   }

	// check if the "username" starts with a dot
  if ( str.charAt(0)== ".")
   {
	alert("The username part of the e-mail address can not start with a \'.\' character.");

	mail.focus();
	mail.select();
	return false;
   }

		locAt= str.indexOf("@");
		tmpStr= str.substring(0,locAt);
		locDot= tmpStr.charAt(tmpStr.length-1);

	// check if the "username" ends with a dot
  if ( tmpStr.charAt(tmpStr.length-1)== ".")
   {
	alert("The username part of the e-mail address cannot end with a \'.\' character.");

	mail.focus();
	mail.select();
	return false;
   }

	// check if the "domain" ends with a dot
  if ( str.charAt(str.length-1)== ".")
   {
	alert("The domain part of the e-mail address cannot end with a \'.\' character.");

	mail.focus();
	mail.select();
	return false;
   }

		locAt= str.indexOf("@");
		tmpStr= str.substring(locAt+1);
	// check if the "domain" starts with a dot
  if ( tmpStr.charAt(0)== ".")
   {
	alert("The domain part of the e-mail address cannot start with a \'.\' character.");

	mail.focus();
	mail.select();
	return false;
   }
  return true;
}

