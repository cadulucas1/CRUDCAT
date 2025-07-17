<?php

require_once __DIR__ . '/../../models/cliente/ClienteModel.php';
require_once __DIR__ . '/../../models/cliente/UsuarioModel.php';
require_once __DIR__ . '/../../models/geral/GeralModel.php';

class ClienteController extends RenderView
{
    public function login()
    {
        $this->loadView('cliente/login', []);
    }
    // função de cadastrar usuario
    public function cadastro()
    {
        $isAjax = (
            !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
        );

        $erro    = '';
        $sucesso = '';
        $field   = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome       = trim($_POST['nome']           ?? '');
            $email      = trim($_POST['email']          ?? '');
            $telefone   = trim($_POST['telefone']       ?? '');
            $senha      =               $_POST['senha']  ?? '';
            $confirmar  =               $_POST['confirmarSenha'] ?? '';

            $model = new ClienteModel();

            if (empty($nome) || empty($email) || empty($telefone) || empty($senha) || empty($confirmar)) {
                $erro = "Preencha todos os campos.";
                if (empty($nome)) {
                    $field = 'nome';
                } elseif (empty($email)) {
                    $field = 'email';
                } elseif (empty($telefone)) {
                    $field = 'telefone';
                } elseif (empty($senha)) {
                    $field = 'senha';
                } else {
                    $field = 'confirmarSenha';
                }
            }
            elseif (strpos($nome, ' ') === false) {
                $erro  = "Digite seu nome completo.";
                $field = 'nome';
            }
            elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $erro  = "E-mail inválido.";
                $field = 'email';
            }
            elseif (!preg_match('/^\d{10,}$/', preg_replace('/\D/', '', $telefone))) {
                $erro  = "Telefone inválido.";
                $field = 'telefone';
            }
            elseif (strlen($senha) < 6) {
                $erro  = "A senha deve ter ao menos 6 caracteres.";
                $field = 'senha';
            }
            elseif ($senha !== $confirmar) {
                $erro  = "As senhas não coincidem.";
                $field = 'confirmarSenha';
            }
            elseif ($model->existeEmail($email)) {
                $erro  = "E-mail já cadastrado.";
                $field = 'email';
            }
            elseif ($model->existeTelefone($telefone)) {
                $erro  = "Telefone já cadastrado.";
                $field = 'telefone';
            }
            else {
                $ok = $model->cadastrar($nome, $email, $telefone, $senha);
                if ($ok) {
                    if ($isAjax) {
                        header('Content-Type: application/json');
                        echo json_encode([
                            'success'  => true,
                            'message'  => 'Cadastro realizado com sucesso!',
                            'redirect' => '/CRUDCAT/login'
                        ]);
                        exit;
                    }
                    header('Location: /CRUDCAT/login');
                    exit;
                } else {
                    $erro = "Erro ao salvar no banco de dados.";
                }
            }
        }

        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => $erro,
                'field'   => $field
            ]);
            exit;
        }
        $this->loadView('cliente/cadastro', [
            'erro'    => $erro,
            'sucesso' => $sucesso
        ]);
    }


    public function perfil()
    {
        // ⛔️ Ainda não temos login implementado, então para teste usa id fixo
        $id_usuario = 1; // Depois use $_SESSION['usuario_id']

        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->getUsuarioById($id_usuario);

        $this->loadView('cliente/perfil', ['usuario' => $usuario]);
    }

    public function getLojasSeguidas()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            exit;
        }

        header('Content-Type: application/json; charset=utf-8');

        $idUsuario = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($idUsuario <= 0) {
            echo json_encode(['erro' => 'Usuário não logado']);
            exit;
        }

        $model = new ClienteModel();
        $resposta = $model->getLojasById($idUsuario);

        if (empty($resposta)) {
            echo json_encode(['alerta' => 'Você não segue nenhuma loja']);
            exit;
        }

        echo json_encode($resposta);
    }

    public function salvarPerfil()
    {
        // session_start();

        // if (!isset($_SESSION['usuario_id'])) {
        //     header('Location: /login');
        //     exit;
        // }

        $id_usuario = $_SESSION['usuario_id'] ?? 1;

        $nome     = trim($_POST['nome'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $telefone = trim($_POST['telefone'] ?? '');
        $senha    = $_POST['senha'] ?? '';
        $confirmarSenha = $_POST['confirmar_senha'] ?? '';

        if (empty($nome) || empty($email) || empty($telefone)) {
            $_SESSION['mensagem_erro'] = 'Nome, e-mail e telefone são obrigatórios.';
            header('Location: /CRUDCAT/perfil');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['mensagem_erro'] = 'E-mail inválido.';
            header('Location: /CRUDCAT/perfil');
            exit;
        }

        if (!empty($senha) || !empty($confirmarSenha)) {
            if ($senha !== $confirmarSenha) {
                $_SESSION['mensagem_erro'] = 'As senhas não coincidem.';
                header('Location: /CRUDCAT/perfil');
                exit;
            }
            if (strlen($senha) < 6) {
                $_SESSION['mensagem_erro'] = 'A senha deve ter pelo menos 6 caracteres.';
                header('Location: /CRUDCAT/perfil');
                exit;
            }
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        } else {
            $senhaHash = null;
        }

        $usuarioModel = new UsuarioModel();

        if ($senhaHash) {
            $usuarioModel->atualizarPerfilComSenha($id_usuario, $nome, $email, $telefone, $senhaHash);
        } else {
            $usuarioModel->atualizarPerfilSemSenha($id_usuario, $nome, $email, $telefone);
        }

        $_SESSION['mensagem_sucesso'] = 'Perfil atualizado com sucesso!';
        header('Location: /CRUDCAT/perfil');
        exit;
    }
    public function toggleSeguirLoja() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['sucesso' => false, 'mensagem' => 'Método não permitido']);
            exit;
        }
    
        header('Content-Type: application/json; charset=utf-8');
    
        $payload = json_decode(file_get_contents('php://input'), true);
    
        $idUser = isset($payload['id_user']) ? intval($payload['id_user']) : 0;
        $idLoja = isset($payload['id_loja']) ? intval($payload['id_loja']) : 0;
        $seguir  = isset($payload['seguir']) ? (bool)$payload['seguir'] : null;
    
        if ($idUser <= 0 || $idLoja <= 0 || !is_bool($seguir)) {
            http_response_code(400);
            echo json_encode([
                'sucesso' => false,
                'mensagem' => 'Parâmetros inválidos'
            ]);
            exit;
        }
    
        $model = new ClienteModel();
    
        $ok = $model->toggleSeguirLoja($idUser, $idLoja, $seguir);
    
        if ($ok) {
            http_response_code(200);
            echo json_encode([
                'sucesso' => true,
                'mensagem' => $seguir ? 'Agora você segue esta loja' : 'Você parou de seguir esta loja'
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'sucesso' => false,
                'mensagem' => 'Erro ao atualizar status de seguimento'
            ]);
        }
    }

    public function cupons() {

        $id_usuario = 1;

        if ($id_usuario <= 0) {
            header('Location: error');
        }

        $model = new GeralModel;

        $cupons = $model->getCuponsDisponiveis($id_usuario);

        $modelCliente = new ClienteModel;

        $userPontos = $modelCliente->getPontosUser($id_usuario);

        if (!empty($cupons)) {
            $this->loadView('cliente/cupom', [
                'cupons' => $cupons,
                'pontos' => $userPontos
            ]);
        }
    }

    public function comprarCupom()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['sucesso' => false, 'mensagem' => 'Método não permitido']);
            exit;
        }

        header('Content-Type: application/json; charset=utf-8');

        $idUser  = isset($_GET['cliente']) ? (int) $_GET['cliente'] : 0;
        $idCupom = isset($_GET['cupom'])   ? (int) $_GET['cupom']   : 0;

        if ($idUser <= 0 || $idCupom <= 0) {
            http_response_code(400);
            echo json_encode(['sucesso' => false, 'mensagem' => 'Parâmetros inválidos']);
            exit;
        }

        $geralModel   = new GeralModel();
        $clienteModel = new ClienteModel();

        $pontosUser = $clienteModel->getPontosUser($idUser);
        if ($pontosUser === null) {
            http_response_code(500);
            echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao ler pontos do usuário']);
            exit;
        }

        $custoCupom = $clienteModel->getValorPontosCupom($idCupom);
        if ($custoCupom === null) {
            http_response_code(404);
            echo json_encode(['sucesso' => false, 'mensagem' => 'Cupom não encontrado']);
            exit;
        }

        if ($pontosUser < $custoCupom) {
            http_response_code(400);
            echo json_encode(['sucesso' => false, 'mensagem' => 'Pontos insuficientes']);
            exit;
        }

        try {
            $pdo = $clienteModel->getConnection();         
            $pdo->beginTransaction();

            $novoSaldo = $pontosUser - $custoCupom;
            $ok1 = $clienteModel->atualizarPontosUsuario($idUser, $novoSaldo);
            $ok2 = $clienteModel->salvarUsuarioCupom($idUser, $idCupom);

            if (!($ok1 && $ok2)) {
                throw new Exception('Falha ao atualizar dados');
            }

            $pdo->commit();

            echo json_encode(['sucesso' => true, 'mensagem' => 'Cupom resgatado!', 'saldo' => $novoSaldo]);
        } catch (Exception $e) {
            $pdo->rollBack();
            http_response_code(500);
            echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao resgatar cupom']);
        }
        exit;
    }
}
