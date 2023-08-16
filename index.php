<head>
    <link rel="stylesheet" href="./CSS/index.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <title>Passagem de Plantão - Login</title>
</head>

<div class="container">
    <div class="login">
        <h1>Passagem de Plantão</h1>
        <hr>
        <form action="authenticate.php" method="post">
            <label for="username">
                <i class="fas fa-user"></i>
            </label>
            <input type="text" name="username" placeholder="Usuário" id="username" required>
            <label for="password">
                <i class="fas fa-lock"></i>
            </label>
            <input type="password" name="password" placeholder="Senha" id="password" required>
            <input type="submit" value="Entrar">
        </form>
    </div>
</div>

<?php
