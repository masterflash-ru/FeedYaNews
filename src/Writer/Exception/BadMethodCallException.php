<?php
/**
 */

namespace Mf\FeedYaNews\Writer\Exception;

use Mf\FeedYaNews\Exception;

/**
 * Feed exceptions
 *
 * Class to represent exceptions that occur during Feed operations.
 */
class BadMethodCallException extends Exception\BadMethodCallException implements ExceptionInterface
{
}
