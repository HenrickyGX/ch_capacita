<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda de Capacitações</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Agenda de Capacitações</h1>
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

            // verifica se algum registro foi editado ou excluído
                    // verifica se algum registro foi editado ou excluído
        if (isset($_GET['action'])) {
            $id = $_GET['id'];
            $action = $_GET['action'];
            if ($action == 'edit') {
                // redireciona o usuário para a página de edição do registro
                header('Location: edit.php?id=1' . $id);
                exit;
            } elseif ($action == 'delete') {
                try {
                    // exclui o registro com o ID informado
                    $stmt = $pdo->prepare('DELETE FROM solicitacoes WHERE id = :id');
                    $stmt->execute(['id' => $id]);
                    echo '<p class="success-msg">Solicitação excluída com sucesso!</p>';
                } catch (\PDOException $e) {
                    echo '<p class="error-msg">Erro ao excluir solicitação: ' . $e->getMessage() . '</p>';
                }
            }
        }

        // busca todos os registros na tabela solicitacoes 
        $stmt = $pdo->query('SELECT * FROM solicitacoes');
        if ($stmt->rowCount() > 0) {
            echo '<table>';
            echo '<tr><th>ID</th><th>Nome</th><th>Local</th><th>Descrição</th><th>Ações</th></tr>';
            while ($row = $stmt->fetch()) {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['nome'] . '</td>';
                echo '<td>' . $row['local'] . '</td>';
                echo '<td>' . $row['descricao'] . '</td>';
                echo '<td>';
                echo '<a href="?id=' . $row['id'] . '&action=edit">Editar</a>';
                echo ' | ';
                echo '<a href="?id=' . $row['id'] . '&action=delete">Excluir</a>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</table>';

            } else {
                echo 'Nenhum registro encontrado.';
            }