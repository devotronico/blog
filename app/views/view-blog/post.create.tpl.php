<main role="main">
     <div id="create-post" class="row align-items-center"> 
        <div class="col-md-6 offset-md-3 text-center">
            <h1>Crea un nuovo post</h1>
            <form action="/post/save" method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="title">Titolo</label>
                    <input type="text" class="form-control" name="title" required>
                </div>

                <div class="form-group">
                    <div class='input-group'>
                        <div class="input-group-addon"><i class="fas fa-image fa-lg"></i></div>
                        <input type="file" class="form-control" name="file"> 
                    </div>
                    <small>il file deve essere minore di&nbsp;<?=$megabytes?>&nbsp;megabytes</small>
                </div> 

                <div class="form-group">
                    <label for="message">Messaggio</label>
                    <textarea class="form-control" name="message" rows='10' required></textarea>
                </div>
                <button id="create-btn" class="btn">Save</button>
            </form>
        </div>
    </div>
</main>



