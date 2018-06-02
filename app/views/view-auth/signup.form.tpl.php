<main role="main">
<form id='signup' class='auth-form' action='/auth/signup/store' method='POST' autocomplete='off' enctype="multipart/form-data">
<h1 class='container-title text-center'>Registrati</h1>
<?php if (!empty($imgMessage)): ?>
    <div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <?= $imgMessage ?>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
        </button>
    </div>
    <?php endif?>

    <div class="form-group">
        <div class='input-group'>
            <div class="input-group-addon"><i class="fas fa-image fa-lg"></i></div>
            <input type="file" class="form-control" name="file"> 
        </div>
        <small>il file deve essere minore di&nbsp;<?=$megabytes?>&nbsp;megabytes</small>   
    </div>

<?php if (!empty($message)): ?>
    <div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <?=$message?>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
        </button>
    </div>
  <?php endif?>
  <div class='form-group'>
    <label for='username'></label> 
    <div class='input-group'>
      <div class='input-group-addon'><i class='fas fa-user fa-lg'></i></div> 
      <input type='text' class='form-control' name='user_name' aria-describedby='username' placeholder='Username'>
    </div>
  </div>

  <div class='form-group'>
    <label for='email'></label> 
    <div class='input-group'>
      <div class='input-group-addon'><i class='fas fa-envelope fa-lg'></i></div> 
      <input type='email' class='form-control' name='user_email' aria-describedby='emailHelp' placeholder='Enter email *' required='required'>
    </div>
  </div>
  <div class='form-group'>
    <label for='password'></label> 
    <div class='input-group'>
      <div class='input-group-addon'><i class='fas fa-key fa-lg'></i></div> 
      <input type='password' class='form-control' name='user_pass' placeholder='Password *' required='required'>
    </div>
    <small>la password deve avere minimo 8 caratteri</small>
  </div> 
  <div class='form-group text-center'>
  <button type='submit' id="signup-btn" class='btn'>Registrati</button>
  </div>
</form>
</main>

