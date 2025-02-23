<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomVerifyEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $verifyUrl=url('/custom-verify-url/' . $notifiable->id . '/' . $this->generateVerificationHash($notifiable));
        return (new MailMessage)
                    ->subject('メール認証')
            ->line('登録したメールアドレスの認証を完了してください。')
            ->html('<a href="' . $verifyUrl . '" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;" target="_self">認証する</a>', 'text/html')
            ->line('このリンクをクリックして認証を完了してください。');
    }

    protected function generateVerificationHash($notifiable)
    {
        return sha1($notifiable->getKey() . $notifiable->getEmailForVerification());
    }
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
