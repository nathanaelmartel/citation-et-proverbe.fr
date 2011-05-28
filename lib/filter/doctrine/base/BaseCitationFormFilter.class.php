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
      'slug'                     => new sfWidgetFormFilterInput(),
      'created_at'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'quote'                    => new sfValidatorPass(array('required' => false)),
      'author'                   => new sfValidatorPass(array('required' => false)),
      'source'                   => new sfValidatorPass(array('required' => false)),
      'website'                  => new sfValidatorPass(array('required' => false)),
      'is_active'                => new sfValidatorPass(array('required' => false)),
      'last_published_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'author_last_published_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'slug'                     => new sfValidatorPass(array('required' => false)),
      'created_at'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('citation_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
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
      'slug'                     => 'Text',
      'created_at'               => 'Date',
      'updated_at'               => 'Date',
    );
  }
}
