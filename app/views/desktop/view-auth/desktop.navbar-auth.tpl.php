<!-- MOBILE NAVBAR AUTH -->
<header>  
  <div id="navbar">
    <a href="/" id="logo-link">
      <img id="logo-img" src="/img/logo/logo.svg" alt="logo">
    </a>
    <div class="toggleNav"></div>
  </div>
  <nav>
    <ul id="nav-list">
      <li class="liPageLink deactive">
        <a class="aPageLink" href="/">Home</a>
      </li>
      <li class="liPageLink deactive">
        <a class="aPageLink" href="/blog/">Posts</a>
      </li>
      <?php if ( isset($_SESSION['user_type']) && ($_SESSION['user_type'] === 'contributor' || $_SESSION['user_type'] === 'administrator') ) : ?>  
      <li class="liPageLink deactive">
        <a class="aPageLink" href="/post/create">New&nbsp;Post</a>
      </li>
      <?php endif ?>
      <?php if ( isset($_SESSION["user_id"]) ) : ?>
      <li class="liPageLink <?=$link=="profile"? 'active' : 'deactive' ?>">
        <a class="aPageLink" href="/auth/<?=$_SESSION['user_id']?>/profile">Profilo</a> 
      </li>
      <li class="liPageLink deactive">
        <a class="aPageLink" href="/auth/logout">Logout</a> 
      </li>
      <?php else: ?>
      <li class="liPageLink <?=$link=='signin'? 'active' : 'deactive' ?>">
        <a class="aPageLink" href="/auth/signin/form">Accedi</a> 
      </li>
      <li class="liPageLink <?=$link=='signup'? 'active' : 'deactive' ?>">
        <a class="aPageLink" href="/auth/signup/form">Registrati</a> 
      </li>
      <?php endif ?>
    </ul>
  </nav>
</header>
<div id='risoluzione'></div>
<div id="btn-scroll"><i class="scrollFA fas fa-chevron-circle-up"></i></div>
<!-- END NAVBAR AUTH -->

