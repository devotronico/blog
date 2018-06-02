<!-- MOBILE NAVBAR BLOG -->
<header>  
  <a href="#home" class="logo">
    <!-- <img src="/img/logo.svg" height="100%" class="d-inline-block align-top" alt=""> -->
    <img src="/img/logo.svg" alt="logo">
  </a>
  <div id="toggleNav" class="navClass"></div>
  <nav>
    <ul>
      <li class="navClass">
        <a class="navClass" href="/">Home</a>
      </li>
      <li class="navClass <?=$link==='posts'? 'active' : 'deactive'?>">
          <a class="navClass" href="/posts">Posts</a> 
      </li>
      <?php if ( isset($_SESSION['user_type']) &&  $_SESSION['user_type'] === 'administrator' ) : ?>  <!-- solo il proprietario del sito può modificare/eliminare i post -->
      <li class="navClass <?=$link==='create'? 'active' : 'deactive' ?>">
        <a class="navClass" href="/post/create">New&nbsp;Post</a>
      </li>
      <?php endif ?>
      <?php if ( isset($_SESSION["user_id"]) ) : ?>
      <li class="navClass">
        <a class="navClass" href="/auth/<?=$_SESSION['user_id']?>/profile">Profilo</a> 
      </li>
      <li class="navClass">
        <a class="navClass" href="/auth/logout">Logout</a> 
      </li>
      <?php else: ?>
      <li class="navClass deactive">
        <a class="navClass" href="/auth/signin/form">Accedi</a> 
      </li>
      <li class="navClass deactive">
        <a class="navClass" href="/auth/signup/form">Registrati</a> 
      </li>
      <?php endif ?>
    </ul>
  </nav>
</header>  
<!-- END NAVBAR BLOG -->







