<?php use_helper('I18N'); ?>
<table>
    <tbody>
      <tr>
        <th><?php echo $form['name']->renderLabel() ?></th>
        <td>
          <?php echo $contact->name; ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['email']->renderLabel() ?></th>
        <td>
          <?php echo $contact->email; ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['comments']->renderLabel() ?></th>
        <td>
          <?php echo nl2br($contact->comments); ?>
        </td>
      </tr>
      <tr>
        <th>Provenance</th>
        <td>
          <?php echo $contact->referer; ?>
        </td>
      </tr>
      <tr>
        <th>Site</th>
        <td>
          <?php echo $contact->host; ?>
        </td>
      </tr>
      <tr>
        <th>Mots clés</th>
        <td>
          <?php echo $contact->keywords; ?>
        </td>
      </tr>
    </tbody>
  </table>