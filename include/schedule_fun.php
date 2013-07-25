<?php



function get_reports($received_query){
	//echo $received_query;
	$result = $GLOBALS['db']->query($received_query);
			$number=0;
			$res.="<div id=\"sch_report\" name=\"sch_report\">";
				if(isset($result) and $result->num_rows>0) {
				$res.="<table border=\"0\">
				           <tr>
				                <th width=\"20px\">
				                Sl 
				               </th>
				               <th  width=\"250px\">
				               Schedule
				               </th>
				               <th  width=\"250px\">
				               Report
				               </th>
				               <th  width=\"250px\">
				               Comment
				               </th>
				               <th  width=\"50px\">
				               </th>
				           </tr>
				       </table>";
				
				
					while($row = $result->fetch_assoc()) {
						$number++;
						$time=get_time($number."_time",0);
						$res.="
						<div class=\"reports_div\">
						
						<table>
						    <tr>
						        <td id=\"sl\">
						        ".$number."
						        </td>
						        <td  class=\"schedule\">
						        <textarea id=\"".$number."_sch\" class=\"schedule\"></textarea>
						        </td>
						        <td class=\"schedule\">
						        <textarea id=\"".$number."_report\" class=\"schedule\">".$row['eight']."</textarea>
						        </td>
						        <td class=\"schedule\">
						        <textarea  id=\"".$number."_comment\" class=\"schedule\"> width=\"250px\">".$row['six']."</textarea>
						        </td>
						        <td class=\"save\">
						        ".$time." <br/><br/>
						        <input type=\"button\" value=\"Update\" onclick=\"javascript:insert_report('".$number."');\" />
						        </td>
						    </tr>
						</table>
						</div>
						";
						
					}// while loop
					}// if loop
					
			$res.="</div>";
return $res;
}


function get_time($id,$selected){
$dd_time="";
if($selected==30){ $sel1="selected=selected";}else{ $sel1="";}
if($selected==60){ $sel2="selected=selected";}else{ $sel2="";}
if($selected==90){ $sel3="selected=selected";}else{ $sel3="";}
if($selected==120){ $sel4="selected=selected";}else{ $sel4="";}
if($selected==150){ $sel5="selected=selected";}else{ $sel5="";}
if($selected==180){ $sel6="selected=selected";}else{ $sel6="";}
if($selected==210){ $sel7="selected=selected";}else{ $sel7="";}
if($selected==240){ $sel8="selected=selected";}else{ $sel8="";}
if($selected==270){ $sel9="selected=selected";}else{ $sel9="";}
if($selected==300){ $sel10="selected=selected";}else{ $sel10="";}
if($selected==330){ $sel11="selected=selected";}else{ $sel11="";}
if($selected==360){ $sel12="selected=selected";}else{ $sel12="";}
if($selected==390){ $sel13="selected=selected";}else{ $sel13="";}
if($selected==420){ $sel14="selected=selected";}else{ $sel14="";}
if($selected==350){ $sel15="selected=selected";}else{ $sel15="";}
if($selected==480){ $sel16="selected=selected";}else{ $sel16="";}

$dd_time.="<select name=".$id." id=".$id." style=\"background-color:#ffffff;width:100px;\">"
."<option value=\"30\" ".$sel1.">30 mins</option>"
."<option value=\"60\" ".$sel2.">1 Hours</option>"
."<option value=\"90\" ".$sel3.">1.5 Hours</option>"
."<option value=\"120\" ".$sel4.">2 Hours</option>"
."<option value=\"150\" ".$sel5.">2.5 hours</option>"
."<option value=\"180\" ".$sel6.">3 Hours</option>"
."<option value=\"210\" ".$sel7.">3.5 Hours</option>"
."<option value=\"240\" ".$sel8.">4 Hours</option>"
."<option value=\"270\" ".$sel9.">4.5 Hours</option>"
."<option value=\"300\" ".$sel10.">5 Hours</option>"
."<option value=\"330\" ".$sel11.">5.5 Hours</option>"
."<option value=\"360\" ".$sel12.">6 Hours</option>"
."<option value=\"390\" ".$sel13.">6.5 Hours</option>"
."<option value=\"420\" ".$sel14.">7 Hours</option>"
."<option value=\"450\" ".$sel15.">7.5 Hours</option>"
."<option value=\"480\" ".$sel16.">Full day</option>"
."</select>";
return $dd_time;
}
?>
