<?php
/**
 * @author        Toni Uebernickel <toni@uebernickel.info>
 * @link          http://toni.uebernickel.info/
 *
 * @package       sfContactFormPlugin
 * @subpackage    mail
 */

class sfContactFormMail
{
  /**
   * Send a contact mail (text only) with the data provided by the given form.
   *
   * @uses Swift
   *
   * @throws InvalidArgumentException
   * @throws RuntimeException
   *
   * @param sfContactForm $form A valid contact form which contains the content.
   * @param sfContactFormDecorator $decorator Defaults to null. If given, the decorated subject and message will be used.
   *
   * @return bool True if all recipients got the mail.
   */
  public static function send(sfContactForm $form, sfContactFormDecorator $decorator = null)
  {
    if (!$form->isValid())
    {
      throw new InvalidArgumentException('The given form is not valid.', 1);
    }

    if (!class_exists('Swift'))
    {
      throw new RuntimeException('Swift could not be found.');
    }

    // set up sender
    $from = sfConfig::get('sf_contactformplugin_from', false);
    if ($from === false)
    {
      throw new InvalidArgumentException('Configuration value of sf_contactformplugin_from is missing.', 2);
    }

    // where to send the contents of the contact form
    $mail = sfConfig::get('sf_contactformplugin_mail', false);
    if ($mail === false)
    {
      throw new InvalidArgumentException('Configuration value of sf_contactformplugin_mail is missing.', 3);
    }

    // set up mail content
    if (!is_null($decorator))
    {
      $subject = $decorator->getSubject();
      $body = $decorator->getMessage();
    }
    else
    {
      $subject = $form->getValue('subject');
      $body = $form->getValue('message');
    }

    // set up recipients
    $recipients = new Swift_RecipientList();
    // check amount for given recipients
    $recipientCheck = 0;

    // use the sender as recipient to apply other recipients only as blind carbon copy
    $recipients->addTo($from);
    $recipientCheck++;

    // add a mail where to send the message
    $recipients->addBcc($mail);
    $recipientCheck++;

    // add sender to recipients, if chosen
    if ($form->getValue('sendcopy'))
    {
      $recipients->addBcc($form->getValue('email'));
      $recipientCheck++;
    }

    if (count($recipients->getIterator('bcc')) === 0)
    {
      throw new InvalidArgumentException('There are no recipients given.', 4);
    }

    // send the mail using swift
    try
    {
      $mailer = new Swift(new Swift_Connection_NativeMail());
      $message = new Swift_Message($subject, $body, 'text/plain');

      $countRecipients = $mailer->send($message, $recipients, $from);
      $mailer->disconnect();

      return ($countRecipients == $recipientCheck);
    }
    catch (Exception $e)
    {
      $mailer->disconnect();
      throw $e;
    }
  }
}