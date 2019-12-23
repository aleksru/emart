<?php

namespace Modules\Seo\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Modules\Seo\Emails\NotFoundPages;
use Modules\Seo\Models\NotFoundPage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SeoNotify404 extends Command
{
    const CACHE_KEY = 'seo.404.last';
    
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'seo:notify-404';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify 404 errors';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param Spreadsheet $spreadsheet
     * @return mixed
     * @throws \Exception
     */
    public function handle(Spreadsheet $spreadsheet)
    {
        $urls = $this->getURLs();
        if ($urls->count() === 0)
            return;
        
        $filePath = storage_path(sprintf("app/not_found_links__%s.xlsx", now()->format('Y-m-d--H-i-s')));
        
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ID')
            ->setCellValue('B1', 'URL')
            ->setCellValue('C1', 'REFERER')
            ->setCellValue('D1', 'User Agent')
            ->setCellValue('E1', 'Дата и время');
        
        foreach ($urls as $i => $url) {
            $row = $i+2;
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue("A{$row}", $url->id)
                ->setCellValue("B{$row}", $url->url)
                ->setCellValue("C{$row}", $url->referer)
                ->setCellValue("D{$row}", $url->user_agent)
                ->setCellValue("E{$row}", $url->date);
        }
        
        (new Xlsx($spreadsheet))->save($filePath);
        
        try {
            Mail::to(config('mail.send_404'))->send(new NotFoundPages($urls->count(), $filePath));
        } finally {
            @unlink($filePath);
        }
        
        $this->info(sprintf('sending %s links', $urls->count()));
    }

    /**
     * Get ErrorURLs for last hour.
     * 
     * @return mixed
     */
    protected function getURLs() 
    {
        $lastTime = Cache::get(static::CACHE_KEY, now()->addHour(-1));
        Cache::forever(static::CACHE_KEY, now());
        
        return NotFoundPage::where('created_at', '>', $lastTime)->get();
    }
}
