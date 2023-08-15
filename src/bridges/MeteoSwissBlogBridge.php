<?php

class MeteoSwissBlogBridge extends BridgeAbstract
{
    const NAME        = 'MeteoSwiss Blog';
    const URI         = 'https://www.meteoschweiz.admin.ch/home/aktuell/meteoschweiz-blog.html';
    const DESCRIPTION = 'Blog of the Federal Office of Meteorology and Climatology MeteoSwiss';
    const MAINTAINER  = 'cstuder';
    const CACHE_TIMEOUT = 3600; // [1h]
    const PARAMETERS  = [
        'Blog' => [
            'lang' => [
                'name' => 'Language',
                'type' => 'list',
                'values' => [
                    'Deutsch' => 'de',
                    'Français' => 'fr',
                    'Italiano' => 'it',
                ],
                'required' => false,
                'default' => 'de',
            ]
        ]
    ];

    const BLOG_INFO_URL = 'https://s3-eu-central-1.amazonaws.com/app-prod-static-fra.meteoswiss-app.ch/v1/blog/blog_overview_{LANG}.json';
    const BLOG_ARTICLE_URL = 'https://s3-eu-central-1.amazonaws.com/app-prod-static-fra.meteoswiss-app.ch/v1/blog/{ARTICLEID}.html';
    const BLOG_IDS_CACHE_EXPIRATION = 30 * 24 * 3600; // [30d]
    const FAVICON     = 'https://www.meteoschweiz.admin.ch/static/favicons/favicon.ico';

    public function collectData()
    {
        // Determine language
        $lang = strtolower(substr($this->getInput('lang'), 0, 2));

        // Read blog info
        $this->readBloginfo($lang);

        // Determine missing article URLs
        $this->determineArticleUrls();

        // Generate feed done.
    }

    protected function readBloginfo($lang): void
    {
        $url = str_replace('{LANG}', $lang, static::BLOG_INFO_URL);
        $raw = getContents($url);
        $categoriesAndEntries = json_decode($raw, true);

        foreach ($categoriesAndEntries as $entries) {
            if (!is_array($entries)) {
                continue;
            }

            foreach ($entries as $entry) {
                $item = [];
                $item['uri'] = '';
                $item['title'] = $entry['title'] ?? '';
                $item['timestamp'] = round(($entry['published'] ?? 0) / 1000);
                $item['author'] = 'MeteoSwiss';
                $item['content'] = $entry['lead'] ?? '';
                $item['enclosures'] = [$entry['thumbnailUrl'] ?? ''];
                $item['categories'] = [$entry['category'] ?? ''];
                $item['uid'] = $entry['blogPostId'] ?? '';

                $this->items[] = $item;
            }
        }
    }

    private function determineArticleUrls(): void
    {
        foreach ($this->items as &$item) {
            $id = $item['uid'];

            $url = $this->loadCacheValue($id, static::BLOG_IDS_CACHE_EXPIRATION);

            if (empty($url)) {
                $url = $this->fetchArticleUrl($id);

                $this->saveCacheValue($id, $url);
            }

            $item['uri'] = $url;
        }
    }

    /**
     * Fetches the mobile article and looks for the sharing link
     * 
     * Returns the sharing link
     * 
     * @param String $id
     * @return String
     */
    protected function fetchArticleUrl(String $id): String
    {
        $articleUrl = str_replace('{ARTICLEID}', $id, self::BLOG_ARTICLE_URL);
        $article = getSimpleHTMLDOMCached($articleUrl);

        $shareUrl = $article->find('a.meteoblog__share_ios', 0)->href;

        return str_replace('shareios://', '', $shareUrl);
    }

    public function getIcon()
    {
        return static::FAVICON;
    }
}
