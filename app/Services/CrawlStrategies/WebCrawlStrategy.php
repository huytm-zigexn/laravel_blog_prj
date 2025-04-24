<?php

namespace App\Services\CrawlStrategies;

use Symfony\Component\DomCrawler\Crawler as DomCrawler;

interface WebCrawlStrategy
{
    public function extractContent(DomCrawler $dom): array;
    public function supports(string $domain): bool;
}