<?php
include("../../../myDatabase.php");
require_once('../../../COCONUT/authentication.php');
$username = $_GET['username'];
$switch = $_GET['switch'];
$ro = new database();

?>

<link rel="stylesheet" type="text/css" href="http://<?php echo $ro->getMyUrl(); ?>/COCONUT/myCSS/coconutCSS.css" />

<?php
 
echo "<form method='get' action='censusPatient.php'>";
echo "<input type=hidden name='username' value='$username'>";
echo "<input type=hidden name='switch' value='$switch'>";
echo "<br><br><Br><br><center><div style='border:1px solid #000000; width:500px; height:140px; border-color:black black black black;'>";

echo "<br><table border=0 cellpadding=0 cellspacing=0>";

echo "<Tr>";
echo "<td>Titles</td>";
echo "<td>";
$ro->coconutComboBoxStart_long("titles");
echo "<option></option>";
$ro->showOption_group("availableCharges","Category");
$ro->coconutComboBoxStop();
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td><font class='labelz'>From Date&nbsp;</font></td>";
echo "<td>
<select name='fromMonth' class='comboBoxShort'>  
<option value='01'>Jan</option>
<option value='02'>Feb</option>
<option value='03'>Mar</option>
<option value='04'>Apr</option>
<option value='05'>May</option>
<option value='06'>Jun</option>
<option value='07'>Jul</option>
<option value='08'>Aug</option>
<option value='09'>Sep</option>
<option value='10'>Oct</option>
<option value='11'>Nov</option>
<option value='12'>Dec</option>
</select>";
echo "&nbsp;<select name='fromDay' class='comboBoxShort'>";

for($x=1;$x<32;$x++) {
if($x<10) {
echo "<option value='0$x'>0$x</option>";
}else {
echo "<option value='$x'>$x</option>";
}
}
echo "</select>";
echo "&nbsp;<input type=text name='fromYear' class='shortField' value='".date("Y")."'>";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td><font class='labelz'>To Date&nbsp;</font></td>";
echo "<td>
<select name='toMonth' class='comboBoxShort'>  
<option value='01'>Jan</option>
<option value='02'>Feb</option>
<option value='03'>Mar</option>
<option value='04'>Apr</option>
<option value='05'>May</option>
<option value='06'>Jun</option>
<option value='07'>Jul</option>
<option value='08'>Aug</option>
<option value='09'>Sep</option>
<option value='10'>Oct</option>
<option value='11'>Nov</option>
<option value='12'>Dec</option>
</select>";
echo "&nbsp;<select name='toDay' class='comboBoxShort'>";

for($x=1;$x<32;$x++) {
if($x<10) {
echo "<option value='0$x'>0$x</option>";
}else {
echo "<option value='$x'>$x</option>";
}
}
echo "</select>";
echo "&nbsp;<input type=text name='toYear' class='shortField' value='".date("Y")."'>";
echo "</td>";
echo "</tr>";
/*
echo "<tr>";
echo "<Td><font class='labelz'>Department&nbsp;	</font></td>";
echo "<td>";
echo "<Select name='department' class='comboBox'>";
echo "<option value='LABORATORY'>LABORATORY</option>";
echo "<option value='RADIOLOGY'>RADIOLOGY<option>";
echo "</select>";
echo "</td>";
echo "</tr>";
*/
echo "</table>";
echo "<br><input type=submit value='Proceed' style='border:1px solid #000; background-color:#3b5998; color:white;' >";
echo "</div>";

echo "</form>";

?>