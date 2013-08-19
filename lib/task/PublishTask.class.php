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
    //SELECT SUBSTRING( `created_at` , 1, 7 ) , count( id ) FROM `citation` GROUP BY SUBSTRING( `created_at` , 1, 7 ) LIMIT 0 , 30
    
    $order_field = array('updated_at', 'last_published_at', 'author', 'quote');
        
    $q = Doctrine_Query::create()
    ->select('*')
    ->from('Citation c')
    ->where('is_active = ?', 1)
    //->andWhere('SUBSTRING( `created_at` , 1, 7 ) <> ?', '2010-08')
    //->andWhere('SUBSTRING( `created_at` , 1, 7 ) <> ?', '2010-09')
    ->andWhere('`source`  <> ?', '')
    ->offset(rand(0, rand(0, 10000)))
    ->limit(10)
    ->orderBy('last_published_at asc');
    
    //echo $q->getSqlQuery();echo "\n";die;
    
    $citation = $q->fetchOne();
    
    $message = $citation->getTwitterMessage(false, false);
    
		//echo $message;echo "\n";die;
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
      echo "\n";
		}
		else
		{ 
		  echo "\nfailed\n";
		  echo $message;
		}
    
    echo "\n";
    $citation->last_published_at =  date('Y-m-d G:i:s');
    $citation->save();   
  }

  
}


