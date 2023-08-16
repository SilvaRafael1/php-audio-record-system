<?php
$days = 30;
$dir = "audios-after-1-day";

    if ($handle = opendir($dir)) {
    while (( $file = readdir($handle)) !== false ) {
        if ( $file == '.' || $file == '..' || is_dir($dir.'/'.$file) ) {
            continue;
        }

        if ((time() - filemtime($dir.'/'.$file)) > ($days * 86400)) {
            unlink($dir.'/'.$file);
        }
    }
    closedir($handle);
}

?>