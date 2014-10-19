<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {

	/**
	 * Creates the application.
	 *
	 * @return \Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	public function createApplication()
	{
		$unitTesting = true;

		$testEnvironment = 'testing';

		return require __DIR__ . '/../../bootstrap/start.php';
	}

	// https://gist.github.com/VladaHejda/8826707
	protected function assertException(callable $callback, $expectedException = 'Exception', $expectedCode = NULL, $expectedMessage = NULL)
	{
		if (!class_exists($expectedException) || interface_exists($expectedException))
		{
			$this->fail("An exception of type '$expectedException' does not exist.");
		}

		try
		{
			$callback();
		} catch (\Exception $e)
		{
			$class = get_class($e);
			$message = $e->getMessage();
			$code = $e->getCode();

			$extraInfo = $message ? " (message was $message, code was $code)" : ($code ? " (code was $code)" : '');
			$this->assertInstanceOf($expectedException, $e, "Failed asserting the class of exception$extraInfo.");

			if (NULL !== $expectedCode)
			{
				$this->assertEquals($expectedCode, $code, "Failed asserting code of thrown $class.");
			}
			if (NULL !== $expectedMessage)
			{
				$this->assertContains($expectedMessage, $message, "Failed asserting the message of thrown $class.");
			}
			return;
		}

		$extraInfo = $expectedException !== 'Exception' ? " of type $expectedException" : '';
		$this->fail("Failed asserting that exception$extraInfo was thrown.");
	}

}
