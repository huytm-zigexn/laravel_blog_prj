<?php
namespace App\Services;

use App\Http\Requests\CrawlPostValidate;
use App\Models\Post;
use App\Models\User;
use App\Services\CrawlStrategies\ThanhNienStrategy;
use App\Services\CrawlStrategies\VNExpressStrategy;
use App\Services\CrawlStrategies\Website1Strategy;
use App\Services\CrawlStrategies\Website2Strategy;
use Spatie\Crawler\CrawlObservers\CrawlObserver;
use Spatie\Crawler\Crawler;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Validator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class PostCrawlerService extends CrawlObserver
{
    private CrawlStrategyFactory $strategyFactory;
    public $postSlug = null;

    public function __construct()
    {
        $this->strategyFactory = new CrawlStrategyFactory();
        $this->strategyFactory->addStrategy(new ThanhNienStrategy);
        $this->strategyFactory->addStrategy(new VNExpressStrategy);
    }

    public function willCrawl(UriInterface $url, ?string $linkText): void
    {
        echo "Now crawling: " . (string) $url . PHP_EOL;
    }

    public function crawl(string $url): ?string
    {
        $outer = $this;

        Crawler::create()
            ->setCrawlObserver(new class($this->strategyFactory, $outer) extends CrawlObserver {
                private CrawlStrategyFactory $strategyFactory;
                private PostCrawlerService $outer;

                public function __construct(CrawlStrategyFactory $strategyFactory, PostCrawlerService $outer)
                {
                    $this->strategyFactory = $strategyFactory;
                    $this->outer = $outer;
                }

                public function crawled(
                    UriInterface $url,
                    ResponseInterface $response,
                    ?UriInterface $foundOnUrl = null,
                    ?string $linkText = null
                ): void {
                    set_time_limit(0);
                    $html = (string) $response->getBody();
                    $dom = new DomCrawler($html);
                    $domain = parse_url((string)$url, PHP_URL_HOST);
                    
                    // Lấy chiến lược phù hợp cho domain
                    $strategy = $this->strategyFactory->getStrategyForDomain($domain);
                    
                    if (!$strategy) {
                        logger()->error("No strategy found for domain: $domain");
                        return;
                    }
                    
                    // Trích xuất dữ liệu từ JSON-LD
                    $jsonData = $this->extractJsonLdData($dom);
                    
                    if (!$jsonData || !isset($jsonData['@type']) || !in_array($jsonData['@type'], ['NewsArticle', 'Article'])) {
                        logger()->info("Skipped non-article page: $url");
                        return;
                    }
                    
                    // Lấy nội dung từ DOM sử dụng chiến lược phù hợp
                    $extractedContent = $strategy->extractContent($dom);
                    
                    $validate_data = [
                        'title' => $jsonData['headline'] ?? 'No title',
                        'content' => $extractedContent['content'] ?? 'No content',
                        'thumbnail' => $jsonData['image']['url'] ?? null,
                        'is_crawled' => true,
                        'source_url' => (string)$url,
                        'source_name' => $domain,
                        'source_author' => is_array($jsonData['author'])
                                    ? implode(', ', array_column($jsonData['author'], 'name'))
                                    : $jsonData['author']['name'] ?? null,
                        'crawled_at' => now(),
                        'original_id' => $jsonData['mainEntityOfPage']['@id'] ?? (string)$url,
                        'user_id' => $this->getCrawlerUserId(),
                        'category_id' => null,
                        'status' => 'draft',
                    ];
                    
                    $validator = Validator::make($validate_data, (new CrawlPostValidate())->rules());

                    if(!$validator->fails()) {
                        $post = Post::create($validate_data);
                        $this->outer->postSlug = $post->slug;
                    } else {
                        logger()->error("Validation failed for data: " . json_encode($validator->errors()));
                        return;
                    }
                }
                
                private function extractJsonLdData(DomCrawler $dom): ?array
                {
                    $jsonLdNodes = $dom->filter('script[type="application/ld+json"]');
                    foreach ($jsonLdNodes as $node) {
                        $jsonContent = $node->textContent;
                    
                        // Parse JSON
                        $data = json_decode($jsonContent, true);
                        
                        if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
                            if (isset($data['author']['name'])) {
                                return $data;
                            }
                        }
                    }
                    
                    return null;
                }

                public function crawlFailed(UriInterface $url,
                    RequestException $requestException,
                    ?UriInterface $foundOnUrl = null, 
                    ?string $linkText = null
                ): void
                {
                    logger()->error("Failed to crawl {$url} with exception: " . $requestException->getMessage());
                }

                private function getCrawlerUserId(): int
                {
                    return User::where('email', 'crawler@example.com')->value('id');
                }
            })
            ->ignoreRobots()
            ->setMaximumDepth(0) // Chỉ lấy URL gốc, không đi vào các liên kết con
            ->startCrawling($url);
        return $this->postSlug;
    }
}