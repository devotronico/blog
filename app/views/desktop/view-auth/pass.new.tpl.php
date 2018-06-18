<main role="main">
  <div id='newpass-create' class='newpass'>
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
        <input type="hidden" name="email" value="<?=isset($_GET['email'])? $_GET['email'] : $_POST['email']?>">

      <div class="form-group">
        <label for="email"></label> 
        <div class="input-group">
          <div class="input-group-addon">
          <i class="fas fa-envelope fa-lg"></i>
          </div> 
          <input type="text" class="form-control" placeholder="<?=isset($_GET['email'])? $_GET['email'] : $_POST['email']?>" readonly>
        </div>
      </div>

      <div class="form-group">
        <label for="password"></label> 
        <div class="input-group">
          <div class="input-group-addon">
          <i class="fas fa-key fa-lg"></i>
          </div> 
          <input type="password" class="form-control" name="pass" placeholder="Password" required="required">
        </div>
      </div>
      <div class="form-group">
        <label for="password"></label> 
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fas fa-key fa-lg"></i>
          </div> 
          <input type="password" class="form-control" name="passconfirm" placeholder="Riscrivi la password" required="required">
        </div>
      </div> 
      <div class="form-group">
        <button type="submit" class="btn btn-newpass">Salva</button>
      </div>
    </form>
  </div>
</main>



<!-- <main role="main">
  <form action="/auth/password/save" method="POST" autocomplete='off'>
    <h1>Nuova Password</h1>
    <?php if (!empty($message)): ?>
    <div class='message'><?=$message?>
      <div class="message-close">X</div>
    </div>
    <?php endif?>
        <input type="hidden" name="email" value="<?=isset($_GET['email'])? $_GET['email'] : $_POST['user_email']?>">

        <label for="email">email</label> 
        <input type="text" placeholder="<?=isset($_GET['email'])? $_GET['email'] : $_POST['email']?>" maxlenght="16" readonly>
  
        <label for="password">password</label>  
        <input type="password" name="pass" id='password' placeholder="Password" maxlenght="16" required autocomplete='off'>
     
        <label for="passwordcopy">riscrivi la password</label> 
        <input type="password" name="passconfirm" id='passwordcopy' placeholder="Riscrivi la password" maxlenght="16" required autocomplete='off'>

        <button type="submit">Salva</button>
  </form>
</main> -->






