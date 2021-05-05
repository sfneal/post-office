# Post Office

[![Packagist PHP support](https://img.shields.io/packagist/php-v/sfneal/post-office)](https://packagist.org/packages/sfneal/post-office)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/sfneal/post-office.svg?style=flat-square)](https://packagist.org/packages/sfneal/post-office)
[![Build Status](https://travis-ci.com/sfneal/post-office.svg?branch=master&style=flat-square)](https://travis-ci.com/sfneal/post-office)
[![Quality Score](https://img.shields.io/scrutinizer/g/sfneal/post-office.svg?style=flat-square)](https://scrutinizer-ci.com/g/sfneal/post-office)
[![Total Downloads](https://img.shields.io/packagist/dt/sfneal/post-office.svg?style=flat-square)](https://packagist.org/packages/sfneal/post-office)

Email suite for Laravel applications with extended Mailable & Notification functionality



## Installation

You can install the package via composer:

```bash
composer require sfneal/post-office
```

To modify the post-office config file & views, publish the ServiceProvider with the following command.

``` php
php artisan vendor:publish --provider="Sfneal\PostOffice\Providers\PostOfficeServiceProvider"
```

## Usage

### Creating a `Mailable` & sending it using the `SendMail` job.
First create a `Mailable` extension & implement applicable mailable interfaces.
``` php
use Sfneal\PostOffice\Mailables\Interfaces\CallToAction;
use Sfneal\PostOffice\Mailables\Interfaces\Email;
use Sfneal\PostOffice\Mailables\Interfaces\Greeting;
use Sfneal\PostOffice\Mailables\Interfaces\Message;
use Sfneal\PostOffice\Mailables\Interfaces\Title;
use Sfneal\PostOffice\Mailables\Mailable;
use Sfneal\PostOffice\Mailables\Traits\UserMailable;
use Sfneal\Users\Models\User;

class InvoiceUnpaidMailable extends Mailable implements Greeting, Email, Title, Message, CallToAction
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var int
     */
    private $invoice_id;

    /**
     * InvoicePaidMailable constructor.
     *
     * @param User $user
     * @param int $invoice_id
     */
    public function __construct(User $user, int $invoice_id)
    {
        $this->user = $user;
        $this->invoice_id = $invoice_id;
        parent::__construct(
            $this->getGreeting(),
            $this->getEmail(),
            $this->getTitle(),
            $this->getMessages(),
            $this->getCallToAction()
        );
    }
    
    /**
     * @return string First line of email
     */
    public function getGreeting(): string
    {
        return "Hi {$this->user->first_name}";
    }

    /**
     * Email recipient.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->user->email;
    }

    /**
     * Retrieve the Mailable's subject/title.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return "Unpaid Invoice: #{$this->invoice_id}";
    }

    /**
     * Retrieve an array of messages to include in a mailable.
     *
     * @return array
     */
    public function getMessages(): array
    {
        return [
            'You have one or more unpaid invoices.  Please send use money asap!',
            "If your invoice is not paid within 30 days we're going to send a team of ninja's to your last known location.",
        ];
    }

    /**
     * Call to Action button in the body of the email.
     *
     * @return array
     */
    public function getCallToAction(): array
    {
        return [
            'url' => 'https://google.com',
            'text' => 'Pay Invoice',
        ];
    }
}
```

Next, instantiate your `Mailable` & pass it as the $mailable parameter to the `SendMail` job.  `SendMail` can be dispatched to the Job queue or executed synchronously. 
``` php
$mailable = new InvoiceUnpaidMailable($user, $invoice_id);

// Dispatch SendMail job to the queue
SendMail::dispatch($user->email, $mailable);

// Execute the SendMail synchronously
SendMail::dispatchSync($user->email, $mailable);

// Execute the SendMail synchronously without using Queueable static methods
$sent = (new SendMail($user->email, $mailable))->handle();
```


#### Creating a Notification & sending it using the `Notification` facade
First create a `Notification` extension that defines your notification.

``` php
use Sfneal\PostOffice\Notifications\Notification;
use Sfneal\Users\Models\User;

class InvoiceUnpaidNotification extends Notification
{
    /**
     * @var User
     */
    public $user;

    /**
     * @var int
     */
    public $invoice_id;

    /**
     * InvoicePaidMailable constructor.
     *
     * @param User $user
     * @param int $invoice_id
     */
    public function __construct(User $user, int $invoice_id)
    {
        $this->user = $user;
        $this->invoice_id = $invoice_id;
        parent::__construct();
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return InvoiceUnpaidMailable
     */
    public function toMail($notifiable): InvoiceUnpaidMailable
    {
        return (new InvoiceUnpaidMailable($this->user, $this->invoice_id))->to($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        return [
            'user_id' => $this->user->getKey(),
            'invoice_id' => $this->invoice_id,
        ];
    }
}
```

Send the Notification using either the `send()` or `sendNow()` methods.
``` php
$notification = new InvoiceUnpaidNotification($user, $invoice_id);

// Send using the Job queue
$notification->send($user);

// Send synchronously
$notification->sendNow($user);
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email stephen.neal14@gmail.com instead of using the issue tracker.

## Credits

- [Stephen Neal](https://github.com/sfneal)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## PHP Package Boilerplate

This package was generated using the [PHP Package Boilerplate](https://laravelpackageboilerplate.com).
