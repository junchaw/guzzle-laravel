<?php

namespace Wu\Guzzle\Exception;

use RuntimeException;
use Throwable;

class TransferException extends RuntimeException implements GuzzleException
{
    /**
     * @var string
     */
    private $messageToReport;

    /**
     * @param string $message
     * @param string $messageToReport
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = '未知错误', string $messageToReport = '', int $code = 0, Throwable $previous = null)
    {
        $this->messageToReport = $messageToReport;

        parent::__construct($message, $code, $previous);
    }

    /**
     * @param string $message
     * @param string $messageToReport
     * @param int $code
     * @param Throwable|null $previous
     * @return static
     */
    public static function message(string $message, string $messageToReport = '', int $code = 0, Throwable $previous = null)
    {
        return new static($message, $messageToReport, $code, $previous);
    }

    /**
     * @param string $message
     * @param string $messageToReport
     * @param string $uri
     * @param array $options
     * @param mixed $response
     * @param int $code
     * @param Throwable|null $previous
     * @return TransferException
     */
    public static function apiError(
        string $message,
        string $messageToReport = '',
        string $uri = '',
        array $options = [],
        $response = null,
        int $code = 0,
        Throwable $previous = null
    ) {
        if (! $messageToReport) {
            $messageToReport = '某接口调用失败';
        }

        if ($uri) {
            $messageToReport .= ', uri: ' . $uri;
        }

        if ($options) {
            $messageToReport .= ', options: ' . json_encode($options, JSON_UNESCAPED_UNICODE);
        }

        if ($response) {
            $messageToReport .= ', response: ' . json_encode($response, JSON_UNESCAPED_UNICODE);
        }

        return new static($message, $messageToReport, $code, $previous);
    }

    /**
     * @return string
     */
    public function getMessageToReport(): string
    {
        return $this->messageToReport;
    }
}
