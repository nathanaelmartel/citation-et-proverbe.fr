
  	<div class="adsense adsense-728">
			<?php foreach(AdsTable::getActivesByPosition(4) as $ads): ?>
				<?php echo $ads->getCode('ESC') ?>
			<?php endforeach; ?>
		</div>
		
<h1>Citation <?php echo $Category->getName() ?> <?php echo $Expression->getName() ?> <br/> meilleurs citations sur le theme <?php echo $Category->getName() ?> <?php echo $Expression->getName() ?></h1>

<div id="site-description" >
	<strong>Citation</strong> et <strong>Proverbe</strong> met à votre disposition une liste de <strong>citation</strong> sur le thème <strong><?php echo $Category->getName() ?> <?php echo $Expression->getName() ?></strong>. Parmi plus de 50 000 citations, voici les meilleures <strong>citations<?php echo $Category->getName() ?>  <?php echo $Expression->getName() ?></strong>, à partager bien sur !
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


		<div id="amazon-search" >
			<?php foreach(AdsTable::getActivesByPosition(3) as $ads): ?>
				<?php echo $ads->getCode('ESC') ?>
			<?php endforeach; ?>
		</div>