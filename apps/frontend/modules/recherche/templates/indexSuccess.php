
  	<div class="search-form">
			<div id="cse-search-results"></div>
			<script type="text/javascript">
			  var googleSearchIframeName = "cse-search-results";
			  var googleSearchFormName = "cse-search-box";
			  var googleSearchFrameWidth = 800;
			  var googleSearchDomain = "www.google.fr";
			  var googleSearchPath = "/cse";
			</script>
			<script type="text/javascript" src="http://www.google.com/afsonline/show_afs_search.js"></script>
		</div>
		
		
  	<div class="adsense adsense-728">
			<?php foreach(AdsTable::getActivesByPosition(14) as $ads): ?>
				<?php echo $ads->getCode('ESC') ?>
			<?php endforeach; ?>
		</div>
		
		
  	<div class="search-form">
	  	<script type="text/javascript" src="http://www.google.com/cse/query_renderer.js"></script>
			<div id="queries"></div>
			<script src="http://www.google.com/cse/api/partner-pub-6736033252489950/cse/4620028292/queries/js?oe=UTF-8&amp;callback=(new+PopularQueryRenderer(document.getElementById(%22queries%22))).render"></script>
		</div>