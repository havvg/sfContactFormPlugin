<?php
/**
 * @author        Toni Uebernickel <toni@uebernickel.info>
 * @link          http://toni.uebernickel.info/
 *
 * @package       sfContactFormPlugin
 * @subpackage    form
 */

class PluginContactForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'name' => new sfWidgetFormInput(),
      'email' => new sfWidgetFormInput(),
      'subject' => new sfWidgetFormInput(),
      'message' => new sfWidgetFormTextarea(),
      'sendcopy' => new sfWidgetFormInputCheckbox(),
    ));

    // check for valid input
    $this->setValidators(array(
      'name' => new sfValidatorString(array('required' => true, 'min_length' => 5, 'max_length' => 255)),
      'email' => new sfValidatorEmail(array('required' => true)),
      'subject' => new sfValidatorString(array('required' => true, 'min_length' => 5, 'max_length' => 255)),
      'message' => new sfValidatorString(array('required' => true, 'min_length' => 5, 'max_length' => 255)),
      'sendcopy' => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('contact_form[%s]');
  }
}