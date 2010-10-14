# EmailPlugin for CakePHP #

This plugin is collection of functions to use usefuly email more than EmailComponent containing by CakePHP default.

Developed for use in CakePHP 1.3

# Installation #

Install the plugin as normal, by dropping the email directory into your /app/plugins directory.

# Usage #

## Configuration ##

When you wanna send email using the ExEmailCompoennt in your shell or controller, you should create configuration file in your config directory like this.

/path/to/your_app/config/mailer.php
	class MAILER_CONFIG {
		var $default = array(
			'to' => 'to@test.com',
			'from' => 'from@phpmatsuri.com',
			'replyTo' => 'replayTo@test.com',
			'readReceipt' => 'readReceipt@test.com',
			'cc' => array('cc@test.com'),
			'bcc' => array('bcc@test.com'),
			'subject' => 'This is test.',
			'headers' => array('headers'),
			'additionalParams' => array('additionalParams'),
			'layout' => 'default',
			'template' => 'phpmatsuri',
			'lineLength' => false,
			'sendAs' => 'text',
			'delivery' => 'smtp',
			'charset' => 'utf-8',
			'xMailer' => 'PHP Matsuri Mailer',

			'port' => 25,
			'host' => 'localhost',
			'timeout' => 10, 
			'username' => 'test@m.ubuntu',
			'password' => 'test',
			'client' => 'testclient',
		);	
	}

If you use this configuration file, you do not need write an email config repeatedly.

## Send email in your controller ##

When you wanna send email in your controller, you can set $useMailerConfig property and call ExEmailComponet::send().
Then set config name as $useMailerConfig property, ExMailComponent load this config from your config/mailer.php automaticly.

	class MailController extends Controller {
		var $uses = array();
		var $components = array('Email.ExEmail');
		/* The default value is 'default'. */
		//var $useMailerConfig = 'default';

		function index() {
			if(isset($this->params['data']['send'])) {
				/* You can change setting as dynamic. */ 
				// $this->ExEmail->useConfig($this->params['data']['setting']);
				$this->ExEmail->to = $this->params['data']['to'];
				$this->ExEmail->set('body', $this->params['data']['body']);
				$this->ExEmail->send();
				$this->set('error', $this->ExEmail->smtpError);
				$this->render('result');		
			}	 
		}
	}

## Send email in your shell ##

You can use the ExEmailComponent in your shell like using in your controller.
But you should extend EmailShell like this.

	App::import('Shell', 'Email.EmailShell');
	class SendShell extends EmailShell {

		var $useMailerConfig = 'default';
		var $helpers = array('Html', 'Time');

		function startup() {
		}

		function main() {
			$this->ExEmail->to = 'test@test.com';
			$this->ExEmail->set('body', $this->params['body']);
			$this->ExEmail->send();

			if(empty($this->ExEmail->smtpError)) {
				$this->out('Complete.');
				return;
			}	 
			$this->out($this->ExEmail->smtpError);
		}

	}

And you can set $helper property if you want use some helpers on your email template.
The other settings and methods that controll your email are same as controller.
