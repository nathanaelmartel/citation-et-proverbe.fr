<?php

class importDicocitationsTask extends sfBaseTask
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
    $this->name             = 'importDicocitations';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [importDicocitations|INFO] task does things.
Call it with:

  [php symfony importDicocitations|INFO]
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
    
    
    //$pages = Doctrine::getTable('Link')->findByUrl('dictionnaire-citations-auteurs.php');
    
    $q = Doctrine_Query::create()
    ->select('*')
    ->from('Link l')
    ->where('statut < ?', 3)
    //->andWhere('url LIKE ? ', 'auteur/%')
    ->andWhere('website = ? ', 'dicocitation')
    //->offset(rand(0, 100))
    ->limit(15)
    ->orderBy('updated_at');
    
    //echo $q->getSqlQuery();echo "\n";
    
    $pages = $q->execute();
    
    foreach ($pages as $page)
    {
      echo $page->url."\n";
      if (($page->statut < 3) && ($page->url != ''))
      {
        $html = $page->getPage('http://www.dicocitations.com/');
        echo "\tgetPage\n";
        
        $nb_url = $this->findURL($html);
        echo "\tfindURL $nb_url \n";
        $page->statut = 2;
        $page->save();
        /*
        $nb_citation = $this->findCitations($html, $page->url);
        echo "\tfindCitations $nb_citation \n";
        //$page->statut = 3;
        //$page->save();*/
      }
    }
  }
  
  protected function findURL($html) {
    $dom = new Zend_Dom_Query($html);
    $results = $dom->query('a');
    
    //$count = count($results);
    foreach ($results as $result) {
      $href = $result->getAttribute('href');
      
      if (substr_count($href, '../auteur/'))
      {
        $href = str_replace('../', '', $href);
        
        if (!substr_count($href, 'javascript'))
        {
          $links = Doctrine::getTable('Link')->findByUrl($href);
          if (count($links) == 0)
          {
            echo "***** New Link : $href ***** \n";
            if ($href != '')
            {
              $new_link = new Link;
              $new_link->url = $href;
              $new_link->website = 'dicocitation';
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
    
    if (substr_count($href, 'auteur/'))
      return $this->findCitationsAuteur($html);
     
    return 0;
  }
  
  protected function findCitationsAuteur($html) {
    $dom = new Zend_Dom_Query($html);
    $results = $dom->query('.citation .citationContenu');
    
    foreach ($results as $result) {
      
      $table = simplexml_import_dom($result)->asXML();
      $citation_dom = new Zend_Dom_Query($table);
      
    
      // citations
      $block_array = split('<a class="lv8bk"', $table);
      $text = simplementNat::cleanString($block_array[0]);
        
      
      // auteur
      $citation_text = $citation_dom->query('/font[1]/a[1]');
      $auteur = '';
      foreach ($citation_text as $citation_text_a)
      {
        $auteur .= simplementNat::cleanString(simplexml_import_dom($citation_text_a)->asXML());
        $auteur = str_replace('Citations de ', '', $auteur);
      }
      
      // source
      $citation_text = $citation_dom->query("a[@class='lv8bk']");
      $source = '';
      foreach ($citation_text as $citation_text_a)
      {
      	$citation_text_a_t = simplementNat::cleanString(simplexml_import_dom($citation_text_a)->asXML());
      	if (!substr_count($citation_text_a_t, 'Citations de '))
          $source .= $citation_text_a_t;
      }
      
      
      echo "text\t".$text."\n";
      echo "auteur\t".$auteur."\n";
      echo "source\t".$source."\n";
      //CitationTable::addCitation($text, $auteur, $source, 'dicocitation');
      
      echo "\n\n";
    }
    
    return count($results);
  }
  
  
}
