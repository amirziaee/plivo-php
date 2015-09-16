<?php namespace Bickart\Plivo\Api;
/**
 * Copyright 2015 Jeff Bickart
 *
 * User: @bickart
 * Date: 09/14/2015
 * Time: 4:00 PM
 * 
 */

use Bickart\Plivo\Exceptions\PlivoException;

class Message extends Api
{
    /**
     * Send a Message
     *
     * This API enables you to send messages via Plivo’s SMS service. The API supports Unicode UTF-8 encoded texts,
     * so you can send messages in any language. The API also handles long SMS automatically by splitting it into standard
     * SMS sized chunks and sending them. Delivery reports are automatically supported in networks where they are provided
     * by the operator.
     *
     * @param string $src The phone number that will be shown as the sender ID. Be sure that all phone numbers include country code, area code, and phone number without spaces or dashes (e.g., 14153336666)
     * @param string $dst The number to which the message will be sent. Be sure that all phone numbers include country code, area code, and phone number without spaces or dashes (e.g., 14153336666). To send messages to multiple numbers, separate your destination phone numbers with the delimiter "<" (e.g., 14156667777<14157778888<14158889999).
     * @param string $text The text message that will be sent. The API will encode the text in Unicode UTF-8 and accepts up to 1000 bytes of UTF-8 encoded text in a single API request. The text will be automatically split into multiple messages and sent separately if the message exceeds the size limit.
     * @param string $type The type of message. Should be `sms` for a text message. Defaults to `sms`.
     * @param null $url The URL to which with the status of the message is sent
     * @param string $method The method used to call the url. Defaults to POST.
     * @param bool $log If set to false, the content of this message will not be logged on the Plivo infrastructure and the dst value will be masked (e.g., 141XXXXX528). Default is set to true.
     * @return mixed
     * @throws PlivoException
     *
     * @link https://www.plivo.com/docs/api/message/#send-a-message
     */

    public function send($src, $dst, $text, $type = 'sms', $url = null, $method = 'POST', $log = true)
    {
        $endpoint = "/Message/";

        $options['json']['src'] = $src;
        $options['json']['dst'] = $dst;
        $options['json']['text'] = $text;
        $options['json']['type'] = $type;

        if (! empty($url)) {
            $options['json']['url'] = $url;
            $options['json']['method'] = $method;
        }

        $options['json']['log'] = $log;

        return $this->request('post', $endpoint, $options);
    }

    /**
     * Get Details of All Messages
     *
     * @param $params
     * @return mixed
     */
    public function all($params)
    {
        $endpoint = "/Message/";

        if (isset($params['property']) && is_array($params['property'])) {
            $queryString = $this->generateBatchQuery('property', $params['property']);
            unset($params['property']);
        } else {
            $queryString = null;
        }

        $options['query'] = $this->getQuery($params);

        return $this->request('get', $endpoint, $options, $queryString);
    }


    /**
     * Get Details of a Single Message
     *
     * @param int $id
     * @return mixed
     */
    public function getById($id)
    {
        $endpoint = "/Message/{$id}/";

        return $this->request('get', $endpoint);
    }
}