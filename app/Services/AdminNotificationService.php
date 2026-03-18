<?php
namespace App\Services;
use App\Models\AdminNotification;

class AdminNotificationService
{
    public static function notify(string $type, string $title, string $message, array $data = []): void
    {
        AdminNotification::create([
            'type'    => $type,
            'title'   => $title,
            'message' => $message,
            'data'    => $data,
        ]);
    }

    public static function registration(string $userName, string $userEmail, string $role): void
    {
        static::notify('registration', 'New ' . ucfirst($role) . ' Registered',
            "{$userName} ({$userEmail}) has registered as a {$role}.",
            ['user_name' => $userName, 'user_email' => $userEmail, 'role' => $role]);
    }

    public static function packageCreated(string $mentorName, string $packageTitle): void
    {
        static::notify('package', 'New Package Created',
            "{$mentorName} created a new package: \"{$packageTitle}\".",
            ['mentor_name' => $mentorName, 'package_title' => $packageTitle]);
    }

    public static function newEnrollment(string $menteeName, string $packageTitle, string $mentorName): void
    {
        static::notify('enrollment', 'New Enrollment',
            "{$menteeName} enrolled in \"{$packageTitle}\" by {$mentorName}.",
            ['mentee_name' => $menteeName, 'package_title' => $packageTitle, 'mentor_name' => $mentorName]);
    }

    public static function newTicket(string $userName, string $subject): void
    {
        static::notify('helpdesk', 'New Support Ticket',
            "{$userName} submitted a support ticket: \"{$subject}\".",
            ['user_name' => $userName, 'subject' => $subject]);
    }
}
