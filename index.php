<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$nome = $_POST['nome'];
	$local = $_POST['local'];
	$email = $_POST['email'];
	$telefone = $_POST['telefone'];
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
	// consulta todos os registros da tabela local
	try {
		$stmt = $pdo->query('SELECT * FROM `local`');
		$locais = $stmt->fetchAll();
		print_r($locais);
	} catch (\PDOException $e) {
		echo 'Erro ao consultar os dados na tabela: ' . $e->getMessage();
	}

	try {
		$stmt = $pdo->prepare('INSERT INTO solicitacoes (nome, local, email, telefone, data, descricao) VALUES (:nome, :local, :email, :telefone, :data, :descricao)');
		$stmt->execute(['nome' => $nome, 'local' => $local, 'email' => $email, 'telefone' => $telefone, 'data' => $data, 'descricao' => $descricao]);

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
			<label for="nome" aria-label="Nome completo">
				<input type="text" id="nome" name="nome" required>


				<label for="email">E-mail:</label>
				<input type="email" id="email" name="email" required>

				<label for="telefone">Telefone:</label>
				<input type="tel" id="telefone" name="telefone" required>

				<label for="local">Local:</label>
				<select id="local" name="local" required>
					<option value="">Selecione o local</option>
					<?php

					$conexao = mysqli_connect("localhost", "root", "", "chcapacita");
					$query = "SELECT id, nome FROM `local`";
					$resultado = mysqli_query($conexao, $query);
					while ($local = mysqli_fetch_assoc($resultado)) {
						echo "<option value='" . $local['id'] . "'>" . $local['nome'] . "</option>";
					}
					mysqli_close($conexao);
					?>
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