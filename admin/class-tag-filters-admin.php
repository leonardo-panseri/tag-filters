<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Tag_Filters
 * @subpackage Tag_Filters/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Tag_Filters
 * @subpackage Tag_Filters/admin
 */
class Tag_Filters_Admin
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
     * @param string $plugin_name The name of this plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct(string $plugin_name, string $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the TagFilters Page custom post type.
     *
     * @since    1.0.0
     */
    public function register_tagfilters_post_type() {
        register_post_type('tagfilters_page', array(
            'label' => 'TagFilters Pages',
            'description' => 'Pages where a post category can be filtered by tags',
            'public' => true,
            'hierarchical' => true,
            'show_in_rest' => true,
            'show_in_menu' => 'edit.php?post_type=page',
            'supports' => array('title', 'editor', 'page-attributes', 'thumbnail', 'custom-fields'),
            'rewrite' => array( 'slug' => 'tagfilters' )
        ));

        flush_rewrite_rules();
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Plugin_Name_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Plugin_Name_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/tag-filters-admin.css', array(), $this->version);

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts($hook)
    {
        if('settings_page_tagfilters' != $hook) {
            return;
        }
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/tag-filters-admin.js', array('jquery'), $this->version);
    }

    public function load_admin_partial() {
        include plugin_dir_path(__FILE__) . 'partials/tag-filters-admin-display.php';
    }

    public function register_admin_menu() {
        add_options_page(
            'TagFilters Options',
            'TagFilters Options',
            'manage_options',
            'tagfilters',
            array($this, 'load_admin_partial')
        );
    }

    /**
     * Load the partial for rendering of the custom meta box in TagFilters Page editor.
     *
     * @param WP_Post $post The post that is being edited
     * @since    1.0.0
     */
    public function load_meta_box_partial(WP_Post $post) {
        extract(array('post', $post), EXTR_PREFIX_ALL, 'tagfilters');
        include plugin_dir_path(__FILE__) . 'partials/tag-filters-metabox-display.php';
    }

    /**
     * Register the custom meta box for the TagFilters Page editor.
     *
     * @since    1.0.0
     */
    public function register_custom_meta_box() {
        add_meta_box(
            'tagfilters-page-meta-box',
            'TagFilters Settings',
            array($this, 'load_meta_box_partial'),
            'tagfilters_page',
            'normal'
        );
    }

    /**
     * Saves the custom meta box data to post meta when saving a TagFilters Page.
     *
     * @param int $post_id The ID of the post
     * @param WP_Post $post The object representing the post
     */
    public function save_custom_meta_box(int $post_id, WP_Post $post) {

    }

}
