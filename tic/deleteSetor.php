<?php
require("../require/db_login.php");
?>

<head>
    <link rel="stylesheet" href="./css/global.css">
    <title>Admin Page - Deletar Setor</title>
    <link rel="icon" type="image/x-icon" href="./img/icon_logo.png">
</head>

<div class="pnc-tela">
    <div class="pnc-box">
        <?php
        $setor_abv = strtolower($_POST['abv_setor']);
        if ($setor_abv != " " && $setor_abv != "") {
            function deletarSetor($dir) {
                array_map('unlink', glob("../$dir/uploads/*.*"));
                array_map('unlink', glob("../$dir/*.*"));
                rmdir("../$dir/uploads");
                rmdir("../$dir/pre-upload");
                rmdir("../$dir/info");
                rmdir("../$dir/audios-after-1-day");
                rmdir("../$dir");
                
                array_map('unlink', glob("../adm/setores/$dir/uploads/*.*"));
                array_map('unlink', glob("../adm/setores/$dir/*.*"));
                rmdir("../adm/setores/$dir/uploads");
                rmdir("../adm/setores/$dir/audios-after-1-day");
                rmdir("../adm/setores/$dir");
                header("location: index.php");
            }
            deletarSetor($setor_abv);
        } else {
            echo "Nome de Setor Inválido";
            echo "<form action='index.php'><input type='submit' value='Voltar' style='cursor: pointer'></form>";
        }
        ?>
    </div>
</div>