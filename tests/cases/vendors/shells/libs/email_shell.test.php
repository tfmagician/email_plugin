<?php
App::import('Shell', 'Shell');
print App::import('Shell', 'Email.EmailShell');

if (!defined('DISABLE_AUTO_DISPATCH')) {
  define('DISABLE_AUTO_DISPATCH', true);
}

if (!class_exists('ShellDispatcher')) {
  ob_start();
  $argv = false;
  require CAKE . 'console' .  DS . 'cake.php';
  ob_end_clean();
}

Mock::generatePartial(
  'ShellDispatcher', 'MockShellDispatcher',
  array('getInput', 'stdout', 'stderr', '_stop', '_initEnvironment')
);

Mock::generatePartial(
  'EmailShell', 'MockEmailShell',
  array('in', 'hr', 'out', 'err', 'error', '_stop', '_dispatch')
);

class EmailShellTestCase extends CakeTestCase {

  function startTest() {

    $this->Dispatcher =& new MockShellDispatcher;
    $this->EmailShell =& new MockEmailShell($this->Dispatcher);
    $this->EmailShell->Dispatch =& $this->Dispatcher;
    $this->EmailShell->Dispatch->shellPaths = Configure::read('shellPaths');

    $this->EmailShell->helpers = array('Html', 'Time');
    $this->EmailShell->useMailerConfig = 'test';

  }

  function endTest() {

    unset($this->EmailShell);
    unset($this->Dispatcher);

  }

  function testInit() {

    $this->EmailShell->initialize();
    $this->assertTrue(is_a($this->EmailShell->ExEmail, 'ExEmailComponent'));
    $this->assertTrue(is_a($this->EmailShell->ExEmail->Controller, 'Controller'));
    $this->assertEqual($this->EmailShell->ExEmail->Controller->helpers, array('Html', 'Time'));
    $this->assertEqual($this->EmailShell->ExEmail->Controller->useMailerConfig, 'test');

  }

}
?>
