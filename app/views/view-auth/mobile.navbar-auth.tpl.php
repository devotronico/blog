<!-- MOBILE NAVBAR BLOG -->
<header>
  <a href="#home" class="logo">
    <img src="/img/logo.svg" alt="logo">
  </a>
  <div id="toggleNav" class="navClass"></div>
  <nav class="nav-collapse">
    <ul>
      <li class="navClass deactive">
        <a class="navClass" href="/">Home</a>
      </li>
      <li class="navClass deactive">
        <a class="navClass" href="/posts">Posts</a>
      </li>
      <?php if ( isset($_SESSION['user_type']) && $_SESSION['user_type'] != 'reader' ) : ?>
      <li class="navClass deactive">
        <a class="navClass" href="/post/create">New&nbsp;Post</a>
      </li>
      <?php endif ?>
      <?php if ( isset($_SESSION["user_id"]) ) : ?>
      <li class="navClass <?=$link=="profile"? 'active' : 'deactive' ?>">
        <a class="navClass" href="/auth/<?=$_SESSION['user_id']?>/profile">Profilo</a> 
      </li>
      <li class="navClass">
        <a class="navClass" href="/auth/logout">Logout</a> 
      </li>
      <?php else: ?>
      <li class="navClass <?=$link=='signin'? 'active' : 'deactive' ?>">
        <a class="navClass" href="/auth/signin/form">Accedi</a> 
      </li>
      <li class="navClass <?=$link=='signup'? 'active' : 'deactive' ?>">
        <a class="navClass" href="/auth/signup/form">Registrati</a> 
      </li>
      <?php endif ?>
    </ul>
  </nav>
</header>
<!-- END NAVBAR BLOG -->



    







