<?php

/**
 * BaseWordCitation
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $word_id
 * @property integer $citation_id
 * 
 * @method integer      getWordId()      Returns the current record's "word_id" value
 * @method integer      getCitationId()  Returns the current record's "citation_id" value
 * @method WordCitation setWordId()      Sets the current record's "word_id" value
 * @method WordCitation setCitationId()  Sets the current record's "citation_id" value
 * 
 * @package    citations
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseWordCitation extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('word_citation');
        $this->hasColumn('word_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('citation_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}