<article>
    <div class="row">
        <div class="col-md-6 push-md-3">
            <h1>Crea un nuovo post</h1>
            <form action="/post/save" method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="title">Titolo</label>
                    <input type="text" class="form-control" name="title" required>
                </div>

                <div class="form-group">
                    <div class="input-group mb-2 mb-sm-0">
                        <div class="input-group-addon"><i class="fas fa-image fa-lg"></i></div>
                        <input type="file" class="form-control" name="file"> 
                    </div>
                </div> 

                <div class="form-group">
                    <label for="message">Messaggio</label>
                    <textarea class="form-control" name="message" rows='10' required></textarea>
                </div>

                <div class="form-group text-md-center">
                    <button class="btn">Save</button>
                </div>
            </form>
        </div>
    </div>
</article>



