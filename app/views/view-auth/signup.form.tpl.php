<form action="/auth/signup/store" method="POST" class='auth-form' autocomplete='off'>
    <h2 class="container-title text-center"><i class="fab fa-wpforms"></i>&nbsp;Sign Up</h2>
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
        <input type="email" class="form-control col-sm-10" name="user_email" aria-describedby="emailHelp" placeholder="Enter email">
    </div>
    <div class="form-group row">
        <i class="fas fa-key fa-lg col-sm-2"></i> 
        <input type="password" class="form-control col-sm-10" name="user_pass" placeholder="Password">
    </div>
    <button type="submit" class="btn btn-primary btn-lg btn-submit" id="submit-signup">Registrati</button>
</form>


      

