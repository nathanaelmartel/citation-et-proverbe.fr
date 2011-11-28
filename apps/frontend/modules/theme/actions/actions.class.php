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
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  	$this->forward404Unless($Category = Doctrine::getTable('Category')->findOneBySlug(array($request->getParameter('theme'))), sprintf('Object category does not exist (%s).', $request->getParameter('theme')));
  	
    $response = $this->getResponse();
    $response->addMeta('description', $Category->getMetaDescription() );
    $response->addMeta('keywords', $Category->getMetaKeyword() );
    $response->setTitle($Category->getMetaTitle() );
    
    
	$this->Expressions = Doctrine_Query::create()
      ->select()
      ->from('CategoryExpression')
      ->AddWhere('category_id = ?', $Category->getId())
      ->execute();
	
    $this->Category = $Category;
  }
  
  public function executeShow(sfWebRequest $request)
  {
  	$this->forward404Unless($Category = Doctrine::getTable('Category')->findOneBySlug(array($request->getParameter('theme'))), sprintf('Object category does not exist (%s).', $request->getParameter('theme')));
  	$this->forward404Unless($Expression = Doctrine::getTable('CategoryExpression')->findOneBySlug(array($request->getParameter('expression'))), sprintf('Object citation does not exist (%s).', $request->getParameter('expression')));
  	$this->forward404Unless($Expression->getCountCitations());

    $response = $this->getResponse();
    $response->addMeta('description', $Category->getName().' '.$Expression->getName().' - '.$Category->getMetaDescription() );
    $response->addMeta('keywords', $Category->getName().' '.$Expression->getName().', '.$Category->getMetaKeyword() );
    $response->setTitle('Citation '.$Category->getName().' '.$Expression->getName().' - '.$Category->getMetaTitle() );
    
	$this->citations = Doctrine_Query::create()
      ->select()
      ->from('Citation c')
      ->leftJoin('c.CategoryCitation w')
      ->AddWhere('w.category_expression_id = ?', $Expression->getId())
      ->execute();
	
    $this->Expression = $Expression;
    $this->Category = $Category;
  }
  
  public function executeList(sfWebRequest $request) {
  	$this->Categories = Doctrine_Query::create()
  	->select()
  	->from('Category')
  	->AddWhere('is_active = ?', 1)
  	->execute();
  }
}
