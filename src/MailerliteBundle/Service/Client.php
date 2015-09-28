<?php
/*
 MIT License
 ===========
 
 Copyright (c) 2012

 Permission is hereby granted, free of charge, to any person obtaining a
 copy of this software and associated documentation files (the "Software"),
 to deal in the Software without restriction, including without limitation
 the rights to use, copy, modify, merge, publish, distribute, sublicense,
 and/or sell copies of the Software, and to permit persons to whom the
 Software is furnished to do so, subject to the following conditions:
 
 The above copyright notice and this permission notice shall be included in
 all copies or substantial portions of the Software.
 
 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 DEALINGS IN THE SOFTWARE.
 */

namespace MailerliteBundle\Service;

use GuzzleHttp\Client as GuzzleClient;

class Client extends GuzzleClient
{

	/**
	 * api key
	 * 
	 * @param string
	 */
	private $apiKey;

	public function __construct(array $config)
	{
		if (!array_key_exists('api_key', $config)) {
			throw new \InvalidArgumentException('API Key must be provided.');
		}

		$this->apiKey = $config['api_key'];
		unset($config['api_key']);

		parent::__construct($config);
	}

	public function subscribe($email, $name)
	{
		return $this->post(
			sprintf('subscribers/%d/', (int)$this->getConfig('list_id')),
			[
				'form_params' => [
					'email' => (string)$email,
					'name' => (string)$name
				]
			]
		);
	}

	public function request($method, $uri = null, array $options = [])
	{
		if (isset($options['query'])) {
			$options['query'] = array_merge(['apiKey' => $this->apiKey], $options['query']);	
		} else {
			$options['query'] = ['apiKey' => $this->apiKey];
		}
		
		return parent::request($method, $uri, $options);
	}
}