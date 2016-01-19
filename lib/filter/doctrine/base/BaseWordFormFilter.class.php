<?php

/**
 * Word filter form base class.
 *
 * @package    citations
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseWordFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_active'      => new sfWidgetFormFilterInput(),
      'slug'           => new sfWidgetFormFilterInput(),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'citations_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Citation')),
    ));

    $this->setValidators(array(
      'name'           => new sfValidatorPass(array('required' => false)),
      'is_active'      => new sfValidatorPass(array('required' => false)),
      'slug'           => new sfValidatorPass(array('required' => false)),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'citations_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Citation', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('word_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function add
Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in /home/sshweb/www/citation-et-proverbe.fr/lib/vendor/symfony/lib/util/sfToolkit.class.php on line 362

Deprecated: preg_replace(): The /e modifier is deprecated, use preg_replace_callback instead in /home/sshweb/www/citation-et-proverbe.fr/lib/vendor/symfony/lib/util/sfToolkit.class.php on line 362
CitationsListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('WordCitation.citation_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Word';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'name'           => 'Text',
      'is_active'      => 'Text',
      'slug'           => 'Text',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
      'citations_list' => 'ManyKey',
    );
  }
}
