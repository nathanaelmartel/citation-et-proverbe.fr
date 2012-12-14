<?php

require_once(dirname(__FILE__).'/../lib/BasepixContactActions.class.php');

/**
 * contact actions.
 *
 * @package    pixToolsPlugin
 * @subpackage plugin
 * @author     Nicolas Ricci <nr@agencepix.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class contactActions extends sfActions
{
    public function executeIndex(sfWebRequest $request)
    {
        $this->form = new ContactForm();
    }


    public function executeCreate(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod(sfRequest::POST));

        $this->form = new ContactForm();

        $this->processForm($request, $this->form);

        $this->setTemplate('index');
    }

    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid()) {
            $contact = $form->save();

            // recupere les infos de cookie
            $cookie = $request->getCookie(sfConfig::get('app_Tools_cookie_name'));
            if ($cookie) {
                $str = parse_str($cookie);
                $contact->referer = $referer;
                $contact->host = $host;
                $contact->keywords = $keywords;
                $contact->save();
            }

            // on envoie le mail
            $message = Swift_Message::newInstance()
                    ->setFrom(sfConfig::get('app_Contact_email_from'))
                    ->setTo(sfConfig::get('app_Contact_email_to'))
                    ->setSubject(sfConfig::get('app_Contact_email_subject') . ' ' . $contact->getName())
                    ->setContentType('text/html')
                    ->setBody($this->getPartial('contact/email', array('contact' => $contact, 'form' => $form, 'tracker' => isset($tracker) ? $tracker : null)));

            foreach (sfConfig::get('app_Contact_email_bcc') as $mail)
            {
                $message->addBcc($mail);
            }
            // on envoie le mail
            $this->getMailer()->send($message);

            $this->getUser()->setFlash('confirmation', 'Votre message a bien été envoyé !');
            $this->redirect('@contact');
        }
    }
}
