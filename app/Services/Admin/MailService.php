<?php
namespace App\Services\Admin;

use Mail;

class MailService
{
    public function send($viewName, $mailSettings, $data)
    {
        Mail::send($viewName, $data, function ($message) use ($mailSettings){
            $message->from($mailSettings->settings['address_from'], $mailSettings->settings['name_from']);
            $message->to($mailSettings->settings['address_from'], $mailSettings->settings['name_from']);
            $message->subject('Test');
        });
    }
}
