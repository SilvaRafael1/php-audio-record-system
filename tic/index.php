<?php
require("../require/db_login.php");
?>

<head>
    <meta charset="UTF-8" />
    <link rel="shortcut icon" href="../img/phone.png" type="image/x-icon">
    <link rel="stylesheet" href="../CSS/global.css">
    <title>Admin Page - TI</title>
</head>

<body>
    <header>
        <div class="title">
            ADMINISTRADOR TI
        </div>
        <div class="login">
            <form action='logout.php'>
                <input type='submit' value='Sair da Sessão'>
            </form>
        </div>
    </header>

    <div class="container">
        <div class="main">
            <form method="post" action='addSetor.php' class="addSetor">
                <input type='text' name="setor" placeholder="Nome do Setor">
                <input type='text' name="abv_setor" placeholder="Prefixo do Setor">
                <input type='submit' value='Adicionar Setor' id="addSetorBottom">
            </form>
            <hr>
            <form method="post" action='deleteSetor.php' class="addSetor">
                <input type='text' name="abv_setor" placeholder="Prefixo do Setor">
                <input type='submit' value='Deletar Setor' id="addSetorBottom">
            </form>
        </div>
    </div>

</body>