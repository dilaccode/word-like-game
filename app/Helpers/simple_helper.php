<?php
/// add by Di Lac

/// type: Param=data1_data2_data3
function GETDataUrlToArray($Param){
    $ArrayResult = array();
    if(!empty($_GET[$Param])){
            $StrValue = $_GET[$Param];
            $ArrayResult = explode("_",$StrValue);
    }
    return $ArrayResult; 
}
/// result: array[0]_array[1]...
function ArrayToGETDataUrl($Param,$Array){
    $Value = count($Array)>0 ? implode("_",$Array) : "";
    return "$Param=$Value";
}