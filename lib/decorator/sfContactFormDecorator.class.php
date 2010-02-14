<?php
/**
 * @author        Toni Uebernickel <toni@uebernickel.info>
 * @link          http://toni.uebernickel.info/
 *
 * @package       sfContactFormPlugin
 * @subpackage    mail
 */

class sfContactFormDecorator extends BaseContactFormDecorator
{
  /**
   * Returns the decorated message.
   *
   * @return string
   */
  public function getMessage()
  {
    return $this->getRawMessage();
  }

  /**
   * Returns the decorated subject.
   *
   * @return string
   */
  public function getSubject()
  {
    return $this->getRawSubject();
  }
}