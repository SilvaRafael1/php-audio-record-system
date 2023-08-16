<?php
// session_start();
// if (!isset($_SESSION['loggedin'])) {
//     header('Location: index.php');
//     exit;
// }
?>

<head>
    <link rel="stylesheet" href="../../../CSS/global.css">
    <link rel="icon" type="image/x-icon" href="../../img/icon_logo.png">
    <?php
    $p = basename(getcwd()) . "\n";
    $replace = str_replace("_", " ", $p);
    echo "<title>Admin Page - $replace</title>";
    ?>
</head>


<div class="pn-tela">
    <div class="pn-box">
        <?php
        function delete()
        {
            $p = basename(getcwd());
            $filename = $_POST['file_name'];
            unlink($filename);
            unlink("../../../$p/$filename");
            echo "Arquivo deletado com sucesso";
            echo "<form action='index.php'><input type='submit' value='Voltar' style='cursor: pointer;'></form>";
        }
        delete()
        ?>
    </div>
</div>