<?php
  /*
  $_SESSION["username"] = 'Daniele';
  $_SESSION["id"] = $_SESSION["username"];
*/
  ?>
<nav class="navbar navbar-expand-lg navbar-dark">
  <a class="navbar-brand" href="/">
    <img src="/img/logo.svg" height="100%" class="d-inline-block align-top" alt="">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-div" aria-controls="navbar-div" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbar-div">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/posts">Posts</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/post/create">New&nbsp;Post</a>
      </li>
      <?php if ( isset($_SESSION["id"]) ) : ?>
        <li class="nav-item">
          <a class="nav-link" href="/auth/logout">Logout</a> 
        </li>
      <?php else: ?>
        <li class="nav-item">
          <a class="nav-link" href="/auth/signin/form">Accedi</a> 
        </li>
        <li class="nav-item">
        <a class="nav-link" href="/auth/signup/form">Registrati</a> 
        </li>
      <?php endif ?>
    </ul>
  </div>
</nav>

