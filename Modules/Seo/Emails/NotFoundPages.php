<?php

namespace Modules\Seo\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotFoundPages extends Mailable
{
    use Queueable, SerializesModels;
    
    protected $count;
    protected $file;

    /**
     * Create a new message instance.
     *
     * @param $count
     * @param $file
     * @return void
     */
    public function __construct($count, $file)
    {
        $this->count = $count;
        $this->file = $file;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Страницы 404 | letsfly.ru')
            ->attach($this->file)
            ->markdown('emails.not_found_pages', ['count' => $this->count]);
    }
}
