<?php

class MeteoSwissBlogBridge extends BridgeAbstract
{
    const NAME        = 'MeteoSwiss Blog';
    const URI         = 'https://www.meteoschweiz.admin.ch/home/aktuell/meteoschweiz-blog.html';
    const DESCRIPTION = 'Blog of the Federal Office of Meteorology and Climatology MeteoSwiss';
    const MAINTAINER  = 'cstuder';
    const CACHE_TIMEOUT = 3600; // 1h
    const FAVICON     = "https://www.meteoschweiz.admin.ch/etc.clientlibs/internet/clientlibs/base/resources/assets/images/favicon.ico";

    public function collectData()
    {
        // Determine language

        // TODO continue here

        // Read blog info

        // Determine missing article URLs

        // Generate feed
    }


    public function getIcon()
    {
        return static::FAVICON;
    }
}
