<?php
require("../require/db_login.php");
?>

<head>
    <link rel="stylesheet" href="./css/global.css">
    <title>Admin Page - Adicionar Setor</title>
    <link rel="icon" type="image/x-icon" href="./img/icon_logo.png">
</head>

<div class="pnc-tela">
    <div class="pnc-box">
        <?php
        $setor_abv = strtolower($_POST['abv_setor']);
        if ($setor_abv != " " && $setor_abv != "") {
            function addSetor($dir) {
                // usuario
                $setor = $_POST['setor'];
                mkdir("../$dir");
                mkdir("../$dir/info/");
                mkdir("../$dir/uploads/");
                mkdir("../$dir/pre-upload/");
                mkdir("../$dir/audios-after-1-day/");
                copy("../base/index.php", "../$dir/index.php");
                copy("../base/save.php", "../$dir/save.php");
                copy("../base/delete.php", "../$dir/delete.php");
                copy("../base/delete_30d.php", "../$dir/delete_30d.php");
                copy("../base/move-audio.php", "../$dir/move-audio.php");
                copy("../base/logout.php", "../$dir/logout.php");
                copy("../base/pre-upload.php", "../$dir/pre-upload.php");
                copy("../base/record.php", "../$dir/record.php");
                copy("../base/post-record.php", "../$dir/post-record.php");
                fopen("../$dir/$setor.txt", 'w');
                
                // admin
                $setor = $_POST['setor'];
                mkdir("../adm/setores/$dir");
                mkdir("../adm/setores/$dir/uploads/");
                mkdir("../adm/setores/$dir/audios-after-1-day/");
                copy("../base_admin/index.php", "../adm/setores/$dir/index.php");
                copy("../base_admin/delete.php", "../adm/setores/$dir/delete.php");
                fopen("../adm/setores/$dir/$setor.txt", 'w');
                header("location: index.php");
            }
            addSetor($setor_abv);
        } else {
            echo "Nome de Setor Inválido";
            echo "<form action='index.php'><input type='submit' value='Voltar' style='cursor: pointer'></form>";
        }
        ?>
    </div>
</div>