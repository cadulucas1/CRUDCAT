<!DOCTYPE html>
<html lang="pt-br">
<head>
<?php
    $css = ["/css/geral/navbar.css", "/css/cliente/perfil_loja.css"];
    require_once('./utils/head.php');
?>
</head>
<body>
    <?php
        include './app/components/php/navbar.php';
    ?>
    <main>
        <div class="perfil_loja_banner_container">
            <img src="./public/images/fotos/banner_default.svg" alt="banner" class="perfil_loja_banner">
            <div class="perfil_loja_content_pfp">

                <div class="perfil_loja_pfp">
                    <img src="./public/images/fotos/foto_default.svg" class='perfil_loja_pfp_pic'>
                </div>

                <div class="perfil_loja_container_buttons">

                    <label class="perfil_loja_button_base">
                        <img src="./public/images/icons/icon_mensagem.svg" alt="banner" class="perfil_loja_button_base_icon">
                    </label>

                    <label class="perfil_loja_like-button">
                        <input type="checkbox" id="perfil_loja_heart" class="on">
                            <div class="perfil_loja_like">
                                <svg class="perfil_loja_like-icon" viewBox="0 0 24 24">
                                <path d="M2 9.137C2 14 6.02 16.591 8.962 18.911C10 19.729 11 20.5 12 20.5s2-.77 3.038-1.59C17.981 16.592 22 14 22 9.138S16.5.825 12 5.501C7.5.825 2 4.274 2 9.137"/></svg>
                                </svg>
                            </div>
                        </input>
                    </label>
                </div>
            </div>
        </div>
        

        <div class="perfil_loja_grid_dados_loja">
            <div class="perfil_loja_fonte_titulo">Comper Itanhangá</div>

            <div class="perfil_loja_container_dados">
                <img src="./public/images/icons/icon_localizacao.svg" class='perfil_loja_pfp_pic'>
                <div class="perfil_loja_fonte_base">Rua Joaquim Murtinho, 975</div>
            </div>

            <div class="perfil_loja_container_dados">
                <img src="./public/images/icons/icon_maleta.svg" class='perfil_loja_pfp_pic'>
                <div class="perfil_loja_fonte_base">Status: Aberto</div>
            </div>

            <div class="perfil_loja_container_dados">
                <img src="./public/images/icons/icon_relogio.svg" class='perfil_loja_pfp_pic'>
                <div class="perfil_loja_fonte_base_cinza">Fechado a partir das 23h</div>
            </div>
        </div>

        <div class="perfil_loja_grid_anuncios">
            <div class="perfil_loja_container_dados">
                <img src="./public/images/icons/icon_cesta.svg" class='perfil_loja_pfp_pic'>
                <div class="perfil_loja_fonte_base_laranja">Ofertas de Hoje!</div>
            </div>
            <div class="perfil_loja_imagens_anuncios"></div>
            <div class="perfil_loja_imagens_anuncios"></div>
            <div class="perfil_loja_container_dados_direita">
            <label class="perfil_loja_button_base">
                        <img src="./public/images/icons/icon_seta_direita.svg" alt="banner" class="perfil_loja_button_base_icon">
            </label>
            </div>
        </div>
    </main>

</body>
</html>