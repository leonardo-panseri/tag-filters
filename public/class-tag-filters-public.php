<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Tag_Filters
 * @subpackage Tag_Filters/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Tag_Filters
 * @subpackage Tag_Filters/public
 */
class Tag_Filters_Public
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private string $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private string $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of the plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct(string $plugin_name, string $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    public function include_template_file($template) {
        if(get_post_type() != 'tagfilters_page')
            return $template;

        return plugin_dir_path(__FILE__) . 'partials/tag-filters-page-single.php';
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        if ($this->is_tagfilters_page()) {
            wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/tag-filters-public.js', array('jquery'), $this->version);
            wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/tag-filters-public.css', array(), $this->version);
        }

    }

    public function is_tagfilters_page(): bool
    {
        return is_page(get_option('tagfilters_page_ids', array()));
    }

}
