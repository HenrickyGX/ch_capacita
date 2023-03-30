<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$nome = $_POST['nome'];
	$local = $_POST['local'];
	$email = $_POST['email'];
	$telefone = $_POST['telefone'];
	$curso = $_POST['curso'];
	$data = $_POST['data'];
	$descricao = $_POST['descricao'];

	// estabelece conexão com o banco de dados
	$host = 'localhost';
	$dbname = 'chcapacita';
	$user = 'root';
	$pass = '';
	$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
	$options = [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES => false,
	];
	try {
		$pdo = new PDO($dsn, $user, $pass, $options);
	} catch (\PDOException $e) {
		throw new \PDOException($e->getMessage(), (int)$e->getCode());
	}

	try {
		$stmt = $pdo->prepare('INSERT INTO solicitacoes (nome, local, email, telefone, curso, data, descricao) VALUES (:nome, :local, :email, :telefone, :curso, :data, :descricao)');
		$stmt->execute(['nome' => $nome,'local' =>$local, 'email' => $email, 'telefone' => $telefone, 'curso' => $curso, 'data' => $data, 'descricao' => $descricao]);

		echo 'Formulário enviado com sucesso!';
	} catch (\PDOException $e) {
		echo 'Erro ao inserir os dados na tabela: ' . $e->getMessage();
	}

	// redireciona o usuário para a mesma página após o envio do formulário
	header('Location: ' . $_SERVER['PHP_SELF']);
	exit;
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="style.css">

	<title>-Solicitações de Capacitações Médicas-</title>
</head>

<body>
<nav>
  <ul>
    <li><a href="index.php">Solicitações</a></li>
    <li><a href="agenda.php">Agenda</a></li>
  </ul>
</nav>

    <div class="container">
        <h1>Solicitações de Capacitações</h1>
        <form method="POST">
            <label for="nome">Nome completo:</label>
            <input type="text" id="nome" name="nome" required>

			<label for="local">Local:</label>
			<input type="text" id="local" name="local" required>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>

            <label for="telefone">Telefone:</label>
            <input type="tel" id="telefone" name="telefone" required>

            <label for="curso">Curso:</label>
            <select id="curso" name="curso" required>
                <option value="">Selecione um curso</option>
                <option value="grupo1">Grupo 1</option>
                <option value="grupo2">Grupo 2</option>
                <option value="grupo3">Grupo 3</option>
            </select>

            <label for="data">Data:</label>
            <input type="date" id="data" name="data" required>

            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao"></textarea>

            <input type="submit" value="Agendar">
        </form>
    </div>
    
</body>

</html>