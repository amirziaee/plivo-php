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

class Account extends Api
{
    /**
     * Get Details of All Messages
     *
     * @param $params
     * @return mixed
     */
    public function getDetails()
    {
        $endpoint = "/";

        return $this->request('get', $endpoint, array(), null);
    }


}