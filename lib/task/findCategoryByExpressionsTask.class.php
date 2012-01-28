<?php

class findCategoryByExpressionsTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'frontend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = '';
    $this->name             = 'findCategoryByExpressions';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [findCategoryByExpressions|INFO] task does things.
Call it with:

  [php symfony findCategoryByExpressions|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    $category_id = 3;
    $q = Doctrine_Query::create()
    ->select('*')
    ->from('Category')
    ->where('id = ?', 5);
	$Categories = $q->execute();
	
	foreach ($Categories as $Category) {
		
    echo "*****************************************************\n";
    echo "******* ".$Category->name."\n";
    
    /* load keywords */
    /*$keyword_file = 'data/keywords/'.$Category->slug.'.txt';
    if (file_exists($keyword_file)) {
	    echo 'load keywords';
	    $lines = file($keyword_file);
	    foreach($lines as $line) {
	    	$line = rtrim($line, "\r\n");
			$line = trim($line);
		    if ($line != '') {
		    	$this->addExpression($line, $Category);
		    }
	    }
	    echo "\n";
    }*/
    
    /*
    $q = Doctrine_Query::create()
	    ->select('*')
	    ->from('Citation c')
	    ->Where('concat( author, \' \', quote ) LIKE ?', '%'.$Category->name.'%');
    
    //echo $q->getSqlQuery();echo "\n";
	$this->addCitations($q->execute(), $Category);
    */
	
    $q = Doctrine_Query::create()
    ->select('*')
    ->from('CategoryExpression')
    ->where('category_id = ?', $Category->id)
    //->limit(10)
    ;
	
	foreach ($q->execute() as $Expression) {
		echo $Expression->name;
		$words = split(' ', $Expression->name);
		
	    $q = Doctrine_Query::create()
	    ->select('*')
	    ->from('Citation c')
	    ;//->Where('concat( author, \' \', quote ) LIKE ?', '%'.$Category->name.' %');
	    
	    foreach ($words as $word) {
	    	$q->addWhere('concat( author, \' \', quote ) LIKE ?', '%'.$word.' %');
	    }
	    
	    //echo $q->getSqlQuery();echo "\n";
	    //$citations = $q->execute();
	    
	    $this->addCitations($q->execute(), $Expression);
	    echo "\n";
	}
	
	
	}
    echo "\n";
  }
  
  private function addCitations($citations, $Expression) {
	    
	    foreach ($citations as $citation) 
	    {
	    	//print_r($citation->getWords());
	    	//echo $citation->id."\n";
	    	//echo $Expression->id."\n";
	    	
	    	$CategoryCitations = Doctrine::getTable('CategoryCitation')->findByCategoryExpressionIdAndCitationId($Expression->id, $citation->id);
	    	if (count($CategoryCitations) == 0)
	    	{
	    		$category_citation = new CategoryCitation;
	    		$category_citation->citation_id = $citation->id;
	    		$category_citation->category_expression_id = $Expression->id;
	    		$category_citation->save();
	    		echo ".";
	    	}
	    }
  	
  }
  
  private function addExpression($expression, $Category) {
	    
	    	
	    	$CategoryExpression = Doctrine::getTable('CategoryExpression')->findByCategoryIdAndName($Category->id, $expression);
	    	if (count($CategoryExpression) == 0)
	    	{
	    		$category_expression = new CategoryExpression;
	    		$category_expression->name = $expression;
	    		$category_expression->category_id = $Category->id;
	    		$category_expression->save();
	    		echo ".";
	    	}
  	
  }
}
