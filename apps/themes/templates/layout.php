<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" class="no-js">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" />
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
    <link rel="alternate" type="application/rss+xml" title="flux" href="/feed" />
    <link rel="apple-touch-icon" href="/apple-touch-icon.png" />
    <link rel="author" href="/humans.txt" />
  </head>
  <body>
    <?php include_partial('global/nav')?>
    <?php echo $sf_content ?>
    <?php include_partial('global/footer')?>
    <script type="text/javascript" src="https://apis.google.com/js/plusone.js">
		  {lang: 'fr'}
		</script>
    <?php include_partial('global/piwik')?>
  </body>
</html>