<?php
namespace App\Mail;
use App\Models\Package;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PackageCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $mentor, public Package $package) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Your Package "' . $this->package->title . '" is Live!');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.package-created');
    }

    public function attachments(): array { return []; }
}
