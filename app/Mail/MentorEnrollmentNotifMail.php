<?php
namespace App\Mail;
use App\Models\Package;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MentorEnrollmentNotifMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $mentee, public Package $package) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'New Enrollment: ' . $this->mentee->name . ' joined "' . $this->package->title . '"');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.mentor-enrollment-notif');
    }

    public function attachments(): array { return []; }
}
