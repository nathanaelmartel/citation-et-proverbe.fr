
  	<div class="adsense adsense-728">
			<?php foreach(AdsTable::getActivesByPosition(4) as $ads): ?>
				<?php echo $ads->getCode('ESC') ?>
			<?php endforeach; ?>
		</div>
		
<h1>Citation <?php echo $Category->getName() ?> <br/> meilleurs citations sur le theme <?php echo $Category->getName() ?></h1>


<div class="authors">
	<ul>
		<?php foreach($Expressions as $Expression): ?>
			<?php if ($Expression->getCountCitations() > 0): ?>
				<li>
					<a href="<?php echo url_for('@themes_expression?theme='.$Category->getSlug().'&expression='.$Expression->getSlug() )?>" class="author"><?php echo $Category->getName() ?> <?php echo $Expression->getName() ?></a>
				</li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>
</div>

<div class="clear"></div>


		<div id="amazon-search" >
			<?php foreach(AdsTable::getActivesByPosition(3) as $ads): ?>
				<?php echo $ads->getCode('ESC') ?>
			<?php endforeach; ?>
		</div>