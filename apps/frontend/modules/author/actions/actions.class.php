<?php

/**
 * author actions.
 *
 * @package    citations
 * @subpackage author
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class authorActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {

  	$dbh = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
  	
		$top_query = 'SELECT a.author, a.slug, count(c.id) as nb 
			FROM author a left join citation c ON a.author = c.author 
			WHERE a.is_active = 1 and c.is_active = 1 
			GROUP BY a.author HAVING nb > 100 LIMIT 10';
		
		$this->top_authors = $dbh->query($top_query); 
  	
		$query = 'SELECT a.author, a.slug, count(c.id) as nb 
			FROM author a left join citation c ON a.author = c.author 
			WHERE a.is_active = 1 and c.is_active = 1 
			GROUP BY a.author HAVING nb > 70 LIMIT 10, 100';
		
		$this->authors = $dbh->query($query); 
		
  	
    $response = $this->getResponse();
    $response->addMeta('description', 'Auteurs de Citations ');
    $response->setTitle('Auteurs de Citations ' );
  }
  
  public function executeShow(sfWebRequest $request)
  {
  	$this->forward404Unless($author = Doctrine::getTable('Author')->findOneBySlug(array($request->getParameter('slug'))), sprintf('Object citation does not exist (%s).', $request->getParameter('slug')));
  	$this->forward404Unless($author->getIsActive());
  	
    $response = $this->getResponse();
    $response->addMeta('description', 'Retrouvez sur notre site toutes les citations de '.$author->getAuthor() );
    $response->setTitle('Citation '.$author->getAuthor().' : toutes les citations '.$author->getAuthor() );
    
    $this->author = $author;
    //$this->citations = $author->getCitations();
    
    $this->citations = new sfDoctrinePager('Citation', sfConfig::get('app_pager'));
		$this->citations->setQuery(Doctrine_Query::create()
    ->select('*')
    ->from('Citation c')
    ->where('c.author = ?', $author->getAuthor()));
		$this->citations->setPage($request->getParameter('page', 1));
		$this->citations->init();
  }
}
