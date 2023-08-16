<head>
    <link rel="stylesheet" href="./CSS/index.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <title>Passagem de Plantão - Login</title>
</head>

<?php
session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'admin';
$DATABASE_NAME = 'plantao_admin';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Falha ao conectar ao banco de dados: ' . mysqli_connect_error());
}

if (!isset($_POST['username'], $_POST['password'])) {
    exit('Preencha todos os campos!');
}

if ($stmt = $con->prepare('SELECT id, password FROM users WHERE username = ?')) {
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        if ($_POST['password'] === $password) {
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;

            $sql = "SELECT setor from users where id = $id";
            $result = $con->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $setor = $row['setor'];
                    header("location: $setor/index.php");
                }
            } else {
                header("location: index.php");
            }
        } else {
            echo '<div class="container">';
            echo '<div class="login">';
            echo '<h1>Login</h1>';
            echo '<form action="index.php" method="post">';
            echo 'Nome de usuário ou senha incorreta!';
            echo '<input type="submit" value="Voltar">';
            echo '</form>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<div class="container">';
        echo '<div class="login">';
        echo '<h1>Login</h1>';
        echo '<form action="index.php" method="post">';
        echo 'Nome de usuário ou senha incorreta!';
        echo '<input type="submit" value="Voltar">';
        echo '</form>';
        echo '</div>';
        echo '</div>';
    }

    $stmt->close();
}
