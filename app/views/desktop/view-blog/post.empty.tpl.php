<main role="main">
    <form action='/post/create' method='GET'>
        <h1>Blog vuoto</h1>
        <?php if ( isset($_SESSION['user_type']) &&  $_SESSION['user_type'] != 'reader' ) : ?>  
            <p>Crea il tuo primo post</p>
            <button type='submit' class="button">New&nbsp;Post</button>
        <?php endif ?>
    </form>
</main>








