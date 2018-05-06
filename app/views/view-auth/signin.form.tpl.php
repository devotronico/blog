<form id='auth'action='/auth/signin/access' method='POST'>
<h2 class='container-title text-center'>Accedi</h2>
    <?php if (!empty($message)): ?>
    <div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <?= $message ?>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
        </button>
    </div>
<?php endif; ?>
  <div class='form-group'>
    <label for='email'></label> 
    <div class='input-group'>
      <div class='input-group-addon'>
      <i class='fas fa-envelope fa-lg'></i>
      </div> 
      <input type='email' name='user_email' placeholder='Email' class='form-control' required='required'>
    </div>
  </div>
  <div class='form-group'>
  <label for='password'></label>  
    <div class='input-group'>
      <div class='input-group-addon'>
        <i class='fas fa-key fa-lg'></i>
      </div> 
      <input type='password' name='user_pass' placeholder='Password' class='form-control' required='required'>
    </div>
    <a href='/auth/password/form' class='text-center' style='padding:8px;'><small class='form-text text-muted'>password dimenticata?</small></a>
  </div> 
  <div class='form-group text-center'>
    <button type='submit' name='submit' class='btn'>Accedi</button>
  </div>
</form>