<?php

/**
 * Category
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    citations
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Category extends BaseCategory
{
	
	public function getCountExpressions()
	{
		$expressions = Doctrine_Query::create()
		->select('*')
		->from('CategoryExpression')
				    ->where('category_id = ?', $this->id)
		->execute();
		 
		return count($expressions);
	}
}