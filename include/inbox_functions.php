<?php 

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ 
 $queryinbox ="

select e.*,em.* from 
email as e ,emaildet as d, employee as em
where 
em.employeeid=e.sender
and
d.emailid=e.emailid
and 
d.emailto 	='".$_SESSION['USERID']."'
and
d.emailstatus !='trash' order by senddate
 ";
$resultinbox = $GLOBALS['db']->query($queryinbox);   
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ 
if($_GET['mail'] && ($_GET['mail']!="")){ 
	$id=intval($_GET['mail']);
	$preview['table']="  email ,employee,emaildet "; 
$preview['fields']=" email.*, employee.*,emaildet.* "; 
$preview['where']= " where sender=employeeid and 	status !='trash' and email.emailid='".$id."' and emaildet.emailto='".$_SESSION['USERID']."' and email.emailid=emaildet.emailid "; 
   $previewinbox =" select ".$preview['fields']." from ".$preview['table']."   ".$preview['where']." "; 
$inboxresult = $GLOBALS['db']->query($previewinbox);   
if(isset($inboxresult) and $inboxresult->num_rows>0) { 
	$row=$inboxresult->fetch_assoc(); 
	$data['mailpreview']="";
	$from=($row['sendertype']!='employee')?" ".ucfirst($row['sendertype'])." ":" ";
	$data['mailpreview'] .= "    <table border=\"1\" width=\"100%\">
	                             <tr>
	                                 <td class=\"outboxmails\" valign=\"top\" width=\"100px\" >
	                                 From 
	                                 </td>
	                                 <td class=\"outboxmails\"  valign=\"top\"> ".$from."  ".$row['fullname']."
	                                 </td>
	                             </tr> 
	                             <tr>
	                                 <td class=\"outboxmails\" valign=\"top\">
	                                 Subject
	                                 </td>
	                                 <td class=\"outboxmails\"  valign=\"top\">".$row['subject']." 
	                                 </td>
	                             </tr>
	                             <tr>
	                                 <td class=\"outboxmails\"  valign=\"top\">
	                                 Message
	                                 </td>
	                                 <td class=\"outboxmails\"  valign=\"top\">
        <textarea class=\"mail_preview_content\"  >".$row['message']." </textarea>
	                                 </td>
	                             </tr>
	                             <tr>
	                                 <td class=\"outboxmails\"  valign=\"top\" align=\"center\" colspan=\"2\">
	                                 <form action=\"inbox.php\" method=\"post\" >
	                                 <input  type=\"hidden\" value=\"".$id."\" name=\"mail\" id=\"mail\"/> 
	                                 <input  type=\"submit\" value=\"Delete\" name=\"d\" id=\"d\"/> 
	                                 </form>
	                                 </td>
	                             </tr>
	                         </table>"; 
	
}
}
else if($_POST['d'] && ($_POST['d']!="")){
$id=intval($_POST['mail']);


 $trash_query =" UPDATE  emaildet SET emailstatus = 'trash' WHERE emailid = '".$id."' and emailto='".$_SESSION['USERID']."' 	LIMIT 1 "; 
$trashresult = $GLOBALS['db']->query($trash_query);   

 
 if($trashresult){ 
			print " 
		<script type=\"text/javascript\"> 
		alert(\"Mail sent to trash\"); 
		window.refresh(); 
		</script> 
		"; 
}
  
} 
?>
