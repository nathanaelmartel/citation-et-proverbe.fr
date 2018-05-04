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
    sfTask::log('**** Begin at: '.date('r').' ****');

    $citations = Doctrine::getTable('Citation')
      ->createQuery('a')
      ->where('is_active = ?', 1)
      ->limit(5)
      ->orderBy('last_published_at desc')
      ->execute();
    $citation = $citations[0];

    sfTask::log('citation: '.$citation->quote);

	    if ($citation->getAuthor())
	    {
		    if ($citation->getAuthorSlug())
		    	$auteur = ' <a href="https://www.citation-et-proverbe.fr/auteur/'.$citation->getAuthorSlug().'?utm_source=mail&utm_medium=mail&utm_campaign=mail" >'.$citation->author.'</a>' ;
		   	else
		    	$auteur =  $citation->author ;
	    }

  	$baseline = array(
  		'«&nbsp;L’education est l’arme la plus puissante pour changer le monde&nbsp;» — Nelson Mandela',
  		'L’éducation de nos enfants est notre priorité : nous nous sommes donnés comme objectif de construire une école',
  		'«&nbsp;Si tu veux aller vite, marche seul ; mais si tu veux aller loin, marchons ensemble&nbsp;» — proverbe africain',
  		'«&nbsp;Un Enfant sans éducation est comme un oiseau sans ailes&nbsp;» — proverbe Tibétain',
  		'Vous pouvez lire et écrire ceci… Pas les enfants de Niellé.',
  	);

    $annonce = '<p>Retrouvez d\'autre citations sur <a href="https://www.citation-ou-proverbe.fr?pk_campaign=email&pk_kwd=email-footer" style="color:#000;">Citation ou Proverbe</a></p>';
  	$annonce = '<p>Découvrez <a href="http://revenudebase.info/?utm_source=citation-et-proverbe.fr&utm_medium=email&utm_campaign=citation-et-proverbe.fr" style="color:#000;">Le Revenu de base</a>, et vous, que feriez-vous si votre revenu était garanti ?</p>';
  	$annonce = '<p>Accrochez des citations à vos murs avec <a href="http://www.wallshop.fr/fr/?pk_campaign=email-citation-et-proverbe&pk_kwd=email-footer-citation-et-proverbe" style="color:#000;">WallShop.fr</a></p>';
  	//$annonce = '<p>Accrochez des citations à vos murs avec <a href="http://www.badessatellites.com/?pk_campaign=email-citation-et-proverbe&pk_kwd=email-footer-citation-et-proverbe" style="color:#000;">www.badessatellites.com</a></p>';

    $annonce = '<p>'.$baseline[rand(0, count($baseline)-1)].' <a href="http://www.badessatellites.com/?utm_medium=email&utm_campaign=citation-ou-proverbe.fr">Une École à Niellé</a></p>';

    $message_text = '<p>Bonjour, <br />Voici la citation du jour : </p>

						<p style="background-color: #FFFFFF;border-radius: 10px 10px 10px 10px;box-shadow: 0 5px 20px #B3BEC7;font-size: 200%;margin: 20px;padding: 20px;">'.$citation->quote.''.$auteur.'</p>

						'.$annonce.'

						<p><a href="https://www.citation-et-proverbe.fr/desabonnement/[encoded_mail]">désabonnement</a></p>';


    $q = Doctrine::getTable('Newsletter')
    		->createQuery('a')
        ->where('is_confirmed = ?', 1)
        ->andWhere('hour(TIMEDIFF(now(), last_send_at)) > ?', 36)
        ->limit(3)
        ->orderBy('last_send_at ASC');

    //die($q->getSqlQuery());

    $newsletters = $q->execute();

    foreach ($newsletters as $newsletter) {
    	sfTask::log($newsletter->getEmail());

      $personalized_message = str_replace('[encoded_mail]', base64_encode($newsletter->getEmail()), $message_text);

	  	$message = $this->getMailer()->compose(
	      'contact@citation-ou-proverbe.fr',
	      'contact@citation-ou-proverbe.fr'/*$newsletter->getEmail()*/,
	      'citation du jour',
	  	  $personalized_message
	    );
      $message->setContentType("text/html");
      if ($this->getMailer()->send($message)) {
    		sfTask::log('  -> ok');
	    	$newsletter->last_send_at = new Doctrine_Expression('NOW()');
	    	$newsletter->save();
      } else {
	    	$newsletter->last_send_at = new Doctrine_Expression('NOW()');
	    	$newsletter->save();
    		sfTask::log('  -> #failed');
      }
    }
    sfTask::log('**** End at: '.date('r').' ****');
  }
}
