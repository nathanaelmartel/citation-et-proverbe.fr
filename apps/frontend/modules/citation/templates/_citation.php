
      <article>
	      <blockquote>
	      	<a rel="bookmark" class="permalink" href="<?php echo url_for('@single_citation?slug='.$citation->getSlug(), true) ?>">#</a>
	      	<?php echo $citation->getQuoteWord(ESC_RAW) ?>
	      </blockquote>
	      
	      <!--  <?php echo $citation->getActiveWords() ?> -->
	      
	      <?php if ($citation->getAuthor()): ?>
		      <div class="author">
            <?php if ($citation->getAuthorSlug()): ?>
		          <a href="<?php echo url_for('@author?slug='.$citation->getAuthorSlug()) ?>" title="citation <?php echo $citation->getAuthor() ?> – Proverbe <?php echo $citation->getAuthor() ?>" >
				      	<?php echo $citation->getAuthor() ?>
		          </a>
		        <?php else: ?>
              <?php echo $citation->getAuthor() ?>
		        <?php endif ?>
		      </div>
	      <?php endif;?>
	      
	      <?php if ($citation->getSource()): ?>
		      <div class="source">
		      	<?php echo $citation->getSource() ?>
		      </div>
	      <?php endif;?>
        
          <div class="share">
            <a href="http://www.facebook.com/sharer.php?u=<?php echo url_for('@single_citation?slug='.$citation->getSlug(), array('absolute' => true)) ?>&t=<?php echo str_replace(' ', '%20', substr($citation->getQuote(), 0, stripos($citation->getQuote(), ' ', 50)+1 ).'... - '.$citation->getAuthor())?>" target="_blank" title="partager sur facebook" class="share-facebook" > </a>
            <a href="http://twitter.com/share?text=<?php echo str_replace(' ', '%20', substr($citation->getQuote(), 0, stripos($citation->getQuote(), ' ', 50)+1 ).'... - '.$citation->getAuthor())?>&url=<?php echo url_for('@single_citation?slug='.$citation->getSlug(), array('absolute' => true)) ?>" target="_blank" title="partager sur twitter" class="share-twitter" ></a>
            <span>Partagez cette citation !</span>
          </div>
          
      </article>
