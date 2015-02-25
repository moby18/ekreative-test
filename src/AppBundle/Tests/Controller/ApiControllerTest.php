<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Bundle\FrameworkBundle\Client;

class ApiControllerTest extends WebTestCase
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $token;

    protected function runCommand(Client $client, $command)
    {
        $application = new Application($client->getKernel());
        $application->setAutoExit(false);

        $input = new StringInput($command);
        $application->run($input);
    }

    public function setUp()
    {
        $this->client = static::createClient();

        $this->token = "token";

//        $this->runCommand($this->client, "doctrine:database:create --env=test");
        $this->runCommand($this->client, "doctrine:schema:update --force --env=test");
        $this->runCommand($this->client, "doctrine:fixtures:load -n --env=test");

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testTagsAction()
    {
        $tag = $this->em
            ->getRepository('AppBundle:Tag')
            ->findOneBy([]);

        $this->client->request('GET', '/api/tags',
            [], // params
            [], // files
            ['HTTP_AUTHORIZATION' => $this->token],
            null // json_encode()
        );
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('content-type'));
        $json = json_decode($response->getContent(), true);
        $this->assertInternalType('array', $json);
        if (count($json)) {
            $this->assertArrayHasKey('id', $json['0']);
            $this->assertArrayHasKey('title', $json['0']);
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->em->close();
    }
}
