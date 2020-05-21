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

/// game zone === >>>
// return array objects (level map)
//  Index = level
//  Exp = amount level exp
//  TotalExp = total exp for complete this level
function GetGameLevels($TotalLevel = 0){
    $INIT_EXP = 300;
    $INCREASE_EXP_PER_LEVEL	= 25;
    $Levels = array();
    $TotalExp = 0;
    // lv 0
    array_push($Levels, (object)array(
        "Exp" => 0,
        "TotalExp" => 0,
    ));
    for($Level = 1; $Level <= $TotalLevel; $Level++){
        $LevelExp =  $INIT_EXP + $Level * $INCREASE_EXP_PER_LEVEL;
        $TotalExp += $LevelExp;
        array_push($Levels, (object)array(
            "Exp" => $LevelExp,
            "TotalExp" => $TotalExp,
        ));
    }
    return $Levels;
}

function Debug($Var){
    var_dump($Var);
    die();
}


