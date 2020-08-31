<script type="text/javascript">
function check_date(field){
var checkstr = "0123456789";
var DateField = field;
var Datevalue = "";
var DateTemp = "";
var seperator = "/";
var day;
var month;
var year;
var step = 0;
var err = 0;
var i;
   err = 0;
   DateValue = DateField.value;
   /* Se campo vuoto non procedo nel controllo */
   if( DateValue.length == 0 )  return '';
   /* cancello tutti i dati tranne 0-9 */
   for (i = 0; i < DateValue.length; i++) {
              if (checkstr.indexOf(DateValue.substr(i,1)) >= 0) {
                 DateTemp = DateTemp + DateValue.substr(i,1);
              }
   }
   DateValue = DateTemp;
  /* se l'anno è inserito con 2 valori lo cambio sempre con  20xx */
   if (DateValue.length == 6) {
      DateValue = DateValue.substr(0,4) + '20' + DateValue.substr(4,2); }
   if (DateValue.length != 8) {
      err = 19;}
   /* anno sbagliato 0000 */
   year = DateValue.substr(4,4);
   if (year == 0) {
      err = 20;
   }
   /* validazione del mese*/
   month = DateValue.substr(2,2);
   if ((month < 1) || (month > 12)) {
      err = 21;
   }
   /* validazione del giorno */
   day = DateValue.substr(0,2);
   if (day < 1) {
     err = 22;
   }
   /* Validazione anno / febbraio / gg */
   if ((year % 4 == 0)) {
      step = 1;
   }
   if ((month == 2) && (step == 1) && (day > 29)) {
      err = 23;
   }
   if ((month == 2) && (step != 1) && (day > 28)) {
      err = 24;
   }
   /* validazione dei mesi */
   if ((day > 31) && ((month == "01") || (month == "03") || (month == "05") || (month == "07") || (month == "08") || (month == "10") || (month == "12"))) {
      err = 25;
   }
   if ((day > 30) && ((month == "04") || (month == "06") || (month == "09") || (month == "11"))) {
      err = 26;
   }
   /* se è inserito 00 cancello i dati */
   if ((day == 0) && (month == 0) && (year == 00)) {
      err = 30; day = ""; month = ""; year = ""; seperator = "";
   }
   /* Se non ci sono errori inserisco */
   if (err == 0) {
      DateField.value = day + seperator + month + seperator + year;
	  return "";
   }
   /* Messaggio di errore, avviso di data non corretta se err diverso da 0 */
   else {
      alert("La data inserita non è corretta.\n\nI formati supportati sono:\n  - ggmmaa\n  - ggmmaaaa\n  - gg/mm/aa\n  - gg/mm/aaaa\n");
      DateField.select();
      DateField.focus();
	  return 1; 
   }
}
function ControllaCF(cf)
{
    var validi, i, s, set1, set2, setpari, setdisp;
    if( cf == '' )  return '';
    cf = cf.toUpperCase();
    if( cf.length != 16 )
        return "La lunghezza del codice fiscale non e'\n"
        +"corretta: il codice fiscale dovrebbe essere lungo\n"
        +"esattamente 16 caratteri.\n";
    validi = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    for( i = 0; i < 16; i++ ){
        if( validi.indexOf( cf.charAt(i) ) == -1 )
            return "Il codice fiscale contiene un carattere non valido `" +
                cf.charAt(i) +
                "'.\nI caratteri validi sono le lettere e le cifre.\n";
    }
    set1 = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    set2 = "ABCDEFGHIJABCDEFGHIJKLMNOPQRSTUVWXYZ";
    setpari = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    setdisp = "BAKPLCQDREVOSFTGUHMINJWZYX";
    s = 0;
    for( i = 1; i <= 13; i += 2 )
        s += setpari.indexOf( set2.charAt( set1.indexOf( cf.charAt(i) )));
    for( i = 0; i <= 14; i += 2 )
        s += setdisp.indexOf( set2.charAt( set1.indexOf( cf.charAt(i) )));
    if( s%26 != cf.charCodeAt(15)-'A'.charCodeAt(0) )
        return "Il codice fiscale non e' corretto:\n"+
            "il codice di controllo non corrisponde.\n";
    return "";
}
function ControllaPIVA(pi)
{
    if( pi == '' )  return '';
    if( pi.length != 11 )
        return "La lunghezza della partita IVA non e'\n" +
            "corretta: la partita IVA dovrebbe essere lunga\n" +
            "esattamente 11 caratteri.\n";
    validi = "0123456789";
    for( i = 0; i < 11; i++ ){
        if( validi.indexOf( pi.charAt(i) ) == -1 )
            return "La partita IVA contiene un carattere non valido `" +
                pi.charAt(i) + "'.\nI caratteri validi sono le cifre.\n";
    }
    s = 0;
    for( i = 0; i <= 9; i += 2 )
        s += pi.charCodeAt(i) - '0'.charCodeAt(0);
    for( i = 1; i <= 9; i += 2 ){
        c = 2*( pi.charCodeAt(i) - '0'.charCodeAt(0) );
        if( c > 9 )  c = c - 9;
        s += c;
    }
    if( ( 10 - s%10 )%10 != pi.charCodeAt(10) - '0'.charCodeAt(0) )
        return "La partita IVA non e' valida:\n" +
            "il codice di controllo non corrisponde.\n";
    return '';
}
var salva_form;
var nomeform;
function salvaform() {
   var f=document.forms[nomeform];
   for (var i=0;i<f.elements.length;i++)
     {
     if(f.elements[i].type=="checkbox")
       salva_form+=f.elements[i].checked;
     else  
       salva_form+=f.elements[i].value;
     }
 }
function salvaform1() {
   var f=document.forms[nomeform];
   var salv;
   for (var i=0;i<f.elements.length;i++)
     {
     if(f.elements[i].type=="checkbox")
       salv+=f.elements[i].checked;
     else  
       salv+=f.elements[i].value;
     }
   return salv;
 }
 
function controlla_cf_piva(cf) {
	if($.isNumeric(cf.substr(0,1)))
	  {
      ret=ControllaPIVA(cf);
	  }
	else
	  {
      ret=ControllaCF(cf);
	  }
	if(ret !=""){
		alert(ret);
	}
}
</script>