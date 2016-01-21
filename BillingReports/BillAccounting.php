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
.style1 {font-family: Arial;font-size: 16px;color: #000000;font-weight: bold;}
.style2 {font-family: "Times New Roman";font-size: 16px;color: #FF0000;font-weight: bold;}
.style3 {font-family: Arial;font-size: 14px;color: #000000;font-weight: bold;}
.style4 {font-family: Arial;font-size: 12px;color: #000000;font-weight: bold;}
.style5 {font-family: Arial;font-size: 14px;color: #000000;}
.style6 {font-family: Arial;font-size: 14px;color: #0066FF;}
.style7 {font-family: Arial;font-size: 14px;color: #FF0000;}
.style8 {font-family: Arial;font-size: 12px;color: #FFFFFF;font-weight: bold;}
.tableBottom {border-bottom: 2px solid #000000;}
.tableTop {border-top: 2px solid #000000;}
.tableTopBottom {border-top: 2px solid #000000;border-bottom: 2px solid #000000;}
.tableBottomSides {border-bottom: 2px solid #000000;border-left: 1px solid #000000;border-right: 1px solid #000000;}
.tableBottomLeftSides {border-bottom: 2px solid #000000;border-left: 2px solid #000000;border-right: 1px solid #000000;}
.tableBottomRightSides {border-bottom: 2px solid #000000;border-left: 1px solid #000000;border-right: 2px solid #000000;}
.tableTopSides {border-top: 2px solid #000000;border-left: 1px solid #000000;border-right: 1px solid #000000;}
.tableTopLeftSides {border-top: 2px solid #000000;border-left: 2px solid #000000;border-right: 1px solid #000000;}
.tableTopRightSides {border-top: 2px solid #000000;border-left: 1px solid #000000;border-right: 2px solid #000000;}
.tableTopBottomSides {border-top: 2px solid #000000;border-bottom: 2px solid #000000;border-left: 1px solid #000000;border-right: 1px solid #000000;}
.tableTopBottomLeftSides {border-top: 2px solid #000000;border-bottom: 2px solid #000000;border-left: 2px solid #000000;border-right: 1px solid #000000;}
.tableTopBottomRightSides {border-top: 2px solid #000000;border-bottom: 2px solid #000000;border-left: 1px solid #000000;border-right: 2px solid #000000;}
.tableSides {border-left: 1px solid #000000;border-right: 1px solid #000000;}
.tableSidesLeft {border-left: 2px solid #000000;border-right: 1px solid #000000;}
.tableSidesRight {border-left: 1px solid #000000;border-right: 2px solid #000000;}
.astyle {text-decoration: none;}
.buttonnodecor {font-family: Arial;font-size: 14px;border: 0;padding: 0;display: inline;background: none;color: #000000;}
tr:hover { background-color:yellow;color:black;}
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

$opdnum=$_POST['opdnum'];
$ipdnum=$_POST['ipdnum'];

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
    <td height='30' bgcolor='#FFFFFF'><div align='left' class='style3'>Transaction Summary</div></td>
  </tr>
  <tr>
    <td height='30' bgcolor='#FFFFFF'><div align='left' class='style3'>From $fdatefmt To $tdatefmt</div></td>
  </tr>
  <tr>
    <td bgcolor='#FFFFFF'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
      <tr>
";

//OUT-PATIENT

echo "
        <td width='46%' valign='top' bgcolor='#FFFFFF'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
          <tr>
            <td width='auto' colspan='3'><div align='left' class='style1'>OPD</div></td>
          </tr>
";

$totcashPaid=0;
$totphic=0;
$totcompany=0;
$totcashUnpaid=0;
$totdiscount=0;
$totqsp=0;
$totcashPaidFromBalance=0;
$totbalance=0;
$finaltotal=0;
$totamountPaidFromCreditCard=0;

for($a=1;$a<=$opdnum;$a++){//For A
//$asql=mysql_query("SELECT rd.registrationNo, rd.type, rd.discount AS disc, pc.itemNo, pc.sellingPrice, pc.quantity, pc.discount, pc.total, pc.cashUnpaid, pc.phic, pc.company, pc.cashPaid, pc.cashPaidFromBalance, pc.dateCharge, pc.amountPaidFromCreditCard, pc.orNo FROM patientCharges pc, registrationDetails rd WHERE pc.registrationNo=rd.registrationNo AND rd.type='OPD' AND pc.status NOT LIKE 'DELETED_%%%%' AND pc.title NOT LIKE 'PROFESSIONAL FEE' AND (pc.dateCharge BETWEEN '$fdate' AND '$tdate') ORDER BY pc.dateCharge,pc.timeCharge");

$rnopa="rop".$a;

$selectrda=$_POST[$rnopa];

if($selectrda!=""){

$asql=mysql_query("SELECT rd.registrationNo, rd.type, rd.discount AS disc, pc.itemNo, pc.sellingPrice, pc.quantity, pc.discount, pc.total, pc.cashUnpaid, pc.phic, pc.company, pc.cashPaid, pc.cashPaidFromBalance, pc.dateCharge, pc.amountPaidFromCreditCard, pc.orNo FROM patientCharges pc, registrationDetails rd WHERE pc.registrationNo=rd.registrationNo AND rd.type='OPD' AND pc.status NOT LIKE 'DELETED_%%%%' AND pc.title NOT LIKE 'PROFESSIONAL FEE' AND rd.registrationNo='$selectrda' ORDER BY pc.dateCharge,pc.timeCharge");
while($afetch=mysql_fetch_array($asql)){
$quantity=$afetch['quantity'];
$sellingPrice=$afetch['sellingPrice'];
$itemNo=$afetch['itemNo'];
$discount=$afetch['discount'];
$total=$afetch['total'];
$cashUnpaid=$afetch['cashUnpaid'];
$phic=$afetch['phic'];
$company=$afetch['company'];
$cashPaid=$afetch['cashPaid'];
$cashPaidFromBalance=$afetch['cashPaidFromBalance'];
$registrationNo=$afetch['registrationNo'];
$dateCharge=$afetch['dateCharge'];
$amountPaidFromCreditCard=$afetch['amountPaidFromCreditCard'];
$orNo=$afetch['orNo'];

$totdiscount+=$discount;
$finaltotal+=$total;
$totcashUnpaid+=$cashUnpaid;
$totphic+=$phic;
$totcompany+=$company;
$totcashPaid+=($cashPaid+$cashPaidFromBalance);
$totcashPaidFromBalance+=$cashPaidFromBalance;
$totamountPaidFromCreditCard+=$amountPaidFromCreditCard;

if($cashPaidFromBalance==''){$truecashPaidFromBalance=0;}else{$truecashPaidFromBalance=$cashPaidFromBalance;}
$qsp=$quantity*$sellingPrice;
$tot=$discount+$cashUnpaid+$phic+$company+$cashPaid+$cashPaidFromBalance+$amountPaidFromCreditCard;

if($qsp==$tot){$balance=0;}else{$balance=$qsp-$tot;}

if($balance!=0){
//echo $registrationNo."-".$itemNo."-($qsp)-($tot)=".number_format($balance,2)." | OR No: $orNo | $dateCharge"."<br />";
$totbalance+=$balance;
}
else{
$totbalance+=0;
}

}

}//If A
}//For A

$pfdiscount=0;
$pfcashUnpaid=0;
$pfphic=0;
$pfcompany=0;
$pfcashPaid=0;
$totPF=0;
$error=0;
$pfcash=0;
$pfamountPaidFromCreditCard=0;

for($b=1;$b<=$opdnum;$b++){//For B
//$bsql=mysql_query("SELECT rd.registrationNo, rd.type, rd.discount AS disc, pc.itemNo, pc.sellingPrice, pc.quantity, pc.discount, pc.total, pc.cashUnpaid, pc.phic, pc.company, pc.cashPaid, pc.dateCharge, pc.amountPaidFromCreditCard, pc.orNo, pc.doctorsPF FROM patientCharges pc, registrationDetails rd WHERE pc.registrationNo=rd.registrationNo AND rd.type='OPD' AND pc.status NOT LIKE 'DELETED_%%%%' AND pc.title='PROFESSIONAL FEE' AND (pc.dateCharge BETWEEN '$fdate' AND '$tdate') ORDER BY pc.dateCharge,pc.timeCharge");

$rnopb="rop".$b;

$selectrdb=$_POST[$rnopb];

if($selectrdb!=""){
$bsql=mysql_query("SELECT rd.registrationNo, rd.type, rd.discount AS disc, pc.itemNo, pc.sellingPrice, pc.quantity, pc.discount, pc.total, pc.cashUnpaid, pc.phic, pc.company, pc.cashPaid, pc.dateCharge, pc.amountPaidFromCreditCard, pc.orNo, pc.doctorsPF FROM patientCharges pc, registrationDetails rd WHERE pc.registrationNo=rd.registrationNo AND rd.type='OPD' AND pc.status NOT LIKE 'DELETED_%%%%' AND pc.title='PROFESSIONAL FEE' AND rd.registrationNo='$selectrdb' ORDER BY pc.dateCharge,pc.timeCharge");
while($bfetch=mysql_fetch_array($bsql)){
$bquantity=$bfetch['quantity'];
$bsellingPrice=$bfetch['sellingPrice'];
$bitemNo=$bfetch['itemNo'];
$bdiscount=$bfetch['discount'];
$btotal=$bfetch['total'];
$bcashUnpaid=$bfetch['cashUnpaid'];
$bphic=$bfetch['phic'];
$bcompany=$bfetch['company'];
$bcashPaid=$bfetch['cashPaid'];
$bregistrationNo=$bfetch['registrationNo'];
$bdateCharge=$bfetch['dateCharge'];
$bamountPaidFromCreditCard=$bfetch['amountPaidFromCreditCard'];
$bdoctorsPF=$bfetch['doctorsPF'];
$bitemNo=$bfetch['itemNo'];

$truesp=preg_split('[/]',$bsellingPrice);

$pfdiscount+=$bdiscount;
$pfcashUnpaid+=$bcashUnpaid;
$pfphic+=$bphic;
$pfcompany+=$bcompany;
$pfcash+=$bcashPaid;
$pfamountPaidFromCreditCard+=$bamountPaidFromCreditCard;

$pfAll=$bcashPaid+$bamountPaidFromCreditCard;
$pfcashPaid+=$pfAll;

if($bdoctorsPF==''){$truebdoctorsPF=0;}else{$truebdoctorsPF=$bdoctorsPF;}
if($bamountPaidFromCreditCard==''){$truebamountPaidFromCreditCard=0;}else{$truebamountPaidFromCreditCard=$bamountPaidFromCreditCard;}

$totspmdpf=($truesp[0])-$truebdoctorsPF;
$totPF+=$totspmdpf;
$errorst=($totspmdpf-($bdiscount+$bcashUnpaid+$bphic+$bcompany+$bcashPaid+$truebamountPaidFromCreditCard));
$error+=$errorst;

//if($errorst!=0){
//echo "$bitemNo | $errorst = ((".$truesp[0]."-$truebdoctorsPF)-($bdiscount+$bcashUnpaid+$bphic+$bcompany+$bcashPaid+$truebamountPaidFromCreditCard))<br>";
//}

}

}
}//For B

if(($totamountPaidFromCreditCard+$pfamountPaidFromCreditCard)!=0){
echo "
          <tr>
            <form name='title' method='post' action='OPDCreditCardSummary.php' target='_blank'>
            <input type='hidden' name='username' value='$username' />
            <input type='hidden' name='fyear' value='$fyear' />
            <input type='hidden' name='fmonth' value='$fmonth' />
            <input type='hidden' name='fday' value='$fday' />
            <input type='hidden' name='tyear' value='$tyear' />
            <input type='hidden' name='tmonth' value='$tmonth' />
            <input type='hidden' name='tday' value='$tday' />
            <input type='hidden' name='opdnum' value='$opdnum' />
";

for($opcc=1;$opcc<=$opdnum;$opcc++){
$rnopccsel="rop".$opcc;
$rnopcc=$_POST[$rnopccsel];

echo "
            <input type='hidden' name='$rnopccsel' value='$rnopcc' />
";
}

echo "
            <td width='auto'><div align='left' class='style5'><input type='submit' class='buttonnodecor' name='show' value='CREDIT CARD' /></div></a></td>
            </form>
            <td width='auto'><div align='right' class='style5'>".number_format(($totamountPaidFromCreditCard+$pfamountPaidFromCreditCard),2,'.',',')."</div></td>
            <td width='auto'><div align='right' class='style5'></div></td>
          </tr>
";
}

if(($totcashPaid+$pfcash)!=0){
echo "
          <tr>
            <form name='title' method='post' action='OPDCashSummary.php' target='_blank'>
            <input type='hidden' name='username' value='$username' />
            <input type='hidden' name='fyear' value='$fyear' />
            <input type='hidden' name='fmonth' value='$fmonth' />
            <input type='hidden' name='fday' value='$fday' />
            <input type='hidden' name='tyear' value='$tyear' />
            <input type='hidden' name='tmonth' value='$tmonth' />
            <input type='hidden' name='tday' value='$tday' />
            <input type='hidden' name='opdnum' value='$opdnum' />
";

for($opca=1;$opca<=$opdnum;$opca++){
$rnopcasel="rop".$opca;
$rnopca=$_POST[$rnopcasel];

echo "
            <input type='hidden' name='$rnopcasel' value='$rnopca' />
";
}

echo "
            <td width='auto'><div align='left' class='style5'><input type='submit' class='buttonnodecor' name='show' value='CASH' /></div></td>
            </form>
            <td width='auto'><div align='right' class='style5'>".number_format(($totcashPaid+$pfcash),2,'.',',')."</div></a></td>
            <td width='auto'><div align='ight' class='style5'></div></td>
          </tr>
";
}

if(($totphic+$pfphic)!=0){
echo "
          <tr>
            <form name='title' method='post' action='OPDARHMOSummary.php' target='_blank'>
            <input type='hidden' name='username' value='$username' />
            <input type='hidden' name='fyear' value='$fyear' />
            <input type='hidden' name='fmonth' value='$fmonth' />
            <input type='hidden' name='fday' value='$fday' />
            <input type='hidden' name='tyear' value='$tyear' />
            <input type='hidden' name='tmonth' value='$tmonth' />
            <input type='hidden' name='tday' value='$tday' />
            <input type='hidden' name='opdnum' value='$opdnum' />
";

for($opap=1;$opap<=$opdnum;$opap++){
$rnopapsel="rop".$opap;
$rnopap=$_POST[$rnopapsel];

echo "
            <input type='hidden' name='$rnopapsel' value='$rnopap' />
";
}

echo "
            <td width='auto'><div align='left'><input type='submit' class='buttonnodecor' name='show' value='A/R - PHIC' /></div></td>
            </form>
            <td width='auto'><div align='right' class='style5'>".number_format(($totphic+$pfphic),2,'.',',')."</div></td>
            <td width='auto'><div align='right' class='style5'></div></td>
          </tr>
";
}

if(($totcompany+$pfcompany)!=0){
echo "
          <tr>
            <form name='title' method='post' action='OPDARHMOSummary.php' target='_blank'>
            <input type='hidden' name='username' value='$username' />
            <input type='hidden' name='fyear' value='$fyear' />
            <input type='hidden' name='fmonth' value='$fmonth' />
            <input type='hidden' name='fday' value='$fday' />
            <input type='hidden' name='tyear' value='$tyear' />
            <input type='hidden' name='tmonth' value='$tmonth' />
            <input type='hidden' name='tday' value='$tday' />
            <input type='hidden' name='opdnum' value='$opdnum' />
";

for($opah=1;$opah<=$opdnum;$opah++){
$rnopahsel="rop".$opah;
$rnopah=$_POST[$rnopahsel];

echo "
            <input type='hidden' name='$rnopahsel' value='$rnopah' />
";
}

echo "
            <td width='auto'><div align='left' class='style5'><input type='submit' class='buttonnodecor' name='show' value='A/R - HMO/COMPANY' /></div></td>
            </form>
            <td width='auto'><div align='right' class='style5'>".number_format(($totcompany+$pfcompany),2,'.',',')."</div></a></td>
            <td width='auto'><div align='right' class='style5'></div></td>
          </tr>
";
}

if((($totdiscount+$pfdiscount)+($totbalance+$error))!=0){
echo "
          <tr>
            <form name='title' method='post' action='OPDRevenueDiscSummary.php' target='_blank'>
            <input type='hidden' name='username' value='$username' />
            <input type='hidden' name='fyear' value='$fyear' />
            <input type='hidden' name='fmonth' value='$fmonth' />
            <input type='hidden' name='fday' value='$fday' />
            <input type='hidden' name='tyear' value='$tyear' />
            <input type='hidden' name='tmonth' value='$tmonth' />
            <input type='hidden' name='tday' value='$tday' />
            <input type='hidden' name='opdnum' value='$opdnum' />
";

for($oprd=1;$oprd<=$opdnum;$oprd++){
$rnoprdsel="rop".$oprd;
$rnoprd=$_POST[$rnoprdsel];

echo "
            <input type='hidden' name='$rnoprdsel' value='$rnoprd' />
";
}

echo "
            <td width='auto'><div align='left'><input type='submit' class='buttonnodecor' name='show' value='REVENUE DISCOUNT' /></div></td>
            </form>
            <td width='auto'><div align='right' class='style5'>".number_format((($totdiscount+$pfdiscount)+($totbalance+$error)),2,'.',',')."</div></td>
            <td width='auto'><div align='right' class='style5'></div></td>
          </tr>
";
}

if(($totcashUnpaid+$pfcashUnpaid)!=0){
echo "
          <tr>
            <form name='title' method='post' action='OPDARPatientSummary.php' target='_blank'>
            <input type='hidden' name='username' value='$username' />
            <input type='hidden' name='fyear' value='$fyear' />
            <input type='hidden' name='fmonth' value='$fmonth' />
            <input type='hidden' name='fday' value='$fday' />
            <input type='hidden' name='tyear' value='$tyear' />
            <input type='hidden' name='tmonth' value='$tmonth' />
            <input type='hidden' name='tday' value='$tday' />
            <input type='hidden' name='opdnum' value='$opdnum' />
";

for($opapt=1;$opapt<=$opdnum;$opapt++){
$rnopaptsel="rop".$opapt;
$rnopapt=$_POST[$rnopaptsel];

echo "
            <input type='hidden' name='$rnopaptsel' value='$rnopapt' />
";
}

echo "
            <td width='auto'><div align='left'><input type='submit' class='buttonnodecor' name='show' value='A/R - PATIENT' /></div></td>
            </form>
            <td width='auto'><div align='right' class='style5'>".number_format(($totcashUnpaid+$pfcashUnpaid),2,'.',',')."</div></td>
            <td width='auto'><div align='right' class='style5'></div></td>
          </tr>
";
}

/*if(($totbalance+$error)!=0){
echo "
          <tr>
            <td width='auto'><div align='left' class='style5'>?????</div></td>
            <td width='auto'><div align='right' class='style5'>".number_format(($totbalance+$error),2,'.',',')."</div></td>
            <td width='auto'><div align='right' class='style5'></div></td>
          </tr>
";
}*/

if($totPF!=0){
echo "
          <tr>
            <form name='title' method='post' action='OPDClinicRevSummary.php' target='_blank'>
            <input type='hidden' name='username' value='$username' />
            <input type='hidden' name='fyear' value='$fyear' />
            <input type='hidden' name='fmonth' value='$fmonth' />
            <input type='hidden' name='fday' value='$fday' />
            <input type='hidden' name='tyear' value='$tyear' />
            <input type='hidden' name='tmonth' value='$tmonth' />
            <input type='hidden' name='tday' value='$tday' />
            <input type='hidden' name='opdnum' value='$opdnum' />
";

for($opcv=1;$opcv<=$opdnum;$opcv++){
$rnopcvsel="rop".$opcv;
$rnopcv=$_POST[$rnopcvsel];

echo "
            <input type='hidden' name='$rnopcvsel' value='$rnopcv' />
";
}

echo "
            <td width='auto'><div align='left'><input type='submit' class='buttonnodecor' name='show' value='CLINIC REVENUE' /></div></a></td>
            </form>
            <td width='auto'><div align='right' class='style5'></div></td>
            <td width='auto'><div align='right' class='style5'>".number_format($totPF,2,'.',',')."</div></td>
          </tr>
";
}

$totcredit=0;
$xsql=mysql_query("SELECT pc.title FROM patientCharges pc, registrationDetails rd WHERE pc.registrationNo=rd.registrationNo AND rd.type='OPD' AND pc.status NOT LIKE 'DELETED_%%%%' AND pc.title NOT LIKE 'PROFESSIONAL FEE' AND (rd.dateRegistered BETWEEN '$fdate' AND '$tdate') GROUP BY pc.title ORDER BY pc.title");

while($xfetch=mysql_fetch_array($xsql)){
$xtitle=$xfetch['title'];

//$csql=mysql_query("SELECT SUM(sellingPrice*quantity) AS creditqsp, SUM(pc.discount) AS totcdiscount, SUM(pc.total) AS totctotal, SUM(pc.discount+pc.cashUnpaid+pc.cashPaid+pc.cashPaidFromBalance+pc.phic+pc.company+pc.amountPaidFromCreditCard) AS othertot FROM patientCharges pc, registrationDetails rd WHERE pc.registrationNo=rd.registrationNo AND rd.type='OPD' AND pc.status NOT LIKE 'DELETED_%%%%' AND pc.title='$xtitle' AND (pc.dateCharge BETWEEN '$fdate' AND '$tdate') ORDER BY pc.dateCharge,pc.timeCharge");
$creditqsp=0;
$totcdiscount=0;
$totctotal=0;
$othertot=0;

for($c=1;$c<=$opdnum;$c++){//For C
$rnopc="rop".$c;

$selectrdc=$_POST[$rnopc];

if($selectrdc!=""){//If C
$csql=mysql_query("SELECT pc.sellingPrice, pc.quantity, pc.discount, pc.total, pc.discount, pc.cashUnpaid, pc.cashPaid, pc.cashPaidFromBalance, pc.phic, pc.company, pc.amountPaidFromCreditCard FROM patientCharges pc, registrationDetails rd WHERE pc.registrationNo=rd.registrationNo AND rd.type='OPD' AND pc.status NOT LIKE 'DELETED_%%%%' AND pc.title='$xtitle'  AND rd.registrationNo='$selectrdc' ORDER BY pc.dateCharge,pc.timeCharge");
while($cfetch=mysql_fetch_array($csql)){
$totcdiscount+=$cfetch['discount'];
$totctotal+=$cfetch['total'];
$othertot+=($cfetch['discount']+$cfetch['cashUnpaid']+$cfetch['cashPaid']+$cfetch['cashPaidFromBalance']+$cfetch['phic']+$cfetch['company']+$cfetch['amountPaidFromCreditCard']);
$creditqsp+=($cfetch['sellingPrice']*$cfetch['quantity']);
}

}//If C
}//For C

$credit=$totcdiscount+$totctotal;
$totcredit+=$creditqsp;

if($creditqsp>0){
echo "
          <tr>
            <form name='title' method='post' action='OPDTitleSummary.php' target='_blank'>
            <input type='hidden' name='username' value='$username' />
            <input type='hidden' name='fyear' value='$fyear' />
            <input type='hidden' name='fmonth' value='$fmonth' />
            <input type='hidden' name='fday' value='$fday' />
            <input type='hidden' name='tyear' value='$tyear' />
            <input type='hidden' name='tmonth' value='$tmonth' />
            <input type='hidden' name='tday' value='$tday' />
            <input type='hidden' name='title' value='$xtitle' />
            <input type='hidden' name='opdnum' value='$opdnum' />
";

for($opt=1;$opt<=$opdnum;$opt++){
$rnoptsel="rop".$opt;
$rnopt=$_POST[$rnoptsel];

echo "
            <input type='hidden' name='$rnoptsel' value='$rnopt' />
";
}

echo "
            <td width='auto'><div align='left'><input type='submit' name='show' class='buttonnodecor' value='".strtoupper($xtitle)."' /></div></td>
            </form>
            <td width='auto'><div align='right' class='style5'></div></td>
            <td width='auto'><div align='right' class='style5'>".number_format($creditqsp,2,'.',',')."</div></td>
          </tr>
";
}
}




$totaldebit=$totdiscount+$totcompany+$totcashPaid+$totamountPaidFromCreditCard+$totphic+$totcashUnpaid+$totbalance+$pfdiscount+$pfcashUnpaid+$pfphic+$pfcompany+$pfcash+$pfamountPaidFromCreditCard+$error;
$totalcredit=$totcredit+$totPF;

echo "
          <tr>
            <td width='auto'><div align='left' class='style3'>TOTAL</div></td>
            <td width='auto'><div align='right' class='style3'>".number_format($totaldebit,2,'.',',')."</div></td>
            <td width='auto'><div align='right' class='style3'>".number_format($totalcredit,2,'.',',')."</div></td>
          </tr>
        </table></td>
        <td width='8%' bgcolor='#FFFFFF'></td>

";

//IN-PATIENT

echo "
        <td width='46%' valign='top' bgcolor='#FFFFFF'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
          <tr>
            <td width='auto' colspan='3'><div align='left' class='style1'>IPD</div></td>
          </tr>
";

$finalzamountPaidCashhb=0;
$finalzamountPaidCredithb=0;
$finalzamountPaidCashd=0;
$finalzamountPaidCreditd=0;
$finalztotgendisc=0;
$finalztotgencomdisc=0;
$dtotcashPaid=0;
$dtotphic=0;
$dtotcompany=0;
$dtotcashUnpaid=0;
$dtotdiscount=0;
$dtotqsp=0;
$dtotcashPaidFromBalance=0;
$dtotbalance=0;
$dfinaltotal=0;
$dtotamountPaidFromCreditCard=0;

$azamountPaidCashhb=0;
$azamountPaidCredithb=0;
$azamountPaidCashd=0;
$azamountPaidCreditd=0;

$zpaidDeposit=0;

for($d=1;$d<=$ipdnum;$d++){

$rnipd="rip".$d;

$selectrdd=$_POST[$rnipd];

if($selectrdd!=""){

//$dsql=mysql_query("SELECT rd.registrationNo, rd.type, rd.discount AS disc, pc.itemNo, pc.sellingPrice, pc.quantity, pc.discount, pc.total, pc.cashUnpaid, pc.phic, pc.company, pc.cashPaid, pc.cashPaidFromBalance, pc.dateCharge, pc.amountPaidFromCreditCard, pc.orNo FROM patientCharges pc, registrationDetails rd WHERE pc.registrationNo=rd.registrationNo AND rd.type='IPD' AND pc.status NOT LIKE 'DELETED_%%%%' AND pc.title NOT LIKE 'PROFESSIONAL FEE' AND (pc.dateCharge BETWEEN '$fdate' AND '$tdate') ORDER BY pc.dateCharge,pc.timeCharge");

$dsql=mysql_query("SELECT rd.registrationNo, rd.type, rd.discount AS disc, pc.itemNo, pc.sellingPrice, pc.quantity, pc.discount, pc.total, pc.cashUnpaid, pc.phic, pc.company, pc.cashPaid, pc.cashPaidFromBalance, pc.dateCharge, pc.amountPaidFromCreditCard, pc.orNo FROM patientCharges pc, registrationDetails rd WHERE pc.registrationNo=rd.registrationNo AND rd.type='IPD' AND pc.status NOT LIKE 'DELETED_%%%%' AND pc.title NOT LIKE 'PROFESSIONAL FEE' AND rd.registrationNo='$selectrdd' ORDER BY pc.dateCharge,pc.timeCharge");
while($dfetch=mysql_fetch_array($dsql)){
$dquantity=$dfetch['quantity'];
$dsellingPrice=$dfetch['sellingPrice'];
$ditemNo=$dfetch['itemNo'];
$ddiscount=$dfetch['discount'];
$dtotal=$dfetch['total'];
$dcashUnpaid=$dfetch['cashUnpaid'];
$dphic=$dfetch['phic'];
$dcompany=$dfetch['company'];
$dcashPaid=$dfetch['cashPaid'];
$dcashPaidFromBalance=$dfetch['cashPaidFromBalance'];
$dregistrationNo=$dfetch['registrationNo'];
$ddateCharge=$dfetch['dateCharge'];
$damountPaidFromCreditCard=$dfetch['amountPaidFromCreditCard'];
$dorNo=$dfetch['orNo'];

$dtotdiscount+=$ddiscount;
$dfinaltotal+=$dtotal;
$dtotcashUnpaid+=$dcashUnpaid;
$dtotphic+=$dphic;
$dtotcompany+=$dcompany;
$dtotcashPaid+=($dcashPaid+$dcashPaidFromBalance);
$dtotcashPaidFromBalance+=$dcashPaidFromBalance;
$dtotamountPaidFromCreditCard+=$damountPaidFromCreditCard;

if($dcashPaidFromBalance==''){$dtruecashPaidFromBalance=0;}else{$dtruecashPaidFromBalance=$dcashPaidFromBalance;}
$dqsp=$dquantity*$dsellingPrice;
$dtot=$ddiscount+$dcashUnpaid+$dphic+$dcompany+$dcashPaid+$dcashPaidFromBalance+$damountPaidFromCreditCard;

if($dqsp==$dtot){$dbalance=0;}else{$dbalance=$dqsp-$dtot;}

if($dbalance!=0){
$dtotbalance+=$dbalance;
}
else{
$dtotbalance+=0;
}

}

//PAYMENT---------------------------------------------------------------
$zamountPaidCashhb=0;
$zamountPaidCredithb=0;
$zamountPaidCashd=0;
$zamountPaidCreditd=0;
$zsql=mysql_query("SELECT amountPaid, paidVia, paymentFor FROM patientPayment WHERE registrationNo='$selectrdd'");
$zcount=mysql_num_rows($zsql);

if($zcount==0){
$zamountPaidCashd+=0;
$zamountPaidCreditd+=0;
}
else{
while($zfetch=mysql_fetch_array($zsql)){
$amountPaid=$zfetch['amountPaid'];
$paidVia=$zfetch['paidVia'];
$paymentFor=$zfetch['paymentFor'];

//echo $amountPaid." | ".$paidVia."<br>";
if($paymentFor=='DEPOSIT'){
if($paidVia=='Cash'){$zamountPaidCashd+=$amountPaid;}
if($paidVia=='Credit Card'){$zamountPaidCreditd+=$amountPaid;}
}
else{
if($paidVia=='Cash'){$zamountPaidCashhb+=$amountPaid;}
if($paidVia=='Credit Card'){$zamountPaidCredithb+=$amountPaid;}
}
}
}

$azamountPaidCashhb+=$zamountPaidCashhb;
$azamountPaidCredithb+=$zamountPaidCredithb;
$azamountPaidCashd+=$zamountPaidCashd;
$azamountPaidCreditd+=$zamountPaidCreditd;
//PAYMENT---------------------------------------------------------------


//General Discount---------------------------------------------------------------
$totgendisc=0;
$totgencomdisc=0;
$zbsql=mysql_query("SELECT discount, companyDiscount FROM registrationDetails WHERE registrationNo='$selectrdd'");
$zbcount=mysql_num_rows($zbsql);

if($zbcount>0){
while($zbfetch=mysql_fetch_array($zbsql)){
$gendisc=$zbfetch['discount'];
$gencomdisc=$zbfetch['companyDiscount'];

if(!is_numeric($gendisc)){$truegendisc=0;}else{$truegendisc=$gendisc;}
if(!is_numeric($gencomdisc)){$truegencomdisc=0;}else{$truegencomdisc=$gencomdisc;}

$totgendisc+=$truegendisc;
$totgencomdisc+=$truegencomdisc;
}
}
$finalztotgendisc+=$totgendisc;
$finalztotgencomdisc+=$totgencomdisc;
//General Discount---------------------------------------------------------------

}//If D


}//For D

$finalzamountPaidCashhb=$azamountPaidCashhb;
$finalzamountPaidCredithb=$azamountPaidCredithb;
$finalzamountPaidCashd=$azamountPaidCashd;
$finalzamountPaidCreditd=$azamountPaidCreditd;

$epfdiscount=0;
$epfcashUnpaid=0;
$epfphic=0;
$epfcompany=0;
$epfcashPaid=0;
$etotPF=0;
$eerror=0;
$epfcash=0;
$epfamountPaidFromCreditCard=0;

for($e=1;$e<=$ipdnum;$e++){//For E

$rnipe="rip".$e;

$selectrde=$_POST[$rnipe];

if($selectrde!=""){//If E

//$esql=mysql_query("SELECT rd.registrationNo, rd.type, rd.discount AS disc, pc.itemNo, pc.sellingPrice, pc.quantity, pc.discount, pc.total, pc.cashUnpaid, pc.phic, pc.company, pc.cashPaid, pc.dateCharge, pc.amountPaidFromCreditCard, pc.orNo, pc.doctorsPF FROM patientCharges pc, registrationDetails rd WHERE pc.registrationNo=rd.registrationNo AND rd.type='IPD' AND pc.status NOT LIKE 'DELETED_%%%%' AND pc.title='PROFESSIONAL FEE' AND (pc.dateCharge BETWEEN '$fdate' AND '$tdate') ORDER BY pc.dateCharge,pc.timeCharge");

$esql=mysql_query("SELECT rd.registrationNo, rd.type, rd.discount AS disc, pc.itemNo, pc.sellingPrice, pc.quantity, pc.discount, pc.total, pc.cashUnpaid, pc.phic, pc.company, pc.cashPaid, pc.dateCharge, pc.amountPaidFromCreditCard, pc.orNo, pc.doctorsPF FROM patientCharges pc, registrationDetails rd WHERE pc.registrationNo=rd.registrationNo AND rd.type='IPD' AND pc.status NOT LIKE 'DELETED_%%%%' AND pc.title='PROFESSIONAL FEE' AND rd.registrationNo='$selectrde' ORDER BY pc.dateCharge,pc.timeCharge");

while($efetch=mysql_fetch_array($esql)){
$eregistrationNo=$efetch['registrationNo'];
$equantity=$efetch['quantity'];
$esellingPrice=$efetch['sellingPrice'];
$eitemNo=$efetch['itemNo'];
$ediscount=$efetch['discount'];
$etotal=$efetch['total'];
$ecashUnpaid=$efetch['cashUnpaid'];
$ephic=$efetch['phic'];
$ecompany=$efetch['company'];
$ecashPaid=$efetch['cashPaid'];
$eregistrationNo=$efetch['registrationNo'];
$edateCharge=$efetch['dateCharge'];
$eamountPaidFromCreditCard=$efetch['amountPaidFromCreditCard'];
$edoctorsPF=$efetch['doctorsPF'];
$eitemNo=$efetch['itemNo'];

$etruesp=preg_split('[/]',$esellingPrice);

$epfdiscount+=$ediscount;
$epfcashUnpaid+=$ecashUnpaid;
$epfphic+=$ephic;
$epfcompany+=$ecompany;
$epfcash+=$ecashPaid;
$epfamountPaidFromCreditCard+=$eamountPaidFromCreditCard;

$epfAll=$ecashPaid+$eamountPaidFromCreditCard;
$epfcashPaid+=$epfAll;

if($edoctorsPF==''){$etruebdoctorsPF=0;}else{$etruebdoctorsPF=$edoctorsPF;}
if($eamountPaidFromCreditCard==''){$etruebamountPaidFromCreditCard=0;}else{$etruebamountPaidFromCreditCard=$eamountPaidFromCreditCard;}

//$etotspmdpf=($etruesp[0])-$etruebdoctorsPF;
$etotspmdpf=($etruesp[0]);
$etotPF+=$etotspmdpf;
$eerrorst=($etotspmdpf-($ediscount+$ecashUnpaid+$ephic+$ecompany+$ecashPaid+$etruebamountPaidFromCreditCard));
$eerror+=$eerrorst;

//if($eerrorst!=0){
//echo "$eitemNo | $eerrorst = ((".$etruesp[0]."-$etruebdoctorsPF)-($ediscount+$ecashUnpaid+$ephic+$ecompany+$ecashPaid+$etruebamountPaidFromCreditCard))<br>";
//}


}

}//If E
}//For E


if(($finalzamountPaidCredithb+$finalzamountPaidCreditd+$epfamountPaidFromCreditCard)!=0){
echo "
          <tr>
            <form name='title' method='post' action='OPDCreditCardSummary.php' target='_blank'>
            <input type='hidden' name='username' value='$username' />
            <input type='hidden' name='fyear' value='$fyear' />
            <input type='hidden' name='fmonth' value='$fmonth' />
            <input type='hidden' name='fday' value='$fday' />
            <input type='hidden' name='tyear' value='$tyear' />
            <input type='hidden' name='tmonth' value='$tmonth' />
            <input type='hidden' name='tday' value='$tday' />
            <input type='hidden' name='opdnum' value='$opdnum' />
";

for($opcc=1;$opcc<=$opdnum;$opcc++){
$rnopccsel="rop".$opcc;
$rnopcc=$_POST[$rnopccsel];

echo "
            <input type='hidden' name='$rnopccsel' value='$rnopcc' />
";
}

echo "
            <td width='auto'><div align='left' class='style5'><input type='submit' class='buttonnodecor' name='show' value='CREDIT CARD' /></div></a></td>
            </form>
            <td width='auto'><div align='right' class='style5'>".number_format(($finalzamountPaidCredithb+$finalzamountPaidCreditd+$epfamountPaidFromCreditCard),2,'.',',')."</div></td>
            <td width='auto'><div align='right' class='style5'></div></td>
          </tr>
";
}

if((($dtotcashPaid+$epfcash+$finalzamountPaidCashhb+$finalzamountPaidCashd)-$finalztotgendisc)!=0){
echo "
          <tr>
            <form name='title' method='post' action='iPDCashSummary.php' target='_blank'>
            <input type='hidden' name='username' value='$username' />
            <input type='hidden' name='fyear' value='$fyear' />
            <input type='hidden' name='fmonth' value='$fmonth' />
            <input type='hidden' name='fday' value='$fday' />
            <input type='hidden' name='tyear' value='$tyear' />
            <input type='hidden' name='tmonth' value='$tmonth' />
            <input type='hidden' name='tday' value='$tday' />
            <input type='hidden' name='ipdnum' value='$ipdnum' />
";

for($ipca=1;$ipca<=$ipdnum;$ipca++){
$rnipcasel="rip".$ipca;
$rnipca=$_POST[$rnipcasel];

echo "
            <input type='hidden' name='$rnipcasel' value='$rnipca' />
";
}

echo "
            <td width='auto'><div align='left' class='style5'><input type='submit' class='buttonnodecor' name='show' value='CASH' /></div></td>
            </form>
            <td width='auto'><div align='right' class='style5'>".number_format((($dtotcashPaid+$epfcash+$finalzamountPaidCashhb+$finalzamountPaidCashd)-$finalztotgendisc),2,'.',',')."</div></a></td>
            <td width='auto'><div align='ight' class='style5'></div></td>
          </tr>
";
}

if(($dtotphic+$epfphic)!=0){
echo "
          <tr>
            <form name='title' method='post' action='IPDARHMOSummary.php' target='_blank'>
            <input type='hidden' name='username' value='$username' />
            <input type='hidden' name='fyear' value='$fyear' />
            <input type='hidden' name='fmonth' value='$fmonth' />
            <input type='hidden' name='fday' value='$fday' />
            <input type='hidden' name='tyear' value='$tyear' />
            <input type='hidden' name='tmonth' value='$tmonth' />
            <input type='hidden' name='tday' value='$tday' />
            <input type='hidden' name='ipdnum' value='$ipdnum' />
";

for($ipap=1;$ipap<=$ipdnum;$ipap++){
$rnipapsel="rip".$ipap;
$rnipap=$_POST[$rnipapsel];

echo "
            <input type='hidden' name='$rnipapsel' value='$rnipap' />
";
}

echo "
            <td width='auto'><div align='left'><input type='submit' class='buttonnodecor' name='show' value='A/R - PHIC' /></div></td>
            </form>
            <td width='auto'><div align='right' class='style5'>".number_format(($dtotphic+$epfphic),2,'.',',')."</div></td>
            <td width='auto'><div align='right' class='style5'></div></td>
          </tr>
";
}

if(($dtotcompany+$epfcompany)!=0){
echo "
          <tr>
            <form name='title' method='post' action='IPDARHMOSummary.php' target='_blank'>
            <input type='hidden' name='username' value='$username' />
            <input type='hidden' name='fyear' value='$fyear' />
            <input type='hidden' name='fmonth' value='$fmonth' />
            <input type='hidden' name='fday' value='$fday' />
            <input type='hidden' name='tyear' value='$tyear' />
            <input type='hidden' name='tmonth' value='$tmonth' />
            <input type='hidden' name='tday' value='$tday' />
            <input type='hidden' name='ipdnum' value='$ipdnum' />
";

for($ipah=1;$ipah<=$ipdnum;$ipah++){
$rnipahsel="rip".$ipah;
$rnipah=$_POST[$rnipahsel];

echo "
            <input type='hidden' name='$rnipahsel' value='$rnipah' />
";
}

echo "
            <td width='auto'><div align='left' class='style5'><input type='submit' class='buttonnodecor' name='show' value='A/R - HMO/COMPANY' /></div></td>
            </form>
            <td width='auto'><div align='right' class='style5'>".number_format(($dtotcompany+$epfcompany),2,'.',',')."</div></a></td>
            <td width='auto'><div align='right' class='style5'></div></td>
          </tr>
";
}

if((($dtotdiscount+$epfdiscount)+(round($dtotbalance)+$eerror)+$finalztotgendisc)!=0){
echo "
          <tr>
            <form name='title' method='post' action='IPDRevenueDiscSummary.php' target='_blank'>
            <input type='hidden' name='username' value='$username' />
            <input type='hidden' name='fyear' value='$fyear' />
            <input type='hidden' name='fmonth' value='$fmonth' />
            <input type='hidden' name='fday' value='$fday' />
            <input type='hidden' name='tyear' value='$tyear' />
            <input type='hidden' name='tmonth' value='$tmonth' />
            <input type='hidden' name='tday' value='$tday' />
            <input type='hidden' name='ipdnum' value='$ipdnum' />
";

for($iprd=1;$iprd<=$ipdnum;$iprd++){
$rniprdsel="rip".$iprd;
$rniprd=$_POST[$rniprdsel];

echo "
            <input type='hidden' name='$rniprdsel' value='$rniprd' />
";
}

echo "
            <td width='auto'><div align='left'><input type='submit' class='buttonnodecor' name='show' value='REVENUE DISCOUNT' /></div></td>
            </form>
            <td width='auto'><div align='right' class='style5'>".number_format((($dtotdiscount+$epfdiscount)+(round($dtotbalance)+$eerror)+$finalztotgendisc),2,'.',',')."</div></td>
            <td width='auto'><div align='right' class='style5'></div></td>
          </tr>
";
}

if((($dtotcashUnpaid+$epfcashUnpaid)-($finalzamountPaidCashhb+$finalzamountPaidCashd+$epfcashPaid+$finalzamountPaidCredithb+$finalzamountPaidCreditd+$epfamountPaidFromCreditCard+$finalztotgendisc))!=0){
echo "
          <tr>
            <form name='title' method='post' action='IPDARPatientSummary.php' target='_blank'>
            <input type='hidden' name='username' value='$username' />
            <input type='hidden' name='fyear' value='$fyear' />
            <input type='hidden' name='fmonth' value='$fmonth' />
            <input type='hidden' name='fday' value='$fday' />
            <input type='hidden' name='tyear' value='$tyear' />
            <input type='hidden' name='tmonth' value='$tmonth' />
            <input type='hidden' name='tday' value='$tday' />
            <input type='hidden' name='ipdnum' value='$ipdnum' />
";

for($ipapt=1;$ipapt<=$ipdnum;$ipapt++){
$rnipaptsel="rip".$ipapt;
$rnipapt=$_POST[$rnipaptsel];

echo "
            <input type='hidden' name='$rnipaptsel' value='$rnipapt' />
";
}

echo "
            <td width='auto'><div align='left'><input type='submit' class='buttonnodecor' name='show' value='A/R - PATIENT' /></div></td>
            </form>
            <td width='auto'><div align='right' class='style5'>".number_format((($dtotcashUnpaid+$epfcashUnpaid)-($finalzamountPaidCashhb+$finalzamountPaidCashd+$epfcashPaid+$finalzamountPaidCredithb+$finalzamountPaidCreditd+$epfamountPaidFromCreditCard+$finalztotgendisc)),2,'.',',')."</div></td>
            <td width='auto'><div align='right' class='style5'></div></td>
          </tr>
";
}

/*if(($dtotbalance+$eerror)!=0){
echo "
          <tr>
            <td width='auto'><div align='left' class='style5'>?????</div></td>
            <td width='auto'><div align='right' class='style5'>".number_format(($dtotbalance+$eerror),2,'.',',')."</div></td>
            <td width='auto'><div align='right' class='style5'></div></td>
          </tr>
";
}*/

if($etotPF!=0){
echo "
          <tr>
            <form name='title' method='post' action='IPDClinicRevSummary.php' target='_blank'>
            <input type='hidden' name='username' value='$username' />
            <input type='hidden' name='fyear' value='$fyear' />
            <input type='hidden' name='fmonth' value='$fmonth' />
            <input type='hidden' name='fday' value='$fday' />
            <input type='hidden' name='tyear' value='$tyear' />
            <input type='hidden' name='tmonth' value='$tmonth' />
            <input type='hidden' name='tday' value='$tday' />
            <input type='hidden' name='ipdnum' value='$ipdnum' />
";

for($ipcv=1;$ipcv<=$ipdnum;$ipcv++){
$rnipcvsel="rip".$ipcv;
$rnipcv=$_POST[$rnipcvsel];

echo "
            <input type='hidden' name='$rnipcvsel' value='$rnipcv' />
";
}

echo "
            <td width='auto'><div align='left'><input type='submit' class='buttonnodecor' name='show' value='CLINIC REVENUE' /></div></a></td>
            </form>
            <td width='auto'><div align='right' class='style5'></div></td>
            <td width='auto'><div align='right' class='style5'>".number_format($etotPF,2,'.',',')."</div></td>
          </tr>
";
}

$gtotcredit=0;
$fsql=mysql_query("SELECT pc.title FROM patientCharges pc, registrationDetails rd WHERE pc.registrationNo=rd.registrationNo AND rd.type='IPD' AND pc.status NOT LIKE 'DELETED_%%%%' AND pc.title NOT LIKE 'PROFESSIONAL FEE' AND (rd.dateUnregistered BETWEEN '$fdate' AND '$tdate') GROUP BY pc.title ORDER BY pc.title");

while($ffetch=mysql_fetch_array($fsql)){
$ftitle=$ffetch['title'];

//$csql=mysql_query("SELECT SUM(sellingPrice*quantity) AS creditqsp, SUM(pc.discount) AS totcdiscount, SUM(pc.total) AS totctotal, SUM(pc.discount+pc.cashUnpaid+pc.cashPaid+pc.cashPaidFromBalance+pc.phic+pc.company+pc.amountPaidFromCreditCard) AS othertot FROM patientCharges pc, registrationDetails rd WHERE pc.registrationNo=rd.registrationNo AND rd.type='OPD' AND pc.status NOT LIKE 'DELETED_%%%%' AND pc.title='$xtitle' AND (pc.dateCharge BETWEEN '$fdate' AND '$tdate') ORDER BY pc.dateCharge,pc.timeCharge");

$gcreditqsp=0;
$gtotcdiscount=0;
$gtotctotal=0;
$gothertot=0;

for($g=1;$g<=$ipdnum;$g++){//For G
$rnipg="rip".$g;

$selectrdg=$_POST[$rnipg];

if($selectrdg!=""){//If G
$gsql=mysql_query("SELECT pc.sellingPrice, pc.quantity, pc.discount, pc.total, pc.discount, pc.cashUnpaid, pc.cashPaid, pc.cashPaidFromBalance, pc.phic, pc.company, pc.amountPaidFromCreditCard FROM patientCharges pc, registrationDetails rd WHERE pc.registrationNo=rd.registrationNo AND rd.type='IPD' AND pc.status NOT LIKE 'DELETED_%%%%' AND pc.title='$ftitle' AND rd.registrationNo='$selectrdg' ORDER BY pc.dateCharge,pc.timeCharge");
while($gfetch=mysql_fetch_array($gsql)){
$gtotcdiscount+=$gfetch['discount'];
$gtotctotal+=$gfetch['total'];
$gothertot+=($gfetch['discount']+$gfetch['cashUnpaid']+$gfetch['cashPaid']+$gfetch['cashPaidFromBalance']+$gfetch['phic']+$gfetch['company']+$gfetch['amountPaidFromCreditCard']);
$gcreditqsp+=($gfetch['sellingPrice']*$gfetch['quantity']);
}

}//If G
}//For G

$gcredit=$gtotcdiscount+$totctotal;
$gtotcredit+=$gcreditqsp;

if($gcreditqsp>0){
echo "
          <tr>
            <form name='title' method='post' action='IPDTitleSummary.php' target='_blank'>
            <input type='hidden' name='username' value='$username' />
            <input type='hidden' name='fyear' value='$fyear' />
            <input type='hidden' name='fmonth' value='$fmonth' />
            <input type='hidden' name='fday' value='$fday' />
            <input type='hidden' name='tyear' value='$tyear' />
            <input type='hidden' name='tmonth' value='$tmonth' />
            <input type='hidden' name='tday' value='$tday' />
            <input type='hidden' name='title' value='$ftitle' />
            <input type='hidden' name='opdnum' value='$ipdnum' />
";

for($ipt=1;$ipt<=$ipdnum;$ipt++){
$rniptsel="rip".$ipt;
$rnipt=$_POST[$rniptsel];

echo "
            <input type='hidden' name='$rniptsel' value='$rnipt' />
";
}

echo "
            <td width='auto'><div align='left'><input type='submit' name='show' class='buttonnodecor' value='".strtoupper($ftitle)."' /></div></td>
            </form>
            <td width='auto'><div align='right' class='style5'></div></td>
            <td width='auto'><div align='right' class='style5'>".number_format($gcreditqsp,2,'.',',')."</div></td>
          </tr>
";
}
}


$inptotaldebit=$dtotdiscount+$dtotcompany+$dtotcashPaid+$dtotamountPaidFromCreditCard+$dtotphic+(($dtotcashUnpaid+$epfcash)-($finalzamountPaidCashhb+$finalzamountPaidCredithb+$finalzamountPaidCashd+$finalzamountPaidCreditd))+$dtotbalance+$epfdiscount+$epfcashUnpaid+$epfphic+$epfcompany+$epfamountPaidFromCreditCard+$eerror+$finalzamountPaidCashhb+$finalzamountPaidCredithb+$finalzamountPaidCashd+$finalzamountPaidCreditd;


$inptotalcredit=$gtotcredit+$etotPF;

echo "
          <tr>
            <td width='auto'><div align='left' class='style3'>TOTAL</div></td>
            <td width='auto'><div align='right' class='style3'>".number_format($inptotaldebit,2,'.',',')."</div></td>
            <td width='auto'><div align='right' class='style3'>".number_format($inptotalcredit,2,'.',',')."</div></td>
          </tr>
        </table></td>
        <td width='8%'></td>
";

echo " 
      </tr>
    </table></td>
  </tr>
</table>
</div>
";
//echo "$dtotdiscount+$dtotcompany+$dtotcashPaid+$dtotamountPaidFromCreditCard+$dtotphic+(($dtotcashUnpaid+$epfcash)-($finalzamountPaidCashhb+$finalzamountPaidCredithb+$finalzamountPaidCashd+$finalzamountPaidCreditd))+$dtotbalance+$epfdiscount+$epfcashUnpaid+$epfphic+$epfcompany+$epfamountPaidFromCreditCard+$eerror+$finalzamountPaidCashhb+$finalzamountPaidCredithb+$finalzamountPaidCashd+$finalzamountPaidCreditd";
?>
</body>
</html>
