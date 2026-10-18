<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>RioAlerta</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="estilo.css" media="screen" />
</head>

<body>
    <p class="titulo">
        Monitoramento
    </p>
    <div class="caixa1" style="background-color: rgba(188, 215, 255, 1)">
        <p class="escrita1">
            Nível da água
        </p>
        <p class="nivel">

            <?php
            include_once 'conexao.php';

            // Executar uma consulta SQL para buscar o último registro
            $sql = "SELECT * FROM dados ORDER BY id DESC LIMIT 1";
            $result = $conn->query($sql);

            // Exibir na tela
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $sensor = $row['sensor'];
                echo "<span>" . $sensor . " mm</span>";
            } else {
                echo "<span>Nenhum dado encontrado</span>";
            }
            ?>

        </p>
    </div>
    <?php include_once 'cores.php'; ?>
    <div class="caixa2" style="background-color: <?php echo $relatorioColor; ?>">
        <p class="escrita2">
            Risco de alagamento
        </p>
        <p class="risco">

            <?php
            // Executar uma consulta SQL para buscar o último registro
            $sql = "SELECT * FROM dados ORDER BY id DESC LIMIT 1";
            $result = $conn->query($sql);

            // Exibir na tela
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $relatorio = $row['relatorio'];
                echo "<span>" . $relatorio . "</span>";
            } else {
                echo "<span>Nenhum dado encontrado</span>";
            }

            // Fechar a conexão com o banco de dados
            $conn->close();
            ?>

        </p>
    </div>
    <img src="logo.png" width="230" height="230" class="logo">
</body>

</html>