<?php


namespace app\exceptions;


use Exception;
use yii\web\HttpException;

/**
 * Class ResponseException
 * custom api error exception
 * @package app\exceptions
 */
class ResponseException extends HttpException
{
    /**
     * Constructor.
     * @param string $message error message
     * @param int $code error code
     * @param Exception $previous The previous exception used for the exception chaining.
     */
    public function __construct($message = null, $code = 0, Exception $previous = null)
    {
        parent::__construct(420, $message, $code, $previous);
    }

}