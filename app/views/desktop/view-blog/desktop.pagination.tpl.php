<footer class="footer">
  <ul class="pagination">
    <?php $pageLast=ceil($totalPosts / $postForPage);?>
    <?php if( $currentPage > 1 ) : ?>
      <li class="page-item attivo"><a class="page-link" href="/posts/page/<?=1?>">First</a></li>
      <li class="page-item attivo"><a class="page-link" href="/posts/page/<?=$currentPage-1?>">Prev</a></li>
    <?php else : ?>
      <li class="page-item disabled"><a class="page-link" tabindex="-1">First</a></li>
      <li class="page-item disabled"><a class="page-link" tabindex="-1">Prev</a></li>
    <?php endif; ?>
    <?php for ( $pageNum=$currentPage- $postForPage; $pageNum<=$pageLast; $pageNum++ ) : ?>
      <?php if ( $pageNum>0 ) : ?>
        <?php if ( $pageNum <= $currentPage +  $postForPage && $pageNum >= $currentPage -  $postForPage) : ?>
          <?php if( $pageNum==$currentPage ) : ?>
            <li class="page-item current"><a class="page-link"><?=$pageNum?></a></li>
          <?php elseif ( $pageNum == $currentPage +  $postForPage ) : ?>
            <li class="page-item dot"><a class="page-link" href="/posts/page/<?=$pageNum?>">...</a></li>
          <?php elseif ( $pageNum == $currentPage -  $postForPage) : ?>
            <li class="page-item dot"><a class="page-link" href="/posts/page/<?=$pageNum?>">...</a></li>
          <?php else : ?>
            <li class="page-item number"><a class="page-link" href="/posts/page/<?=$pageNum?>"><?=$pageNum?></a></li>
          <?php endif; ?>
        <?php endif; ?>
      <?php endif; ?>
    <?php endfor; ?>
    <?php if( $currentPage != $pageLast) : ?>
      <li class="page-item attivo"><a class="page-link" href="/posts/page/<?=$currentPage+1?>">Next</a></li>
      <li class="page-item attivo"><a class="page-link" href="/posts/page/<?=$pageLast?>">Last</a></li>
    <?php else : ?>
      <li class="page-item disabled"><a class="page-link" tabindex="+1">Next</a></li>
      <li class="page-item disabled"><a class="page-link" tabindex="+1">Last</a></li>
    <?php endif; ?>
  </ul>
</footer>
</main>
