<div class="section" id='contact'>
   <div class="section-title">Contatti</div>
    <div class='contact-message'><?=isset($errorMessage) ? $errorMessage : '' ?></div> 
    <div class='contact-message'><?=isset($successMessage) ? $successMessage : '' ?></div> 
    <form class="contact-form" method='post' action='email.php'>
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type='text' class="form-control" name='nome' id='nome' placeholder='Nome'>

            <label for="cognome">Cognome</label>
            <input type='text' class="form-control" name='cognome' id='cognome' placeholder='Cognome'>

            <label for="tel">Telefono</label>
            <input type='tel' class="form-control" name='tel' id='tel' placeholder='Telefono'>

            <label for="email">Email</label>
            <input type='email' class="form-control" name='email' id='email' placeholder='Email'>

            <label for="testo">Descrivi il lavoro</label>
            <textarea rows="4" class="form-control" cols="50" name='testo' id='testo' placeholder="Descrivi il lavoro" ></textarea>

            <input type='submit' class="btn btn-primary" id='submit' name='submit' value='invia'>
        </div>
    </form> 
</div>




    



     
     
     


