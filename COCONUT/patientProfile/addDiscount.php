<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Add Discount</title>
<?php
include("../../myDatabase.php");
$registrationNo = $_GET['registrationNo'];
$username = $_GET['username'];
$ro = new database();
$ro->coconutDesign();
$ro->getPatientProfile($registrationNo);
$target = "addDiscount1.php";
echo "
<form method='get' action='$target'>
<center>
<br />
<div style='border:1px solid #000000; width:500px; height:auto; border-color:black black black black;'>
<br />
<table border=0 cellpadding=0 cellspacing=0>
";
if($ro->selectNow("registeredUser","module","username",$username) == "CASHIER" || $ro->selectNow("registeredUser","module","username",$username) == "BILLING" || $ro->selectNow("registeredUser","module","username",$username) == "PHARMACY" ) {

if($ro->selectNow("registrationDetails","type","registrationNo",$registrationNo) == "IPD") {
echo "<tr>";
echo "<td>Discount Cash</td>";
echo "<td>";
$ro->coconutTextBox("discount","");
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Discount Company</td>";
echo "<td>";
$ro->coconutTextBox("companyDiscount","");
echo "</td>";
echo "</tr>";
}else {
$ro->coconutHidden("discount","");
$ro->coconutHidden("companyDiscount","");
}



echo "<Tr>";
echo "<td>Discount Type</td>";
echo "<td>";
$ro->coconutComboBoxStart_long("discountType");
$ro->showOption("discountType","discountType");
$ro->coconutComboBoxStop();
echo "</td>";
echo "</tr>";



}
else {
echo $ro->coconutHidden("discount","");
echo $ro->coconutHidden("companyDiscount","");
echo $ro->coconutHidden("discountType","");
}
echo "
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type=submit value='        Edit        ' style='border:1px solid #000000; background:#3b5998 no-repeat 4px 4px; color:white;'></td>
  </tr>
</table>
<br />
</div>
</center>
<input type='hidden' name='patientNo' value='".$ro->getRegistrationDetails_patientNo()."'>
<input type='hidden' name='registrationNo' value='$registrationNo'>
<input type='hidden' name='username' value='$username'>
</form>
";
?>
</body>
</html>