<?php

namespace App\Services;

use App\Services\CrawlStrategies\WebCrawlStrategy;

class CrawlStrategyFactory
{
    /**
     * @var WebCrawlStrategy[]
     */
    private array $strategies = [];

    public function addStrategy(WebCrawlStrategy $strategy): void
    {
        $this->strategies[] = $strategy;
    }

    public function getStrategyForDomain(string $domain): ?WebCrawlStrategy
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->supports($domain)) {
                return $strategy;
            }
        }
        
        return null;
    }
}