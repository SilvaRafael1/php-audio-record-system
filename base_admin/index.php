<?php
require("../../../require/db_login.php");
?>

<head>
    <title>Passagem de Plantão</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../../CSS/global.css">
</head>

<header>
    <div class="title">
        PASSAGEM DE PLANTÃO
    </div>
    <div class="login">
        <form action='../../index.php'>
            <input type='submit' value='Voltar'>
        </form>
    </div>
</header>

<body>
    <article>

        <div class="container">
            <div class="main">

                <div class="files-container">
                    <?php
                    $files = glob('uploads/*');
                    usort($files, function ($a, $b) {
                        return filemtime($b) - filemtime($a);
                    });
                    foreach ($files as $file) {
                        $audio = str_replace("abcde123", "<br>", basename($file));
                        $audio2 = str_replace("&", ":", $audio);
                        $audio3 = str_replace(".wav", "", $audio2);

                        printf(
                            "<div class='container-files'><div class='container-files-esquerda'>" . $audio3 . "</div><div><audio controls controlsList='nodownload'><source src='$file' type='audio/mpeg'></audio></div><div class='container-fd'><form method='post' action='delete.php'><input type='hidden' name='file_name' value='" . $file . "'><input type='submit' name='delete_file' value=' < Deletar arquivo' class='container-files-delete'></form></div></div>",
                            $audio3
                        );
                    };

                    $directory = "uploads/";
                    $filecount = count(glob($directory . "*"));
                    if ($filecount === 0) {
                        echo '<p style="color: white;">Não foi encontrado nenhum áudio<p>';
                    }
                    ?>
                </div>
                <hr>
                <div class='equi-add'>
                    <span id='equi'>Áudios não visíveis</span>
                </div>
                <div class="files-container">
                    <?php
                    $files = glob('audios-after-1-day/*');
                    usort($files, function ($a, $b) {
                        return filemtime($b) - filemtime($a);
                    });
                    foreach ($files as $file) {
                        $audio = str_replace("abcde123", "<br>", basename($file));
                        $audio2 = str_replace("&", ":", $audio);
                        $audio3 = str_replace(".wav", "", $audio2);

                        printf(
                            "<div class='container-files'><div class='container-files-esquerda'>" . $audio3 . "</div><div><audio controls controlsList='nodownload'><source src='$file' type='audio/mpeg'></audio></div><div class='container-fd'><form method='post' action='delete.php'><input type='hidden' name='file_name' value='" . $file . "'><input type='submit' name='delete_file' value=' < Deletar arquivo' class='container-files-delete'></form></div></div>",
                            $audio3
                        );
                    };

                    $directory = "audios-after-1-day/";
                    $filecount = count(glob($directory . "*"));
                    if ($filecount === 0) {
                        echo '<p style="color: white;">Não foi encontrado nenhum áudio<p>';
                    }
                    ?>
                </div>
            </div>
        </div>
</body>

</html>