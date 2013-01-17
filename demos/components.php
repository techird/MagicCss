<?php
    $path = "../resources/components/base/";
    $fileList = array();
    $handle = opendir($path);
    $componentsQueryString = "";
    while($name = readdir($handle)){
        if($name != "." && $name != ".."){
            $filePath = $name . "/" . $name . ".html";
            is_file($path.$filePath) && $fileList[$name] = $path.$filePath;
            $componentsQueryString .= $name . ',';
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>all</title>
        <link rel="stylesheet" href="../resources/units/base/reset.css" />
        <link rel="stylesheet" href="../resources/import.php?components=<?php echo $componentsQueryString?>&skins=default" />
        <link rel="stylesheet" href="../resources/units/default/common.css" />
        <style>
            body {
                font: 12px/1.5 tahoma, arial, \5b8b\4f53;;
            }
            #wrapper {
                padding: 20px;
                margin: 20px;
            }
            #wrapper .item {
                padding: 10px 20px 30px;
                border: 1px dotted #76A2FF;
                margin: 20px;
            }
            #wrapper .item h2 {
                font-size: 18px;
                padding-bottom: 10px;
                color: #1581A4;
                margin-bottom: 20px;
                border-bottom: 2px solid #197BC1;
            }
        </style>
    </head>
    <body>
        <div class="mg">
            <div class="default" id="wrapper">
                <?php
                foreach($fileList as $name => $filePath){
                ?>
                <div class="item">
                    <h2><?php echo $name ?></h2>
                    <?php echo file_get_contents($filePath) ?>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </body>
</html>
