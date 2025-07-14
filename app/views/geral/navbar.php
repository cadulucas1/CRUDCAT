<!DOCTYPE html>
<html lang="pt-br">
<head>
<?php
    $css = ["/css/navbar.css"];
    require_once('./utils/head.php');
?>
</head>
<body>
    <div class="navbar_button_container">
        <div class="navbar_left">
            <img src="./public/images/icons/icon_logo_minicomunica.svg" alt="Logo da empresa" class="navbar_logo">
        </div>

        <div class="navbar_right">
            <button class="navbar_button">
                <img src="./public/images/icons/icon_home.svg" alt="">
            </button>
            <button class="navbar_button">
                <img src="./public/images/icons/icon_search.svg" alt="">
            </button>
            <button class="navbar_button">
                <img src="./public/images/icons/icon_headset.svg" alt="">
            </button>
            <button class="navbar_button">
                <img src="./public/images/icons/icon_ticket.svg" alt="">
            </button>
            <button class="navbar_button">
                <img src="./public/images/icons/icon_user.svg" alt="">
            </button>
        </div>
    </div>
</body>
</html>