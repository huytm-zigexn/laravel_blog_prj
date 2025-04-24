<?php
namespace App\Services\CrawlStrategies;

use Symfony\Component\DomCrawler\Crawler as DomCrawler;

class ThanhNienStrategy implements WebCrawlStrategy
{
    public function supports(string $domain): bool
    {
        return strpos($domain, 'thanhnien.vn') !== false;
    }

    public function extractContent(DomCrawler $dom): array
    {
        $content = null;
        $contentElement = $dom->filter('#content');
        if ($contentElement->count() > 0) {
            $mainFlexElement = $contentElement->filter('.detail__cmain-flex');
            if ($mainFlexElement->count() > 0) {
                $mainElement = $mainFlexElement->filter('.detail__cmain-main');
                if ($mainElement->count() > 0) {
                    $detailContent = $mainElement->filter('.detail-cmain');
                    if ($detailContent->count() > 0) {
                        $content = $detailContent->filter('.detail-content')->html();
                    }
                }
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