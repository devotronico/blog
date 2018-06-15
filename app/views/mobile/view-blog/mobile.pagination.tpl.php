<footer class="footer">
    <ul id="pagination">
    <?php $pageLast=ceil($totalPosts / $postForPage);?>

    <?php if( $currentPage > 1 ) : ?>
      <li class="page-item active"><a class="page-link" tabindex="-1" href="/posts/page/<?=$currentPage-1?>">&#9664;</a></li>
    <?php else : ?>
      <li class="page-item disabled">&#9664;</li>
    <?php endif; ?>
    
    <li class="page-item"><?=$currentPage?></li>
   
    <?php if( $currentPage != $pageLast) : ?>
      <li class="page-item active"><a class="page-link" href="/posts/page/<?=$currentPage+1?>">&#9654;</a></li>
    <?php else : ?>
      <li class="page-item disabled">&#9654;</li>
    <?php endif; ?>

    </ul>
</footer>
</main>





