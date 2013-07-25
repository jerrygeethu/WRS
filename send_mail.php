<?php
require_once('include/class.mail.php');
$obj=new mail();

$data['from']='danielgeorg7@gmail.com';
$data['to']=array('imageorge7@gmail.com','geethusnny@gmail.com');
//$data['bcc']=array('w@w.com','w@w.com');
$data['bcc']=array('imageorge7@gmail.com');
$data['subject']='from local';
$data['message']='hellooooooo';

//$data['message']='<p>hhhhh</p>';
$data['ishtml']=false;
$value=$obj->mailsend($data);
$obj->msg;
?>
