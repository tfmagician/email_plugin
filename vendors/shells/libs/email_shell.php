<?php
class EmailShell extends Shell {

  /**
   * Helpers using for your mail template.
   *
   * @access public
   * @var array
   */
  var $helpers = array();

  /**
   * Mailer settings using for this shell.
   *
   * @access public
   * @var string
   */
  var $useMailerConfig = 'default';

  function initialize() {

    App::import('Core', 'Controller');
    $Controller = new Controller();
    $Controller->helpers = $this->helpers;
    $Controller->useMailerConfig = $this->useMailerConfig;

    App::import('Component', 'Email.ExEmail');
    $this->ExEmail = new ExEmailComponent();
    $this->ExEmail->initialize($Controller);

    parent::initialize();
  }

}
?>
