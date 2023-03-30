<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Capacitação</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Editar Capacitação</h1>
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
            try {
                // atualiza o registro no banco de dados
                $stmt = $pdo->prepare('UPDATE solicitacoes SET local = :local, descricao = :descricao WHERE id = :id');
                $stmt->execute([
                    'id' => $_POST['id'],
                    'local' => $_POST['local'],
                    'descricao' => $_POST['descricao'],
                    
                ]);
                echo '<p class="success-msg">Capacitação atualizada com sucesso!</p>';
            } catch (\PDOException $e) {
                echo '<p class="error-msg">Erro ao atualizar capacitação: ' . $e->getMessage() . '</p>';
            }
        }

        // busca o registro com o ID informado
        $id = $_GET['id'];
        $stmt = $pdo->prepare('SELECT * FROM solicitacoes WHERE id ');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        // verifica se existe um registro com o ID informado
        if (!$row) {
            echo '<p class="error-msg">Registro não encontrado.</p>';
            exit;
        }

        // exibe o formulário com os dados do registro
        ?>
        <form action="edit.php" method="post">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <label for="local">Local:</label>
            <input type="text" name="local" id="local" value="<?php echo $row['local']; ?>">
            <label for="descricao">Descrição:</label>
            <textarea name="descricao" id="descricao"><?php echo $row['descricao']; ?></textarea>
            <input type="submit" name="submit" value="Salvar">
        </form>
    </div>
</body>

</html>