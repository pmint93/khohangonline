<?php
/**
 * Created by PhpStorm.
 * User: Buminta
 * Date: 2/27/14
 * Time: 3:39 AM
 */
class RSS
{
    var $feed;

    function rss($feed)
    {
        $this->feed = $feed;
    }

    function parse()
    {
        $rss = @simplexml_load_file($this->feed);
        if(!$rss) return false;
        $rss_split = array();
        foreach ($rss->channel->item as $item) {
            $title = (string)$item->title; // Title
            $link = (string)$item->link; // Url Link
            $description = (string)$item->description; //Description
            $rss_split[] = '<div class="rss_box" title="'.$title.'">
                <a href="' . $link . '" target="_blank" title="'.$title.'" >
                    ' . $title . '
                </a>
            </div>
';
        }
        return $rss_split;
    }

    function display($numrows, $head)
    {
        $rss_split = $this->parse();
        if(!$rss_split) return "Nothing...";
        $i = 0;
        $rss_data = '<div class="vas">
           <div class="title-head">
         ' . $head . '
           </div>
         <div class="feeds-links">';
        while (($i < $numrows) && ($i < count($rss_split))) {
            $rss_data .= $rss_split[$i];
            $i++;
        }
        $trim = str_replace('', '', $this->feed);
        $user = str_replace('&lang=en-us&format=rss_200', '', $trim);
        $rss_data .= '</div></div>';
        return $rss_data;
    }
}