<main role="main">
    <form action='/auth/signup/store' method='POST' autocomplete='off' enctype="multipart/form-data">
        <h1>Registrati</h1>
        <?php if (!empty($imgMessage)): ?>
        <div class='message'><?= $imgMessage ?>
            <div class="message-close">X</div>
        </div>
        <?php endif?>
        <small>carica un immagine per il tuo profilo</small>   
        <input type="file" name="file"> 
        <small>il file deve essere minore di&nbsp;<?=$megabytes?>&nbsp;megabytes</small>   
        <?php if (!empty($message)): ?>
        <div class='message'><?=$message?>
            <div class="message-close">X</div>
        </div>
        <?php endif?>
        <label for='username'>username</label> 
        <input type='text' name='user_name' id='username' aria-describedby='username' placeholder='Username' maxlenght="16" autocomplete="off">
        <label for='email'>email</label> 
        <input type='email' name='user_email' id='email' aria-describedby='email' placeholder='Email *' required  maxlenght="16" autocomplete="off">
        <label for='password'>password</label> 
        <input type='password' name='user_pass' id='password' placeholder='Password *' aria-describedby='password' required maxlenght="16" autocomplete="off">
        <small>la password deve avere minimo 8 caratteri</small>
        <button type='submit'>Registrati</button>
    </form>
</main>

