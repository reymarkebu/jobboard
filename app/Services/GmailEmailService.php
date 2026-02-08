<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;

class GmailEmailService
{
    public function send($to, string $subject, $message, array $attachments = [])
    {
        
        // If a Mailable is passed, just send it
        if ($message instanceof Mailable) {
            // Mail::to($to)->queue(
            //     $message->subject($subject)
            // );
            Mail::to($to)->send($message->subject($subject));
            
            return;
        }
    }

    private function isHtml(string $content): bool
    {
        return strip_tags($content) !== $content;
    }
}
