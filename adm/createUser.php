<head>
    <link rel="stylesheet" href="./CSS/index.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <title>Passagem de Plantão - Criar Usuário</title>
</head>

<?php
$username = $_POST['username'];
$password = $_POST['password'];
$setor = $_POST['setor'];

if (strlen($setor) > 3) {
    exit('Setor preenchido incorretamente');
};

session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'admin';
$DATABASE_NAME = 'plantao_admin';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Falha ao conectar ao banco de dados: ' . mysqli_connect_error());
}

if (!isset($_POST['username'], $_POST['password'], $_POST['setor'])) {
    exit('Preencha todos os campos!');
}

$sql = "SELECT id FROM users ORDER BY id DESC LIMIT 1";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $lastId = $row['id'] + 1;
    }
}

$sql = "SELECT username FROM users WHERE username = '$username'";

$result = $con->query($sql);
if ($result->num_rows > 0) {
    echo "Usuário já cadastrado";
} else {
    $sql = "INSERT INTO users VALUES ($lastId, '$username', '$password', '$setor')";
    $result = $con->query($sql);
    echo "Usuário criado";
}