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
  public function executeShow(sfWebRequest $request)
  {
  	$this->forward404Unless($author = Doctrine::getTable('Author')->findOneBySlug(array($request->getParameter('slug'))), sprintf('Object citation does not exist (%s).', $request->getParameter('slug')));
  	$this->forward404Unless($author->getIsActive());
  	
    $response = $this->getResponse();
    $response->addMeta('description', 'Retrouvez sur notre site toutes les citations de '.$author->getAuthor() );
    $response->setTitle('Citation '.$author->getAuthor().' : toutes les citations '.$author->getAuthor() );
    
    $this->author = $author;
    $this->citations = $author->getCitations();
  }
}
