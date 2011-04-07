<?php
/*
Plugin Name: Tinyit.cc - Best and safe URL shortener and tracker
Plugin URI: http://tinyit.cc
Description: The wordpress plugin for the best and safe URL shortener - Tinyit.cc. Will automatically shorten the post's URL/Permalink and put the short link at the bottom of each post. Also supports posting your short link to Twitter. With Tinyit.cc, you convert long links to short tiny links, customize and share them instantly with your friends, get comprehensive click statistics for your short links and use free API in your applications. And the short URL's are safe. Each URL is checked before redirecting against Google safe browsing list of websites, phishtank phishing list, spamming list, SURBL list and Tinyit.cc blocked websites list. More information <a href="http://tinyit.cc/more.html" target="_blank">here</a>.<br>
Dont have an API key? Register and get it now at http://tinyit.cc/getapi.html
Version: 1.0.0. 
Author: Tinyit.cc
Author URI: http://www.tinyit.cc/
*/


define('DEFAULT_API_URL', 'http://tinyit.cc/api.php?user=USERNAME&api=APIKEY&url=%s');


class Tinyit_Short_URL
{
    function api_urls()
    {
        return array(
            array(
                'name' => 'tinyit.cc',
                'url'  => 'http://tinyit.cc/api.php?user=USERNAME&api=APIKEY&url=%s',
                ),
            );
    }
	


    /**
     * Create short URL based on post URL
     */
    function create($post_id)
    {	
	 
        if (!$apiURL = get_option('TinyitShortUrlApiUrl')) {
            $apiURL = DEFAULT_API_URL;
        }

        $post = get_post($post_id);
        $pos = strpos($post->post_name, 'autosave');
        if ($pos !== false) {
            return false;
        }
        $pos = strpos($post->post_name, 'revision');
        if ($pos !== false) {
            return false;
        }

		$permalink = str_replace(array('http://','https://'), '',get_permalink($post_id));
        $apiURL = str_replace('%s', urlencode($permalink), $apiURL);

        $result = false;

        if (ini_get('allow_url_fopen')) {
            if ($handle = @fopen($apiURL, 'r')) {
                $result = fread($handle, 4096);
                fclose($handle);
            }
        } elseif (function_exists('curl_init')) {
            $ch = curl_init($apiURL);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            $result = @curl_exec($ch);
            curl_close($ch);
        }

        if ($result !== false) {
            delete_post_meta($post_id, 'TinyitShortURL');
            $res = add_post_meta($post_id, 'TinyitShortURL', $result, true);
            return true;
        }
    }

    /**
     * Option list (default settings)
     */
    function options()
    {
        return array(
           'ApiUrl'         => DEFAULT_API_URL,
           'Display'        => 'Y',
           'TwitterLink'    => 'Y',
           );
    }

    /**
     * Plugin settings
     *
     */
    function settings()
    {
        $apiUrls = $this->api_urls();
        $options = $this->options();
        $opt = array();

        if (!empty($_POST)) {
            foreach ($options AS $key => $val)
            {
                if (!isset($_POST[$key])) {
                    continue;
                }
                update_option('TinyitShortUrl' . $key, $_POST[$key]);
            }
        }
        foreach ($options AS $key => $val)
        {
            $opt[$key] = get_option('TinyitShortUrl' . $key);
        }
        include '../wp-content/plugins/Tinyit-short-url/template/settings.tpl.php';
    }

    /**
     *
     */
    function admin_menu()
    {
        add_options_page('Tinyit Short URL', 'Tinyit Short URL', 10, 'Tinyit_shorturl-settings', array(&$this, 'settings'));
    }

    /**
     * Display the short URL
     */
    function display($content)
    {

        global $post;

        if ($post->ID <= 0) {
            return $content;
        }

        $options = $this->options();

        foreach ($options AS $key => $val)
        {
            $opt[$key] = get_option('TinyitShortUrl' . $key);
        }

        $shortUrl = get_post_meta($post->ID, 'TinyitShortURL', true);

        if (empty($shortUrl)) {
            return $content;
        }

        $shortUrlEncoded = urlencode($shortUrl);

        ob_start();
        include './wp-content/plugins/Tinyit-short-url/template/public.tpl.php';
        $content .= ob_get_contents();
        ob_end_clean();

        return $content;
    }
}

$tinyitobj = new Tinyit_Short_URL;

if (is_admin()) {
    add_action('publish_post', array(&$tinyitobj, 'create'));
    add_action('admin_menu', array(&$tinyitobj, 'admin_menu'));
} else {
    add_filter('the_content', array(&$tinyitobj, 'display'));
}