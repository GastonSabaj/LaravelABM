<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address as Adress;

class MyEmail extends Mailable
{
    use Queueable, SerializesModels;
    //public $name;

    public $subject;
    public $body;
    public $fromEmail;
    /**
     * Create a new message instance.
     */
    public function __construct($subject, $body, $fromEmail = null)
    {
        //$this->name = $name;

        $this->subject = $subject;
        $this->body = $body;
        $this->fromEmail = $fromEmail;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        /* 
            Entiendo. Parece que estás especificando manualmente la dirección de correo electrónico del remitente (mailtrap@gmail.com) en el 
        método envelope() dentro de tu clase MyEmail. Esto está sobrescribiendo la configuración de MAIL_FROM_ADDRESS que has establecido en tu 
        archivo .env.
            Para que se utilice la dirección de correo electrónico del remitente definida en tu archivo .env, deberías eliminar 
        la parte donde se especifica manualmente el remitente en el método envelope() y dejar que Laravel utilice la configuración 
        predeterminada del remitente que has establecido en tu archivo .env.
        
        */
        return new Envelope(
            subject: 'My Email',
            from: new Adress($this->fromEmail),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.test-email',
            with: [
                'subject' => $this->subject,
                'body' => $this->body
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
