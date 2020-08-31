<script type="text/javascript" src="include/jquery-2.1.1.min.js"></script>
<script type="text/javaScript" src="ele_preventivi.js"></script>
<?php
require 'include/database.php';
require 'include/java.php';
$codice=$_GET["codice"];
$j=0;
//
echo "<input type=\"button\" value=\"Conferma\" onclick=\"conferma();\">";
echo "<form name='preventivi' id='preventivi'>";
echo "<table width=\"100%\">";
$qr="SELECT * FROM preventivi WHERE PREV_CLIENTE='$codice' AND (PREV_ORDINATO IS NULL OR PREV_ORDINATO='') ORDER BY PREV_DATA_DOC DESC, PREV_NUM_DOC";
$rst=mysql_query($qr,$con);
while($row = mysql_fetch_assoc($rst)) {
   extract($row);
   $t="";
   $righe=json_decode($row["PREV_RIGHE"],true);
   for($jj=0;$jj<count($righe["cod"]);$jj++)
     {
      $t.=$righe["cod"][$jj] . " " . $righe["desc"][$jj] . " " . $righe["qta"][$jj] . " " . $righe["tot"][$jj] . "\n";
	 }
   $data=addrizza($row["PREV_DATA_DOC"],"");
   echo "<tr title='$t'><td>$data<td>$PREV_NUM_DOC</td><td><input type=\"checkbox\" value=\"$PREV_ID\" id=\"chk$j\" name=\"chk$j\"></td></tr>";
   $j++;
   }
echo "</table>";
echo "</form>";
?>
