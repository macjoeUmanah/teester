<?php

namespace Chocoholics\LaravelElasticEmail;

use GuzzleHttp\ClientInterface;
use Illuminate\Mail\Transport\Transport;
use Swift_Mime_SimpleMessage;

class ElasticTransport extends Transport
{

	/**
     * Guzzle client instance.
     *
     * @var \GuzzleHttp\ClientInterface
     */
  protected $client;

    /**
     * The Elastic Email API key.
     *
     * @var string
     */
    protected $key;

    /**
     * The Elastic Email username.
     *
     * @var string
     */
    protected $account;

    /**
     * THe Elastic Email API end-point.
     *
     * @var string
     */
    protected $url = 'https://api.elasticemail.com/v2/email/send';

    /**
     * Create a new Elastic Email transport instance.
     *
     * @param  \GuzzleHttp\ClientInterface  $client
     * @param  string  $key
     * @param  string  $username
	 *
     * @return void
     */
    public function __construct(ClientInterface $client, $key, $account, $custom_message_id=null)
    {
    	$this->client = $client;
      $this->key = $key;
      $this->account = $account;
      $this->custom_message_id = $custom_message_id;
    }

    /**
     * {@inheritdoc}
     */
    public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null)
    {
      $this->beforeSendPerformed($message);

      $data = [
        'api_key' => $this->key,
        'account' => $this->account,
        'msgTo' => $this->getEmailAddresses($message),
        'msgCC' => $this->getEmailAddresses($message, 'getCc'),
        'msgBcc' => $this->getEmailAddresses($message, 'getBcc'),
        'msgFrom' => $this->getFromAddress($message)['email'],
        'msgFromName' => $this->getFromAddress($message)['name'],
        'from' => $this->getFromAddress($message)['email'],
        'fromName' => $this->getFromAddress($message)['name'],
        'to' => $this->getEmailAddresses($message),
        'subject' => $message->getSubject(),
        'body_html' => $message->getBody(),
        'body_text' => $this->getText($message),
        'postback' => $this->custom_message_id
      ];

      $result = $this->client->post($this->url, [
       'form_params' => $data
     ]);

      return $result;
    }

    /**
     * Get the plain text part.
     *
     * @param  \Swift_Mime_SimpleMessage $message
     * @return text|null
     */
    protected function getText(Swift_Mime_SimpleMessage $message)
    {
      $text = null;

      foreach($message->getChildren() as $child)
      {
       if($child->getContentType() == 'text/plain')
       {
        $text = $child->getBody();
      }
    }

    return $text;
  }

	/**
	 * @param \Swift_Mime_SimpleMessage $message
	 *
	 * @return array
	 */
  protected function getFromAddress(Swift_Mime_SimpleMessage $message)
  {
    return [
     'email' => array_keys($message->getFrom())[0],
     'name' => array_values($message->getFrom())[0],
   ];
 }

 protected function getEmailAddresses(Swift_Mime_SimpleMessage $message, $method = 'getTo')
 {
  $data = call_user_func([$message, $method]);

  if(is_array($data))
  {
   return implode(',', array_keys($data));
 }
 return '';
}
}
