<?php
    include("importUnits.php");
    header("Content-type: text/css");
    $path = "./";
    $components = $_GET["components"];
    $components = explode(",", $components);
    
    $skins = $_GET["skins"];
    $skins = explode(",", $skins);
    
    $finalStr = "";
    foreach ($components as $component) {
        $componentPath = $path . "components/base/" . $component . "/".$component.".css";
        if(is_file($componentPath)){
            $componentFileContent = file_get_contents($componentPath) . "\n";
            // $finalStr .= replaceunitName($unitFileContent, $unit, $skin);
            $dependency = importDependency($componentFileContent);
            $finalStr .= $dependency["content"];
            $finalStr .= "/** ". $component ." Start **/\n";
            $finalStr .= $componentFileContent;
            $finalStr .= "/** ". $component ." End **/\n";
        
            foreach ($skins as $skin) {
                $skinPath = $path . "components/".$skin."/" . $component . "/".$component.".css";
                if(is_file($skinPath)){
                    $finalStr .= "/** ". $component ." " .$skin. " Skin Start **/\n";
                    $skinFileContent = file_get_contents($skinPath) . "\n";
                    $finalStr .= $skinFileContent;
                    $finalStr .= getUnitsContent($dependency["units"], false, array($skin));
                    $finalStr .= "/** ". $component ." " .$skin. " Skin End **/\n";
                }
            }
        }
    }
    
    echo $finalStr;

    function replaceToDependency($matches){
        $units = explode(',', $matches[1]);
        return getUnitsContent($units);        
    }
    function importDependency($content){
        $unitsStr = "";
        $pattern = "/\/\*\*\s*@import\s+units\s*:\s+\[(.+)\]\s+\*\*\//";
        preg_match_all($pattern, $content, $out, PREG_PATTERN_ORDER);
        $units = explode(',', $out[1][0]);
        return array(
            "content" => getUnitsContent($units),
            "units" => $units
        );;
        // echo preg_replace_callback($pattern, "replaceToDependency", $content);
    }
?>