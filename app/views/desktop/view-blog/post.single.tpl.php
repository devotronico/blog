<main role="main">
    <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js?lang=css&amp;skin=sunburst"></script>
    <section id="post">
        <article>
            <h1><?=$post->title?></h1> <!-- <span><h2>&#x2709 &#x1F5BC &#x1F40C</h2></span> -->
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
            <?php if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] == 1 ) : ?>  <!-- solo il proprietario del sito può modificare/eliminare i post -->
                <a href="/post/<?= $post->post_ID ?>/edit" id="post-btn-edit" class="btn btn-primary">EDIT</a>
                <a href="/post/<?= $post->post_ID ?>/delete" id="post-btn-delete" class="btn btn-danger">DELETE</a>
            <?php endif; ?>
        </article>
    </section>
    <!-- <hr> -->
    <div id="textarea-container">
        <h2>Partecipa alla discussione</h2>    
        <?php if ( isset($_SESSION['user_id']) ) : ?>  
            <form class="comment-form" action="/post/<?=$post->post_ID?>/comment" method="POST">
                <div class="form-group">
                    <textarea required class="form-control" name="comment" rows="6" placeholder="Scrivi un commento"></textarea> <!-- i="message" -->
                </div>
                <div class="form-group text-md-center">
                    <button id="textarea-btn" class="btn btn-success">Invia</button>   
                </div>
            </form>
        <?php endif; ?>
    </div> 
    <div id='comments-container'>
    <?php  if( !empty($comments) ) : ?>
        <div class="centertitle"><p>Elenco commenti</p></div>
        <?php  foreach ($comments as $comment) : ?>
            <div class='comment-box'>
            <hr>
                <div class='comment-head'>
                    <img src="/img/auth/<?=!empty($comment->user_image)?$comment->user_image:'default.jpg'?>" alt="avatar personale">
                    <time datetime="<?= $comment->c_datecreated ?>"><?=$comment->c_dateformatted?></time>
                    <span class="author">di&nbsp;<a href="/auth/<?=$comment->user_id?>/profile"><?=$comment->user_name?>&nbsp;</a></span> 
                    <span class="mailto"><a href="mailto:<?= $comment->user_email ?>">&#x2709</a></span> 
                    <?php if ( isset($_SESSION['user_id']) && $_SESSION['user_id'] == 1 ) : ?><a href='/comment/<?=$comment->comment_ID?>/delete' class="btn comment-btn-delete">&#10006;</a><?php endif; ?>
                <div class='clear'></div>
                </div> 
                <p class='comment-body'><?=$comment->comment?></p>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <div class="centertitle"><p>Non ci sono commenti</p></div>
    <?php endif ?>
    </div>
</main>

