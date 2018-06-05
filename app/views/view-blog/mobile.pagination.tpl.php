<footer class="footer">
  <div class="Pagination">
    <ul class="pagination pagination-lg justify-content-center">
    <?php $pageLast=round($totalPosts / $postForPage);?>

    <?php if( $currentPage > 1 ) : ?>
      <li class="page-item"><a class="page-link" href="/posts/page/<?=$currentPage-1?>">Prev</a></li>
    <?php else : ?>
      <li class="page-item disabled"><a class="page-link" tabindex="-1">Prev</a></li>
    <?php endif; ?>
    
    <li class="page-item active"><a class="page-link" href="/posts/page/<?=$currentPage?>"><?=$currentPage?><span class="sr-only">(current)</span></a></li>
   
    <?php if( $currentPage != $pageLast) : ?>
      <li class="page-item"><a class="page-link" href="/posts/page/<?=$currentPage+1?>">Next</a></li>
    <?php else : ?>
      <li class="page-item disabled"><a class="page-link" tabindex="-1">Next</a></li>
    <?php endif; ?>

    </ul>
  </div>
</footer>
</main>

