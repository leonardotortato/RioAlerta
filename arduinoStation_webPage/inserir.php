<?php

include_once 'conexao.php';

// Dados vindos do Arduino
$valorSensor = $_GET["sensor"];
$valorStatus = $_GET["relatorio"];

// Preparar e executar a consulta SQL para inserir os dados
$sql = "INSERT INTO dados (sensor, relatorio) VALUES ('$valorSensor', '$valorStatus')";

// Verificação
if ($conn->query($sql) === TRUE) {
    echo "Dados inseridos com sucesso.";
} else {
    echo "Erro ao inserir os dados: " . $conn->error;
}

// Fechar a conexão com o banco de dados
$conn->close();
?>
