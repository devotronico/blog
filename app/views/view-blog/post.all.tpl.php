<?php foreach ($posts as $post) : ?>    
<article>
    <h2><a href="/post/<?=$post->id?>"><?=htmlentities($post->title)?></a></h2>
    <p>
        <time datetime="<?=$post->datecreated?>"><?=$post->dateformatted?></time>
        by&nbsp;<span><a href="mailto:<?=$post->user_email?>"><?=$post->user_name?></a></span>
    </p>
    <p><?= $post->messtruncate ?>&nbsp;<a href='/post/$post->id'>[...]</a></p>
    <p><?=$post->num_comments?>&nbsp;commenti</p>
    <hr>
</article>
<?php endforeach;