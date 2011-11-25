<?php

/**
 * citation actions.
 *
 * @package    citations
 * @subpackage citation
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class citationActions extends sfActions
{ 
  public function preExecute()
  {
  	$theme = substr($_SERVER['HTTP_HOST'], 0, strpos($_SERVER['HTTP_HOST'], '.'));
  	
  	$this->forward404Unless($Category= Doctrine::getTable('Category')->findOneBySlug(array($theme)), sprintf('Object citation does not exist (%s).', $theme));
  	$this->forward404Unless($Category->getIsActive());
  	
  	$this->Category = $Category;
  }
  
  public function executeIndex(sfWebRequest $request)
  { 
    $citations = Doctrine::getTable('Citation c')
      ->createQuery('a')
      ->where('is_active = ?', 1)
      ->limit(50)
      ->offset(rand(0, 1000))
      ->orderBy('last_published_at desc')
      ->execute(); 
    
    $citation = $citations[rand(0, 49)];
    
    if($citation)
      $this->redirect('@single_citation?slug='.$citation->getSlug());
    else 
      $this->redirect('@homepage');
  }
	
  public function executeLast(sfWebRequest $request)
  { 
    /*$citations = Doctrine::getTable('Citation')
      ->createQuery('a')
      ->where('is_active = ?', 1)
      ->limit(5)
      ->orderBy('last_published_at desc')
      ->execute();*/
  	$citations = Doctrine_Query::create()->select('*')
	  ->from('Citation c, CategoryCitation cc, Category ca')
      ->where('c.is_active = ?', 1)
      ->andWhere('ca.slug = ?', $this->theme)
      ->andWhere('c.id = cc.citation_id')
      ->andWhere('cc.category_id = ca.id')
      ->limit(5)
      ->execute();
  	/*
  	echo $citations->getSqlQuery();
  	 die;*/
  	
    $this->citations = $citations;
  }
  
  public function executeTheme(sfWebRequest $request)
  {
  	
    $response = $this->getResponse();
    $response->addMeta('description', $this->Category->getName().': un thème sur lequel beaucoup d\'auteurs ont écrit. Consultez les meilleures citations sur ce sujet et partagez-les sur les réseaux sociaux !' );
    $response->addMeta('keywords', $this->Category->getName().', citation '.$this->Category->getName().', proverbe '.$this->Category->getName().', citation, citations, proverbe, proverbes' );
    $response->setTitle('citation '.$this->Category->getName().' - citations sur '.$this->Category->getName() );
    
    //$this->citations = $word->getCitations();
    
    $this->Expressions = Doctrine_Query::create()
	      ->select()
	      ->from('CategoryExpression')
	      ->AddWhere('category_id = ?', $this->Category->getId())
    	  ->execute();
  }
  
  public function executeShow(sfWebRequest $request)
  {
    $this->forward404Unless($citation = Doctrine::getTable('Citation')->findOneBySlug(array($request->getParameter('slug'))), sprintf('Object citation does not exist (%s).', $request->getParameter('slug')));

    $response = $this->getResponse();
    $response->addMeta('description', substr($citation->getQuote(), 0, stripos($citation->getQuote(), ' ', 50)+1 ).'... - '.$citation->getAuthor().'. Retrouvez plus de citations sur notre site.');
    $response->setTitle($citation->getAuthor().' : '.$citation->getQuote() );
    
    if ($citation->getIsActive() != 1)
      $this->redirect('@homepage');
    
    $this->citation = $citation;
  }
  
  public function executeSitemap(sfWebRequest $request)
  {
  	$page = $request->getParameter('page', 0);
  	$nb = 100;
  	
    $this->Expressions = Doctrine_Query::create()
	      ->select()
	      ->from('CategoryExpression')
	      ->AddWhere('category_id = ?', $this->Category->getId())
        ->limit($nb)
        ->offset($nb*$page)
    	  ->execute();
  	$this->citations = Doctrine_Query::create()
	  	->select()
	    ->from('CategoryExpression c')
	  	->leftJoin('c.CategoryCitation cc')
	  	->AddWhere('c.category_id = ?', $this->Category->getId())
        ->limit($nb)
        ->offset($nb*$page)
	  	->execute();
  	
    $this->setLayout(false);
    $this->getResponse()->addHttpMeta('content-type', 'text/xml');
  }
  
  public function executeFeed(sfWebRequest $request)
  {
  	
    $citations = Doctrine::getTable('Citation')
      ->createQuery('a')
      ->where('is_active = ?', 1)
      ->limit(20)
      ->orderBy('last_published_at desc')
      ->execute();
      
    
    $feed = new sfRss201Feed();

	  $feed->setTitle('Citations francophones');
	  $feed->setLink('http://www.citation-et-proverbe.fr/');
	  $feed->setAuthorEmail('contact@citation-et-proverbe.fr');
	  $feed->setAuthorName('Nathanaël Martel - Sebastien Cay');
		
	  foreach ($citations as $citation)
	  {
	    $item = new sfFeedItem();
      $item->setTitle($citation->quote.' - '.$citation->author);
	    $item->setLink('http://www.citation-et-proverbe.fr/'.$citation->slug.'/?utm_source=feed&amp;utm_medium=feed&amp;utm_campaign=feed');
	    $item->setAuthorName($citation->author);
	    $item->setAuthorEmail('contact@citation-et-proverbe.fr');
	    $item->setPubdate(strtotime($citation->getLastPublishedAt()));
	    $item->setUniqueId('http://www.citation-et-proverbe.fr/'.$citation->slug.'/');
	
	    $description = '<p>'.$citation->quote;
	    if ($citation->getAuthor())
	    {
		    if ($citation->getAuthorSlug()) 
		    	$description .= ' <a href="http://www.citation-et-proverbe.fr/auteur/'.$citation->getAuthorSlug().'?utm_source=feed&utm_medium=feed&utm_campaign=feed" >'.$citation->author.'</a></p>' ;
		   	else 
		    	$description .=  $citation->author.'</p>' ;
	    } else {
		    	$description .= '</p>' ;
	    }
	    
	    $description .= '<p>Retrouvez plus de citations sur <a href="http://www.citation-et-proverbe.fr/?utm_source=feed&utm_medium=feed&utm_campaign=feed">www.citation-et-proverbe.fr</a></p>';

	    $item->setDescription($description);
	    $feed->addItem($item);
	  }
	
    $this->setLayout(false);
	  $this->feed = $feed;
	  
  }
}
