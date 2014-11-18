<?php
namespace LaFourchette\Talend;

use Guzzle\Common\Collection;
use Guzzle\Service\Client;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Guzzle\Http\Message\Request;
use Guzzle\Http\Message\Response;
use LaFourchette\Talend\Exception\TalendApiException;
use LaFourchette\Talend\Exception\JobExecutionException;

/**
 * Class TalendClient
 *
 * @package LaFourchette\Talend
 */
class TalendClient extends Client
{

    /**
     * Basic factory method to create a new client. Extend this method in subclasses to build more complex clients.
     *
     * @param array|Collection $config Configuration data
     *
     * @return Client
     */
    public static function factory($config = array())
    {
        $defaults = array();

        $required = array(
            'base_url',
            'login',
            'password'
        );

        $config = Collection::fromConfig($config, $defaults, $required);

        $client = new self($config['base_url'], $config);

        return $client;
    }

    /**
     * @param int     $taskId
     * @param array   $context
     *
     * @return array|Guzzle\Http\Message\Response
     */
    public function runTask($taskId, $context = array())
    {
        $param =  array(
            'actionName' => 'runTask',
            'authPass'   => $this->getConfig('password'),
            'authUser'   => $this->getConfig('login'),
            'taskId'     => $taskId,
            'mode'       => 'synchronous'
        );

        if ($this->getConfig('context') != '' && is_array($this->getConfig('context'))) {
            $context = array_merge($this->getConfig('context'), $context);
        }

        if (!empty($context) && is_array($context)) {
            $param['context'] = $context;
        }

        return $this->getContent($this->doRequest($this->get('?'. $this->getJsonEncoded($param))));
    }

    /**
     * @return array|Guzzle\Http\Message\Response
     */
    public function listTasks()
    {
        $param =  array(
            'actionName' => 'listTasks',
            'authPass'   => $this->getConfig('password'),
            'authUser'   => $this->getConfig('login'),
            'mode'       => 'synchronous'
        );

        return $this->getContent($this->doRequest($this->get('?'. $this->getJsonEncoded($param))));
    }

    /**
     * @param type $param
     *
     * @return string
     */
    public function getJsonEncoded($param)
    {
        return base64_encode(json_encode($param));
    }

    /**
     * @param Response $response
     *
     * @return array
     */
    public function getContent(Response $response)
    {
        $data = json_decode($response->getBody(true), true);
        $this->generateException($data);

        return $data;
    }

    /**
     * @param array $data
     *
     * @throws TalendApiException
     * @throws JobExecutionException
     */
    private function generateException(array $data)
    {
        if (array_key_exists('error', $data) && 0 < $data['returnCode']) {
            throw new TalendApiException('Api exception error: ' . $data['error']);
        } elseif (array_key_exists('errorStatus', $data) && 'NO_ERROR' != $data['errorStatus']) {
            throw new JobExecutionException('Job execution exception error: ' . $data['errorStatus']);
        }
    }

    /**
     * Returns a Response object
     *
     * @param Guzzle\Http\Message\Request $request
     *
     * @return array|Guzzle\Http\Message\Response
     */
    private function doRequest(Request $request)
    {
        try {
            return $request->send();
        } catch (ClientErrorResponseException $e) {
            return $e->getResponse();
        }
    }
}
