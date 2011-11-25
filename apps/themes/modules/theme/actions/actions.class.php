<?php

/**
 * theme actions.
 *
 * @package    citations
 * @subpackage theme
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class themeActions extends sfActions
{
  public function preExecute()
  {
  	$theme = substr($_SERVER['HTTP_HOST'], 0, strpos($_SERVER['HTTP_HOST'], '.'));
  	
  	$this->forward404Unless($Category= Doctrine::getTable('Category')->findOneBySlug(array($theme)), sprintf('Object citation does not exist (%s).', $theme));
  	$this->forward404Unless($Category->getIsActive());
  	
  	$this->Category = $Category;
  }
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  	$this->forward404Unless($Expression = Doctrine::getTable('CategoryExpression')->findOneBySlug(array($request->getParameter('slug'))), sprintf('Object citation does not exist (%s).', $request->getParameter('slug')));
  	$this->forward404Unless($Expression->getCountCitations());
  	
    $response = $this->getResponse();
    $response->addMeta('description', $this->Category->getName().' '.$Expression->getName().': un thème sur lequel beaucoup d\'auteurs ont écrit. Consultez les meilleures citations sur ce sujet et partagez-les sur les réseaux sociaux !' );
    $response->addMeta('keywords', $this->Category->getName().' '.$Expression->getName().', citation '.$this->Category->getName().' '.$Expression->getName().', proverbe '.$this->Category->getName().' '.$Expression->getName().', citation, citations, proverbe, proverbes' );
    $response->setTitle('citation '.$this->Category->getName().' '.$Expression->getName().' - citations '.$this->Category->getName().' '.$Expression->getName().' célèbres' );
    
    $this->Expression = $Expression;
    //$this->citations = $word->getCitations();
    
	$this->citations = Doctrine_Query::create()
      ->select()
      ->from('Citation c')
      ->leftJoin('c.CategoryCitation w')
      ->AddWhere('w.category_expression_id = ?', $Expression->getId())
      ->execute();
  }
}
