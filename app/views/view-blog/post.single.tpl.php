<article>
    <h1><?= $post->title ?></h1>
    <p>
        <time datetime="<?= $post->datecreated ?>"><?= $post->datecreated ?></time>
        by <span><a  href="mailto:<?= $post->email ?>"> <?= $post->email ?></a> </span>
    </p>
    <div><?= $post->message ?></div>
    <br>
     <?php if ( isset($_SESSION['id']) &&  $_SESSION['id'] == 1 ) : ?>  <!-- solo il proprietario del sito può modificare/eliminare i post -->
        <a href="/post/<?= $post->id ?>/edit" class="btn btn-primary">EDIT</a>
        <a href="/post/<?= $post->id ?>/delete" class="btn btn-danger">DELETE</a>
    <?php endif; ?>
<hr>
<div class="textarea-box">
    <h2>Commenti</h2>    
    <?php if ( isset($_SESSION['id']) ) : ?>  
        <form class="comment-form" action="/post/<?= $post->id ?>/comment" method="POST">
<!-- <div class="form-group"><label for="email">Email</label><input class="form-control" name="email" type="email" name="email" i="email" required></div> -->
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
                <time datetime="<?= $comment->datecreated ?>"><?= $comment->datecreated ?></time>
                by <span><a  href="mailto:<?= $comment->email ?>"> <?= $comment->username ?></a></span> 
                <?php if ( $_SESSION['id'] == 1 ) : ?><a href='/comment/<?= $comment->id ?>/delete' class="btn right">X</a><?php endif; ?>
            <div class='clear'></div>
            </div> 
         
            <p class='comment-body'><?=$comment->comment?></p>
        </div>
    <?php  endforeach; ?>
<?php else : ?>
    <p>Non ci sono commenti</p>
<?php endif ?>
    

</article>

