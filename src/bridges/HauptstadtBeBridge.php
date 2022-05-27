<?php

class HauptstadtBeBridge extends BridgeAbstract
{
    const NAME        = 'Hauptstadt.be';
    const URI         = 'https://www.hauptstadt.be';
    const DESCRIPTION = 'Articles from the Swiss news website Hauptstadt.be';
    const MAINTAINER  = 'cstuder';

    public function collectData()
    {
        // TODO implement this: Read JSON, loop, output items.
        $item = array(); // Create an empty item

        $item['title'] = 'Hello World!';

        $this->items[] = $item; // Add item to the list
    }
}
