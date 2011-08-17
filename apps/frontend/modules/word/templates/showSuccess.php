
  	<div class="adsense adsense-728">
			<?php foreach(AdsTable::getActivesByPosition(4) as $ads): ?>
				<?php echo $ads->getCode('ESC') ?>
			<?php endforeach; ?>
		</div>
		
<h1>Citation <?php echo $word->getName() ?> <br/> meilleurs citations sur le theme <?php echo $word->getName() ?></h1>

<div id="site-description" >
	<strong>Citation</strong> et <strong>Proverbe</strong> met à votre disposition une liste de <strong>citation</strong> sur le thème <strong><?php echo $word->getName() ?></strong>. Parmi plus de 50 000 citations, voici les meilleures <strong>citations <?php echo $word->getName() ?></strong>, à partager bien sur !
</div>

<?php foreach($citations as $citation): ?>
  <?php include_partial('citation/citation', array('citation' => $citation)) ?>
  
  <?php if($i++%5 == 1): ?>
  	<div class="adsense adsense-728">
			<?php foreach(AdsTable::getActivesByPosition(5) as $ads): ?>
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
				<?php echo link_to($page, '@word?slug='.$word->getSlug().'&page='.$page) ?>
			<?php endif; ?>
		<?php endforeach ?>
	</div>    
<?php endif ?>


		<div id="amazon-search" >
			<?php foreach(AdsTable::getActivesByPosition(3) as $ads): ?>
				<?php echo $ads->getCode('ESC') ?>
			<?php endforeach; ?>
		</div>