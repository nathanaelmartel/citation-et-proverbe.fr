<!-- google_ad_section_start -->

<h1>Thèmes de Citations</h1>

<h2>Top 10 des thèmes de citations</h2>

<div class="authors top-authors">
	<ul>
		<?php foreach($top_words as $word): ?>
			<li>
				<a href="<?php echo url_for('@word?slug='.$word['slug'] )?>" class="author"><?php echo $word['name'] ?> (<?php echo $word['nb'] ?> citations)</a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>

<div class="clear"></div>

<h2>Top 100 des thèmes de citations</h2>

<div class="authors">
	<ul>
		<?php foreach($words as $word): ?>
			<li>
				<a href="<?php echo url_for('@word?slug='.$word['slug'] )?>" class="author"><?php echo $word['name'] ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>

<div class="clear"></div>

<!-- google_ad_section_end -->
