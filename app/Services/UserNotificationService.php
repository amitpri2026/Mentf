<?php
namespace App\Services;

use App\Models\UserNotification;

class UserNotificationService
{
    public static function notify(int $userId, string $type, string $title, string $message, array $data = [], ?string $actionUrl = null): void
    {
        UserNotification::create([
            'user_id'    => $userId,
            'type'       => $type,
            'title'      => $title,
            'message'    => $message,
            'data'       => $data,
            'action_url' => $actionUrl,
        ]);
    }

    /** Notify mentor when a mentee enrolls in their package */
    public static function mentorNewEnrollment(int $mentorId, string $menteeName, string $packageTitle, ?string $menteeSlug = null): void
    {
        static::notify(
            $mentorId,
            'enrollment',
            'New Student Enrolled!',
            "{$menteeName} enrolled in your package \"{$packageTitle}\".",
            ['mentee_name' => $menteeName, 'package_title' => $packageTitle],
            $menteeSlug ? "/mentees/{$menteeSlug}" : '/dashboard/mentor'
        );
    }

    /** Notify a user when they receive a new chat message */
    public static function newChatMessage(int $recipientId, string $senderName, string $preview, int $conversationId): void
    {
        static::notify(
            $recipientId,
            'chat',
            "New message from {$senderName}",
            $preview,
            ['sender_name' => $senderName, 'conversation_id' => $conversationId],
            "/chat/{$conversationId}"
        );
    }
}
