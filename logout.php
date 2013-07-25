<?php 
session_start();
require_once('include/include.php');

//destroy mysqli object if still active
/* close connection */
if(!empty($GLOBALS['db']))
{
    $GLOBALS['db']->close();
    $GLOBALS['db']=null;
}
session_destroy(); 
header("location:index.php?e=4");
 
?>
