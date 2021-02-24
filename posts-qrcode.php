<?php


/**
 * Plugin Name: Post qrcode
 * Plugin URI: http://google.com
 * Description: This is a demo plugin
 * Version: 1.0
 * Author: Arijit
 * Licence: GPLv2 or latest
 * Text Domain: post-qrcode
 * Domain Path: /Languages/
 */

function wordcount_load_textdomain(){
    load_plugin_textdomain('word-count', false, dirname(__FILE__).'/languages');
}

function pqrc_display_qr_code($content){
    $current_post_id = get_the_ID();
    $current_post_title = get_the_title($current_post_id);
    $current_post_url = urlencode(get_the_permalink($current_post_id));
    $current_post_type = get_post_type($current_post_id);

    /**
     * post type check
     */
    $excluded_post_type = apply_filters("pqrc_excluded_post_types", array());

    if(in_array($current_post_type, $excluded_post_type)){
        return $content;
    }

    /**
     * size hook
     */
    $dimention = apply_filters('pqrc_qucode_dimention', '185x185');

    /**
     * image attributes
     */
    $image_attributes = apply_filters('pqrc_image_attributes', null);

    $image_src = sprintf('https://api.qrserver.com/v1/create-qr-code/?data=%s&size=%s&margin=0', $current_post_url, $dimention);
    $content .= sprintf("<div class='qrcode'><img %s src='%s' alt='%s' /></div>", $image_attributes, $image_src, $current_post_title);
    return $content;
}


add_filter('the_content', 'pqrc_display_qr_code');
