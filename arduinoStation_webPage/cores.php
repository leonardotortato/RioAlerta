<?php
include_once 'conexao.php';

// Executar uma consulta SQL para buscar o último registro
$sql = "SELECT * FROM dados ORDER BY id DESC LIMIT 1"; // Supondo que o campo de ID seja 'id'
$result = $conn->query($sql);

// Definir $relatorioColor com um valor padrão
$relatorioColor = '#7ED957';

// Exibir na tela
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $relatorio = $row['relatorio'];

    // Determinar a cor da caixa com base no valor de $relatorio
    if (isset($relatorio)) {
        if ($relatorio === 'Moderado') {
            $relatorioColor = '#FFCE6D';
        } elseif ($relatorio === 'Alto') {
            $relatorioColor = '#FB1641';
        }
    }
}
?>
