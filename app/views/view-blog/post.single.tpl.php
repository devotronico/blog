<article>
    <h1><?=$post->title?></h1>
    <p>
        <time datetime="<?=$post->datecreated?>"><?=$post->datecreated?></time>
        by&nbsp;<span><a href="mailto:<?=$post->email?>"><?=$post->username?></a></span>
    </p>
    <?php if ( !empty($post->image) ) : ?>
        <img src="/img/posts/<?=$post->image?>" alt="immagine del post">
    <?php endif;?>
    <div><?=$post->message?></div>
    <br>
     <?php if ( isset($_SESSION['user_id']) &&  $_SESSION['user_id'] == 1 ) : ?>  <!-- solo il proprietario del sito può modificare/eliminare i post -->
        <a href="/post/<?= $post->id ?>/edit" class="btn btn-primary">EDIT</a>
        <a href="/post/<?= $post->id ?>/delete" class="btn btn-danger">DELETE</a>
    <?php endif; ?>
<hr>
<div class="textarea-box">
    <h3>Partecipa alla discussione</h3>    
    <?php if ( isset($_SESSION['user_id']) ) : ?>  
        <form class="comment-form" action="/post/<?= $post->id ?>/comment" method="POST">
            <div class="form-group">
                <label for="comment">Scrivi un messaggio</label>
                <textarea required class="form-control" name="comment" rows="8"></textarea> <!-- i="message" -->
            </div>
            <div class="form-group text-md-center">
                <button class="btn btn-success">Save</button>   
            </div>
        </form>
    <?php endif; ?>
</div>
     
<?php  if( !empty($comments)  ) : ?>
    <p>Elenco commenti</p>
    <?php  foreach ($comments as $comment) : ?>
        <div class='comment-box'>
            <div class='comment-head'>
                <img src="/img/auth/<?=!empty($comment->user_image)?$comment->user_image:'default.jpg'?>" alt="avatar personale">
                <time datetime="<?= $comment->datecreated ?>"><?= $comment->datecreated ?></time>
                by <span><a  href="mailto:<?= $comment->user_email ?>"> <?= $comment->user_name ?></a></span> 
                <?php if ( isset($_SESSION['user_id']) && $_SESSION['user_id'] == 1 ) : ?><a href='/comment/<?= $comment->id ?>/delete' class="btn right">X</a><?php endif; ?>
            <div class='clear'></div>
            </div> 
         
            <p class='comment-body'><?=$comment->comment?></p>
        </div>
    <?php endforeach; ?>
<?php else : ?>
    <p>Non ci sono commenti</p>
<?php endif ?>
</article>

