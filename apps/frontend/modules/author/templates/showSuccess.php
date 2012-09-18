
<?php slot('header') ?>
  <link rel="canonical" href="<?php echo url_for('@author?slug='.$author->slug, array('absolute' => true)) ?>" />
  <meta property="og:title" content="Citations de <?php echo $author->getAuthor() ?>" />
  <meta property="og:description" content="«<?php echo $first_citation->getQuote(ESC_RAW); ?> ?>» <?php echo $author->wikipedia_bio ?>" />
  <meta name="twitter:card" content="summary" />
  <meta name="twitter:url" content="<?php echo url_for('@author?slug='.$author->slug, array('absolute' => true)) ?>" />
  <meta name="twitter:title" content="Citations de <?php echo $author->getAuthor() ?>" />
  <meta name="twitter:description" content="«<?php echo $first_citation->getQuote(ESC_RAW); ?> ?>» <?php echo $author->wikipedia_bio ?>" />
  <meta name="twitter:site" content="@citation_fr" />
<?php end_slot() ?>


  	<div class="adsense adsense-728">
			<?php foreach(AdsTable::getActivesByPosition(9) as $ads): ?>
				<?php echo $ads->getCode('ESC') ?>
			<?php endforeach; ?>
		</div>

<h1>Citations de <?php echo $author->getAuthor() ?></h1>

<div class="wikipedia">
  <p>
    <?php echo $author->wikipedia_bio ?>
    <?php if ($author->wikipedia_url): ?>
      <a href="<?php echo $author->wikipedia_url ?>" target="_blank" ><?php echo $author->getAuthor() ?> sur Wikipedia</a>
    <?php endif; ?>
  </p> 
</div>

<?php foreach($citations as $citation): ?>
  <?php include_partial('citation/citation', array('citation' => $citation)) ?>
  
  <?php if($i++%5 == 1): ?>
  	<div class="adsense adsense-728">
			<?php foreach(AdsTable::getActivesByPosition(10) as $ads): ?>
				<?php echo $ads->getCode('ESC') ?>
			<?php endforeach; ?>
		</div>
  <?php endif; ?>
  
<?php endforeach; ?>


<?php if ($citations->haveToPaginate()): ?>
	<div class="pagination">
		<?php $links = $citations->getLinks(); ?>
		<?php foreach ($links as $page): ?>
			<?php if ($page == $citations->getPage()): ?>
				<span><?php echo $page?></span>
			<?php else: ?>
				<?php echo link_to($page, '@author?slug='.$author->getSlug().'&page='.$page) ?>
			<?php endif; ?>
		<?php endforeach ?>
	</div>    
<?php endif ?>



      
		<div id="amazon-search" >
			<?php foreach(AdsTable::getActivesByPosition(8) as $ads): ?>
				<?php echo $ads->getCode('ESC') ?>
			<?php endforeach; ?>
		</div>