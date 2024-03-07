<?php
require 'mail.php';
class SendEmailJob
{
    public function perform(): void
    {
        $mailer = new Mail();
        $contents = [
            'name' =>$this->args['customer']['name'],
            'email' => $this->args['customer']['email'],
            'subject' => 'Your order has been placed',
            'body' => 'Your order has been placed. Your total is ' . $this->args['total']
        ];
        $mailer->send($contents);
    }
}