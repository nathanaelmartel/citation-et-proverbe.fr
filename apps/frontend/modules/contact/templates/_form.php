<?php if ($sf_user->hasFlash('confirmation')): ?>
    <div id="confirmation">
        <?php echo __($sf_user->getFlash('confirmation')) ?>
    </div>
<?php else: ?>
  	<h1>Formulaire de Contact</h1>

<form action="<?php echo url_for('@contact_validation') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

  <fieldset class="form" >

    <?php if (!$form->getObject()->isNew()): ?>
      <input type="hidden" name="sf_method" value="put"/>
    <?php endif; ?>

    <?php foreach ($form as $fieldName => $field): ?>
      <?php include_partial('contact/input', array('field' => $field)); ?>
    <?php endforeach; ?>

    <div class="grid_2 alpha prefix_1 row-control">
      <input type="submit" value="Envoyer" class="buton"/>
    </div>

  </fieldset>

</form>
<?php endif; ?>