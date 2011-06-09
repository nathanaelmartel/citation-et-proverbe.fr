<h1><?php echo $word->getName() ?></h1>

<?php foreach($citations as $citation): ?>
  <?php include_partial('citation/citation', array('citation' => $citation)) ?>
<?php endforeach; ?>
