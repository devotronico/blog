<form action="/auth/signin/access" method="POST" class='auth-form'>
    <h2 class="container-title text-center"><i class="fab fa-wpforms"></i>&nbsp;Sign In</h2>
    <?php if (!empty($message)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $message ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif?>
    <div class="form-group row">
        <i class="far fa-envelope fa-lg col-sm-2"></i>
        <input type="email" class="form-control col-sm-10" id="signin-email" name="user_email" aria-describedby="emailHelp" placeholder="Enter email">
    </div>
    <div class="form-group row">
        <i class="fas fa-key fa-lg col-sm-2"></i>
        <input type="password" class="form-control col-sm-10" id="signin-password" name="user_pass" placeholder="Password">
        <a href="/auth/password/form"><small id="password-forgot" class="form-text text-muted">password dimenticata?</small></a>
    </div>
    <div class="form-check">
        <label class="form-check-label">
        <input type="checkbox" class="form-check-input" name='setcookie' value=1>&nbsp;Rimani loggato
        </label>
    </div>
    <button type="submit" class="btn btn-primary btn-lg">Accedi</button>
</form>







