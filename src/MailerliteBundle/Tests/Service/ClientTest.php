<?php

namespace MailerliteBundle\Tests\Service;

use MailerliteBundle\Service\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{	
	/**
	 * @test
	 * @expectedException 			InvalidArgumentException
	 * @expectedExceptionMessage	API Key must be provided.
	 */
	public function it_should_throw_exception_if_api_key_is_not_provided()
	{
		$client = new Client([]);
	}
}