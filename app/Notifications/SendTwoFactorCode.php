<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendTwoFactorCode extends Notification
{
    use Queueable;

    
    public function __construct()
    {
        //
    }

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
    
     */
    public function toMail(User $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line("Your requested 2 factor authentication code is {$notifiable->two_factor_code}")
            ->action('Verify your login attempt here', route('verify.index'))
            ->line('The code will expire in a few minutes')
            ->line("If this is an unauthorized action please disregard the email. Thank you");
    }

        /**
         * @return array<string, mixed>
         */
        public function toArray(object $notifiable): array
        {
            return [
                
            ];
        }
    }