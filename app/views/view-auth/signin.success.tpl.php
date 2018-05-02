<div id='auth-verify' style="background-color:#fff;padding:20px;text-align:center;">
    <h2>Login riuscito</h2>
    <?php if (isset($_SESSION['id'])): ?>
    <div class="alert alert-success" role="alert"><?=$message?></div>
    <a href="/posts" class="btn btn-primary btn-lg">Entra</a>
    <?php else: ?>
    <h2>Attiva il tuo account</h2>
    <div class="alert alert-danger" role="alert">
    Prima di loggarti ti chiediamo di confermare la tua iscrizione.<br>Un link di conferma è stato mandato alla tua casella di posta <strong><?=$email?></strong><br>Per verificare il tuo account clicca sul link che trovi nella mail che ti abbiamo inviato!
    </div>
    <?php endif ?>
</div>








