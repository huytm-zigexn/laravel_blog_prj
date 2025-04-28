<?php
namespace App\Services\CrawlStrategies;

use Symfony\Component\DomCrawler\Crawler as DomCrawler;

class VNExpressStrategy implements WebCrawlStrategy
{
    public function supports(string $domain): bool
    {
        return strpos($domain, 'vnexpress.net') !== false;
    }

    public function extractContent(DomCrawler $dom): array
    {
        // Cấu trúc DOM khác cho website 2
        $content = null;
        $contentElement = $dom->filter('.detail-photo');
        if ($contentElement->count() <= 0) {
            $contentElement = $dom->filter('.top-detail');
        }
        if ($contentElement->count() > 0) {
            $container = $contentElement->filter('.container');
            if ($container->count() > 0) {
                $mainElement = $container->filter('.sidebar-1');
                if ($mainElement->count() > 0) {
                    if ($mainElement->filter('.description')->count() > 0) {
                        $content = $mainElement->filter('.description')->html();
                    }
                    $content .= $mainElement->filter('.fck_detail')->html();
                }
                $content = $container->filter('.fck_detail')->html();
            }
        }

        $content = $this->processImages($content);
        
        return [
            'content' => $content,
        ];
    }

    private function processImages(string $html): string
    {
        $dom = new \DOMDocument();
        @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
        
        $images = $dom->getElementsByTagName('img');
        foreach ($images as $img) {
            if ($img->hasAttribute('data-src')) {
                $dataSrc = $img->getAttribute('data-src');
                $img->setAttribute('src', $dataSrc);
                // Tùy chọn: xóa thuộc tính không cần thiết
                $img->removeAttribute('data-src');
                $img->removeAttribute('class');
                $img->removeAttribute('loading');
            }

            if ($img->hasAttribute('style')) {
                $img->removeAttribute('style');
            }
        }

        $divs = $dom->getElementsByTagName('div');
        foreach ($divs as $div)
        {
            if ($div->hasAttribute('style')) {
                $div->removeAttribute('style');
            }
            if ($div->hasAttribute('width')) {
                $div->removeAttribute('width');
            }
            if ($div->hasAttribute('height')) {
                $div->removeAttribute('height');
            }
        }
        
        return $dom->saveHTML();
    }
}