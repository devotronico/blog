<main role="main">
<div id='signin'>
    <?php if (isset($_SESSION['user_id'])): ?>
        <h1 id="access-title"><?=$message?></h1>
        <a href="/posts" id="access-btn" class="btn">Entra</a>
    <?php else: ?>
    <h2>Attiva il tuo account</h2>
    <div class="alert alert-danger" role="alert">
    Prima di loggarti ti chiediamo di confermare la tua iscrizione.<br>Un link di conferma è stato mandato alla tua casella di posta <strong><?=$email?></strong><br>Per verificare il tuo account clicca sul link che trovi nella mail che ti abbiamo inviato!
    </div>
    <?php endif ?>
</div>
</main>








