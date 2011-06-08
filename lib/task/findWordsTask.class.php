<?php

class findWordsTask extends sfBaseTask
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
    $this->name             = 'findWords';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [findWords|INFO] task does things.
Call it with:

  [php symfony findWords|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();
/*
SELECT * FROM (
SELECT name, count(citation_id) as nb
FROM word
LEFT OUTER JOIN word_citation ON (id=word_id)
GROUP BY name ) as aaa
ORDER BY nb DESC
 */
    
    
    
    
    // add your code here
    for($i = 0;$i < 60000; $i += 100)
    {
	    $q = Doctrine_Query::create()
	    ->select('*')
	    ->from('Citation c')
	    ->limit(100)
	    ->offset($i);
	    
	    //echo $q->getSqlQuery();echo "\n";
	    
	    $citations = $q->execute();
	    
	    foreach ($citations as $citation) 
	    {
	    	//print_r($citation->getWords());
	    	echo $citation->getId()."\n";
	    	foreach ($citation->getWords() as $word)
	    	{
	    		WordTable::addWord($word, $citation->id);
	    	}
	    }
    }
    echo "\n";
  }
}
