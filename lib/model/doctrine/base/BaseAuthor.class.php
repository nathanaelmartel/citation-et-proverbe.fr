<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Author', 'doctrine');

/**
 * BaseAuthor
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $author
 * @property string $twitter_account
 * @property string $twitter_keys
 * @property int $is_active
 * 
 * @method string getAuthor()          Returns the current record's "author" value
 * @method string getTwitterAccount()  Returns the current record's "twitter_account" value
 * @method string getTwitterKeys()     Returns the current record's "twitter_keys" value
 * @method int    getIsActive()        Returns the current record's "is_active" value
 * @method Author setAuthor()          Sets the current record's "author" value
 * @method Author setTwitterAccount()  Sets the current record's "twitter_account" value
 * @method Author setTwitterKeys()     Sets the current record's "twitter_keys" value
 * @method Author setIsActive()        Sets the current record's "is_active" value
 * 
 * @package    citations
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseAuthor extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('author');
        $this->hasColumn('author', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('twitter_account', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('twitter_keys', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('is_active', 'int', null, array(
             'type' => 'int',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $sluggable0 = new Doctrine_Template_Sluggable(array(
             'unique' => true,
             'fields' => 
             array(
              0 => 'author',
             ),
             ));
        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($sluggable0);
        $this->actAs($timestampable0);
    }
}