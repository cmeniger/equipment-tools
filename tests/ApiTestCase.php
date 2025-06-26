<?php 

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class ApiTestCase extends TestCase
{
    private $http;

    public function setUp(): void
    {
        $env = parse_ini_file(__DIR__ . '/../.env');

        $this->http = new \GuzzleHttp\Client(['base_uri' => $env['APP_HOST']]);
    }

    public function tearDown(): void 
    {
        $this->http = null;
    }

    public function get(string $route): ResponseInterface
    {
        return $this->http->request('GET', $route);
    }
}