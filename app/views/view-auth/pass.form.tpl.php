<form action='/auth/password/check' method="POST" class='auth-form'>
    <h2 class="container-title text-center"><i class="fab fa-wpforms"></i>&nbsp;Password dimenticata?</h2>
    <div class="<?=isset($message)? 'alert alert-danger' : '' ?>" role="alert"><?=isset($message)? $message : '' ?></div>
    <div>Per creare una nuova password inserisci la tua email</div>
    <div class="form-group row">
        <i class="far fa-envelope fa-lg col-sm-2"></i>
        <input type="email" class="form-control col-sm-10" id="signin-email" name="user_email" aria-describedby="emailHelp" placeholder="Enter email">
    </div>

    <button type="submit" class="btn btn-primary btn-lg">Procedi</button>
</form>







