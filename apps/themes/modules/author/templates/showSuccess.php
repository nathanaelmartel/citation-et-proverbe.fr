
  	<div class="adsense adsense-728">
			<?php foreach(AdsTable::getActivesByPosition(9) as $ads): ?>
				<?php echo $ads->getCode('ESC') ?>
			<?php endforeach; ?>
		</div>

<h1>Citations de <br/><?php echo $author->getAuthor() ?> <br/>sur le thème : <?php echo $Category->getName() ?></h1>


<?php if(count($citations)): ?>

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
	
<?php else: ?>
	<div class="adsense adsense-728">
		<p>Il n'y a pas de citation de <?php echo $author->getAuthor() ?> sur le thème : <?php echo $Category->getName() ?></p>
		<p>Retrouvez d'autre <strong><a href="http://www.citation-et-proverbe.fr<?php echo url_for('@author?slug='.$author->getSlug()) ?>" target="_blank">citation de <?php echo $author->getAuthor() ?></a></strong></p>
	</div>
<?php endif; ?>

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