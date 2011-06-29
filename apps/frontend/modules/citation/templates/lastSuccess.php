
<?php foreach($citations as $citation): ?>
  <?php include_partial('citation/citation', array('citation' => $citation)) ?>
  
  <?php if($i++%5 == 1): ?>
  	<?php include_partial('citation/adsense728') ?>
  <?php endif; ?>
  
<?php endforeach; ?>
      