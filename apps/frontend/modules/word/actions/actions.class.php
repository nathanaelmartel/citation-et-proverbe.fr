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
  public function executeShow(sfWebRequest $request)
  {
  	$this->forward404Unless($word = Doctrine::getTable('Word')->findOneBySlug(array($request->getParameter('slug'))), sprintf('Object citation does not exist (%s).', $request->getParameter('slug')));
  	$this->forward404Unless($word->getIsActive());
  	
    $response = $this->getResponse();
    $response->addMeta('description', $word->getName().': un thème sur lequel beaucoup d\'auteurs ont écrit. Consultez les meilleures citations sur ce sujet et partagez-les sur les réseaux sociaux !' );
    $response->addMeta('keywords', $word->getName().', citation '.$word->getName().', proverbe '.$word->getName().', citation, citations, proverbe, proverbes' );
    $response->setTitle('citation '.$word->getName().' - citations '.$word->getName().' célèbres' );
    
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
