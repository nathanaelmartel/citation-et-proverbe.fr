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
	
    $message_text = '<p>Bonjour, <br />Voici la citation du jour : </p>

						<p style="background-color: #FFFFFF;border-radius: 10px 10px 10px 10px;box-shadow: 0 5px 20px #B3BEC7;font-size: 200%;margin: 20px;padding: 20px;">'.$citation->quote.''.$auteur.'</p>
						
						<p>Retrouvez d\'autre citations sur <a href="http://www.citation-ou-proverbe.fr?pk_campaign=email&pk_kwd=email-footer" style="color:#000;">Citation ou Proverbe</a></p>
						
						<p><a href="http://www.citation-et-proverbe.fr/desabonnement/[encoded_mail]">désabonnement</a></p>';

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
      
      $personalized_message = str_replace('[encoded_mail]', base64_encode($newsletter->getEmail()), $message_text);
      
	  	$message = $this->getMailer()->compose(
	      'contact@citation-ou-proverbe.fr',
	      $newsletter->getEmail(),
	      'citation du jour',
	  	  $personalized_message
	    );
      $message->setContentType("text/html");
  		$this->getMailer()->send($message);
  		echo $newsletter->getEmail()."\n";
    }
    echo "\n";
  }
}
