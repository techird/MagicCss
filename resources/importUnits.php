<?php
    header("Content-type: text/css");
    
    /*
    $units = $_GET["units"];
    $units = explode(",", $units);
    $skins = $_GET["skin"];
    $skins = explode(",", $skins);
    $base = $_GET["base"] != 'false' ? true : false;
    */
    
    function getUnitsContent($units, $base = true, $skins = array()){
        $path = "./units/";
        $finalStr = "";
        foreach ($units as $unit) {
            $unit = trim($unit);
            $unitPath = $path . "base/" . $unit . ".css";
            if($base && is_file($unitPath)){
                $finalStr .= "/** unit ". $unit ." Start **/\n";
                $unitFileContent = file_get_contents($unitPath) . "\n";
                $finalStr .= $unitFileContent;
                $finalStr .= "/** unit ". $unit ." End **/\n";
            }
            
            foreach ($skins as $skin) {
                $skin = trim($skin);
                $skinPath = $path . $skin . "/" . $unit . ".css";
                if(is_file($skinPath)){
                    $finalStr .= "/** unit ". $unit ." " .$skin. " Skin Start **/\n";
                    $skinFileContent = file_get_contents($skinPath) . "\n";
                    $finalStr .= replaceSkinName($skinFileContent, $unit, $skin);
                    $finalStr .= "/** unit ". $unit ." " .$skin. " Skin End **/\n";
                }
            }
        }
        return $finalStr;
    }

    // return getUnitsContent($units, $base, $skins);

    function p($i){
        echo "<pre>";
        print_r($i);
        echo "</pre>";
    }
   
    
    function replaceSkinName($string, $unit, $skin){
        $pattern = "/.(tang\-unit\-".$unit.")/i";
        $replacement = ($skin == "default" ? "" : (".tang-" . $skin." ") ). ".$1";
        return preg_replace($pattern, $replacement, $string);
    }
    
    
    
    
?>