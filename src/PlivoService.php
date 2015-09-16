<?php namespace Bickart\Plivo;


use Bickart\Plivo\Exceptions\PlivoException;
use Bickart\Plivo\Http\Client;

/**
 * Class PlivoService
 * @package Bickart\Plivo
 *
 * @method \Bickart\Plivo\Api\Account account()
 * @method \Bickart\Plivo\Api\Application application()
 * @method \Bickart\Plivo\Api\Call call()
 * @method \Bickart\Plivo\Api\Conference conference()
 * @method \Bickart\Plivo\Api\Endpoint endpoint()
 * @method \Bickart\Plivo\Api\Message message()
 * @method \Bickart\Plivo\Api\Number number()
 * @method \Bickart\Plivo\Api\Pricing pricing()
 * @method \Bickart\Plivo\Api\Recording recording()
 */
class PlivoService
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
     * @param string|null $apiKey
     * @param bool $oauth
     * @throws PlivoException
     */
    protected function __construct($authId = null, $authToken = null)
    {
        $this->authId = $authId;
        $this->authToken = $authToken;

        if (empty($this->authId)) {
            throw new PlivoException("You must provide a Plivo AUTH ID.");
        }

        if (empty($this->authToken)) {
            throw new PlivoException("You must provide a Plivo AUTH Token.");
        }
    }

    /**
     * @param string $authId Plivo AUTH ID
     * @param string $authToken Plivo AUTH Token
     *
     * @return static
     */
    public static function make($authId = null, $authToken = null)
    {
        return new static($authId, $authToken);
    }

    /**
     * @param string $name
     * @param null $arguments
     * @return mixed
     * @throws PlivoException
     */
    public function __call($name, $arguments = null)
    {
        $apiClass = $this->getApiClassName($name);

        if (! (new \ReflectionClass($apiClass))->isInstantiable()) {
            throw new PlivoException("Target [$apiClass] is not instantiable.");
        }

        return new $apiClass($this->authId, $this->authToken, new Client);
    }

    /**
     * @param string $name
     * @return string
     */
    protected function getApiClassName($name)
    {
        return 'Bickart\\Plivo\\Api\\' . ucfirst($name);
    }
}
