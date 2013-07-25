     <?php
    // Connects to your Database
    mysql_connect("your.hostaddress.com", "username", "password") or die(mysql_error());
    mysql_select_db("address") or die(mysql_error());

    //This checks to see if there is a page number. If not, it will set it to page 1
    if (!(isset($pagenum)))
    {
    $pagenum = 1;
    }

    //Here we count the number of results
    //Edit $data to be your query
    $data = mysql_query("SELECT * FROM topsites") or die(mysql_error());
    $rows = mysql_num_rows($data);

    //This is the number of results displayed per page
    $page_rows = 4;

    //This tells us the page number of our last page
    $last = ceil($rows/$page_rows);

    //this makes sure the page number isn't below one, or more than our maximum pages
    if ($pagenum < 1)
    {
    $pagenum = 1;
    }
    elseif ($pagenum > $last)
    {
    $pagenum = $last;
    }

    //This sets the range to display in our query
    $max = 'limit ' .($pagenum - 1) * $page_rows .',' .$page_rows; 

?>










