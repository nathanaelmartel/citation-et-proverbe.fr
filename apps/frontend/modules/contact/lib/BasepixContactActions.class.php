<?php
/**
 * Created by JetBrains PhpStorm.
 * Author: Nicolas R.
 * Date: 19/04/2011
 * Time: 09:23
 */
 
class BasepixContactActions extends sfActions{

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
            $cookie = $request->getCookie(sfConfig::get('app_pixTools_cookie_name'));
            if ($cookie) {
                $str = parse_str($cookie);
                $contact->referer = $referer;
                $contact->host = $host;
                $contact->keywords = $keywords;
                $contact->save();
            }

            // on envoie le mail
            $message = Swift_Message::newInstance()
                    ->setFrom(sfConfig::get('app_pixContact_email_from'))
                    ->setTo(sfConfig::get('app_pixContact_email_to'))
                    ->setSubject(sfConfig::get('app_pixContact_email_subject') . ' ' . $contact->getFullName())
                    ->setContentType('text/html')
                    ->setBody($this->getPartial('pixContact/email', array('contact' => $contact, 'form' => $form, 'tracker' => isset($tracker) ? $tracker : null)));

            foreach (sfConfig::get('app_pixContact_email_bcc') as $mail)
            {
                $message->addBcc($mail);
            }
            // on envoie le mail
            $this->getMailer()->send($message);

            $this->getUser()->setFlash('confirmation', 'label_contact_confirmation_envoi');
            $this->redirect('@pix_contact');
        }
    }
}