

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
		</div>

      
      
		<div id="amazon-search" >
			<?php foreach(AdsTable::getActivesByPosition(13) as $ads): ?>
				<?php echo $ads->getCode('ESC') ?>
			<?php endforeach; ?>
		</div>