<!-- <main role="main">
  <div id="newpass" class='newpass'> 
  <form action='/auth/password/check' method="POST" autocomplete='off' required>
  <h1>Password dimenticata?</h1>
  <div class="<?=isset($message)? 'alert alert-danger' : '' ?>" role="alert"><?=isset($message)? $message : '' ?></div>
      <p>Per creare una nuova password inserisci la tua email</p>
    <div class="form-group">
      <label for="email"></label> 
      <div class="input-group">
        <div class="input-group-addon">
        <i class="fas fa-envelope fa-lg"></i>
        </div> 
        <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Enter email" required>
      </div>
    </div>
    <div class="form-group">
    <button type="submit" id="newpass-btn" class="btn btn-newpass">Procedi</button>
    </div>
  </form>
  </div>  
</main> -->

<main role="main">
  <form action='/auth/password/check' method="POST" autocomplete='off' required>
    <h1>Password dimenticata?</h1>
    <?php if (!empty($message)): ?>
    <div class='message'><?=$message?>
      <div class="message-close">X</div>
    </div>
    <?php endif?>
    <small>Per creare una nuova password inserisci la tua email</small>
    <input type="email" name="email" aria-describedby="email" maxlenght="16" placeholder="Email" required>
    <button type="submit" class="button">Procedi</button>
  </form>
</main>






