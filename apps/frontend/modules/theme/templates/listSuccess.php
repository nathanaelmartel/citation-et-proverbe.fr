
  	<div class="adsense adsense-728">
			<?php foreach(AdsTable::getActivesByPosition(4) as $ads): ?>
				<?php echo $ads->getCode('ESC') ?>
			<?php endforeach; ?>
		</div>
		
<h1>Thèmes de Citations</h1>





<div class="authors top-authors">
<ul>
		<?php foreach($Categories as $Category): ?>
			<li>
				<a href="<?php echo url_for('@theme?theme='.$Category->getSlug() )?>" class="author"><?php echo $Category->getName() ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>

  	<div class="adsense adsense-728">
			<?php foreach(AdsTable::getActivesByPosition(5) as $ads): ?>
				<?php echo $ads->getCode('ESC') ?>
			<?php endforeach; ?>
		</div>

		<div id="amazon-search" >
			<?php foreach(AdsTable::getActivesByPosition(3) as $ads): ?>
				<?php echo $ads->getCode('ESC') ?>
			<?php endforeach; ?>
		</div>