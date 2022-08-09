<?php

class HauptstadtBeBridge extends BridgeAbstract
{
    const NAME        = 'Hauptstadt.be';
    const URI         = 'https://www.hauptstadt.be';
    const DESCRIPTION = 'Articles from the Swiss capital news website Hauptstadt.be';
    const MAINTAINER  = 'cstuder';
    const CACHE_TIMEOUT = 600; // 10min

    public function collectData()
    {
        // Fetch index page
        $indexPage = $this->readIndexPage();

        // Extract data
        if (isset($indexPage['data']['page']['blocks']) && is_array($indexPage['data']['page']['blocks'])) {
            $blocks = $indexPage['data']['page']['blocks'];

            foreach ($blocks as $block) {
                if (!isset($block['teasers'][0]['article']) || !is_array($block['teasers'][0]['article'])) {
                    continue;
                }

                $article = $block['teasers'][0]['article'];

                $item = [];
                $item['uri'] = $article['url'];
                $item['title'] = $article['title'];
                $item['timestamp'] = $article['publishedAt'];
                $item['author'] = implode(', ', array_column($article['authors'], 'name'));
                $item['content'] = $article['lead'];
                $item['uid'] = $article['id'];

                if (isset($article['image']['url'])) {
                    $item['enclosures'] = [$article['image']['url']];
                }

                $this->items[] = $item;
            }
        }
    }

