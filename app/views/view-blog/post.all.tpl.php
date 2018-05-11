<?php foreach ($posts as $post) : ?>
<article>
    <h2><a href="/post/<?=$post->id?>"><?=htmlentities($post->title)?></a></h2>
    <p>
        <time datetime="<?=$post->datecreated?>"><?=$post->datecreated?></time>
        by&nbsp;<span><a href="mailto:<?=$post->user_email?>"><?=$post->user_name?></a></span>
    </p>
    <?php if ( strlen($post->message) > 250 ) { $post->message = trim(substr($post->message, 0, 200))."<a href='/post/$post->id'>&nbsp;[...]</a>"; } ?>
    
    <?= $post->message?>
    <p><?=$post->num_comments?>&nbsp;commenti</p>
    <hr>
</article>
<?php endforeach;