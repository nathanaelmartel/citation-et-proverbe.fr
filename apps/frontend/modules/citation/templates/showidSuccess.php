<?php slot('header') ?>
  <link rel="canonical" href="<?php echo url_for('@single_citation?slug='.$citation->slug, array('absolute' => true)) ?>" />
  <meta property="og:title" content="«<?php echo $citation->getQuote(ESC_RAW); ?>» <?php echo $citation->getAuthor(); ?>" />
  <meta property="og:description" content="«<?php echo $citation->getQuote(ESC_RAW); ?>» <?php echo $citation->getAuthor(); ?>. <?php echo $citation->getAuthorWikipediaBio(); ?>" />
  <meta name="twitter:card" content="summary" />
  <meta name="twitter:url" content="<?php echo url_for('@single_citation?slug='.$citation->slug, array('absolute' => true)) ?>" />
  <meta name="twitter:title" content="«<?php echo $citation->getQuote(ESC_RAW); ?>» <?php echo $citation->getAuthor(); ?>" />
  <meta name="twitter:description" content="«<?php echo $citation->getQuote(ESC_RAW); ?>» <?php echo $citation->getAuthor(); ?>. <?php echo $citation->getAuthorWikipediaBio(); ?>" />
  <meta name="twitter:site" content="@citation_fr" />
<?php end_slot() ?>


  	<div class="adsense adsense-728">
			<?php foreach(AdsTable::getActivesByPosition(14) as $ads): ?>
				<?php echo $ads->getCode('ESC') ?>
			<?php endforeach; ?>
		</div>

      <?php include_partial('citation/citation', array('citation' => $citation)) ?>
      
      
  	<div class="adsense adsense-728">
			<?php foreach(AdsTable::getActivesByPosition(15) as $ads): ?>
				<?php echo $ads->getCode('ESC') ?>
			<?php endforeach; ?>
			<?php for ($i=1 ; $i<10 ; $i++): $id = $citation->id+bcpow($i,2); ?>
				<a href="<?php echo url_for('@single_citation_id?id='.$id, array('absolute' => true)) ?>" >citation <?php echo $id ?></a>
			<?php endfor; ?>
			<?php for ($i=2 ; $i<100 ; $i++): $id = $citation->id+$i*2; ?>
				<a href="<?php echo url_for('@single_citation_id?id='.$id, array('absolute' => true)) ?>" >citation <?php echo $id ?></a>
			<?php endfor; ?>
			<?php for ($i=2 ; $i<100 ; $i++): $id = $citation->id+$i; ?>
				<a href="<?php echo url_for('@single_citation_id?id='.$id, array('absolute' => true)) ?>" >citation <?php echo $id ?></a>
			<?php endfor; ?>
		</div>