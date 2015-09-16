<?php namespace Bickart\Plivo\Api;
/**
 * Copyright 2015 Jeff Bickart
 *
 * User: @bickart
 * Date: 09/14/2015
 * Time: 4:02 PM
 * 
 */

use Bickart\Plivo\Contracts\HttpClient;
use Bickart\Plivo\Http\Query;
use GuzzleHttp\Exception\RequestException;

abstract class Api
{
    /**
     * @var string Plivo AUTH ID
     */
    protected $authId;

    /**
     * @var string Plivo AUTH Token
     */
    protected $authToken;


    /**
     * @var HttpClient
     */
    protected $client;

    /**
     * @var string Base url
     */
    protected $baseUrl = "https://api.plivo.com/v1/Account/";

    /**
     * Default user agent.
     */
    const USER_AGENT = 'Bickart_Plivo_PHP/0.1 (https://github.com/bickart/plivo-php)';


    /**
     *
     * Authentication
     * All requests to Plivo API are authenticated with Basic Auth using your AUTH ID and AUTH TOKEN.
     * Your Plivo AUTH ID and AUTH TOKEN can be found when you login to your <a href='https://manage.plivo.com/dashboard/'>dashboard</a>.
     * @link https://manage.plivo.com/dashboard/
     *
     * @param string $authId
     * @param string $authToken
     * @param HttpClient $client
     */
    public function __construct($authId , $authToken, HttpClient $client)
    {
        $this->authId = $authId;
        $this->authToken = $authToken;

        $this->client = $client;
    }

    /**
     * Send the request to the Plivo API.
     *
     * @param string $method The HTTP request verb.
     * @param string $url The url to send the request to.
     * @param array $options An array of options to send with the request.
     * @return mixed
     */
    protected function requestUrl($method, $url, array $options =[])
    {
        $options['headers']['User-Agent'] = self::USER_AGENT;
        $options['auth'] = [$this->authId, $this->authToken];

        try {
            return $this->client->$method($url, $options);
        } catch (RequestException $e) {
            return $e->getResponse();
        }
    }

    /**
     * Send the request to the Plivo API.
     *
     * @param string $method The HTTP request verb.
     * @param string $endpoint The Plivo API endpoint.
     * @param array $options An array of options to send with the request.
     * @param string $queryString A query string to send with the request.
     * @return mixed
     */
    protected function request($method, $endpoint, array $options = [], $queryString = null)
    {
        $url = $this->generateUrl($endpoint, $queryString);

        return $this->requestUrl($method, $url, $options);
    }

    /**
     * Generate the full endpoint url, including query string.
     *
     * @param string $endpoint The Plivo API endpoint.
     * @param string $queryString The query string to send to the endpoint.
     * @return string
     */
    protected function generateUrl($endpoint, $queryString = null)
    {
        return $this->baseUrl . $this->authId . $endpoint . $queryString;
    }

    /**
     * Generate a query string for batch requests.
     *
     * This is a workaround to deal with multiple items with the same key/variable name, not something PHP generally likes.
     *
     * @param string $varName The name of the query variable.
     * @param array $items An array of item values for the variable.
     * @return string
     */
    protected function generateBatchQuery($varName, array $items)
    {
        $queryString = '';
        foreach ($items as $item) {
            $queryString .= "&{$varName}={$item}";
        }

        return $queryString;
    }

    /**
     * @param array|Query $params
     * @return mixed
     * @throws \InvalidArgumentException
     */
    protected function getQuery($params)
    {
        if (is_array($params) || $params instanceof Query) {
            return $params;
        }

        throw new \InvalidArgumentException('Argument must be an array or an instance of \Bickart\Plivo\Http\Query');
    }
}