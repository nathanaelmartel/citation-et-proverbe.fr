<?php

class findWikipediaBioTask extends sfBaseTask
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
    $this->name             = 'findWikipediaBio';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [findWikipediaBio|INFO] task does things.
Call it with:

  [php symfony findWikipediaBio|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    // ALTER TABLE `author` ADD `wikipedia_bio` TEXT NOT NULL AFTER `author` 
    echo "******************************\nbegin \n";
    require_once('lib/vendor/Zend/Dom/Query.php');
    require_once('lib/nat/lib.php');
    
    $q = Doctrine_Query::create()
    ->select('*')
    ->from('Author a')
    ->where('wikipedia_url IS NULL')
    ->offset(0)
    ->limit(500);
    
    $authors = $q->execute();
    
    foreach ($authors as $author) {
      echo "author:\t\t".$author->author."\t\t";
      $file = "data/downloaded/wikipedia/$author->slug.html";
      
      if ($author->wikipedia_url == null) {
        if ($url = $this->searchWikipedia($author->author)) {
          
          $author->wikipedia_url = $url;
          $author->save();
          
          $html = $this->retrievePage($url, $file);
        } else {
          $author->wikipedia_url = '';
          $author->save();
        }
      }
      
      if (file_exists($file)) {
        $fp = fopen($file, "r");
        $html = fread($fp, filesize($file));
        fclose($fp);
    
        $bio = $this->retrieveBio($html);
        
        $author->wikipedia_bio = $bio;
        $author->save();
      }
      echo "\n";
    }
    
    
    echo "******************************\nend \n";
    
  }
  
  public function searchWikipedia($name)
  {
    
    // http://fr.wikipedia.org/w/api.php?action=opensearch&search=Aaron+Eckhart&format=json
    $url = 'http://fr.wikipedia.org/w/api.php?action=opensearch&search='.str_replace(' ', '+', $name).'&format=json';
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_USERAGENT, 'citation-et-proverbe.fr , nathanael@fam-martel.eu'); 
    curl_setopt($ch, CURLOPT_URL, $url );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);

    //echo $output;
    $response = json_decode($output);
    if (count($response[1]) > 0)
      return 'http://fr.wikipedia.org/wiki/'.str_replace(' ', '_', $response[1][0]);
    else {
      return false;
    }
  }
  
  public function retrievePage($url, $file) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_USERAGENT, 'citation-et-proverbe.fr , nathanael@fam-martel.eu'); 
    curl_setopt($ch, CURLOPT_URL, $url );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);

    $fp = fopen($file, "w");
    fwrite($fp, $output);
    fclose($fp);
    
    return $output;
  }
  
  public function retrieveBio($html) {
    $dom = new Zend_Dom_Query($html);
    $results = $dom->query('#mw-content-text>p');
    
    foreach ($results as $result) {
        return strip_tags(simplexml_import_dom($result)->asXML());
        echo "\n";die();
    }
  }
  
}
