<?php
App::import('Component', 'Email');

class ExEmailComponent extends EmailComponent {

  function _wrap($message) {
    $message = $this->_strip($message, true);
    $message = str_replace(array("\r\n","\r"), "\n", $message);
    $lines = explode("\n", $message);
    $formatted = array();

    if ($this->_lineLength !== null) {
      trigger_error(__('_lineLength cannot be accessed please use lineLength', true), E_USER_WARNING);
      $this->lineLength = $this->_lineLength;
    }

    foreach ($lines as $line) {
      if (substr($line, 0, 1) == '.') {
        $line = '.' . $line;
      }
      if($this->lineLength) {
        $line = wordwrap($line, $this->lineLength, "\n", true);
      }
      $formatted = array_merge($formatted, explode("\n", $line));
    }
    $formatted[] = '';
    return $formatted;
  }

  function _load($setting = 'default') {

    if(!class_exists('MAILER_CONFIG') && file_exists(CONFIGS.'mailer.php')) {
      require_once(CONFIGS.'mailer.php');
    }

    if(class_exists('MAILER_CONFIG')) {
      $config = new MAILER_CONFIG;

      $this->lineLength = 70;
      $this->xMailer = 'CakePHP Email Component';
      $this->headers = array();
      $this->smtpOptions = array();

      $params = array(
        'to',
        'from',
        'replyTo',
        'readReceipt',
        'cc',
        'bcc',
        'subject',
        'headers',
        'additionalParams',
        'layout',
        'template',
        'lineLength',
        'sendAs',
        'delivery',
        'charset',
        'xMailer',
      );
      foreach($params as $param) {
        if(isset($config->{$setting}[$param])) {
          $this->{$param} = $config->{$setting}[$param];
        }
      }

      $smtpParams = array(
        'port',
        'host',
        'timeout',
        'username',
        'password',
        'client',
      );
      foreach($smtpParams as $param) {
        if(isset($config->{$setting}[$param])) {
          $this->smtpOptions[$param] = $config->{$setting}[$param];
        }
      }
    }

  }

  function _convertMessage($message) {
    mb_convert_variables($this->charset, Configure::read('App.encoding'), $message);
    return $message;
  }

  function _render($content) {
    $message = parent::_render($content);
    return $this->_convertMessage($message);
  }

  function _formatMessage($message) {
    $message = parent::_formatMessage($message);
    return $this->_convertMessage($message);
  }

  function initialize(&$Controller, $settings = array()) {
    parent::initialize(&$Controller, $settings);
    $this->reset();
  }

  function set($one, $two = NULL) {
    $this->Controller->set($one, $two);
  }

  function reset() {
    parent::reset();
    if(isset($this->Controller->useMailerConfig) && $this->Controller->useMailerConfig) {
      $this->_load($this->Controller->useMailerConfig);
    }
  }

  function useConfig($setting) {
    parent::reset();
    $this->_load($setting);
  }

}
?>
