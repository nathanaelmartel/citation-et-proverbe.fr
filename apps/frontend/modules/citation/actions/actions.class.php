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
      ->limit(1)
      ->orderBy('last_published_at desc')
      ->execute();
    
    $citation = $citations[0];
    
    if($citation)
      $this->redirect('@single_citation?slug='.$citation->getSlug());
    else 
      $this->redirect('@homepage');
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
    $this->authors = Doctrine::getTable('Author')
      ->createQuery('a')
      ->where('is_active = ?', 1)
      ->limit(10000)
      ->execute();
    $this->citations = Doctrine::getTable('Citation')
      ->createQuery('a')
      ->where('is_active = ?', 1)
      ->limit(2000)
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
      
    
    $feed = new sfAtom1Feed();

	  $feed->setTitle('Citations francophones');
	  $feed->setLink('http://www.citation-et-proverbe.fr/');
	  $feed->setAuthorEmail('citation@fam-martel.eu');
	  $feed->setAuthorName('Nathanaël Martel');
		
	  foreach ($citations as $citation)
	  {
	    $item = new sfFeedItem();
	    if ($citation->author == '')
       $item->setTitle($citation->quote);
      else
       $item->setTitle($citation->author);
	    $item->setLink('http://www.citation-et-proverbe.fr/'.$citation->slug);
	    $item->setAuthorName($citation->author);
	    $item->setAuthorEmail('citation@fam-martel.eu');
	    $item->setPubdate(strtotime($citation->getLastPublishedAt()));
	    $item->setUniqueId('http://www.citation-et-proverbe.fr/'.$citation->slug);
	    $item->setDescription($citation->quote);
	
	    $feed->addItem($item);
	  }
	
    $this->setLayout(false);
	  $this->feed = $feed;
	  
  }
}
