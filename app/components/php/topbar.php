<div class="top-bar <?= isset($topBarClass) ? $topBarClass : ''; ?>">
    <img class="top-bar-favicon" src="./public/images/favicon_branco.svg" alt="" onclick="pag('')">
    <?php if (isset($topBarClass)): ?>
        <img class="top-bar-brand-name" src="./public/images/brand-name.svg" alt="">
    <?php endif; ?>
</div>