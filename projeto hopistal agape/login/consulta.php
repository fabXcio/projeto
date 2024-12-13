<?php
// Iniciar a sessão
session_start();

// Defina suas credenciais de banco de dados
$host = 'localhost'; 
$username = 'root'; 
$password = '1234'; 
$dbname = 'selilá'; 

// Conectar ao banco de dados
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obter dados do formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Sanitizar os dados
    $email = $conn->real_escape_string($email);
    $senha = $conn->real_escape_string($senha);

    // Verificar se o usuário existe no banco de dados
    $sql = "SELECT * FROM usuarios WHERE email = '$email' LIMIT 1";
    $result = $conn->query($sql);

    // Verificar se o usuário foi encontrado
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verificar a senha
        if (password_verify($senha, $user['senha'])) {
            // Iniciar sessão e armazenar dados do usuário
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];

            // Verificar qual página redirecionar com base no email
            if (strpos($user['email'], '@cliente.com') !== false) {
                // Se o e-mail contiver '@cliente.com', é um cliente
                header("Location: ../hospital/cliente.html"); // Página do cliente
            } elseif (strpos($user['email'], '@medico.com') !== false) {
                // Se o e-mail contiver '@medico.com', é um médico
                header("Location: ../hospital/medico.html"); // Página do médico
            } else {
                // Caso não seja nem cliente nem médico
                echo "Email não reconhecido como cliente ou médico.";
            }
            exit;
        } else {
            // Senha incorreta
            echo "Email ou senha incorretos.";
        }
    } else {
        // Usuário não encontrado
        echo "Email ou senha incorretos.";
    }
}

$conn->close();
?>
