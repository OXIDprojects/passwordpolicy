<?php

namespace OxidProfessionalServices\PasswordPolicy\Exception;

use Exception;

class LimiterNotFound extends Exception
{

    /**
     * LimiterNotFound constructor.
     */
    public function __construct(string $message = 'Limiter not found', int $code = 404, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}