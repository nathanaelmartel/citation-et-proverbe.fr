    
		<div class="adsense adsense-728">
			<?php foreach(AdsTable::getActivesByPosition(6) as $ads): ?>
				<?php echo $ads->getCode('ESC') ?>
			<?php endforeach; ?>
		</div>


<!-- google_ad_section_start -->

<h1>Citations sur <?php echo $Category->getName() ?></h1>

<div class="authors top-authors">
	<ul>
		<?php foreach($Expressions as $Expression): ?>
			<?php if ($Expression->getCountCitations() > 0): ?>
			<li>
				<a href="<?php echo url_for('@theme?slug='.$Expression->slug )?>" class="author"><?php echo $Expression->name ?></a>
			</li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>
</div>
		
		<div class="clear"></div>