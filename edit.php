<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Solicitação</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Editar Solicitação</h1>
        <?php
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

            // verifica se o formulário foi enviado
            if (isset($_POST['submit'])) {
                $id = $_POST['id'];
                $nome = $_POST['nome'];
                $local = $_POST['local'];
                $descricao = $_POST['descricao'];
            
                try {
                    // atualiza o registro com os novos valores
                    $stmt = $pdo->prepare('UPDATE solicitacoes SET nome = :nome, local = :local, descricao = :descricao WHERE id = :id');
                    $stmt->execute(['id' => $id, 'nome' => $nome, 'local' => $local, 'descricao' => $descricao]);
                    echo '<p class="success-msg">Solicitação atualizada com sucesso!</p>';
                    echo '<script>window.location.href = "agenda.php";</script>'; // redireciona para a página de agendas
                } catch (\PDOException $e) {
                    echo '<p class="error-msg">Erro ao atualizar solicitação: ' . $e->getMessage() . '</p>';
                }
            }
            

            // busca o registro com o ID informado
            $id = $_GET['id'];
            $stmt = $pdo->prepare('SELECT * FROM solicitacoes WHERE id = :id');
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch();
        ?>

        <form method="post">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" value="<?php echo $row['nome']; ?>" required>
            <label for="local">Local:</label>
            <input type="text" name="local" id="local" value="<?php echo $row['local']; ?>" required>
            <label for="descricao">Descrição:</label>
            <textarea name="descricao" id="descricao" required><?php echo $row['descricao']; ?></textarea>
            <input type="submit" name="submit" value="Salvar">
            <a href="index.php">Cancelar</a>
        </form>
    </div>
</body>
</html>
