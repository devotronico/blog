<footer class="footer">
  <div class="Pagination">
    <ul class="pagination justify-content-center">
    <?php $postForPage = 2;   $pageLast=round($totalPosts / $postForPage);?>
    <?php if( $page > 1 ) : ?>
      <li class="page-item"><a class="page-link" href="/posts/page/<?=1?>">First</a></li>
      <li class="page-item page-basic"><a class="page-link" href="/posts/page/<?=$page-1?>">Prev</a></li>
    <?php else : ?>
      <li class="page-item disabled"><a class="page-link" tabindex="-1">First</a></li>
      <li class="page-item page-basic disabled"><a class="page-link" tabindex="-1">Prev</a></li>
    <?php endif; ?>
    <?php for ( $pageNum=$page-3; $pageNum<=$pageLast; $pageNum++ ) : ?>
      <?php if ( $pageNum>0 ) : ?>
        <?php if ( $pageNum <= $page + 3 && $pageNum >= $page - 3) : ?>
          <?php if( $pageNum==$page ) : ?>
            <li class="page-item active"><a class="page-link" href="/posts/page/<?=$pageNum?>"><?=$pageNum?><span class="sr-only">(current)</span></a></li>
          <?php elseif ( $pageNum == $page + 3 ) : ?>
            <li class="page-item"><a class="page-link" href="/posts/page/<?=$pageNum?>">...</a></li>
          <?php elseif ( $pageNum == $page - 3) : ?>
            <li class="page-item"><a class="page-link" href="/posts/page/<?=$pageNum?>">...</a></li>
          <?php else : ?>
            <li class="page-item"><a class="page-link" href="/posts/page/<?=$pageNum?>"><?=$pageNum?></a></li>
          <?php endif; ?>
        <?php endif; ?>
      <?php endif; ?>
    <?php endfor; ?>
    <?php if( $page != $pageLast) : ?>
      <li class="page-item page-basic"><a class="page-link" href="/posts/page/<?=$page+1?>">Next</a></li>
      <li class="page-item"><a class="page-link" href="/posts/page/<?=$pageLast?>">Last</a></li>
    <?php else : ?>
      <li class="page-item page-basic disabled"><a class="page-link" tabindex="-1">Next</a></li>
      <li class="page-item disabled"><a class="page-link" tabindex="-1">Last</a></li>
    <?php endif; ?>
    </ul>
  </div>
</footer>

