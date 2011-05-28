<h1>Citations de <?php echo $author->getAuthor() ?></h1>

<?php foreach($citations as $citation): ?>
  <?php include_partial('citation/citation', array('citation' => $citation)) ?>
<?php endforeach; ?>
