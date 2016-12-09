<?php

namespace Classy;

use Psr\Http\Message\ResponseInterface;

/**
 * Class MailChimpClient
 * @package App\Services
 *
 * Simple php client to request mailchimp API 3.0.
 *
 * @method ResponseInterface get($uri, array $options = [])
 * @method ResponseInterface head($uri, array $options = [])
 * @method ResponseInterface put($uri, array $options = [])
 * @method ResponseInterface post($uri, array $options = [])
 * @method ResponseInterface patch($uri, array $options = [])
 * @method ResponseInterface delete($uri, array $options = [])

 */
class MailchimpClient
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * @param $api_key
     * @param array $options Accept same options as Guzzle constructor
     */
    public function __construct($api_key, array $config = [])
    {
        if (!is_string($api_key)) {
            throw new \Exception("api_key must be a string");
        }
        if (strpos($api_key, '-') === false) {
            throw new \Exception("api_key $api_key is invalid");
        }

        list($key, $dc) = explode('-', $api_key);

        $config = array_merge($config, [
            'base_uri' => "https://$dc.api.mailchimp.com/3.0/",
            'auth'     => ['apikey', $key],
        ]);

        $this->client = new \GuzzleHttp\Client($config);
    }

    /**
     * Shortcut.
     *
     * @param $uri
     * @param array $options
     * @return mixed
     */
    public function getData($uri, $options = [])
    {
        return json_decode($this->client->get($uri, $options)->getBody()->getContents());
    }

    /**
     * Perform a request
     *
     * @param $method
     * @param string $uri
     * @param array $options
     * @return mixed|ResponseInterface
     */
    public function request($method, $uri = '', array $options = [])
    {
        return $this->client->request($method, $uri, $options);
    }

    /**
     * Forward any other call to guzzle client.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->client, $method], $parameters);
    }
}
