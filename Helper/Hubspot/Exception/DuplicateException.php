<?php
/**
 * MageMe
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MageMe.com license that is
 * available through the world-wide-web at this URL:
 * https://mageme.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to a newer
 * version in the future.
 *
 * Copyright (c) MageMe (https://mageme.com)
 **/

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