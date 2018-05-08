<?php foreach ($posts as $post) : ?>
<article>
    <h2><a href="/post/<?=$post->id?>"><?=htmlentities($post->title)?></a></h2>
    <p>
        <time datetime="<?=$post->datecreated?>"><?=$post->datecreated?></time>
        by&nbsp;<span><a href="mailto:<?=$post->email?>"><?=$post->username?></a></span>
    </p>
    <?= htmlentities($post->message)?>
    <hr>
</article>
<?php endforeach;