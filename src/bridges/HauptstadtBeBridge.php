<?php

class HauptstadtBeBridge extends BridgeAbstract
{
    const NAME        = 'Hauptstadt.be';
    const URI         = 'https://www.hauptstadt.be';
    const DESCRIPTION = 'No longer maintained: Hauptstadt.be now has its own RSS feed at https://www.hauptstadt.be/api/rss-feed';
    const MAINTAINER  = 'n/a';
    const CACHE_TIMEOUT = 0; // 10min

    public function collectData()
    {
        // Fake item
        $item = [];
        $item['uri'] = 'https://www.hauptstadt.be/api/rss-feed';
        $item['title'] = 'Hauptstadt.be hat jetzt einen eigenen RSS-Feed, Link updaten!';
        $item['timestamp'] = time();
        $item['author'] = 'Hauptstadt.be';
        $item['content'] = 'Hauptstadt.be hat jetzt einen eigenen RSS-Feed, Link updaten! <a href="https://www.hauptstadt.be/api/rss-feed">https://www.hauptstadt.be/api/rss-feed</a><p>Dieser Feed publiziert keine Artikel mehr.</p><p>Tschüss.</p>';
        $item['uid'] = 'hauptstadtbe-rss-feed';

        $this->items[] = $item;
    }

    public function getIcon()
    {
        return static::URI . '/favicon.png';
    }
}
