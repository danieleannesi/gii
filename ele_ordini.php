<script type="text/javascript" src="include/jquery-2.1.1.min.js"></script>
<script type="text/javaScript" src="ele_ordini.js"></script>
<?php
require 'include/database.php';
require 'include/java.php';
$codice=$_GET["codice"];
//
echo "<input type=\"button\" value=\"Conferma\" onclick=\"conferma();\">";
echo "<form name='ordini' id='ordini'>";
echo "<table width=\"100%\">";
$r=0;
$qr="SELECT * FROM ordini WHERE ORDI_CLIENTE='$codice' AND (ORDI_EVASO IS NULL OR ORDI_EVASO='') ORDER BY ORDI_DATA_DOC DESC";
$rst=mysql_query($qr,$con);
while($row = mysql_fetch_assoc($rst)) {
   extract($row);
   $t="";
   $qt=0;
   $righe=json_decode($row["ORDI_RIGHE"],true);
   for($j=0;$j<count($righe["cod"]);$j++)
     {
      $q1=($righe["qta"][$j]-$righe["qta_sca"][$j]);
      if($q1>0)
        {
        $qt+=$q1;
        $t.=$righe["cod"][$j] . " " . $righe["desc"][$j] . " " . $righe["qta"][$j] . " " . $righe["tot"][$j] . "\n";
		}
	 }
   if($qt>0)
     {
     $data=addrizza($row["ORDI_DATA_DOC"],"");
     echo "<tr title='$t'><td>$data<td>$ORDI_NUM_DOC</td><td>$ORDI_DES_INDIRIZZO</td><td>$ORDI_RIFE</td><td><input type=\"checkbox\" value=\"$ORDI_ID\" id=\"chk$r\" name=\"chk$r\"></td></tr>";
	 $r++;
	 }
   }
echo "</table>";
echo "</form>";
?>
