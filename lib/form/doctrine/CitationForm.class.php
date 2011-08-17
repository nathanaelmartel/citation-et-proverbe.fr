<?php

/**
 * Citation form.
 *
 * @package    citations
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CitationForm extends BaseCitationForm
{
  public function configure()
  {
  	unset(  $this['slug'],
            $this['created_at'],
		  	 $this['updated_at'],
			$this['words_list']
  	);
  }
}
