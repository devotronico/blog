<main role="main">
    <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js?lang=css&amp;skin=sunburst"></script>
    <section id="post">
        <article>
            <h1><?=$post->title?></h1>
            <p>
                <time datetime="<?=$post->datecreated?>"><?=$post->dateformatted?></time>
                <span class="author">di&nbsp;<a href="/auth/<?=$post->user_id?>/profile"><?=$post->user_name?>&nbsp;</a></span>
                <span class="mailto"><a href="mailto:<?= $post->user_email ?>">&#x2709</a></span>
            </p>
            <?php if ( !empty($post->image) ) : ?>
                <img src="/img/posts/<?=$post->image?>" alt="immagine del post">
            <?php endif;?>
            <div id="post-text"><p><?=$post->message?></p></div>
            <br>
            <?php  if (isset($_SESSION)) : ?>
            <?php if ( $_SESSION['user_type'] === 'administrator' ) : ?>    
                <a href="/post/<?= $post->post_ID ?>/edit" id="post-btn-edit" class="button">EDIT</a>
                <a href="/post/<?= $post->post_ID ?>/delete" id="post-btn-delete" class="button">DELETE</a>
            <?php elseif ( $_SESSION['user_type'] === 'contributor' && ($_SESSION['user_id'] === $post->user_id) ) : ?>
                <a href="/post/<?= $post->post_ID ?>/edit" id="post-btn-edit" class="button">EDIT</a>
                <a href="/post/<?= $post->post_ID ?>/delete" id="post-btn-delete" class="button">DELETE</a>
            <?php endif; ?>
            <?php endif; ?>
        </article>
    </section>
    <section id="textarea-container">
        <h1>Partecipa alla discussione</h1>    
        <?php if ( isset($_SESSION['user_id']) ) : ?>  
            <form class="comment-form" action="/post/<?=$post->post_ID?>/comment" method="POST">
                <textarea name="comment" rows="6" placeholder="Scrivi un commento" required></textarea>
                <button class="button" <?= $_SESSION['user_type'] === 'banned'? 'disabled': ''?> >Invia</button>   
            </form>
        <?php endif; ?>
    </section> 
    <section id='comments-container'>
    <?php  if( !empty($comments) ) : ?>
        <div class="centertitle"><p>Elenco commenti</p></div>
        <?php  foreach ($comments as $comment) : ?>
            <div class='comment-box'>
                <div class='comment-head'>
                    <img src="/img/auth/<?=!empty($comment->user_image)?$comment->user_image:'default.jpg'?>" alt="avatar personale">
                    <time datetime="<?= $comment->c_datecreated ?>"><?=$comment->c_dateformatted?></time>
                    <span class="author">di&nbsp;<a href="/auth/<?=$comment->user_id?>/profile"><?=$comment->user_name?>&nbsp;</a></span> 
                    <span class="mailto"><a href="mailto:<?= $comment->user_email ?>">&#x2709</a></span> 
                    <?php  if (isset($_SESSION)) : ?>
                    <?php if ( $_SESSION['user_type'] === 'administrator' ) : ?>
                    <a href='/comment/<?=$comment->comment_ID?>/delete' class="btn comment-btn-delete">&#10006;</a>    
                    <?php elseif ( $_SESSION['user_type'] === 'contributor' && ($_SESSION['user_id'] === $post->user_id) ) : ?>
                    <a href='/comment/<?=$comment->comment_ID?>/delete' class="btn comment-btn-delete">&#10006;</a> 
                    <?php endif; ?>
                    <?php endif; ?>                
                    <div class='clear'></div>
                </div> 
                <p class='comment-body'><?=$comment->comment?></p>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <div class="centertitle"><p>Non ci sono commenti</p></div>
    <?php endif ?>
    </section>
</main>

