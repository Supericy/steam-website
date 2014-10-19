<?php

class ActivationManagerTest extends TestCase {

	/**
	 * @group activation_manager
	 */
	public function testSendActivationEmail()
	{
		$activationManager = $this->app->make('Icy\User\IActivationManager');
		$this->assertInstanceOf('Icy\User\IActivationManager', $activationManager);

//		$activationManager->sendActivationEmail('koise150@hotmail.com', 'test_activation_code');
	}

} 