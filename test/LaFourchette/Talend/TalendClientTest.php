<?php
namespace test\LaFourchette\Talend;

use LaFourchette\Talend\TalendClient;
use Guzzle\Http\Message\Response;
use Guzzle\Plugin\Mock\MockPlugin;
use Guzzle\Tests\GuzzleTestCase;

/**
 * Class TalendClientTest
 *
 * @package LaFourchette\Talend
 */
class TalendClientTest extends GuzzleTestCase
{
    /**
     * @var MockPlugin
     */
    private $mock;

    /**
     * @var TalendClient
     */
    private $client;

    /**
     * setUp
     */
    public function setUp()
    {
        $this->mock = new MockPlugin;
        $this->client = TalendClient::factory(array(
            'base_url'    => 'http://talend.url/org.talend.administrator/metaServlet',
            'login'       => 'login',
            'password'    => 'password',
        ));
        $this->client->addSubscriber($this->mock);
    }

    /**
     * method : runTask
     * case :  run the task with id=17 (job_label)
     */
    public function testRunTask()
    {

        $this->mock->addResponse(new Response(
            200,
            array(
                'Content-Type' => 'application/json',
            ),
            <<<BODY
{
    "returnCode": 0
}
BODY
        ));
        $return = $this->client->runTask(17);

        $requests = $this->mock->getReceivedRequests();

        $this->assertCount(1, $requests);
        $request = reset($requests);

        $this->assertEquals(0, $return->returnCode);
        $this->assertEquals(
            'http://talend.url/org.talend.administrator/metaServlet?eyJhY3Rpb25OYW1lIjoicnVuVGFzayIsImF1dGhQYXNzIjoicGFzc3dvcmQiLCJhdXRoVXNlciI6ImxvZ2luIiwidGFza0lkIjoxNywibW9kZSI6ImFzeW5jaHJvbm91cyJ9',
            $request->getUrl()
        );
    }

    /**
     * method : runTask
     * case :  run the task with id=17 (job_label) and a context parameter
     */
    public function testRunWithContextParameterTask()
    {
        $this->client = TalendClient::factory(array(
            'base_url'    => 'http://talend.url/org.talend.administrator/metaServlet',
            'login'       => 'login',
            'password'    => 'password',
            'context'     => array('ids' => '1,2,3')
        ));
        $this->client->addSubscriber($this->mock);

        $this->mock->addResponse(new Response(
            200,
            array(
                'Content-Type' => 'application/json',
            ),
            <<<BODY
{
    "returnCode": 0
}
BODY
        ));
        $return = $this->client->runTask(17);

        $requests = $this->mock->getReceivedRequests();

        $this->assertCount(1, $requests);
        $request = reset($requests);

        $this->assertEquals(0, $return->returnCode);
        $this->assertEquals(
            'http://talend.url/org.talend.administrator/metaServlet?eyJhY3Rpb25OYW1lIjoicnVuVGFzayIsImF1dGhQYXNzIjoicGFzc3dvcmQiLCJhdXRoVXNlciI6ImxvZ2luIiwidGFza0lkIjoxNywibW9kZSI6ImFzeW5jaHJvbm91cyIsImNvbnRleHQiOnsiaWRzIjoiMSwyLDMifX0=',
            $request->getUrl()
        );
    }

    /**
     * method : runTask
     * case :  run the task with id=17 (job_label) and a context parameter equals null
     */
    public function testRunWithContextParameterTaskEqualsNull()
    {
        $this->client = TalendClient::factory(array(
            'base_url'    => 'http://talend.url/org.talend.administrator/metaServlet',
            'login'       => 'login',
            'password'    => 'password',
            'context'     => null
        ));
        $this->client->addSubscriber($this->mock);

        $this->mock->addResponse(new Response(
            200,
            array(
                'Content-Type' => 'application/json',
            ),
            <<<BODY
{
    "returnCode": 0
}
BODY
        ));
        $return = $this->client->runTask(17);

        $requests = $this->mock->getReceivedRequests();

        $this->assertCount(1, $requests);
        $request = reset($requests);

        $this->assertEquals(0, $return->returnCode);
        $this->assertEquals(
            'http://talend.url/org.talend.administrator/metaServlet?eyJhY3Rpb25OYW1lIjoicnVuVGFzayIsImF1dGhQYXNzIjoicGFzc3dvcmQiLCJhdXRoVXNlciI6ImxvZ2luIiwidGFza0lkIjoxNywibW9kZSI6ImFzeW5jaHJvbm91cyJ9',
            $request->getUrl()
        );
    }

    /**
     * method : runTask
     * case :  run the task with id=17 (job_label) and a context parameter equals null
     */
    public function testRunWithFunctionContextParameter()
    {
        $this->client = TalendClient::factory(array(
            'base_url'    => 'http://talend.url/org.talend.administrator/metaServlet',
            'login'       => 'login',
            'password'    => 'password'
        ));
        $this->client->addSubscriber($this->mock);

        $this->mock->addResponse(new Response(
            200,
            array(
                'Content-Type' => 'application/json',
            ),
            <<<BODY
{
    "returnCode": 0
}
BODY
        ));
        $return = $this->client->runTask(17, array('ids' => '1,2,3,4'));

        $requests = $this->mock->getReceivedRequests();

        $this->assertCount(1, $requests);
        $request = reset($requests);

        $this->assertEquals(0, $return->returnCode);
        $this->assertEquals(
            'http://talend.url/org.talend.administrator/metaServlet?eyJhY3Rpb25OYW1lIjoicnVuVGFzayIsImF1dGhQYXNzIjoicGFzc3dvcmQiLCJhdXRoVXNlciI6ImxvZ2luIiwidGFza0lkIjoxNywibW9kZSI6ImFzeW5jaHJvbm91cyIsImNvbnRleHQiOnsiaWRzIjoiMSwyLDMsNCJ9fQ=%3D',
            $request->getUrl()
        );
    }

    /**
     * method : listTasks
     * case : search a task with a label job_label
     */
    public function testListTasks()
    {

        $this->mock->addResponse(new Response(
            200,
            array(
                'Content-Type' => 'application/json',
            ),
            <<<BODY
{
    "result": [{
        "label": "job_label"
    }],
    "returnCode": 0
}
BODY
        ));

        $return = $this->client->listTasks();

        $requests = $this->mock->getReceivedRequests();

        $this->assertCount(1, $requests);
        $request = reset($requests);

        $this->assertEquals(0, $return->returnCode);

        $this->assertEquals(
            'http://talend.url/org.talend.administrator/metaServlet?eyJhY3Rpb25OYW1lIjoibGlzdFRhc2tzIiwiYXV0aFBhc3MiOiJwYXNzd29yZCIsImF1dGhVc2VyIjoibG9naW4iLCJtb2RlIjoic3luY2hyb25vdXMifQ=%3D',
            $request->getUrl()
        );

        $taskLabels = array();
        if (!empty($return->result)) {
            foreach ($return->result as $task) {
                $taskLabels[] = $task->label;
            }
        }

        $this->assertTrue(array_search('job_label', $taskLabels) !== false);
    }
}
