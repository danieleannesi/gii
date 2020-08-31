<?php
function closediv($divname) {
	$html ="<img src=\"immagini/divclose.png\" class=\"xclose\" onclick=\"closediv('$divname');\" title=\"chiudimi\" />";
	return $html;
}
//
function showpopup3($prefix,$title,$content,$options=array()) {
    $refer="none";
	extract($options);
	//$position="$ax;$ay";
	$position="under";
	if($prefix!=""){
		$prefix=" id=\"$prefix\" ";
	}
	$xml_code="<popup $prefix >";
	if($content!="") {
		$xml_code.="<content><![CDATA[$content]]></content>";
	}
	$xml_code.="<title><![CDATA[$title]]></title>";
	$xml_code.="<position dove=\"$position\">$refer</position>";
	$xml_code.="<type>$type</type>";
	$xml_code.="</popup>";
	//file_put_contents("popup3.xml", $xml_code);
	return $xml_code;
}
function showpopupe($prefix,$title,$content,$options=array()) {
    $refer="none";
	extract($options);
	$position="$ax;$ay";
	if($prefix!=""){
		$prefix=" id=\"$prefix\" ";
	}
	$xml_code="<popupe $prefix >";
	if($content!="") {
		$xml_code.="<content><![CDATA[$content]]></content>";
	}
	$xml_code.="<title><![CDATA[$title]]></title>";
	$xml_code.="<position dove=\"$position\">$refer</position>";
	$xml_code.="<type>$type</type>";
	$xml_code.="</popupe>";
	return $xml_code;
}
?>