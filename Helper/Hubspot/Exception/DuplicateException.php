<?php
/**
 * Copyright © MageMe. All rights reserved.
 * See LICENSE for license terms, or https://mageme.com/license.
 */

namespace MageMe\WebFormsHubspot\Helper\Hubspot\Exception;

use Exception;
use Throwable;

class DuplicateException extends Exception
{
    /**
     * @var string
     */
    private $id;

    /**
     * @param string $id
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $id, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getObjectId(): string
    {
        return $this->id;
    }
}