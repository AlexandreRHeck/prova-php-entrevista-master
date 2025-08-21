<?php
echo "<div style='background:#f0f8ff;border:1px solid #b2d8b2;padding:15px;margin-bottom:20px;'>
    <h1>Bem-vinecho "</table>";

// ... Vinculação de cores pode ser adicionada abaixo ...e usuários</h1>
    <p>Utilize o formulário abaixo para cadastrar um novo usuário ou editar um existente.<br>
    Na tabela, você pode editar ou excluir usuários facilmente.<br>
    Todas as ações são feitas nesta mesma página, de forma simples e rápida.</p>
    <ul>
        <li>Para cadastrar, preencha os campos e clique em <b>Cadastrar usuário</b>.</li>
        <li>Para editar, clique em <b>Editar</b> ao lado do usuário desejado.</li>
        <li>Para excluir, clique em <b>Excluir</b> e confirme a ação.</li>
    </ul>
    <p style='color:#555;font-size:13px;'>Dica: Você pode atualizar a página a qualquer momento para ver as alterações.</p>
</div>";

require 'connection.php';
$connection = new Connection();

// Função para mostrar mensagens
function mostrarMensagem($msg) {
    echo "<div style='background:#e0ffe0;border:1px solid #b2d8b2;padding:10px;margin:10px 0;'>$msg</div>";
}

// Adicionar usuário
if (isset($_POST['add_user'])) {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    if ($name && $email) {
        $connection->query("INSERT INTO users (name, email) VALUES (?, ?)", [$name, $email]);
        mostrarMensagem("Usuário cadastrado com sucesso!");
    } else {
        mostrarMensagem("Por favor, preencha todos os campos!");
    }
}

// Editar usuário
if (isset($_POST['edit_user'])) {
    $id = $_POST['id'] ?? '';
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    if ($id && $name && $email) {
        $connection->query("UPDATE users SET name=?, email=? WHERE id=?", [$name, $email, $id]);
        mostrarMensagem("Usuário atualizado com sucesso!");
    }
}

// Excluir usuário
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $connection->query("DELETE FROM users WHERE id=?", [$id]);
    mostrarMensagem("Usuário excluído com sucesso!");
}

// Buscar usuário para edição
$editUser = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $connection->query("SELECT * FROM users WHERE id=?", [$id]);
    $editUser = $result ? $result[0] : null;
}

// Listar usuários
$users = $connection->query("SELECT * FROM users");

// Formulário de cadastro/edição
echo "<h2>" . ($editUser ? "Editar Usuário" : "Cadastrar Usuário") . "</h2>";
echo "<form method='post' style='margin-bottom:20px;'>";
if ($editUser) {
    echo "<input type='hidden' name='id' value='{$editUser->id}'>";
}
echo "<input type='text' name='name' placeholder='Nome completo' value='" . ($editUser ? $editUser->name : "") . "' required> ";
echo "<input type='email' name='email' placeholder='E-mail' value='" . ($editUser ? $editUser->email : "") . "' required> ";
if ($editUser) {
    echo "<button type='submit' name='edit_user'>Salvar alterações</button> ";
    echo "<a href='index.php'>Cancelar</a>";
} else {
    echo "<button type='submit' name='add_user'>Cadastrar usuário</button>";
}
echo "</form>";

// Tabela de usuários
echo "<h2>Lista de Usuários</h2>";
echo "<table border='1' cellpadding='8' style='border-collapse:collapse;'>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>E-mail</th>
        <th>Ações</th>
    </tr>";
foreach($users as $user) {
    echo "<tr>
        <td>{$user->id}</td>
        <td>{$user->name}</td>
        <td>{$user->email}</td>
        <td>
            <a href='?edit={$user->id}'>Editar</a> |
            <a href='?delete={$user->id}' onclick='return confirm(\"Tem certeza que deseja excluir este usuário?\")'>Excluir</a>
        </td>
    </tr>";
}
=======
<?php

require 'connection.php';

$connection = new Connection();

$users = $connection->query("SELECT * FROM users");

echo "<table border='1'>

    <tr>
        <th>ID</th>    
        <th>Nome</th>    
        <th>Email</th>
        <th>Ação</th>    
    </tr>
";

foreach($users as $user) {

    echo sprintf("<tr>
                      <td>%s</td>
                      <td>%s</td>
                      <td>%s</td>
                      <td>
                           <a href='#'>Editar</a>
                           <a href='#'>Excluir</a>
                      </td>
                   </tr>",
        $user->id, $user->name, $user->email);

}
echo "</table>";