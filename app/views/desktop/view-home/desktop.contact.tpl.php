<div id="contact">
    <div class='contact-message'><?=isset($message) ? $message : '' ?></div> 
    <div id="contact-title"><p>Contact</p></div>
    <form id="contact-form" method="post" action="/home/contact">
        <label for="nome">nome</label>
        <input type="text" name="nome" placeholder="nome" maxlength="32">
        <label for="cognome">cognome</label>
        <input type="text" name="cognome" placeholder="cognome" maxlength="32">
        <label for="tel">tel</label>
        <input type="tel" name="tel" placeholder="tel" maxlength="16">
        <label for="email">email</label>
        <input type="email" name="email" placeholder="email" maxlength="32">
        <label for="descrivi il lavoro">descrivi il lavoro</label>
        <textarea rows="3" cols="50" name="testo" placeholder="descrivi il lavoro" maxlength="64"></textarea>
        <button type="submit" id="contact-btn">invia</button>
    </form>
</div>




    



     
     
     


