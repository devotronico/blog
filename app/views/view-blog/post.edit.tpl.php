<article>
<div class="row">
    <div class="col-md-6 push-md-3">
        <h1>Modifica il post</h1>
        <form action="/post/update" method="POST">
            <input type="hidden" name="id" value="<?=$post->id?>">
            <div class="form-group">
                <label for="title">Title</label>
                <input class="form-control" type="text" name="title" value="<?=$post->title?>" required>
            </div>
            <div class="form-group">
                <label for="title">Message</label>
                <textarea class="form-control" name="message" rows='12' required><?=$post->message?></textarea>
            </div>
            <div class="form-group text-md-center">
                <button class="btn">Save</button>
            </div>
        </form>
    </div>
</div>
</article>