    /**
     * Index-Seite lesen
     * 
     * Um die Query bei Änderungen vom Hauptstadt-CMS her zu aktualisieren, folgendermassen vorgehen:
     * 
     * 1. https://www.hauptstadt.be öffnen (Firefox)
     * 2. In der Netzwerkkonsole den POST-Request auf api.hauptstadt.be mit der grössten Antwort suchen.
     * 3. Rechtsklick -> Copy -> Copy POST data
     * 4. JSON in single quotes unten als CURLOPT_POSTFIELDS eintragen.
     */
    protected function readIndexPage()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.hauptstadt.be/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => '{"operationName":"getPage","variables":{"slug":"front"},"query":"query getPage($slug: Slug, $pageId: ID, $token: String) {\n  page(slug: $slug, id: $pageId, token: $token) {\n    ...page\n    __typename\n  }\n}\n\nfragment page on Page {\n  id\n  updatedAt\n  publishedAt\n  slug\n  url\n  title\n  tags\n  properties {\n    ...property\n    __typename\n  }\n  image {\n    ...image\n    __typename\n  }\n  socialMediaTitle\n  socialMediaDescription\n  socialMediaImage {\n    ...image\n    __typename\n  }\n  description\n  blocks {\n    ... on TeaserGridBlock {\n      ...teaserGridBlock\n      __typename\n    }\n    ... on RichTextBlock {\n      ...richTextBlock\n      __typename\n    }\n    ... on ImageBlock {\n      ...imageBlock\n      __typename\n    }\n    ... on TitleBlock {\n      ...titleBlock\n      __typename\n    }\n    ... on ImageGalleryBlock {\n      ...imageGalleryBlock\n      __typename\n    }\n    ... on ListicleBlock {\n      ...listicleBlock\n      __typename\n    }\n    ... on QuoteBlock {\n      ...quoteBlock\n      __typename\n    }\n    ... on EmbedBlock {\n      ...embedBlock\n      __typename\n    }\n    ... on TwitterTweetBlock {\n      ...twitterTweetBlock\n      __typename\n    }\n    ... on InstagramPostBlock {\n      ...instagramPostBlock\n      __typename\n    }\n    ... on LinkPageBreakBlock {\n      ...linkPageBreakBlock\n      __typename\n    }\n    __typename\n  }\n  __typename\n}\n\nfragment property on PublicProperties {\n  key\n  value\n  __typename\n}\n\nfragment image on Image {\n  id\n  title\n  description\n  tags\n  source\n  license\n  fileSize\n  extension\n  mimeType\n  format\n  width\n  height\n  focalPoint {\n    ...focalPoint\n    __typename\n  }\n  url\n  xsUrl: transformURL(input: {width: 1500})\n  smUrl: transformURL(input: {width: 2000})\n  mdAndUpUrl: transformURL(input: {width: 2500})\n  __typename\n}\n\nfragment focalPoint on Point {\n  x\n  y\n  __typename\n}\n\nfragment teaserGridBlock on TeaserGridBlock {\n  numColumns\n  teasers {\n    ... on ArticleTeaser {\n      ...articleTeaser\n      __typename\n    }\n    ... on PageTeaser {\n      ...pageTeaser\n      __typename\n    }\n    ... on PeerArticleTeaser {\n      ...peerArticleTeaser\n      __typename\n    }\n    __typename\n  }\n  __typename\n}\n\nfragment articleTeaser on ArticleTeaser {\n  style\n  image {\n    ...image\n    __typename\n  }\n  preTitle\n  title\n  lead\n  article {\n    ...reducedArticle\n    __typename\n  }\n  __typename\n}\n\nfragment reducedArticle on Article {\n  id\n  publishedAt\n  slug\n  url\n  title\n  preTitle\n  lead\n  authors {\n    ...reducedAuthors\n    __typename\n  }\n  image {\n    ...image\n    __typename\n  }\n  socialMediaTitle\n  socialMediaDescription\n  socialMediaImage {\n    ...image\n    __typename\n  }\n  properties {\n    ...property\n    __typename\n  }\n  __typename\n}\n\nfragment reducedAuthors on Author {\n  name\n  __typename\n}\n\nfragment pageTeaser on PageTeaser {\n  style\n  image {\n    ...image\n    __typename\n  }\n  preTitle\n  title\n  lead\n  page {\n    ...reducedPage\n    __typename\n  }\n  __typename\n}\n\nfragment reducedPage on Page {\n  id\n  publishedAt\n  slug\n  url\n  title\n  image {\n    ...image\n    __typename\n  }\n  socialMediaTitle\n  socialMediaDescription\n  socialMediaImage {\n    ...image\n    __typename\n  }\n  properties {\n    ...property\n    __typename\n  }\n  __typename\n}\n\nfragment peerArticleTeaser on PeerArticleTeaser {\n  style\n  image {\n    ...image\n    __typename\n  }\n  preTitle\n  title\n  lead\n  peer {\n    ...reducedPeer\n    __typename\n  }\n  article {\n    ...reducedArticle\n    __typename\n  }\n  __typename\n}\n\nfragment reducedPeer on Peer {\n  id\n  name\n  slug\n  hostURL\n  profile {\n    ...reducedPeerProfile\n    __typename\n  }\n  __typename\n}\n\nfragment reducedPeerProfile on PeerProfile {\n  websiteURL\n  logo {\n    ...image\n    __typename\n  }\n  __typename\n}\n\nfragment richTextBlock on RichTextBlock {\n  richText\n  __typename\n}\n\nfragment imageBlock on ImageBlock {\n  caption\n  image {\n    ...image\n    __typename\n  }\n  __typename\n}\n\nfragment titleBlock on TitleBlock {\n  title\n  lead\n  __typename\n}\n\nfragment imageGalleryBlock on ImageGalleryBlock {\n  images {\n    caption\n    image {\n      ...image\n      __typename\n    }\n    __typename\n  }\n  __typename\n}\n\nfragment listicleBlock on ListicleBlock {\n  items {\n    title\n    image {\n      ...image\n      __typename\n    }\n    richText\n    __typename\n  }\n  __typename\n}\n\nfragment quoteBlock on QuoteBlock {\n  quote\n  author\n  __typename\n}\n\nfragment embedBlock on EmbedBlock {\n  url\n  title\n  width\n  height\n  styleCustom\n  __typename\n}\n\nfragment twitterTweetBlock on TwitterTweetBlock {\n  userID\n  tweetID\n  __typename\n}\n\nfragment instagramPostBlock on InstagramPostBlock {\n  postID\n  __typename\n}\n\nfragment linkPageBreakBlock on LinkPageBreakBlock {\n  text\n  richText\n  linkURL\n  linkText\n  linkTarget\n  hideButton\n  styleOption\n  layoutOption\n  templateOption\n  image {\n    ...image\n    __typename\n  }\n  __typename\n}\n"}',
            CURLOPT_HTTPHEADER => [
                "accept: */*",
                "accept-encoding: gzip, deflate, br",
                "accept-language: de-CH,de;q=0.8,en-US;q=0.5,en;q=0.3",
                "content-type: application/json",
                "origin: https://rss.existenz.ch",
                "referer: https://rss.existenz.ch/",
                "user-agent: php-curl"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            returnServerError($err);
        }

        return json_decode($response, true);
    }

    public function getIcon()
    {
        return static::URI . '/favicon.png';
    }
}
