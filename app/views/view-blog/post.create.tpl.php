<article>
    <div class="row">
        <div class="col-md-6 push-md-3">
            <h1>Crea un nuovo post</h1>
            <form action="/post/save" method="POST">

                <!-- <div class="form-group">
                <label for="email">Email</label>
                <input class="form-control" name="email" type="email"  name="email" i="email" required>
                </div> -->

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" name="title" required>
                </div>

                <div class="form-group">
                <label for="message">Message</label>
                <textarea class="form-control" name="message" rows='10' required></textarea>
                </div>

                <div class="form-group text-md-center">
                    <button class="btn">Save</button>
                </div>
            </form>
        </div>
    </div>
</article>



