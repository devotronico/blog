<!-- MOBILE NAVBAR BLOG -->
<header>  
  <div id="navbar">
    <a href="/" class="logo">
      <img src="/img/logo.svg" alt="logo">
    </a>
    <div class="toggleNav"></div>
  </div>
  <nav>
    <ul>
      <li class="linkClass">
        <a class="linkClass" href="/">Home</a>
      </li>
      <li class="linkClass <?=$link==='posts'? 'active' : 'deactive'?>">
          <a class="linkClass" href="/posts">Posts</a> 
      </li>
      <?php if ( isset($_SESSION['user_type']) &&  $_SESSION['user_type'] === 'administrator' ) : ?>  <!-- solo il proprietario del sito può modificare/eliminare i post -->
      <li class="linkClass <?=$link==='create'? 'active' : 'deactive' ?>">
        <a class="linkClass" href="/post/create">New&nbsp;Post</a>
      </li>
      <?php endif ?>
      <?php if ( isset($_SESSION["user_id"]) ) : ?>
      <li class="linkClass">
        <a class="linkClass" href="/auth/<?=$_SESSION['user_id']?>/profile">Profilo</a> 
      </li>
      <li class="linkClass">
        <a class="linkClass" href="/auth/logout">Logout</a> 
      </li>
      <?php else: ?>
      <li class="linkClass deactive">
        <a class="linkClass" href="/auth/signin/form">Accedi</a> 
      </li>
      <li class="linkClass deactive">
        <a class="linkClass" href="/auth/signup/form">Registrati</a> 
      </li>
      <?php endif ?>
    </ul>
  </nav>
</header>  
<!-- END NAVBAR BLOG -->







