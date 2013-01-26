<?php
namespace ResqueEnqueuer;

class Enqueuer
{
    /**
     * @var string
     */
    protected $keyName;

    /**
     * @var \Redis
     */
    private $redis;

    /**
     * @param string $redisHost
     * @param int $redisPort
     * @param int $redisDb
     * @param string $keyName
     */
    public function __construct($redisHost = 'localhost', $redisPort = 6379, $redisDb = 0, $keyName = 'resque:queue')
    {
        $this->keyName = $keyName;

        $this->redis = new \Redis();
        $this->redis->connect($redisHost, $redisPort);
        if ($redisDb > 0) {
            $this->redis->select($redisDb);
        }
    }

    /**
     * Adds a job to a resque queue.
     * $args must be an array of key => value parameters that
     * will be passed to the specified Job class
     *
     * @param string $queue
     * @param string $class
     * @param array $args
     */
    public function enqueue($queue, $class, Array $args = array())
    {
        $content = json_encode(array("class" => $class, "args" => $args));
        $this->redis->rPush("{$this->keyName}:{$queue}", $content);
    }

    /**
     * Sets the key namespace used by Resque inside Redis
     *
     * @param $keyName
     */
    public function setKeyName($keyName) {
        $this->keyName = $keyName;
    }

    /**
     * Disconnects from Redis
     */
    public function __destruct()
    {
        try {
            $this->redis->close();
        } catch (\RedisException $e) {
        }
    }
}
