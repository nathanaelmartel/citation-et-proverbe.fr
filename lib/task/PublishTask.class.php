<?php

class PublishTask extends sfBaseTask
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
    $this->name             = 'Publish';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [Publish|INFO] task does things.
Call it with:

  [php symfony Publish|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    //echo "\n";
    
    $order_field = array('updated_at', 'last_published_at', 'author', 'quote');
        
    $q = Doctrine_Query::create()
    ->select('*')
    ->from('Citation c')
    ->where('is_active = ?', 1)
    ->offset(rand(0, 1000))
    ->limit(10)
    ->orderBy('last_published_at asc');
    
    //echo $q->getSqlQuery();echo "\n";die;
    
    $hour = date('H');
    
    if (($hour < 7) || (($hour%2) == 0))
      die("pas de twitt à cette heure ci : pas de post la nuit, ni les heures paires\n");
    
    $citation = $q->fetchOne();
    
    $message = $citation->getTwitterMessage();
    
		//echo $message;
		//echo "\n";
    $keys['app_consumer_key'] = 'yCoanARNtjPwX4LenZLqTQ';
    $keys['app_consumer_secret'] = 'lGJlKSRxrAYW9onwmigQyBmiowlUjv2hYOGDsH5JY8';
    $keys['oauth_token'] = '184945759-cmsehTb775iS8erxzySwIt2Y6jAV23H1W0E0p0rg';
    $keys['oauth_token_secret'] = '3551nBlC5zbalRpgIJulwX8U8aytotfQgqCwG8OpnoE';
    $json_keys = json_encode($keys);
		
    if (simplementNat::twitter_statuses_update($message, $json_keys))
		{
		  echo "\nsuccess\n";
		echo $message;
	    $citation->last_published_at =  date('Y-m-d G:i:s');
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


