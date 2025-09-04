<?php

class Response
{
    public function redirect(string $url, int $statusCode = 302): void
    {
        header("Location: $url", true, $statusCode);

        exit;
    }

    public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }

    public function render(string $viewPath, array $data = []): void
    {
        extract($data);

        require_once $viewPath;
    }
}
