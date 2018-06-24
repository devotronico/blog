<main role="main">
    <form action="/post/save" method="POST" enctype="multipart/form-data">
        <h1>Crea un nuovo post</h1>
        <label for="title">Titolo</label>
        <input type="text" name="title" id="title" placeholder="Titolo del post" maxlenght="64" required>
        <label for="image">Immagine</label>
        <input type="file" name="file" id="image"> 
        <small>il file deve essere minore di&nbsp;<?=$megabytes?>&nbsp;megabytes</small>
        <label for="message">Messaggio</label>
        <textarea name="message" id="message" rows='7' placeholder="Testo del post" maxlenght="2000" required></textarea>
        <button type='submit' class="button">Salva</button>
    </form>
</main>




