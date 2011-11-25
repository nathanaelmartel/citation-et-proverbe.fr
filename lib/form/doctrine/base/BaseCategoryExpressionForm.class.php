<?php

/**
 * CategoryExpression form base class.
 *
 * @method CategoryExpression getObject() Returns the current form's model object
 *
 * @package    citations
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCategoryExpressionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'category_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Category'), 'add_empty' => true)),
      'name'           => new sfWidgetFormInputText(),
      'slug'           => new sfWidgetFormInputText(),
      'citations_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Citation')),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'category_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Category'), 'required' => false)),
      'name'           => new sfValidatorString(array('max_length' => 255)),
      'slug'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'citations_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Citation', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'CategoryExpression', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('category_expression[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CategoryExpression';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['citations_list']))
    {
      $this->setDefault('citations_list', $this->object->Citations->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveCitationsList($con);

    parent::doSave($con);
  }

  public function saveCitationsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['citations_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Citations->getPrimaryKeys();
    $values = $this->getValue('citations_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Citations', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Citations', array_values($link));
    }
  }

}
