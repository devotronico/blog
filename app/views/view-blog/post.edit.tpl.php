<main role="main">
    <div id="edit-post" class="row align-items-center"> 
        <div class="col-md-6 offset-md-3 text-center">
            <h1>Modifica il post</h1>
            <form action="/post/<?=$post->post_ID?>/update" method="POST">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input class="form-control" type="text" name="title" value="<?=$post->title?>" required>
                </div>
                <div class="form-group">
                    <label for="title">Message</label>
                    <textarea class="form-control" name="message" rows='12' required><?=$post->message?></textarea>
                </div>
                <button id="create-btn" class="btn">Save</button>
            </form>
        </div>
    </div>
</main>
