<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Citation', 'doctrine');

/**
 * BaseCitation
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $quote
 * @property string $author
 * @property string $source
 * @property string $website
 * @property int $is_active
 * @property datetime $last_published_at
 * @property datetime $author_last_published_at
 * 
 * @method string   getQuote()                    Returns the current record's "quote" value
 * @method string   getAuthor()                   Returns the current record's "author" value
 * @method string   getSource()                   Returns the current record's "source" value
 * @method string   getWebsite()                  Returns the current record's "website" value
 * @method int      getIsActive()                 Returns the current record's "is_active" value
 * @method datetime getLastPublishedAt()          Returns the current record's "last_published_at" value
 * @method datetime getAuthorLastPublishedAt()    Returns the current record's "author_last_published_at" value
 * @method Citation setQuote()                    Sets the current record's "quote" value
 * @method Citation setAuthor()                   Sets the current record's "author" value
 * @method Citation setSource()                   Sets the current record's "source" value
 * @method Citation setWebsite()                  Sets the current record's "website" value
 * @method Citation setIsActive()                 Sets the current record's "is_active" value
 * @method Citation setLastPublishedAt()          Sets the current record's "last_published_at" value
 * @method Citation setAuthorLastPublishedAt()    Sets the current record's "author_last_published_at" value
 * 
 * @package    citations
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCitation extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('citation');
        $this->hasColumn('quote', 'string', null, array(
             'type' => 'string',
             'length' => '',
             ));
        $this->hasColumn('author', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('source', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('website', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('is_active', 'int', null, array(
             'type' => 'int',
             ));
        $this->hasColumn('last_published_at', 'datetime', null, array(
             'type' => 'datetime',
             ));
        $this->hasColumn('author_last_published_at', 'datetime', null, array(
             'type' => 'datetime',
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
             'canUpdate' => true,
             ));
        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($sluggable0);
        $this->actAs($timestampable0);
    }
}