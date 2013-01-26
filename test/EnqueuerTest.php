<?php
require_once __DIR__ . '/../vendor/autoload.php';

class EnqueuerTest extends \PHPUnit_Framework_TestCase
{

    // @todo: move the configuration in a yaml file
    protected $redisHost = 'localhost';
    protected $redisPort = 6379;
    protected $redisDb = 0;
    protected $keyName = 'resque:queuetest';
    protected $redis;
    protected $keyContent;

    public function setUp()
    {
        $this->redis = new \Redis();
        $this->redis->connect($this->redisHost, $this->redisPort);

        $this->enq = new \ResqueEnqueuer\Enqueuer($this->redisHost, $this->redisPort, $this->redisDb, $this->keyName);
        $this->enq->enqueue('queue_name_test', 'class_name_test', array('test' => 1, 'test_param2' => 'hello'));

        $this->keyContent = $this->redis->lpop("{$this->keyName}:queue_name_test");
    }

    public function testAddedToRedis()
    {
        $this->assertNotEmpty($this->keyContent);
    }

    public function testValidJson()
    {
        $this->assertArrayHasKey('class', json_decode($this->keyContent, true));
    }

    public function testRightClass()
    {
        $this->assertEquals('class_name_test', json_decode($this->keyContent, true)['class']);
    }

    public function testRightArguments()
    {
        $this->assertArrayHasKey('test_param2', json_decode($this->keyContent, true)['args']);
    }
}
