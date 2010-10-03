<?php
/**
 * Settings
 *
 * to => null;
 * replyTo => null;
 * readReceipt => null;
 * cc => array();
 * bcc => array();
 * subject => null;
 * headers => array();
 * additionalParams => null;
 * layout => 'default';
 * template => null;
 * lineLength => 70;
 * sendAs => 'text';
 * delivery => 'mail';
 * charset => 'utf-8';
 * xMailer => 'CakePHP Email Component';
 *
 * SMTP Options
 *  port => 1111,
 *  host => 'testhost',
 *  timeout => 10,
 *  username => 'testname',
 *  password => 'testpassword',
 *  client => 'testclient',
 */
class MAILER_CONFIG {

  var $default => array(
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
    'lineLength' => 70,
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

  var $test => array(
    'to' => 'test',
    'replyTo' => 'test',
    'readReceipt' => 'test',
    'cc' => array('test'),
    'bcc' => array('test'),
  );

}

