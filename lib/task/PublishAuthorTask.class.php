<?php

class PublishAuthorTask extends sfBaseTask
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
    $this->name             = 'PublishAuthor';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [PublishAuthor|INFO] task does things.
Call it with:

  [php symfony PublishAuthor|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();
    
    
    // http://dev.twitter.com/apps/new
  
    
      $q = Doctrine_Query::create()
    ->select('*')
    ->from('Author a')
    //->limit(20)
    ->where('twitter_account <> ?', '' )
    ->andWhere('is_active = ?', 1);
    
    //echo $q->getSqlQuery();echo "\n";die;
    
    $auteurs = $q->execute();
    foreach ($auteurs as $auteur)
    {
      echo "***** Author : ".$auteur->getAuthor()." ***** \n";
       
	    $q = Doctrine_Query::create()
	    ->select('*')
	    ->from('Citation c')
      ->where('is_active = ?', 1)
      ->andWhere('author = ?', $auteur->getAuthor())
	    ->orderBy('author_last_published_at asc');
	    
      //echo $q->getSqlQuery();echo "\n";
      
	    $citation = $q->fetchOne();
      $message = json_encode($citation->getTwitterMessage(false));
      
      if (false)//simplementNat::twitter_statuses_update($message, $auteur->getTwitterKeys()))
	    {
	      echo "\nsuccess\n";
		echo $message;
	      $citation->author_last_published_at = date('Y-m-d G:i:s');
	      $citation->save();   
	      echo "\n";
	    }
	    else
	    { 
	      echo "\nfailed\n";
		echo $message;
	    }
	    
	    echo "\n";
      
    }
    
  }
}
