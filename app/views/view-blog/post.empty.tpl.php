<div id='auth' class='auth-verify'>
    <h2>Blog vuoto</h2>
    <!-- <div class="alert alert-warning" role="alert"> -->
    <?php if ( isset($_SESSION['user_type']) &&  $_SESSION['user_type'] != 'reader' ) : ?>  
        <p>Crea il tuo primo post</p>
        <a class="btn" href="/post/create">New&nbsp;Post</a>
    <?php endif ?>
    <!-- </div> -->
</div>








