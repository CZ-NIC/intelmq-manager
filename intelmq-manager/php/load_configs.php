<?php

    require('config.php');

    $filename = False;
    $config_text = 'Unknown resource';

    if (array_key_exists($_GET['file'], $FILES)) {
        header('Content-Type: application/json');
        $filename = $FILES[$_GET['file']];
    } else{
        $wanted_file = realpath($_GET["file"]);// sanitize the path
        if(strpos($wanted_file, $ALLOWED_PATH) === 0) {
            $filename = $wanted_file;
        }
    }

    if($filename) {
        if(is_dir($filename)) {
            $config_text = "**** Directory $filename\n";
            foreach(glob($filename."/*") as $f) {
                $config_text .= "*** File: ".basename($f)."\n";
                $config_text .= file_get_contents($f);
            }
        } else {
            $config_text = file_get_contents($filename);
        }
    }

    echo $config_text;
