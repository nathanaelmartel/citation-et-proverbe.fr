<?php

class importEveneTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = '';
    $this->name             = 'importEvene';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [importEvene|INFO] task does things.
Call it with:

  [php symfony importEvene|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();
    
    echo "******************************\nbegin \n";
    require_once('lib/vendor/Zend/Dom/Query.php');
    require_once('lib/nat/lib.php');
    
    //$pages = Doctrine::getTable('Link')->findByUrl('theme/baccalaureat.php');
    
    $q = Doctrine_Query::create()
    ->select('*')
    ->from('Link l')
    ->where('statut < ?', 3)
    //->andWhere('url LIKE ? ', 'mot.php%')
    ->andWhere('website = ? ', 'evene')
    ->offset(rand(0, 100))
    ->limit(20)
    ->orderBy('updated_at');
    
    //echo $q->getSqlQuery();echo "\n";
    
    $pages = $q->execute();
    
    foreach ($pages as $page)
    {
    	echo $page->url."\n";
    	if (($page->statut < 3) && ($page->url != ''))
    	{
    		$html = $page->getPage('http://www.evene.fr/citations/');
    		echo "\tgetPage\n";
        
        $nb_url = $this->findURL($html);
        echo "\tfindURL $nb_url \n";
        $page->statut = 2;
        $page->save();
        
	      $nb_citation = $this->findCitations($html, $page->url);
        echo "\tfindCitations $nb_citation \n";
        $page->statut = 3;
        $page->save();
    	}
    }
    
    // add your code here
  }
  
  protected function findURL($html) {
    $dom = new Zend_Dom_Query($html);
    $results = $dom->query('a');
    
    //$count = count($results);
    foreach ($results as $result) {
      $href = $result->getAttribute('href');
      if ((substr_count($href, 'http://www.evene.fr/citations/')) || (substr_count($href, '/citations/')))
      {
        $href = str_replace('http://www.evene.fr/citations/', '', $href);
        $href = str_replace('/citations/', '', $href);
        
        if (!substr_count($href, 'javascript:OpenWin'))
        {
	        $links = Doctrine::getTable('Link')->findByUrl($href);
	        if (count($links) > 0)
	        {
	          //echo "***** Aleady added : $href ***** \n";
	        } else {
	        	if ($href != '')
	        	{
		          $new_link = new Link;
		          $new_link->url = $href;
		          $new_link->website = 'evene';
		          $new_link->statut = 0;
		          $new_link->save();
	        	}
	        }
        }
      }
    }
    
    return count($results);
  }
  
  protected function findCitations($html, $href) {
    
    if (substr_count($href, 'theme/'))
      return $this->findCitationsThemes($html);
    
    if (substr_count($href, 'mot.php'))
      return $this->findCitationsMots($html);
  	 
    return 0;
  }
  
  protected function findCitationsThemes($html) {
    $dom = new Zend_Dom_Query($html);
    $results = $dom->query('.bloc_content.trait_liste table');
    
    foreach ($results as $result) {
    	
      $table = simplexml_import_dom($result)->asXML();
      $citation_dom = new Zend_Dom_Query($table);
    
      // citations
      $citation_text = $citation_dom->query('/tr[1]/td[1]');
      $text = '';
      foreach ($citation_text as $citation_text_a)
      {
      	$text = simplementNat::cleanString(simplexml_import_dom($citation_text_a)->asXML());
      }
      
      // auteur
      $citation_text = $citation_dom->query('/tr[2]/td[1]');
      $auteur = '';
      foreach ($citation_text as $citation_text_a)
      {
        $auteur = simplementNat::cleanString(simplexml_import_dom($citation_text_a)->asXML());
        $auteur = str_replace('[', '', $auteur);
        $auteur = str_replace(']', '', $auteur);
      }
      
      // source
      $citation_text = $citation_dom->query('/tr[3]/td[1]');
      $source = '';
      foreach ($citation_text as $citation_text_a)
      {
        $source = simplementNat::cleanString(simplexml_import_dom($citation_text_a)->asXML());
      }
      
      CitationTable::addCitation($text, $auteur, $source, 'evene');
      
      //echo "\n\n";
    }
    
    return count($results);
  }
  
  protected function findCitationsMots($html) {
    $dom = new Zend_Dom_Query($html);
    $results = $dom->query('table.trait_liste');
    
    foreach ($results as $result) {
      
      $table = simplexml_import_dom($result)->asXML();
      $citation_dom = new Zend_Dom_Query($table);
    
      // citations
      $citation_text = $citation_dom->query('span.txtC40.B14');
      $text = '';
      foreach ($citation_text as $citation_text_a)
      {
        $text = simplementNat::cleanString(simplexml_import_dom($citation_text_a)->asXML());
      }
      
      // auteur
      $citation_text = $citation_dom->query('a.B14.txtC30');
      $auteur = '';
      foreach ($citation_text as $citation_text_a)
      {
        $auteur = simplementNat::cleanString(simplexml_import_dom($citation_text_a)->asXML());
        $auteur = str_replace('[', '', $auteur);
        $auteur = str_replace(']', '', $auteur);
      }
      
      // source
      $citation_text = $citation_dom->query('span.N12.txtNr');
      $source = '';
      foreach ($citation_text as $citation_text_a)
      {
        $source = simplementNat::cleanString(simplexml_import_dom($citation_text_a)->asXML());
      }
      
      CitationTable::addCitation($text, $auteur, $source, 'evene');
      
      //echo "\n\n";
    }
    
    return count($results);
  }
  
}
