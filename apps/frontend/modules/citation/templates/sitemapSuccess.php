<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9             http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

<?php foreach ($authors as $author): ?>
<url>
  <loc>http://www.citation-et-proverbe.fr/auteur/<?php echo $author->getSlug() ?></loc>
</url>
<?php endforeach; ?>

<?php foreach ($citations as $citation): ?>
<url>
  <loc>http://www.citation-et-proverbe.fr/<?php echo $citation->getSlug() ?></loc>
</url>
<?php endforeach; ?>
  
</urlset>
