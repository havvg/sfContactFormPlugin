<?php
/**
 * @author        Toni Uebernickel <toni@uebernickel.info>
 * @link          http://toni.uebernickel.info/
 *
 * @package       sfContactFormPlugin
 * @subpackage    form
 */

abstract class BaseContactFormDecorator
{
  /**
   * The sfContactForm that has been decorated.
   *
   * @var sfContactForm
   */
  protected $form;

  public function __construct(sfContactForm $form)
  {
    $this->setForm($form);
  }

  /**
   * Set the related form.
   *
   * @param sfContactForm $form
   *
   * @return BaseContactFormDecorator (this)
   */
  public function setForm(sfContactForm $form)
  {
    $this->form = $form;

    return $this;
  }

  /**
   * Returns the related form.
   *
   * @return sfContactForm
   */
  public function getForm()
  {
    return $this->form;
  }

  /**
   * Returns the decorated message.
   *
   * @return string
   */
  abstract public function getMessage();

  /**
   * Returns the decorated subject.
   *
   * @return string
   */
  abstract public function getSubject();

  /**
   * Returns the raw message provided by the form.
   *
   * @return string
   */
  public function getRawMessage()
  {
    return $this->getForm()->getValue('message');
  }

  /**
   * Returns the raw subject provided by the form.
   *
   * @return string
   */
  public function getRawSubject()
  {
    return $this->getForm()->getValue('subject');
  }
}