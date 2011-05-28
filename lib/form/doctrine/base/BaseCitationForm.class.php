<?php

/**
 * Citation form base class.
 *
 * @method Citation getObject() Returns the current form's model object
 *
 * @package    citations
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCitationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                       => new sfWidgetFormInputHidden(),
      'quote'                    => new sfWidgetFormTextarea(),
      'author'                   => new sfWidgetFormInputText(),
      'source'                   => new sfWidgetFormInputText(),
      'website'                  => new sfWidgetFormInputText(),
      'is_active'                => new sfWidgetFormInputText(),
      'last_published_at'        => new sfWidgetFormInputText(),
      'author_last_published_at' => new sfWidgetFormInputText(),
      'slug'                     => new sfWidgetFormInputText(),
      'created_at'               => new sfWidgetFormDateTime(),
      'updated_at'               => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'quote'                    => new sfValidatorString(array('required' => false)),
      'author'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'source'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'website'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'is_active'                => new sfValidatorPass(array('required' => false)),
      'last_published_at'        => new sfValidatorPass(array('required' => false)),
      'author_last_published_at' => new sfValidatorPass(array('required' => false)),
      'slug'                     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'               => new sfValidatorDateTime(),
      'updated_at'               => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Citation', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('citation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Citation';
  }

}
