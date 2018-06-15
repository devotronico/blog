<main role="main">
  <form action='/auth/password/check' method="POST" autocomplete='off'>
    <h1>Password dimenticata?</h1>
    <?php if (!empty($message)): ?>
    <div class='message'><?=$message?>
      <div class="message-close">X</div>
    </div>
    <?php endif?>
    <small>Per creare una nuova password inserisci la tua email</small>
    <input type="email" name="user_email" aria-describedby="email" maxlenght="16" placeholder="Email" required>
    <button type="submit">Procedi</button>
  </form>
</main>






