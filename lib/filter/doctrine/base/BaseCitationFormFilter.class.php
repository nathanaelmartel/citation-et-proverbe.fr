<?php

/**
 * Citation filter form base class.
 *
 * @package    citations
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCitationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'quote'                    => new sfWidgetFormFilterInput(),
      'author'                   => new sfWidgetFormFilterInput(),
      'source'                   => new sfWidgetFormFilterInput(),
      'website'                  => new sfWidgetFormFilterInput(),
      'is_active'                => new sfWidgetFormFilterInput(),
      'last_published_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'author_last_published_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'hash'                     => new sfWidgetFormFilterInput(),
      'slug'                     => new sfWidgetFormFilterInput(),
      'created_at'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'words_list'               => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Word')),
      'categories_list'          => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Category')),
    ));

    $this->setValidators(array(
      'quote'                    => new sfValidatorPass(array('required' => false)),
      'author'                   => new sfValidatorPass(array('required' => false)),
      'source'                   => new sfValidatorPass(array('required' => false)),
      'website'                  => new sfValidatorPass(array('required' => false)),
      'is_active'                => new sfValidatorPass(array('required' => false)),
      'last_published_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'author_last_published_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'hash'                     => new sfValidatorPass(array('required' => false)),
      'slug'                     => new sfValidatorPass(array('required' => false)),
      'created_at'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'words_list'               => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Word', 'required' => false)),
      'categories_list'          => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Category', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('citation_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addWordsListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.WordCitation WordCitation')
      ->andWhereIn('WordCitation.word_id', $values)
    ;
  }

  public function addCategoriesListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.CategoryCitation CategoryCitation')
      ->andWhereIn('CategoryCitation.category_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Citation';
  }

  public function getFields()
  {
    return array(
      'id'                       => 'Number',
      'quote'                    => 'Text',
      'author'                   => 'Text',
      'source'                   => 'Text',
      'website'                  => 'Text',
      'is_active'                => 'Text',
      'last_published_at'        => 'Date',
      'author_last_published_at' => 'Date',
      'hash'                     => 'Text',
      'slug'                     => 'Text',
      'created_at'               => 'Date',
      'updated_at'               => 'Date',
      'words_list'               => 'ManyKey',
      'categories_list'          => 'ManyKey',
    );
  }
}
