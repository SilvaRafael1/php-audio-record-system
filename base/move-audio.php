<?php
$days = 1;
$dir = "uploads";

    if ($handle = opendir($dir)) {
    while (( $file = readdir($handle)) !== false ) {
        if ( $file == '.' || $file == '..' || is_dir($dir.'/'.$file) ) {
            continue;
        }

        if ((time() - filemtime($dir.'/'.$file)) > ($days * 86400)) {
            copy($dir.'/'.$file, "./audios-after-1-day/$file");
            unlink($dir.'/'.$file);
        }
    }
    closedir($handle);
}

?>