<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9             http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

<?php foreach ($Categories as $Category): ?>
<url>
  <loc>
  	<?php echo url_for('@theme?theme='.$Category->getSlug(), array('absolute' => true)) ?>
  </loc>
</url>
	<?php foreach ($Category->getExpressions() as $Expression): ?>
		<?php if ($Expression->getCountCitations() > 0): ?>
		<url>
		  <loc>
		  	<?php echo url_for('@themes_expression?theme='.$Category->getSlug().'&expression='.$Expression->getSlug(), array('absolute' => true)) ?>
		  </loc>
		</url>
		<?php endif; ?>	
	<?php endforeach; ?>
<?php endforeach; ?>



<?php foreach ($authors as $author): ?>
<url>
  <loc>
  	<?php echo url_for('@author?slug='.$author->getSlug(), array('absolute' => true)) ?>
  </loc>
</url>
<?php endforeach; ?>

<?php foreach ($words as $word): ?>
<url>
  <loc>
  	<?php echo url_for('@word?slug='.$word->getSlug(), array('absolute' => true)) ?>
  </loc>
</url>
<?php endforeach; ?>

<?php foreach ($citations as $citation): ?>
<url>
  <loc>
  	<?php echo url_for('@single_citation?slug='.$citation->getSlug(), array('absolute' => true)) ?>
  </loc>
</url>
<?php endforeach; ?>
  
</urlset>