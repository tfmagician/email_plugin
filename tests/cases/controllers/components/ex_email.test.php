<?php
App::import('Component', 'Email.ExEmail');

class MAILER_CONFIG {

  var $default = array(
    'to' => 'to@test.com',
    'replyTo' => 'replayTo@test.com',
    'readReceipt' => 'readReceipt@test.com',
    'cc' => array('cc@test.com'),
    'bcc' => array('bcc@test.com'),
    'subject' => 'subject',
    'headers' => array('headers'),
    'additionalParams' => array('additionalParams'),
    'layout' => 'default',
    'template' => 'template',
    'lineLength' => 80,
    'sendAs' => 'text',
    'delivery' => 'mail',
    'charset' => 'utf-8',
    'xMailer' => 'xMailer',

    'port' => 1111,
    'host' => 'testhost',
    'timeout' => 10,
    'username' => 'testname',
    'password' => 'testpassword',
    'client' => 'testclient',
  );

  var $test = array(
    'to' => 'test',
    'replyTo' => 'test',
    'readReceipt' => 'test',
    'cc' => array('test'),
    'bcc' => array('test'),
  );

}

Mock::generatePartial(
  'Controller', 'MockController',
  array('set')
);

class TestExEmailComponent extends ExEmailComponent {

  function wrap($message) {
    return $this->_wrap($message);
  }

}

class EmailTestCase extends CakeTestCase {

  function startTest() {
    $this->ExEmail =& new TestExEmailComponent();
    $this->ExEmail->lineLength = false;
    $this->ExEmail->Controller = new MockController;
  }

  function endTest() {
    unset($this->ExEmail);
  }

  function testWrap() {

    // wrap multi byte string.
    $message = 'This is test message.';
    $ret = $this->ExEmail->wrap($message);
    $expected = array(
      'This is test message.',
      '',
    );
    $this->assertEqual($expected, $ret);

  }

  function testSetConfig() {

    // Set default
    $this->ExEmail->useConfig('default');
    
    $this->assertEqual($this->ExEmail->to, 'to@test.com');
    $this->assertEqual($this->ExEmail->replyTo, 'replayTo@test.com');
    $this->assertEqual($this->ExEmail->readReceipt, 'readReceipt@test.com');
    $this->assertEqual($this->ExEmail->cc, array('cc@test.com'));
    $this->assertEqual($this->ExEmail->bcc, array('bcc@test.com'));
    $this->assertEqual($this->ExEmail->subject, 'subject');
    $this->assertEqual($this->ExEmail->headers, array('headers'));
    $this->assertEqual($this->ExEmail->additionalParams, array('additionalParams'));
    $this->assertEqual($this->ExEmail->layout, 'default');
    $this->assertEqual($this->ExEmail->template, 'template');
    $this->assertEqual($this->ExEmail->lineLength, 80);
    $this->assertEqual($this->ExEmail->sendAs, 'text');
    $this->assertEqual($this->ExEmail->delivery, 'mail');
    $this->assertEqual($this->ExEmail->charset, 'utf-8');
    $this->assertEqual($this->ExEmail->xMailer, 'xMailer');

    $this->assertEqual($this->ExEmail->smtpOptions, 
      array(
        'port' => 1111,
        'host' => 'testhost',
        'timeout' => 10,
        'username' => 'testname',
        'password' => 'testpassword',
        'client' => 'testclient',
      )
    );

    // Set test 
    $this->ExEmail->useConfig('test');
    
    $this->assertEqual($this->ExEmail->to, 'test');
    $this->assertEqual($this->ExEmail->replyTo, 'test');
    $this->assertEqual($this->ExEmail->readReceipt, 'test');
    $this->assertEqual($this->ExEmail->cc, array('test'));
    $this->assertEqual($this->ExEmail->bcc, array('test'));
    $this->assertEqual($this->ExEmail->subject, NULL);
    $this->assertEqual($this->ExEmail->headers, array());
    $this->assertEqual($this->ExEmail->additionalParams, array());
    $this->assertEqual($this->ExEmail->layout, 'default');
    $this->assertEqual($this->ExEmail->template, NULL);
    $this->assertEqual($this->ExEmail->lineLength, 70);
    $this->assertEqual($this->ExEmail->sendAs, 'text');
    $this->assertEqual($this->ExEmail->delivery, 'mail');
    $this->assertEqual($this->ExEmail->charset, 'utf-8');
    $this->assertEqual($this->ExEmail->xMailer, 'CakePHP Email Component');

    $this->assertEqual($this->ExEmail->smtpOptions, array());

  }

  function testSet() {

    $this->ExEmail->Controller->expectOnce('set', array('name', 'value'));
    $this->ExEmail->set('name', 'value');

  }

}
?>
