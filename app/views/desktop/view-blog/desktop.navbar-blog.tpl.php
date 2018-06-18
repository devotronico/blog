<!-- DESKTOP NAVBAR BLOG -->
<header>  
  <div id="navbar">
    <a href="/" class="logo">
      <img src="/img/logo.svg" alt="logo">
    </a>
    <div class="toggleNav"></div>
  </div>
  <nav>
    <ul id="nav-list">
      <li class="liPageLink">
        <a class="aPageLink" href="/">Home</a>
      </li>
      <li class="liPageLink <?=$link==='posts'? 'active' : 'deactive'?>">
          <a class="aPageLink" href="/posts">Posts</a> 
      </li>
      <?php if ( isset($_SESSION['user_type']) &&  $_SESSION['user_type'] !== 'reader' ) : ?>  <!-- solo il proprietario del sito può modificare/eliminare i post -->
      <li class="liPageLink <?=$link==='create'? 'active' : 'deactive' ?>">
        <a class="aPageLink" href="/post/create">New&nbsp;Post</a>
      </li>
      <?php endif ?>
      <?php if ( isset($_SESSION["user_id"]) ) : ?>
      <li class="liPageLink">
        <a class="aPageLink" href="/auth/<?=$_SESSION['user_id']?>/profile">Profilo</a> 
      </li>
      <li class="liPageLink">
        <a class="aPageLink" href="/auth/logout">Logout</a> 
      </li>
      <?php else: ?>
      <li class="liPageLink deactive">
        <a class="aPageLink" href="/auth/signin/form">Accedi</a> 
      </li>
      <li class="liPageLink deactive">
        <a class="aPageLink" href="/auth/signup/form">Registrati</a> 
      </li>
      <?php endif ?>
    </ul>
  </nav>
</header>  
<!-- END NAVBAR BLOG -->

