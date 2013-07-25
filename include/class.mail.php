<?php
/*
 * 
 * author: ima george
 * date:12/10/2009
 */
/*
 * 
 * name: mailsend()
 * @param:string from,array to,array bcc,array cc,string subject,string message
 * @return:boolean 
 */
class mail 
{ 
	private $to;
	private $from;
	private $bcc;
	private $cc;
	private $subject;
	private $message;
	private $headers;
	private $html;
	
	public $msg;
	
	public function mailsend($data)
	{//print_r($data);
		$this->html=$data['ishtml'];
		
		//from,$to,$subject,$message,$ishtml=true
		//from
		$this->from=$data['from'];
		
		// multiple recipients array
		$this->to  = $data['to'];		
		$this->bcc=  $data['bcc'];
		$this->cc=  $data['cc'];
		
		// subject
		$this->subject =$data['subject'];

		// message
		$this->message =$data['message'];

		// To send HTML mail, the Content-type header must be set
		$this->headers  = 'MIME-Version: 1.0' . "\r\n";
		$this->headers .= "Message-ID: <".$now." TheSystem@".$_SERVER['SERVER_NAME'].">"."\r\n";
		$this->headers .= "X-Mailer: PHP v".phpversion()."\r\n";
		if($this->html)
		{
			$this->headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		}
		else
		{
			$this->headers .= 'Content-type: text/plain; charset=UTF-8'. "\r\n";
		}

		//to Id
		$count_to=count($this->to);
		$count='0';
		$to="";
		while($count < $count_to)
		{
			$to.=$this->to[$count].", ";				
			$count ++;
		}
		

		// Additional headers		                                         
		$this->headers .= 'From: '.$this->from."\r\n";                                       
		$this->headers .= 'Reply-To:'.$this->from."\r\n"; 
		
		//Bcc
		$count_recip= count($this->bcc );		
		$count='0';
		$this->headers.="Bcc: ";
		while($count < $count_recip)
		{
			$this->headers.=$this->bcc[$count].", ";
			$count ++;
		}

		//cc
		$count_recip= count($this->cc );		
		$count='0';
		$this->headers.="Cc: ";
		while($count < $count_recip)
		{
			$this->headers.=$this->cc[$count].", ";
			$count ++;
		}						
	//$send=mail($to, $this->subject, $this->message, $this->headers);     //correct
		if($send)
		{
			$this->msg="Mail has been sent successfully";
			$result=true;
		}
		else
		{
			$this->msg="Failed to send mail.";
			$result=false;
		}		
		return $result;
	}
}



////////////////////////////////////////////////////////////////////
{
// multiple recipients
//$to  = 'aidan@example.com' . ', '; // note the comma
//$to .= 'wez@example.com';

/*
// subject
$subject = 'Birthday Reminders for August';

// message
$message = '
<html>
<head>
  <title>Birthday Reminders for August</title>
</head>
<body>
  <p>Here are the birthdays upcoming in August!</p>
  <table>
    <tr>
      <th>Person</th><th>Day</th><th>Month</th><th>Year</th>
    </tr>
    <tr>
      <td>Joe</td><td>3rd</td><td>August</td><td>1970</td>
    </tr>
    <tr>
      <td>Sally</td><td>17th</td><td>August</td><td>1973</td>
    </tr>
  </table>
</body>
</html>
';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
$headers .= 'From: Birthday Reminder <birthday@example.com>' . "\r\n";
$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";

// Mail it
mail($to, $subject, $message, $headers);
*/
}
?>
