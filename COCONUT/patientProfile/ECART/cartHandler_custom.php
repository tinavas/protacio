<?php
include("../../../myDatabase.php");
$batchNo = $_GET['batchNo'];
$registrationNo = $_GET['registrationNo'];
$username = $_GET['username'];
$room = $_GET['room'];


$ro = new database();

/*
$ro->getBatchNo();
$myFile = "/opt/lampp/htdocs/COCONUT/trackingNo/batchNo.dat";
$fh = fopen($myFile, 'r');
$batchNo = fread($fh, 100);
fclose($fh);
*/


/*
echo "
<frameset rows='25%,185%,85%' framespacing='0' border='1'>
   <frame src='cartSelection.php?registrationNo=$registrationNo&username=$username&room=$room&batchNo=$batchNo'  scrolling=no frameborder=1 framespacing=1 name='selection' />
   <frame src='#' frameborder=1 framespacing=1 name='selectedFrame' />
   <frame src='showCart_update.php?registrationNo=$registrationNo&batchNo=$batchNo&username=$username' frameborder=1 framespacing=1 />
</frameset>

";

*/
$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
if( stripos($ua,'iPad') !== false ) { //solution pra s bug ng ipad na lumalaki ung selection
echo "<iframe src='cartSelection.php?registrationNo=$registrationNo&username=$username&room=$room&batchNo=$batchNo' scrolling='no' frameborder='0' width='100%' height='40px;' >
</iframe>";

echo "<iframe src='http://".$ro->getMyUrl()."/COCONUT/availableCharges/searchCharges.php?registrationNo=$registrationNo&username=$username&room=$room&batchNo=$batchNo' name='selectedFrame' width='100%' height='400px;' style='border:1px solid #FF0000;' ></iframe>";

}else {
echo "
<iframe src='cartSelection.php?registrationNo=$registrationNo&username=$username&room=$room&batchNo=$batchNo' scrolling='no' frameborder='0' width='45%' height='10%' align='left' >
</iframe>";
echo "<Br><Br><Br>";
echo "<iframe src='http://".$ro->getMyUrl()."/COCONUT/availableCharges/searchCharges.php?registrationNo=$registrationNo&username=$username&room=$room&batchNo=$batchNo' name='selectedFrame' width='50%' height='90%' align='left' style='border:1px solid #FF0000;' ></iframe>";

}

echo "<iframe src='showCart_update.php?registrationNo=$registrationNo&batchNo=$batchNo&username=$username' align='right' frameborder=0 width='48%'></iframe>";



?>
