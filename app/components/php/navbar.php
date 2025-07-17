<?php
    $rotaCompleta = $_SERVER['REQUEST_URI'];
    $partes = explode('/', trim($rotaCompleta, '/'));

    $rotaAtual = isset($partes[1]) ? $partes[1] : '';


    $rotas = [
        '' => 'icon_home.svg',
        'search' => 'icon_search.svg',
        'suporte' => 'icon_headset.svg',
        'cupons' => 'icon_ticket.svg',
        'perfil' => 'icon_user.svg'
    ];
?>

<div class="navbar_button_container">
    <div class="navbar_left">
        <img src="./public/images/icons/icon_logo_minicomunica.svg" alt="Logo da empresa" class="navbar_logo">
    </div>

    <div class="navbar_right">
        <?php foreach ($rotas as $rota => $icon): ?>
            <button class="<?= 'navbar_button' . ($rotaAtual === $rota || ($rotaAtual === 'login' && $rota === 'perfil') || ($rotaAtual === 'cadastro' && $rota === 'perfil') || ($rotaAtual === 'index.php' && $rota === '')? ' active' : '')?>">
                <img 
                    src="./public/images/icons/<?= $icon ?>" 
                    alt="" 
                    onclick="pag('<?= $rota ?>')"
                    class="navbar_icon"
                >
            </button>
        <?php endforeach; ?>
    </div>
</div>
