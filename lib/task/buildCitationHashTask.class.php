<?php

class buildCitationHashTask extends sfBaseTask
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
    $this->name             = 'buildCitationHash';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [buildCitationHash|INFO] task does things.
Call it with:

  [php symfony buildCitationHash|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();
    
    // add your code here
    $q = Doctrine_Query::create()
    ->select('*')
    ->from('Citation c')
    ->where('hash = ?', '')
    ->limit(10);
    
    //echo $q->getSqlQuery();echo "\n";
    
    $citations = $q->execute();
    
    foreach ($citations as $citation)
    {
    	$hash = simplementNat::slugify($citation->quote.' '.$citation->author);
    	$hash = str_replace(' ', '-', $hash);
    	$hash = trim($hash, '-');
    	$citation->hash = substr($hash, 0, 64);
    	$citation->save();
    }
  }
}
