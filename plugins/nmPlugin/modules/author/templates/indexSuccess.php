    
		<div class="adsense adsense-728">
			<?php foreach(AdsTable::getActivesByPosition(11) as $ads): ?>
				<?php echo $ads->getCode('ESC') ?>
			<?php endforeach; ?>
		</div>


<!-- google_ad_section_start -->
 
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

<!-- google_ad_section_end -->


      
		<div id="amazon-search" >
			<?php foreach(AdsTable::getActivesByPosition(12) as $ads): ?>
				<?php echo $ads->getCode('ESC') ?>
			<?php endforeach; ?>
		</div>