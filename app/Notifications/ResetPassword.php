<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
{
    /**
     * Build the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {


        return (new MailMessage)
            ->subject('Восстановление пароля')
            ->line('Чтобы восстановить пароль к личному кабинету сайта ' . config('app.name') . ', перейдите по ссылке.')
            ->action('Восстановить пароль', url(config('app.url') . '/password/reset/' . $this->token) . '?email=' . urlencode($notifiable->email))
            ->line('Если вы не запрашивали восстановление, то просто удалите данное письмо.');

    }
}
