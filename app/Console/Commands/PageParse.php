<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;

class PageParse extends Command
{
    protected $signature = 'page:parse';
    protected $description = 'Parsing pages content';

    public function handle()
    {
        $pageContent = file_get_contents('https://www.livemint.com/opinion/columns/opinion-economic-geography-central-to-india-s-regional-inequality-woes-1556647599599.html');

        $content = [];
        
        preg_replace_callback('/<(?<tag>\w+)>(?<content>.*?)<\/\1>/i',
            function($matches) use (&$content)
            {
                $tag = $matches[1];
                $innerText = $matches[2];
                if($tag == 'title'):
                    $content['title'] = $innerText;
                elseif(!in_array($tag, ['script', 'style']) && preg_match('/[—a-z\s?.!,\d]{100,}/i', $innerText)):
                    $content['paragraphs'][] = $innerText;
                endif;
            }, $pageContent);

        Storage::disk('local')->put('page_content.json', json_encode($content));
        
        return $this->info('done');
    }
}
