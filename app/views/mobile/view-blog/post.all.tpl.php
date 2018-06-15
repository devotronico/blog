<main role="main">
    <div id="blog">
    <?php foreach ($posts as $post) : ?> 
        <article class="posts">
            <h1><a class="title" href="/post/<?=$post->post_ID?>"><?=htmlentities($post->title)?></a></h1>
            <p>
                <time datetime="<?=$post->datecreated?>"><?=$post->dateformatted?></time>
                by&nbsp;<span><a class="author" href="mailto:<?=$post->user_email?>"><?=$post->user_name?></a></span>
            </p>
            <p class="messtruncate"><?=$post->messtruncate?>&nbsp;<a class="read" href='/post/<?=$post->post_ID?>'>leggi</a></p>
            <p class="comment-num"><?=$post->num_comments?>&nbsp;commenti</p>
            <hr>
        </article>
    <?php endforeach; ?>
    </div>









