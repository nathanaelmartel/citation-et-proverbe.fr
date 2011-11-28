

	
    <div class="adsense adsense-728">
			<?php foreach(AdsTable::getActivesByPosition(1) as $ads): ?>
				<?php echo $ads->getCode('ESC') ?>
			<?php endforeach; ?>
		</div>

<?php $i=0;foreach($citations as $citation): ?>
  <?php include_partial('citation/citation', array('citation' => $citation)) ?>
  
  <?php if($i++%5 == 1): ?>
  	<div class="adsense adsense-728">
			<?php foreach(AdsTable::getActivesByPosition(2) as $ads): ?>
				<?php echo $ads->getCode('ESC') ?>
			<?php endforeach; ?>
		</div>
  <?php endif; ?>
  
<?php endforeach; ?>
      
      
		<div id="amazon-search" >
			<?php foreach(AdsTable::getActivesByPosition(0) as $ads): ?>
				<?php echo $ads->getCode('ESC') ?>
			<?php endforeach; ?>
		</div>