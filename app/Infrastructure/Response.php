<?php

declare(strict_types=1);

namespace App\Infrastructure;

final class Response
{ 
    public const int HTTP_OK = 200;
    public const int HTTP_CREATED = 201;
    public const int HTTP_BAD_REQUEST = 400;
    public const int HTTP_NOT_FOUND = 404;
    public const int HTTP_INTERNAL_SERVER_ERROR = 500;

    protected string $content;
    protected int $statusCode;
    protected array $headers = [];

    public function __construct(?string $content = '', int $status = self::HTTP_OK)
    {
        $this->setContent(content: $content);
        $this->setStatusCode(status: $status);
    }

    public function setContent(?string $content = ''): void
    {
        $this->content = $content ?? '';
    }

    public function setStatusCode(int $status): void
    {
        $this->statusCode = $status;
    }

    public function addHeader(string $key, string $value): void
    {
        $this->headers[$key] = $value;
    }

    public static function JsonResponse(array $content = [], int $status = self::HTTP_OK): self
    {
        $response = new self(content: json_encode($content), status: $status);
        $response->addHeader('Content-Type', 'application/json');

        return $response;
    }

    public function send(): void
    {
        foreach ($this->headers as $key => $value) {
            header(header: sprintf('%s:%s', $key, $value), replace: true, response_code: $this->statusCode);
        }

        echo $this->content;
    }
}