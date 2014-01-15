<?php

/**
 * word actions.
 *
 * @package    citations
 * @subpackage word
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class wordActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {

  	$dbh = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
  	
		$top_query = 'SELECT a.name, a.slug, count(c.citation_id) as nb 
			FROM word a left join word_citation c ON a.id = c.word_id 
			WHERE a.is_active = 1  
			GROUP BY a.name HAVING nb > 100 LIMIT 10';
		
		$this->top_words = $dbh->query($top_query); 
  	
		$query = 'SELECT a.name, a.slug, count(c.citation_id) as nb 
			FROM word a left join word_citation c ON a.id = c.word_id 
			WHERE a.is_active = 1 
			GROUP BY a.name HAVING nb > 70 LIMIT 10, 100';
		
		$this->words = $dbh->query($query); 
		
  	
    $response = $this->getResponse();
    $response->addMeta('description', 'Thèmes de Citations ');
    $response->setTitle('Thème de Citations ' );
  }
  
  public function executeShow(sfWebRequest $request)
  {
  	$this->forward404Unless($word = Doctrine::getTable('Word')->findOneBySlug(array($request->getParameter('slug'))), sprintf('Object citation does not exist (%s).', $request->getParameter('slug')));
  	$this->forward404Unless($word->getIsActive());
  	
    $page = '';
    if ($request->getParameter('page', 1) > 1)
        $page = ' page '.$request->getParameter('page', 1);
    
    $this->word = $word;
    //$this->citations = $word->getCitations();
    
    $this->citations = new sfDoctrinePager('Citation', sfConfig::get('app_pager'));
		$this->citations->setQuery(Doctrine_Query::create()
      ->select()
      ->from('Citation c')
      ->leftJoin('c.WordCitation w')
      ->AddWhere('w.word_id = ?', $word->getId()));
		$this->citations->setPage($request->getParameter('page', 1));
		$this->citations->init();
  }
}
