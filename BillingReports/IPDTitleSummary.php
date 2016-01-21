<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Transaction Summary</title>
<script type="text/JavaScript">
<!--
function placeFocus() {
if (document.forms.length > 0) {
var field = document.forms[0];
for (i = 0; i < field.length; i++) {
if ((field.elements[i].type == "text") || (field.elements[i].type == "textarea") || (field.elements[i].type.toString().charAt(0) == "s")) {
document.forms[0].elements[i].focus();
break;
         }
      }
   }
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<style type="text/css">
<!--
.arial10black {font-family: Arial;font-size: 10px;color: #000000;}
.arial10blackbold {font-family: Arial;font-size: 10px;font-weight: bold;color: #000000;}
.arial11black {font-family: Arial;font-size: 11px;color: #000000;}
.arial11blackbold {font-family: Arial;font-size: 11px;font-weight: bold;color: #000000;}
.arial12black {font-family: Arial;font-size: 12px;color: #000000;}
.arial12blackbold {font-family: Arial;font-size: 12px;font-weight: bold;color: #000000;}
.arial13black {font-family: Arial;font-size: 13px;color: #000000;}
.arial13blackbold {font-family: Arial;font-size: 13px;font-weight: bold;color: #000000;}
.arial14black {font-family: Arial;font-size: 14px;color: #000000;}
.arial14blackbold {font-family: Arial;font-size: 14px;font-weight: bold;color: #000000;}
.arial15black {font-family: Arial;font-size: 15px;color: #000000;}
.arial15blackbold {font-family: Arial;font-size: 15px;font-weight: bold;color: #000000;}
.arial16black {font-family: Arial;font-size: 16px;color: #000000;}
.arial16blackbold {font-family: Arial;font-size: 16px;font-weight: bold;color: #000000;}
.tableBottom {border-bottom: 2px solid #000000;}
.table2Top2Bottom {border-top-width: 2px;border-top-color: #000000;border-top-style: solid;border-bottom-width: 2px;border-bottom-color: #000000;border-bottom-style: solid;}
.table1Bottom1Right {border-bottom-width: 1px;border-bottom-color: #000000;border-bottom-style: solid;border-right-width: 1px;border-right-color: #000000;border-right-style: solid;}
.table1Bottom {border-bottom-width: 1px;border-bottom-color: #000000;border-bottom-style: solid;}
.table1Top2Bottom1Right {border-top-width: 1px;border-top-color: #000000;border-top-style: solid;border-bottom-width: 2px;border-bottom-color: #000000;border-bottom-style: solid;border-right-width: 1px;border-right-color: #000000;border-right-style: solid;}
.table1Top2Bottom {border-top-width: 1px;border-top-color: #000000;border-top-style: solid;border-bottom-width: 2px;border-bottom-color: #000000;border-bottom-style: solid;}
.button03 {font-family: Arial;font-size: 14px;border: 0;padding: 0;display: inline;background: none;color: #000000;}
tr:hover { background-color:yellow;color:black;}
.astyle {text-decoration: none;}
-->
</style>
</head>

<body onload="placeFocus()">
<?php
include("../myDatabase.php");
$cuz = new database();

mysql_connect($cuz->myHost(),$cuz->getUser(),$cuz->getPass());
mysql_select_db($cuz->getDB());

$username=$_POST['username'];

$fmonth=$_POST['fmonth'];
$fday=$_POST['fday'];
$fyear=$_POST['fyear'];
$tmonth=$_POST['tmonth'];
$tday=$_POST['tday'];
$tyear=$_POST['tyear'];
$title=$_POST['title'];
$ipdnum=$_POST['opdnum'];

$fdate=$fyear."-".$fmonth."-".$fday;
$fdatestr=strtotime($fdate);
$fdatefmt=date("M d, Y",$fdatestr);
$tdate=$tyear."-".$tmonth."-".$tday;
$tdatestr=strtotime($tdate);
$tdatefmt=date("M d, Y",$tdatestr);

echo "
<div align='center'>
<img src='../../COCONUT/myImages/ProtacioHeader.png' width='100%' height='auto' />
<br />
<br />
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td height='30'><div align='left' class='arial15blackbold'>OPD ".$title." SUMMARY</div></td>
  </tr>
  <tr>
    <td height='30'><div align='left' class='arial14blackbold'>From $fdatefmt To $tdatefmt</div></td>
  </tr>
  <tr>
    <td bgcolor='#FFFFFF'><table border='0' cellpadding='0' cellspacing='0'>
      <tr>
        <td width='auto' class='table2Top2Bottom'><div align='center' class='arial12blackbold'>&nbsp;Patient&nbsp;</div></td>
        <td width='200' class='table2Top2Bottom'><div align='center' class='arial12blackbold'>&nbsp;Transaction Date&nbsp;</div></td>
        <td width='200' class='table2Top2Bottom'><div align='center' class='arial12blackbold'>&nbsp;Amount&nbsp;</div></td>
      </tr>
";

$creditqsp=0;
$totcdiscount=0;
$totctotal=0;
$othertot=0;
$totalall=0;
for($c=1;$c<=$ipdnum;$c++){//For C
$rnipc="rip".$c;

$selectrdc=$_POST[$rnipc];

if($selectrdc!=""){//If C

$csql=mysql_query("SELECT SUM(sellingPrice*quantity) AS creditqsp, SUM(pc.discount) AS totcdiscount, SUM(pc.total) AS totctotal, SUM(pc.discount+pc.cashUnpaid+pc.cashPaid+pc.cashPaidFromBalance+pc.phic+pc.company+pc.amountPaidFromCreditCard) AS othertot FROM patientCharges pc, registrationDetails rd WHERE pc.registrationNo=rd.registrationNo AND rd.type='IPD' AND pc.status NOT LIKE 'DELETED_%%%%' AND pc.title='$title' AND rd.registrationNo='$selectrdc' ORDER BY pc.dateCharge,pc.timeCharge");
//$csql=mysql_query("SELECT pc.sellingPrice, pc.quantity, pc.discount, pc.total, pc.discount, pc.cashUnpaid, pc.cashPaid, pc.cashPaidFromBalance, pc.phic, pc.company, pc.amountPaidFromCreditCard FROM patientCharges pc, registrationDetails rd WHERE pc.registrationNo=rd.registrationNo AND rd.type='OPD' AND pc.status NOT LIKE 'DELETED_%%%%' AND pc.title='$title'  AND rd.registrationNo='$selectrdc' ORDER BY pc.dateCharge,pc.timeCharge");
while($cfetch=mysql_fetch_array($csql)){
$totcdiscount=$cfetch['totcdiscount'];
$totctotal=$cfetch['totctotal'];
$othertot=$cfetch['othertot'];
$creditqsp=$cfetch['creditqsp'];

$totalall+=$creditqsp;

if($creditqsp>0){

$patientNo=$cuz->selectNow("registrationDetails","patientNo","registrationNo",$selectrdc);
$lastName=$cuz->selectNow("patientRecord","lastName","patientNo",$patientNo);
$firstName=$cuz->selectNow("patientRecord","firstName","patientNo",$patientNo);
$middleName=$cuz->selectNow("patientRecord","middleName","patientNo",$patientNo);

$dateRegistered=$cuz->selectNow("registrationDetails","dateRegistered","registrationNo",$selectrdc);

$name=$lastName.", ".$firstName." ".$middleName;

echo "
      <tr>
        <form name='Submit' method='post' action='../COCONUT/currentPatient/patientInterface1.php' target='_blank'>
        <input type='hidden' name='username' value='$username' />
        <input type='hidden' name='registrationNo' value='$selectrdc' />
        <td class='table1Bottom1Right'><div align='left'><input type='submit' name='Submit' class='button03' value='".strtoupper($name)."' /></div></td>
        </form>
        <td class='table1Bottom1Right'><div align='center' class='arial14black'>&nbsp;".date("M d, Y",strtotime($dateRegistered))."&nbsp;</div></td>
        <td class='table1Bottom'><a href='../COCONUT/patientProfile/SOAoption/newSOA/newDetailed.php?registrationNo=$selectrdc&username=$username&show=try' class='astyle' target='_blank'><div align='right' class='arial14black'>&nbsp;".number_format($creditqsp,2)."&nbsp;</div></a></td>
      </tr>
";
}

}

}//If C
}//For C



echo "
      <tr>
        <td class='table1Top2Bottom1Right' colspan='2'><div align='right' class='arial14blackbold'>&nbsp;TOTAL&nbsp;</div></td>
        <td class='table1Top2Bottom'><div align='right' class='arial14blackbold'>&nbsp;".number_format($totalall,2)."&nbsp;</div></td>
      </tr>
    </table></td>
  </tr>
</table>
</div>
";
?>
</body>
</html>
