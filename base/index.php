<?php
require("../require/db_login.php");
require("./move-audio.php");
require("./delete_30d.php");
?>

<head>
    <title>Passagem de Plantão</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../CSS/global.css">
    <link rel="shortcut icon" href="../img/phone.png" type="image/x-icon">
</head>

<header>
    <div class="title">
        PASSAGEM DE PLANTÃO
    </div>
    <div class="login">
        <form action='logout.php'>
            <input type='submit' value='Sair da Sessão'>
        </form>
    </div>
</header>

<body>
    <div class="container">
        <div class="main">
            <div style="display: flex; justify-content: center;">
                <div class="gravarAudio">
                    <form action='pre-upload.php'>
                        <input type='submit' value='Gravar Áudio'>
                    </form>
                </div>
            </div>
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
                        " <div class='container-files'>" . $audio3 . "<audio controls controlsList='nodownload'><source src='$file' type='audio/mpeg'></audio></div>",
                        $audio3,
                        date('F d Y, H:i:s', filemtime($file))
                    );
                };

                $directory = "uploads/";
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