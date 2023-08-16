<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informações do Paciente</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="../css/infoPaciente.css">
</head>

<body>
    <div class="login">
        <h1>Informações do Paciente</h1>
        <form action="pre-upload-auth.php" method="post">
            <label for="paciente">
                <i class="fas fa-user"></i>
            </label>
            <input type="text" name="paciente" placeholder="Nome do Paciente" id="paciente" required>
            <label for="dataNasc">
                <i class="fa fa-calendar"></i>
            </label>
            <input type="date" name="dataNasc" placeholder="Senha" id="dataNasc" required>
            <input type="submit" value="Salvar">
        </form>
    </div>
</body>

</html>
