<?php

/**
 * Author filter form base class.
 *
 * @package    citations
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseAuthorFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'author'          => new sfWidgetFormFilterInput(),
      'wikipedia_bio'   => new sfWidgetFormFilterInput(),
      'wikipedia_url'   => new sfWidgetFormFilterInput(),
      'twitter_account' => new sfWidgetFormFilterInput(),
      'twitter_keys'    => new sfWidgetFormFilterInput(),
      'is_active'       => new sfWidgetFormFilterInput(),
      'slug'            => new sfWidgetFormFilterInput(),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'author'          => new sfValidatorPass(array('required' => false)),
      'wikipedia_bio'   => new sfValidatorPass(array('required' => false)),
      'wikipedia_url'   => new sfValidatorPass(array('required' => false)),
      'twitter_account' => new sfValidatorPass(array('required' => false)),
      'twitter_keys'    => new sfValidatorPass(array('required' => false)),
      'is_active'       => new sfValidatorPass(array('required' => false)),
      'slug'            => new sfValidatorPass(array('required' => false)),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('author_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Author';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'author'          => 'Text',
      'wikipedia_bio'   => 'Text',
      'wikipedia_url'   => 'Text',
      'twitter_account' => 'Text',
      'twitter_keys'    => 'Text',
      'is_active'       => 'Text',
      'slug'            => 'Text',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
    );
  }
}
