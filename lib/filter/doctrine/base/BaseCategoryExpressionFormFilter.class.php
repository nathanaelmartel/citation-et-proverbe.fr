<?php

/**
 * CategoryExpression filter form base class.
 *
 * @package    citations
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCategoryExpressionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'category_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Category'), 'add_empty' => true)),
      'name'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'slug'           => new sfWidgetFormFilterInput(),
      'citations_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Citation')),
    ));

    $this->setValidators(array(
      'category_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Category'), 'column' => 'id')),
      'name'           => new sfValidatorPass(array('required' => false)),
      'slug'           => new sfValidatorPass(array('required' => false)),
      'citations_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Citation', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('category_expression_filters[%s]');

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
      ->leftJoin($query->getRootAlias().'.CategoryCitation CategoryCitation')
      ->andWhereIn('CategoryCitation.citation_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'CategoryExpression';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'category_id'    => 'ForeignKey',
      'name'           => 'Text',
      'slug'           => 'Text',
      'citations_list' => 'ManyKey',
    );
  }
}
