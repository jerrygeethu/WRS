<?php 

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
$outbox['table']="  email "; 
$outbox['fields']=" * "; 
$outbox['where']= " where sender ='".$_SESSION['USERID']."' and 	status !='trash' order by senddate"; 
$querymail =" select ".$outbox['fields']." from ".$outbox['table']."   ".$outbox['where']." ";
$resultmail = $GLOBALS['db']->query($querymail);   
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

if($_GET['mail'] && ($_GET['mail']!="")){ 
	$id=intval($_GET['mail']);
	$preview['table']="  email ,employee "; 
$preview['fields']=" email.*, employee.* "; 
$preview['where']= " where sender=employeeid and sender ='".$_SESSION['USERID']."' and 	status !='trash' and emailid='".$id."' limit 1"; 
  $previewmail =" select ".$preview['fields']." from ".$preview['table']."   ".$preview['where']." ";
$previewresult = $GLOBALS['db']->query($previewmail);   
if(isset($previewresult) and $previewresult->num_rows>0) {
	 $tomailquery="select * from employee where employeeid in (select emailto from emaildet where  emailid='".$id."' ) order by fullname ";
	$emailtos="";
	$tomailresult = $GLOBALS['db']->query($tomailquery);   
	while($rowto=$tomailresult->fetch_assoc()){
		$emailtos .=($emailtos!="")?", ":"";
		$emailtos .=$rowto['fullname']; 
	} 
	$row=$previewresult->fetch_assoc(); 
	$data['mailpreview']="";
	$data['mailpreview'] .= "    <table border=\"1\" width=\"100%\">
	                             <tr>
	                                 <td class=\"outboxmails\" valign=\"top\" width=\"100px\" >
	                                 From 
	                                 </td>
	                                 <td class=\"outboxmails\"  valign=\"top\">  ".$row['email']." 
	                                 </td>
	                             </tr>
	                             <tr>
	                                 <td class=\"outboxmails\"  valign=\"top\">
	                                 To
	                                 </td>
	                                 <td class=\"outboxmails\"  valign=\"top\">  ".$emailtos." 
	                                 </td>
	                             </tr>
	                             <tr>
	                                 <td class=\"outboxmails\"  valign=\"top\">
	                                 Subject
	                                 </td>
	                                 <td class=\"outboxmails\" valign=\"top\">".$row['subject']." 
	                                 </td>
	                             </tr>
	                             <tr>
	                                 <td class=\"outboxmails\"  valign=\"top\">
	                                 Message
	                                 </td>
	                                 <td class=\"outboxmails\" > 
        <textarea class=\"mail_preview_content\"  >".$row['message']." </textarea>
	                                 </td>
	                             </tr>
	                         </table>";
	
	
	
	
	
	
	
}
}
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
	

























?>
