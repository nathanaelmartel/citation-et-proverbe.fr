<?php

/**
 * WordCitation form base class.
 *
 * @method WordCitation getObject() Returns the current form's model object
 *
 * @package    citations
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseWordCitationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'word_id'     => new sfWidgetFormInputHidden(),
      'citation_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'word_id'     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('word_id')), 'empty_value' => $this->getObject()->get('word_id'), 'required' => false)),
      'citation_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('citation_id')), 'empty_value' => $this->getObject()->get('citation_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('word_citation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'WordCitation';
  }

}
