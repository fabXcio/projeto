
<?php

#codigo php para enviar feedback da pagina principal para o banco de dados

$conn = new mysqli = ("localhost","root","1234","feedback");

if ($conn -> error_connect){
    die("erro de conexão :".$conn -> error_connect);
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $contato = $_POST['contato'];
    $feedback = $_POST['feedback'];

    $sql = ("INSERT INTO comentario(nome,email,contato,feedback) VALUES ($nome,$email,$contato,$feedback)");
    
    $conn -> close();
}
?>