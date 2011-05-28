<?php

class slugifyTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'frontend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = '';
    $this->name             = 'slugify';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [slugify|INFO] task does things.
Call it with:

  [php symfony slugify|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    // add your code here
    $citations = Doctrine::getTable('Citation')
      ->createQuery('a')
      ->execute();
      
      foreach ($citations as $citation) {
      	$author = $citation->getAuthor();
      	$citation->author =  $citation->getAuthor().' '.$citation->getQuote();
      	$citation->quote =  $citation->getQuote();
      	$citation->save();
      	$citation->author =  $author;
      	$citation->save();
      	echo $citation->getSlug()."\n";
      }
  }
}
