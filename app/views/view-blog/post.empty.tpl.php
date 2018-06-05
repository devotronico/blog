<main role="main">
    <div id='empty'>
        <h1>Blog vuoto</h1>
        <?php if ( isset($_SESSION['user_type']) &&  $_SESSION['user_type'] != 'reader' ) : ?>  
            <p>Crea il tuo primo post</p>
            <a id="empty-btn" class="btn" href="/post/create">New&nbsp;Post</a>
        <?php endif ?>
    </div>
</main>








