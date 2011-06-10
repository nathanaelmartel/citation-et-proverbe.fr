<h1>Auteurs de Citations</h1>

<div class="authors">
	<?php foreach($authors as $author): ?>
		<a href="<?php url_for('@author?slug='.$author['slug'] )?>" class="author" style="font-size:<?php echo $author['nb'] ?>%"><?php echo $author['author'] ?></a>
	<?php endforeach; ?>
</div>
