<?php
session_start();
include("conexao_bd.php");

$nome  = @$_POST['txt_usuario'];
$senha = @$_POST['txt_senha'];

function consulta_usuario_bd($nome, $senha)
{
    $conn = new conexao_bd();
    $result1 = $conn->query("SELECT * FROM usuarios WHERE nome = '$nome' LIMIT 1");
    if (!empty($result1)) {
        if ($fetch = $result1->fetch_assoc()) {
            foreach ($fetch as $field => $value) {
                if ($field == 'senha') {
                    if ($value != $senha) {
                        header('Location: index.html');
                        exit;
                    }
                }
                if ($field == 'nome') {
                    if ($value != $nome) {
                        header("Location: index.html");
                        exit;
                    } else {
                        $_SESSION['nome'] = $value;
                    }
                }
                if ($field == 'id') {
                    $_SESSION['id'] = $value;
                }
                if ($field == 'nivel_acesso') {
                    $_SESSION['nivel_acesso'] = $value;
                    $nivel_acesso = $value;
                    direciona_pelo_nivel_acesso($nivel_acesso);
                }
            } //foreach
        } // fetch
    } else {
        header("Location: index.html");
        exit;
    }
}

function direciona_pelo_nivel_acesso($nivel_acesso){

    if (!empty($nivel_acesso)) {
        if ($nivel_acesso == 1) {
            header("Location: ../paginas/listar_pedidos.php");exit;
        }
        elseif ($nivel_acesso == 2) {
            header("Location: menu.html");exit;
        }
        else{
            header("Location: index.html");exit;
        }
    }
}

consulta_usuario_bd($nome, $senha);
