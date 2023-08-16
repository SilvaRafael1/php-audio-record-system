<?php 
require("../require/db_login.php");
$setor = $_POST['setor'];

function custom_copy($src, $dst) { 
    $setor = $_POST['setor'];
  
    // open the source directory
    $dir = opendir($src); 
  
    // Make the destination directory if not exist
    @mkdir($dst); 
  
    // Loop through the files in source directory
    while( $file = readdir($dir) ) { 
  
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) 
            { 
  
                // Recursively calling custom copy function
                // for sub directory 
                custom_copy($src . '/' . $file, $dst . '/' . $file); 
  
            } 
            else { 
                copy($src . '/' . $file, $dst . '/' . $file); 
            } 
        } 
    } 
  
    closedir($dir);
    header("location: ./setores/$setor/");
} 
  
$src = "../$setor/uploads/";
  
$dst = "./setores/$setor/uploads/";
  
custom_copy($src, $dst);

$src2 = "../$setor/audios-after-1-day/";
  
$dst2 = "./setores/$setor/audios-after-1-day/";
  
custom_copy($src2, $dst2);
  
?>