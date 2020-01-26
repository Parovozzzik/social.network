<?php


namespace App\Services;

use Mailgun\Mailgun;

/**
 * Class MailgunService
 * @package App\Services
 */
class MailgunService
{
    /** @var string */
    const STATUS_QUEUE = 'queue';
    /** @var string */
    const STATUS_SUCCESS = 'success';
    /** @var string */
    const STATUS_ERROR = 'error';

    /**
     * @param string $toName
     * @param string $toEmail
     * @param string $subject
     * @param string $html
     * @return bool|\Mailgun\Model\Message\SendResponse|\Psr\Http\Message\ResponseInterface
     */
    public static function send(string $toName, string $toEmail, string $subject, string $html)
    {
        $domain = getenv('MAILGUN_DOMAIN');
        $apiKey = getenv('MAILGUN_API_KEY');
        $fromName = getenv('MAILGUN_NAME_FROM');

        $mgClient = Mailgun::create($apiKey);

        try {
            return $mgClient->messages()->send(
                $domain,
                [
                    'from' => $fromName . ' <mail@' . $domain . '>',
                    'to' => $toName . ' <' . $toEmail . '>',
                    'subject' => $subject,
                    'html' => $html,
                ]
            );
        } catch (\Mailgun\Exception\HttpClientException $e) {
            return false;
        }
    }
}