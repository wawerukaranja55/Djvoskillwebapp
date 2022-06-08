<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Approvedbookings extends Notification
{
    use Queueable;

    public $bookingstatus;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($bookingstatus)
    {
        $this->bookingstatus=$bookingstatus;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Hello there Accoutant')
                    ->subject('Kindly request cash from following client'.$this->bookingstatus->full_name)
                    ->action('Click this link to Request',url('admin/requestpayment/',$this->bookingstatus->id));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
