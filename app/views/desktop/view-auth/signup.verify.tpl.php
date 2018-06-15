<main role="main">
    <div id='signup-verify' class='signup'>
        <h1>Verifica registrazione</h1>
        <div class="message">
            <div class="alert <?=$_SESSION["user_id"]?'alert-success':'alert-danger'?>" role="alert"><?=$message?></div>
        </div>
            <a id="signup-btn" class="btn" href="/posts" role="button">Entra</a>
    </div>
</main>






