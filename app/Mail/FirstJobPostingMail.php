<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FirstJobPostingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 30;

    /**
     * Create a new message instance.
     */
    public function __construct(public string $subjectLine, public int $userId)
    {
    }

    public function build()
    {

        return $this->subject($this->subjectLine)->view('mail.first_job_posting');
    }

    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'First Job Posting Mail',
    //     );
    // }

    // /**
    //  * Get the message content definition.
    //  */
    // public function content(): Content
    // {
    //     return new Content(
    //         markdown: 'mail.first.job.post.mail',
    //     );
    // }

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
