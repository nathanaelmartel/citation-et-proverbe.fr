<?php

/**
 * BaseCategory
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property int $is_active
 * @property CategoryExpression $Expressions
 * 
 * @method string             getName()        Returns the current record's "name" value
 * @method int                getIsActive()    Returns the current record's "is_active" value
 * @method CategoryExpression getExpressions() Returns the current record's "Expressions" value
 * @method Category           setName()        Sets the current record's "name" value
 * @method Category           setIsActive()    Sets the current record's "is_active" value
 * @method Category           setExpressions() Sets the current record's "Expressions" value
 * 
 * @package    citations
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCategory extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('category');
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('is_active', 'int', null, array(
             'type' => 'int',
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('CategoryExpression as Expressions', array(
             'local' => 'id',
             'foreign' => 'category_id'));

        $sluggable0 = new Doctrine_Template_Sluggable(array(
             'unique' => true,
             'fields' => 
             array(
              0 => 'name',
             ),
             ));
        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($sluggable0);
        $this->actAs($timestampable0);
    }
}