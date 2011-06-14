<h1>Auteurs de Citations</h1>

<h2>Top 10 des auteurs de citations</h2>

<div class="authors top-authors">
	<ul>
		<?php foreach($top_authors as $author): ?>
			<li>
				<a href="<?php echo url_for('@author?slug='.$author['slug'] )?>" class="author"><?php echo $author['author'] ?> (<?php echo $author['nb'] ?> citations)</a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>

<div class="clear"></div>

<h2>Top 100 des auteurs de citations</h2>

<div class="authors">
	<ul>
		<?php foreach($authors as $author): ?>
			<li>
				<a href="<?php echo url_for('@author?slug='.$author['slug'] )?>" class="author"><?php echo $author['author'] ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>

<div class="clear"></div>

