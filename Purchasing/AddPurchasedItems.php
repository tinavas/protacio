<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Add Purchased Items</title>
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

//-->
</script>
<style type="text/css">
<!--
.style1 {font-family: Arial;font-size: 14px;color: #000000;font-weight: bold;}
.style2 {font-family: Arial;font-size: 12px;color: #000000;font-weight: bold;}
.textfield1 {font-family: Arial;font-size: 12px;font-weight: bold;color: #000000;background-color: #FFFFFF;border: 1px solid #000000;}
.button1 {font-family: Arial;font-size: 12px;font-weight: bold;color: #000000;background-color: #FFFFFF;border: 1px solid #000000;}
-->
</style>
</head>

<body onload="placeFocus()">
<?php
include("../myDatabase.php");
$cuz = new database();

mysql_connect($cuz->myHost(),$cuz->getUser(),$cuz->getPass());
mysql_select_db($cuz->getDB());

$year=date("Y");
$month=date("m");
$day=date("d");

$username=$_GET['username'];

echo "
<br />
<div align='left'><span class='style1'>Fill Up FIelds</span>
  <table width='400' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000' bgcolor='#000000'>
    <form id='Create' name='Create' method='get' action='#'>
    <tr>
      <td><table width='400' border='0' cellpadding='0' cellspacing='0' bgcolor='#FFFFFF'>
        <tr>
          <td colspan='3' class='style1'><div align='left'>&nbsp;Create Purchase Report</div></td>
        </tr>
        <tr>
          <td width='133' class='style2'><div align='left'>&nbsp;Invoice No . </div></td>
          <td width='15' class='style2'><div align='center'>:</div></td>
          <td width='252' class='style2'><div align='left'>
            <input name='invoiceNo' type='text' class='textfield1' placeholder='Invoice Number' />
          </div></td>
        </tr>
        <tr>
          <td class='style2'><div align='left'>&nbsp;Supplier</div></td>
          <td class='style2'><div align='center'>:</div></td>
          <td class='style2'><div align='left'>
            <select name='supplier' class='textfield1' id='supplier'>
	      <option selected='selected'>-Select Supplier-</option>
";



$supsql=mysql_query("SELECT supplierCode, supplierName FROM supplier ORDER BY supplierName");
while($supfetch=mysql_fetch_array($supsql)){
$supplierCode=$supfetch['supplierCode'];
$supplierName=$supfetch['supplierName'];
echo "
	      <option value='$supplierCode'>$supplierName</option>
";
}

echo "
	    </select>
          </div></td>
        </tr>
        <tr>
          <td class='style2'><div align='left'>&nbsp;Terms</div></td>
          <td class='style2'><div align='center'>:</div></td>
          <td class='style2'><div align='left'>
            <input name='terms' type='text' class='textfield1' placeholder='Terms' />
          </div></td>
        </tr>
        <tr>
          <td class='style2'><div align='left'>&nbsp;Transaction Date </div></td>
          <td class='style2'><div align='center'>:</div></td>
          <td class='style2'><div align='left'>
            <select name='tdmonth' class='textfield1' id='month'>
";

if($month=='01'){$tm01="selected='selected'"; $tm02=""; $tm03=""; $tm04=""; $tm05=""; $tm06=""; $tm07=""; $tm08=""; $tm09=""; $tm10=""; $tm11=""; $tm12="";}
else if($month=='02'){$tm01=""; $tm02="selected='selected'"; $tm03=""; $tm04=""; $tm05=""; $tm06=""; $tm07=""; $tm08=""; $tm09=""; $tm10=""; $tm11=""; $tm12="";}
else if($month=='03'){$tm01=""; $tm02=""; $tm03="selected='selected'"; $tm04=""; $tm05=""; $tm06=""; $tm07=""; $tm08=""; $tm09=""; $tm10=""; $tm11=""; $tm12="";}
else if($month=='04'){$tm01=""; $tm02=""; $tm03=""; $tm04="selected='selected'"; $tm05=""; $tm06=""; $tm07=""; $tm08=""; $tm09=""; $tm10=""; $tm11=""; $tm12="";}
else if($month=='05'){$tm01=""; $tm02=""; $tm03=""; $tm04=""; $tm05="selected='selected'"; $tm06=""; $tm07=""; $tm08=""; $tm09=""; $tm10=""; $tm11=""; $tm12="";}
else if($month=='06'){$tm01=""; $tm02=""; $tm03=""; $tm04=""; $tm05=""; $tm06="selected='selected'"; $tm07=""; $tm08=""; $tm09=""; $tm10=""; $tm11=""; $tm12="";}
else if($month=='07'){$tm01=""; $tm02=""; $tm03=""; $tm04=""; $tm05=""; $tm06=""; $tm07="selected='selected'"; $tm08=""; $tm09=""; $tm10=""; $tm11=""; $tm12="";}
else if($month=='08'){$tm01=""; $tm02=""; $tm03=""; $tm04=""; $tm05=""; $tm06=""; $tm07=""; $tm08="selected='selected'"; $tm09=""; $tm10=""; $tm11=""; $tm12="";}
else if($month=='09'){$tm01=""; $tm02=""; $tm03=""; $tm04=""; $tm05=""; $tm06=""; $tm07=""; $tm08=""; $tm09="selected='selected'"; $tm10=""; $tm11=""; $tm12="";}
else if($month=='10'){$tm01=""; $tm02=""; $tm03=""; $tm04=""; $tm05=""; $tm06=""; $tm07=""; $tm08=""; $tm09=""; $tm10="selected='selected'"; $tm11=""; $tm12="";}
else if($month=='11'){$tm01=""; $tm02=""; $tm03=""; $tm04=""; $tm05=""; $tm06=""; $tm07=""; $tm08=""; $tm09=""; $tm10=""; $tm11="selected='selected'"; $tm12="";}
else if($month=='12'){$tm01=""; $tm02=""; $tm03=""; $tm04=""; $tm05=""; $tm06=""; $tm07=""; $tm08=""; $tm09=""; $tm10=""; $tm11=""; $tm12="selected='selected'";}

echo "
	      <option value='01' $tm01>Jan</option>
	      <option value='02' $tm02>Feb</option>
	      <option value='03' $tm03>Mar</option>
	      <option value='04' $tm04>Apr</option>
	      <option value='05' $tm05>May</option>
	      <option value='06' $tm06>Jun</option>
	      <option value='07' $tm07>Jul</option>
	      <option value='08' $tm08>Aug</option>
	      <option value='09' $tm09>Sep</option>
	      <option value='10' $tm10>Oct</option>
	      <option value='11' $tm11>Nov</option>
	      <option value='12' $tm12>Dec</option>
";


echo "
	    </select>
	    <select name='tdday' class='textfield1' id='day'>
";

for($z=1;$z<=31;$z++){
if($z<10){$y="0".$z;}else{$y=$z;}

if($day==$y){$tsd="selected='selected'";}else{$tsd="";}

echo "
	      <option $tsd>$y</option>
";
}

echo "
	    </select>
	    <select name='tdyear' class='textfield1' id='year'>
";

for($a=1930;$a<$year;$a++){
echo "
	      <option>$a</option>
";
}

echo "
	      <option selected='selected'>$year</option>
";

for($b=($year+1);$b<=($year+10);$b++){
echo "
	      <option>$b</option>
";
}

echo "
	    </select>
          </div></td>
        </tr>
        <tr>
          <td class='style2'><div align='left'>&nbsp;Recieved Date </div></td>
          <td class='style2'><div align='center'>:</div></td>
          <td class='style2'><div align='left'>
            <select name='rdmonth' class='textfield1' id='month'>
";

if($month=='01'){$rm01="selected='selected'"; $rm02=""; $rm03=""; $rm04=""; $rm05=""; $rm06=""; $rm07=""; $rm08=""; $rm09=""; $rm10=""; $rm11=""; $rm12="";}
else if($month=='02'){$rm01=""; $rm02="selected='selected'"; $rm03=""; $rm04=""; $rm05=""; $rm06=""; $rm07=""; $rm08=""; $rm09=""; $rm10=""; $rm11=""; $rm12="";}
else if($month=='03'){$rm01=""; $rm02=""; $rm03="selected='selected'"; $rm04=""; $rm05=""; $rm06=""; $rm07=""; $rm08=""; $rm09=""; $rm10=""; $rm11=""; $rm12="";}
else if($month=='04'){$rm01=""; $rm02=""; $rm03=""; $rm04="selected='selected'"; $rm05=""; $rm06=""; $rm07=""; $rm08=""; $rm09=""; $rm10=""; $rm11=""; $rm12="";}
else if($month=='05'){$rm01=""; $rm02=""; $rm03=""; $rm04=""; $rm05="selected='selected'"; $rm06=""; $rm07=""; $rm08=""; $rm09=""; $rm10=""; $rm11=""; $rm12="";}
else if($month=='06'){$rm01=""; $rm02=""; $rm03=""; $rm04=""; $rm05=""; $rm06="selected='selected'"; $rm07=""; $rm08=""; $rm09=""; $rm10=""; $rm11=""; $rm12="";}
else if($month=='07'){$rm01=""; $rm02=""; $rm03=""; $rm04=""; $rm05=""; $rm06=""; $rm07="selected='selected'"; $rm08=""; $rm09=""; $rm10=""; $rm11=""; $rm12="";}
else if($month=='08'){$rm01=""; $rm02=""; $rm03=""; $rm04=""; $rm05=""; $rm06=""; $rm07=""; $rm08="selected='selected'"; $rm09=""; $rm10=""; $rm11=""; $rm12="";}
else if($month=='09'){$rm01=""; $rm02=""; $rm03=""; $rm04=""; $rm05=""; $rm06=""; $rm07=""; $rm08=""; $rm09="selected='selected'"; $rm10=""; $rm11=""; $rm12="";}
else if($month=='10'){$rm01=""; $rm02=""; $rm03=""; $rm04=""; $rm05=""; $rm06=""; $rm07=""; $rm08=""; $rm09=""; $rm10="selected='selected'"; $rm11=""; $rm12="";}
else if($month=='11'){$rm01=""; $rm02=""; $rm03=""; $rm04=""; $rm05=""; $rm06=""; $rm07=""; $rm08=""; $rm09=""; $rm10=""; $rm11="selected='selected'"; $rm12="";}
else if($month=='12'){$rm01=""; $rm02=""; $rm03=""; $rm04=""; $rm05=""; $rm06=""; $rm07=""; $rm08=""; $rm09=""; $rm10=""; $rm11=""; $rm12="selected='selected'";}

echo "
	      <option value='01' $rm01>Jan</option>
	      <option value='02' $rm02>Feb</option>
	      <option value='03' $rm03>Mar</option>
	      <option value='04' $rm04>Apr</option>
	      <option value='05' $rm05>May</option>
	      <option value='06' $rm06>Jun</option>
	      <option value='07' $rm07>Jul</option>
	      <option value='08' $rm08>Aug</option>
	      <option value='09' $rm09>Sep</option>
	      <option value='10' $rm10>Oct</option>
	      <option value='11' $rm11>Nov</option>
	      <option value='12' $rm12>Dec</option>
";


echo "
	      </select>
	      <select name='rdday' class='textfield1' id='day'>
";

for($x=1;$x<=31;$x++){
if($x<10){$w="0".$x;}else{$w=$x;}

if($day==$w){$rsd="selected='selected'";}else{$rsd="";}

echo "
	      <option $rsd>$w</option>
";
}

echo "
	    </select>
	    <select name='rdyear' class='textfield1' id='year'>
";

for($c=1930;$c<$year;$c++){
echo "
	      <option>$c</option>
";
}

echo "
	      <option selected='selected'>$year</option>
";

for($d=($year+1);$d<=($year+10);$d++){
echo "
	      <option>$d</option>
";
}

echo "
	    </select>
          </div></td>
        </tr>
        <tr>
          <td colspan='3'><div align='right'>
            <input name='Submit' type='submit' class='button1' value='Continue &gt;&gt;' />
          </div></td>
        </tr>
      </table></td>
    </tr>
    <input type='hidden' name='username' value='$username' />
    </form>
  </table>
</div>
";
?>
</body>
</html>
