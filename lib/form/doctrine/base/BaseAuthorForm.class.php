<?php

/**
 * Author form base class.
 *
 * @method Author getObject() Returns the current form's model object
 *
 * @package    citations
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAuthorForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'author'          => new sfWidgetFormInputText(),
      'wikipedia_bio'   => new sfWidgetFormTextarea(),
      'wikipedia_url'   => new sfWidgetFormInputText(),
      'twitter_account' => new sfWidgetFormInputText(),
      'twitter_keys'    => new sfWidgetFormInputText(),
      'is_active'       => new sfWidgetFormInputText(),
      'slug'            => new sfWidgetFormInputText(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'author'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'wikipedia_bio'   => new sfValidatorString(array('required' => false)),
      'wikipedia_url'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'twitter_account' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'twitter_keys'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'is_active'       => new sfValidatorPass(array('required' => false)),
      'slug'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Author', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('author[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Author';
  }

}
