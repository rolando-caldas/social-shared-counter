<?php

namespace App\Infrastructure\UI\WebSite;

class Response
{

    private $code;
    private $response;

    private function __construct(int $code = 200)
    {
        $this->code = $code;
    }

    public static function generateExceptionResponse(int $code, \Exception $exception) : self
    {
        $return = new self($code);
        $return->generateResponseFromException($exception);
        return $return;
    }

    private function generateResponseFromException(\Exception $exception) : void
    {
        $this->response = [
            "code" => $exception->getCode(),
            "file" => $exception->getFile(),
            "line" => $exception->getLine(),
            "message" => $exception->getMessage(),
            "trace" => $exception->getTraceAsString()
        ];
    }

    public static function generateSuccessResponse(int $code, $data) : self
    {
        $return = new self($code);
        $return->generateResponseFromSuccess($data);
        return $return;
    }

    private function generateResponseFromSuccess($data) : void
    {
        $this->response = $data;
    }

    public function code() : string
    {
        return $this->code;
    }

    public function response()
    {
        return $this->response;
    }
}