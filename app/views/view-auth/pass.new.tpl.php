<main role="main">
  <div id='newpass-create'>
    <form class='auth-form' action="/auth/password/save" method="POST" autocomplete='off'>
    <h1>Nuova Password</h1>
    <?php if (!empty($message)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $message ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php endif?>
        <input type="hidden" name="user_email" value="<?=isset($_GET['email'])? $_GET['email'] : $_POST['user_email']?>">

      <div class="form-group">
        <label for="email"></label> 
        <div class="input-group">
          <div class="input-group-addon">
          <i class="fas fa-envelope fa-lg"></i>
          </div> 
          <input type="text" class="form-control" placeholder="<?=isset($_GET['email'])? $_GET['email'] : $_POST['user_email']?>" readonly>
        </div>
      </div>

      <div class="form-group">
        <label for="password"></label> 
        <div class="input-group">
          <div class="input-group-addon">
          <i class="fas fa-key fa-lg"></i>
          </div> 
          <input type="password" class="form-control" name="user_pass" placeholder="Password" required="required">
        </div>
      </div>
      <div class="form-group">
        <label for="password"></label> 
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fas fa-key fa-lg"></i>
          </div> 
          <input type="password" class="form-control" name="user_pass_confirm" placeholder="Riscrivi la password" required="required">
        </div>
      </div> 
      <div class="form-group">
      <button type="submit" class="btn btn-primary btn-lg btn-submit">Salva</button>
      </div>
    </form>
  </div>
</main>







