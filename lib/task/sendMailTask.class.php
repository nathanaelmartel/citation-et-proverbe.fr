<?php

class sendMailTask extends sfBaseTask
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
    $this->name             = 'sendMail';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [sendMail|INFO] task does things.
Call it with:

  [php symfony sendMail|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();
    
    $citations = Doctrine::getTable('Citation')
      ->createQuery('a')
      ->where('is_active = ?', 1)
      ->limit(5)
      ->orderBy('last_published_at desc')
      ->execute();
    $citation = $citations[0];
    echo "\n";
    echo "citation: \n";
    echo $citation->quote;
    
	    if ($citation->getAuthor())
	    {
		    if ($citation->getAuthorSlug()) 
		    	$auteur = ' <a href="http://www.citation-et-proverbe.fr/auteur/'.$citation->getAuthorSlug().'?utm_source=mail&utm_medium=mail&utm_campaign=mail" >'.$citation->author.'</a>' ;
		   	else 
		    	$auteur =  $citation->author ;
	    }
	
    $message_text = '<p>Bonjour, <br />

						<p>'.$citation->quote.''.$auteur.'</p>
						
						<p>Citations<br />
						<a href="http://www.citation-et-proverbe.fr?utm_source=mail&utm_medium=mail&utm_campaign=mail">http://www.citation-et-proverbe.fr</a>
						</p>';

    echo "\n";
    echo "message: \n";
    echo $message_text;
    echo "\n";
    echo "abonnes: \n";
    
    $newsletters = Doctrine::getTable('Newsletter')
    	->createQuery('a')
        ->where('is_confirmed = ?', 1)
        ->execute();
    
    
    foreach ($newsletters as $newsletter) {
    	$message = $this->getMailer()->compose(
    		'contact@citation-et-proverbe.fr',
    		$newsletter->getEmail(),
    		'citation du jour',
    		$message_text
    	);
    	$this->getMailer()->send($message);
		echo $newsletter->getEmail()."\n";
    }
    echo "\n";
  }
}
