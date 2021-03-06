<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BidFulfilled extends Notification
{
    use Queueable;

    private $order_id;
    private $requester_name;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order_id, $requester_name)
    {
        $this->order_id = $order_id;
        $this->requester_name = $requester_name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
            'order_id' => $this->order_id,
            'requester_name' => $this->requester_name,
            'type' => 'bid_fulfilled'
        ];
    }
}
