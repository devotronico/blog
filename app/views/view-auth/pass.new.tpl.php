<form action="/auth/password/save" method="POST" class='auth-form' autocomplete='off'>
    <h2 class="container-title text-center"><i class="fab fa-wpforms"></i>&nbsp;Nuova Password</h2>
    <?php if (!empty($message)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $message ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif?>
    <p><?=isset($_GET['email'])? $_GET['email'] : $_POST['user_email']?></p>
    <input type="hidden" name="user_email" value="<?=isset($_GET['email'])? $_GET['email'] : $_POST['user_email']?>">
    <div class="form-group row">
        <i class="fas fa-key fa-lg col-sm-2"></i> 
        <input type="password" class="form-control col-sm-10" name="user_pass" placeholder="Password">
    </div>

    <div class="form-group row">
        <i class="fas fa-key fa-lg col-sm-2"></i> 
        <input type="password" class="form-control col-sm-10" name="user_pass_confirm" placeholder="Riscrivi la password">
    </div>
    <button type="submit" class="btn btn-primary btn-lg btn-submit" id="submit-signup">Salva</button>
</form>







