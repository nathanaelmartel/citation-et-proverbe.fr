

      <article>
      
				<!-- google_ad_section_start -->

	      <blockquote>
	      	<a rel="bookmark" class="permalink" href="<?php echo url_for('@single_citation?slug='.$citation->getSlug(), true) ?>">#</a>
	      	<?php echo $citation->getQuote() ?>
	      </blockquote>
	      
	      <?php if ($citation->getAuthor()): ?>
		      <div class="author" >
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
		      <div class="source" >
		      	<?php echo $citation->getSource() ?>
		      </div>
	      <?php endif;?>
				
				<?php if ($citation->getAuthor()): ?>
		      <div class="books" >
		      	<a href="http://www.amazon.fr/gp/search?ie=UTF8&keywords=<?php echo str_replace(' ', '%20', $citation->getAuthor().' '.$citation->getSource() ) ?>&tag=citatetprov05-21&index=books&linkCode=ur2&camp=1642&creative=6746" target="_blank" >Achetez les livres de <?php echo $citation->getAuthor() ?></a>
		      	<img src="http://www.assoc-amazon.fr/e/ir?t=citatetprov05-21&l=ur2&o=8" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />
		      </div>
	      <?php endif;?>

				<!-- google_ad_section_end -->
        
        <div class="share">
          <a href="http://www.facebook.com/sharer.php?u=<?php echo url_for('@single_citation?slug='.$citation->getSlug(), array('absolute' => true)) ?>&t=<?php echo str_replace(' ', '%20', substr($citation->getQuote(), 0, stripos($citation->getQuote(), ' ', 50)+1 ).'... - '.$citation->getAuthor())?>" target="_blank" title="partager sur facebook" class="share-facebook" > </a>
          <a href="http://twitter.com/share?text=<?php echo str_replace(' ', '%20', $citation->getQuote().' - '.$citation->getAuthor())?>&url=<?php echo url_for('@single_citation?slug='.$citation->getSlug(), array('absolute' => true)) ?>" target="_blank" title="partager sur twitter" class="share-twitter" ></a>
          <span class="google-plus-1"><g:plusone count="false" href="<?php echo url_for('@single_citation?slug='.$citation->getSlug(), array('absolute' => true)) ?>"></g:plusone></span>
          <span class="phrase">Partagez cette citation !</span>
        </div>
          
      </article>

