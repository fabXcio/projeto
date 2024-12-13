<?php
// Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "selilá";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obter os dados do formulário
    $tipoUsuario = $_POST['tipoUsuario'];

    // Proteção contra SQL Injection: usar prepared statements
    if ($tipoUsuario == "cliente") {
        $nomeCliente = $conn->real_escape_string($_POST['nomeCliente']);
        $emailCliente = $conn->real_escape_string($_POST['emailCliente']);
        $telefoneCliente = $conn->real_escape_string($_POST['telefoneCliente']);
        $localidade  = $conn->real_escape_string($_POST['localidade'])
        
        // Inserir os dados no banco de dados para cliente
        $sql = $conn->prepare("INSERT INTO clientes (nome, email, telefone, localidade) VALUES (?, ?, ?, ?)");
        $sql->bind_param("sss", $nomeCliente, $emailCliente, $telefoneCliente,$localidade);
        $sql->execute();
    } elseif ($tipoUsuario == "funcionario") {
        $medico = $conn->real_escape_string($_POST['medico']);
        $crm = $conn->real_escape_string($_POST['crm']);
        $area = $conn->real_escape_string($_POST['area']);
        
        // Inserir os dados no banco de dados para funcionário
        $sql = $conn->prepare("INSERT INTO funcionarios (nome, crm, area) VALUES (?, ?, ?)");
        $sql->bind_param("ssd", $nomeFuncionario, $crm, $area);
        $sql->execute();
    }

    // Fechar a conexão
    $sql->close();
    $conn->close();

    echo "Cadastro realizado com sucesso!";
}
?>
