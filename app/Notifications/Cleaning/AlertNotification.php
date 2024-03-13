<?php

namespace BDS\Notifications\Cleaning;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;
use BDS\Models\Material;

class AlertNotification extends Notification
{
    use Queueable;

    /**
     * The last cleaning date or null if no date.
     *
     * @var string|null
     */
    private ?string $lastCleaning;

    /**
     * The next cleaning date for the material.
     *
     * @var string
     */
    private string $nextCleaning;

    /**
     * Create a new notification instance.
     */
    public function __construct(private Material $material)
    {
        $days = config('bds.cleaning.multipliers.' . $this->material->cleaning_alert_frequency_type) * $this->material->cleaning_alert_frequency_repeatedly;

        // Get le next cleaning date or use the creat_at field if there's no last cleaning date.
        $this->nextCleaning = $this->material->last_cleaning_at === null ?
            $this->material->created_at->addDays($days)->format('d-m-Y à H:i') :
            $this->material->last_cleaning_at->addDays($days)->format('d-m-Y à H:i');

        // Get the last cleaning date formatted or null is no cleaning date.
        $this->lastCleaning = $this->material->last_cleaning_at === null ?
            null :
            $this->material->last_cleaning_at->format('d-m-Y à H:i');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // Check if the Email Alert is enabled.
        if ($this->material->cleaning_alert_email) {
            return [
                'database',
                'mail'
            ];
        }

        return ['database'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        $message = $this->lastCleaning === null ? '.' : " or le dernier nettoyage a été fait le <strong>$this->lastCleaning</strong>.";

        return (new MailMessage())
            ->line(new HtmlString('Vous recevez cet email à la suite d\'une <strong>alerte de nettoyage</strong> sur le matériel suivant :'))
            ->line(new HtmlString('<p class="light-layer">' . $this->material->name . '</p>'))
            ->line(new HtmlString('Le prochain nettoyage devait être fait avant le <strong>' . $this->nextCleaning . '</strong>' . $message))
            ->action('Voir le matériel', $this->material->show_url)
            ->level('primary')
            ->subject('Alert de Nettoyage - ' . config('app.name'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param object $notifiable
     *
     * @return array
     */
    public function toDatabase(object $notifiable): array
    {
        $message = $this->material->last_cleaning_at === null ? '.' : ' or le dernier nettoyage a été fait le <strong>%s</strong>.';

        return [
            'message' => 'Alerte de nettoyage sur le matériel <strong>%s</strong> ! Le prochain nettoyage devait être fait avant le <strong>%s</strong>' . $message,
            'message_key' => [$this->material->name, $this->nextCleaning, $this->lastCleaning],
            'url' => $this->material->show_url,
            'type' => 'alert'
        ];
    }
}
