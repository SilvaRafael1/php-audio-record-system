<?php

$paciente = $_POST['paciente'];
$dataNasc_input = $_POST['dataNasc'];
$dataNasc_change = explode("-", $dataNasc_input);
$dataNasc_reverse = array_reverse($dataNasc_change);
$dataNasc = implode("-", $dataNasc_reverse);

$dir = "./pre-upload";
$files = scandir($dir);
$audio = $files[2];

// $boldAbre = "BOLDABRE123strongBOLDFECHA123";
// $boldFecha = "BOLDABRE123BARRAstrongBOLDFECHA123";

$rename_from = "$dir/$audio";
$rename_to = "$dir/Nome do Paciente& " . $paciente . " abcde123 Data de Nascimento& " . $dataNasc . " abcde123 " . $audio;
$copy_to = "./uploads/Nome do Paciente& " . $paciente . " abcde123 Data de Nascimento& " . $dataNasc . " abcde123 " . $audio;

rename($rename_from, $rename_to);
copy($rename_to, $copy_to);
unlink($rename_to);

header("Location: index.php")

?>