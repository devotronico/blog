<main role="main">
  <div id="newpass"> 
  <form action='/auth/password/check' method="POST" autocomplete='off'>
  <h1>Password dimenticata?</h1>
  <div class="<?=isset($message)? 'alert alert-danger' : '' ?>" role="alert"><?=isset($message)? $message : '' ?></div>
      <p>Per creare una nuova password inserisci la tua email</p>
    <div class="form-group">
      <label for="email"></label> 
      <div class="input-group">
        <div class="input-group-addon">
        <i class="fas fa-envelope fa-lg"></i>
        </div> 
        <input type="email" class="form-control" name="user_email" aria-describedby="emailHelp" placeholder="Enter email">
      </div>
    </div>
    <div class="form-group">
    <button type="submit" id="newpass-btn"class="btn">Procedi</button>
    </div>
  </form>
  </div>  
</main>






