<footer class="footer">
  <div class="Pagination">
    <ul class="pagination pagination-lg justify-content-center">
    <?php $postForPage = 2; $pageLast=round($totalPosts / $postForPage);?>

    <?php if( $page > 1 ) : ?>
      <li class="page-item"><a class="page-link" href="/posts/page/<?=$page-1?>">Prev</a></li>
    <?php else : ?>
      <li class="page-item disabled"><a class="page-link" tabindex="-1">Prev</a></li>
    <?php endif; ?>
    
    <li class="page-item active"><a class="page-link" href="/posts/page/<?=$page?>"><?=$page?><span class="sr-only">(current)</span></a></li>
   
    <?php if( $page != $pageLast) : ?>
      <li class="page-item"><a class="page-link" href="/posts/page/<?=$page+1?>">Next</a></li>
    <?php else : ?>
      <li class="page-item disabled"><a class="page-link" tabindex="-1">Next</a></li>
    <?php endif; ?>

    </ul>
  </div>
</footer>

