<?php

namespace BDS\Notifications\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\HtmlString;
use BDS\Models\User;

class RegisteredNotification extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param User $notifiable
     *
     * @return array<int, string>
     */
    public function via(User $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param User $notifiable
     *
     * @return MailMessage
     */
    public function toMail(User $notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage())
            ->greeting(new HtmlString('<strong>Bienvenue à la Coopérative Bourgogne du Sud, ' . $notifiable->full_name . ' !</strong>'))
            ->line(new HtmlString('Votre compte vient d\'être créé sur le site de la Coopérative Bourgogne du Sud.'))
            ->line(new HtmlString('Avant de pouvoir vous connecter sur le site, vous devez créer un mot de passe pour votre compte.'))
            ->action('Créer mon mot de passe', $verificationUrl)
            ->level('primary')
            ->line(new HtmlString('<strong>Note : Ne partagez jamais votre mot de passe avec qui que ce soit. L\'équipe informatique n\'a pas besoin de votre mot de passe pour intéragir avec votre compte si elle doit le faire.</strong>'))
            ->subject('Bienvenue à la Coopérative Bourgogne du Sud, ' . $notifiable->full_name . ' !');
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param User $notifiable
     *
     * @return string
     */
    protected function verificationUrl(User $notifiable): string
    {
        return URL::temporarySignedRoute(
            'auth.password.setup',
            Carbon::now()->addMinutes(Config::get('auth.password_setup.timeout', 1440)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForSetup()),
            ]
        );
    }
}
