<?php
require("../require/db_login.php");

$dir = "./pre-upload";
$files = scandir($dir);
$info = scandir("./info");
$audio = $files[2];
$dataNascTxt = $info[2];
$dataNasc = str_replace(".txt", "", $dataNascTxt);
$pacienteTxt = $info[3];
$paciente = str_replace(".txt", "", $pacienteTxt);

unlink("./info/$dataNascTxt");
unlink("./info/$pacienteTxt");

// $boldAbre = "BOLDABRE123strongBOLDFECHA123";
// $boldFecha = "BOLDABRE123BARRAstrongBOLDFECHA123";

$rename_from = "$dir/$audio";
$rename_to = "$dir/Nome do Paciente& " . $paciente . " abcde123 Data de Nascimento& " . $dataNasc . " abcde123 " . $audio;
$copy_to = "./uploads/Nome do Paciente& " . $paciente . " abcde123 Data de Nascimento& " . $dataNasc . " abcde123 " . $audio;

rename($rename_from, $rename_to);
copy($rename_to, $copy_to);
unlink($rename_to);

header("Location: index.php");