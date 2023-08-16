<?php
require("../require/db_login.php");
?>

<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/x-icon" href="./img/icon_logo.png">
    <link rel="stylesheet" href="../CSS/global.css">
    <title>Admin Page</title>
</head>

<body>
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
    <div class="container">
        <div class="main">
            <div class="equi-add">
                <span id="equi">Setores</span>
            </div>
            <div class="grid-container">
                <?php
                $dir = "./setores/";
                if (is_dir($dir)) {
                    if ($dh = opendir($dir)) {
                        while (($file = readdir($dh)) !== false) {
                            if ($file != "." && $file != ".." && $file != "JS" && $file != "CSS" && $file != "index.php" && $file != "base" && $file != "admin" && $file != "tic" && $file != "img" && $file != "require" && $file != "oracle") {
                                $faction = "goTo.php";
                                // $replace = str_replace("_", " ", $file);
                                // $replace = str_replace('p', "Posto ", $file);
                                $setor_nome = glob("./setores/$file/*.txt");
                                $setor_nome[0] = str_replace("./setores/$file/", "", $setor_nome[0]);
                                $setor_nome[0] = str_replace(".txt", "", $setor_nome[0]);
                                $ftype = "submit";
                                echo "<div class='grid-item'>";
                                echo "<form action=$faction method='post'> <input type='text' name='setor' value='$file' hidden> <input type=$ftype value='$setor_nome[0]' style='cursor: pointer; padding: 20px; width: 100%; border: 0; text-transform: capitalize;'> </form>";
                                echo "</div>";
                            }
                        }
                        closedir($dh);
                    }
                }
                ?>
            </div>
            <hr>
            <div class="divCreateUser">
                <div class="createUserTitle">
                    <span id="equi">Criar usuário</span>
                </div>
                <form action="createUser.php" method="post" class="createUser">
                    <div><p>Usuário:</p> <input type="text" name="username" required></div>
                    <div><p>Senha:</p> <input type="text" name="password" required></div>
                    <!-- <div><p>Setor:</p> <input type="text" name="setor" required></div> -->
                    <div><p>Setor:</p> <select name="setor" id="" required>
                        <option value="co">Centro Obstetrico</option>
                        <option value="p1a">Unidade de Internação 1A</option>
                        <option value="p2a">Unidade de Internação 2A</option>
                        <option value="p2b">Unidade de Internação 2B</option>
                        <option value="p2c">Unidade de Internação 2C</option>
                        <option value="p4">Unidade de Internação 4</option>
                        <option value="p5">Unidade de Internação 5</option>
                        <option value="p6">Unidade de Internação 6</option>
                        <option value="p7">Unidade de Internação 7</option>
                    </select></div>
                    <input type="submit" value="Criar">
                </form>
            </div>
        </div>
    </div>
</body>