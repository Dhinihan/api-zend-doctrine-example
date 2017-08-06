<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ApplicationTest\Controller;

use Application\Controller\IndexController;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class IndexControllerTest extends AbstractHttpControllerTestCase
{
    private $controller;
    private $pdo;

    public function setUp()
    {
        $this->pdo = new \PDO('pgsql:host=localhost;port=5432;dbname=api_teste;user=postgres');
        $this->pdo->exec('TRUNCATE example');
        $this->pdo->exec('INSERT INTO example VALUES (\'de5ff4ce-74c8-11e7-b5a5-be2e44b06b34\', \'An Example\')');
        $this->pdo->exec('INSERT INTO example VALUES (\'4b6771b8-74ca-11e7-b5a5-be2e44b06b34\', \'Another Example\')');

        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));

        parent::setUp();
    }

    public function testGetList()
    {
        $response = $this->dispatch('/application', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('application');
        $this->assertControllerName(IndexController::class); // as specified in router's controller name alias
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('application');

        $body = $this->getResponse()->getBody();
        $arrayBody = json_decode($body, true);

        $this->assertEquals($arrayBody['page'], 1);
        $this->assertEquals($arrayBody['page_size'], 25);
        $this->assertEquals($arrayBody['total_items'], 2);
        $this->assertEquals($arrayBody['items'][0], [
            'id' => 'de5ff4ce-74c8-11e7-b5a5-be2e44b06b34',
            'description' => 'An Example'
        ]);
        $this->assertEquals($arrayBody['items'][1], [
            'id' => '4b6771b8-74ca-11e7-b5a5-be2e44b06b34',
            'description' => 'Another Example'
        ]);
    }

    public function testGet()
    {
        $response = $this->dispatch('/application/de5ff4ce-74c8-11e7-b5a5-be2e44b06b34', 'GET');
        $this->assertResponseStatusCode(200);

        $body = $this->getResponse()->getBody();
        $arrayBody = json_decode($body, true);

        $this->assertEquals($arrayBody, [
            'id' => 'de5ff4ce-74c8-11e7-b5a5-be2e44b06b34',
            'description' => 'An Example'
        ]);
    }

    public function testPost()
    {
        $this->getRequest()
            ->setMethod('POST')
            ->setContent('{"description":"Yet Another Example"}');

        $this->getRequest()->getHeaders()->addHeaderLine('Content-Type', 'application/json');

        $this->dispatch('/application');
        $this->assertResponseStatusCode(201);

        $body = $this->getResponse()->getBody();
        $arrayBody = json_decode($body, true);

        $this->assertEquals($arrayBody['description'], 'Yet Another Example');

        $result = $this->pdo->query('select description from example where id = \'' . $arrayBody['id'] . '\'');

        $this->assertEquals('Yet Another Example', $result->fetchAll()[0]['description']);
    }

    public function testPut()
    {
        $this->getRequest()
            ->setMethod('PUT')
            ->setContent('{"description":"A Better Example"}');

        $this->getRequest()->getHeaders()->addHeaderLine('Content-Type', 'application/json');

        $this->dispatch('/application/de5ff4ce-74c8-11e7-b5a5-be2e44b06b34');
        $this->assertResponseStatusCode(200);

        $body = $this->getResponse()->getBody();
        $arrayBody = json_decode($body, true);

        $this->assertEquals($arrayBody['description'], 'A Better Example');

        $result = $this->pdo->query(
            'select description from example where id = \'de5ff4ce-74c8-11e7-b5a5-be2e44b06b34\''
        );

        $this->assertEquals('A Better Example', $result->fetchAll()[0]['description']);
    }
}
