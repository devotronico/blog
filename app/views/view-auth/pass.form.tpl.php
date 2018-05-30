<form id='auth' class='auth-form' action='/auth/password/check' method="POST" autocomplete='off'>
<h2 class="container-title text-center">Password dimenticata?</h2>
<div class="<?=isset($message)? 'alert alert-danger' : '' ?>" role="alert"><?=isset($message)? $message : '' ?></div>
    <div>Per creare una nuova password inserisci la tua email</div>
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
  <button type="submit" class="btn btn-primary btn-lg">Procedi</button>
  </div>
</form>






