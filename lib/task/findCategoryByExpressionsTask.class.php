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

    $category_id = 1;
    $q = Doctrine_Query::create()
    ->select('*')
    ->from('Category')
    ->where('id = ?', $category_id);
	$Categories = $q->execute();
	$Category = $Categories[0];
    
    // add your code here
    $q = Doctrine_Query::create()
    ->select('*')
    ->from('CategoryExpression')
    ->where('category_id = ?', $Category->id)
    //->limit(10)
    ;
    
    
    //echo $q->getSqlQuery();echo "\n";
	$expressions = $q->execute();
	
	foreach ($expressions as $Expression) {
		echo $Expression->name;echo "\n";
		$words = split(' ', $Expression->name);
		
	    $q = Doctrine_Query::create()
	    ->select('*')
	    ->from('Citation c')
	    ->Where('quote LIKE ?', '%'.$Category->name.'%');
	    
	    foreach ($words as $word) {
	    	$q->addWhere('quote LIKE ?', '%'.$word.'%');
	    }
	    
	    //echo $q->getSqlQuery();echo "\n";
	    $citations = $q->execute();
	    $citations = $q->execute();
	    
	    foreach ($citations as $citation) 
	    {
	    	//print_r($citation->getWords());
	    	//echo $citation->id."\n";
	    	//echo $Category->id."\n";
	    	
	    	$CategoryCitations = Doctrine::getTable('CategoryCitation')->findByCategoryIdAndCitationId($Category->id, $citation->id);
	    	if (count($CategoryCitations) == 0)
	    	{
	    		$category_citation = new CategoryCitation;
	    		$category_citation->citation_id = $citation->id;
	    		$category_citation->category_id = $Category->id;
	    		$category_citation->save();
	    	}
	    }
	}
    echo "\n";
  }
}
