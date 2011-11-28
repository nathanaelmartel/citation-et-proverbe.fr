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
  public function executeError404(sfWebRequest $request)
  { 
  	$this->redirect('@homepage');
  }
  
  public function executeIndex(sfWebRequest $request)
  { 
    $citations = Doctrine::getTable('Citation')
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
    $citations = Doctrine::getTable('Citation')
      ->createQuery('a')
      ->where('is_active = ?', 1)
      ->limit(5)
      ->orderBy('last_published_at desc')
      ->execute();
    
    $this->citations = $citations;
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
  	$nb = 2500;
  	
    $this->Categories = Doctrine::getTable('Category')
      ->createQuery('a')
      ->where('is_active = ?', 1)
      ->limit(1)
      ->offset($page)
      ->execute();
  	
    $this->authors = Doctrine::getTable('Author')
      ->createQuery('a')
      ->where('is_active = ?', 1)
      ->limit($nb/2)
      ->offset($nb/2*$page)
      ->execute();
    $this->words = Doctrine::getTable('Word')
      ->createQuery('a')
      ->where('is_active = ?', 1)
      ->limit($nb/2)
      ->offset($nb/2*$page)
      ->execute();
    $this->citations = Doctrine::getTable('Citation')
      ->createQuery('a')
      ->where('is_active = ?', 1)
      ->limit($nb)
      ->offset($nb*$page)
      ->orderBy('last_published_at desc')
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
