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

    private function load_default_container_partial() : string {
        return include plugin_dir_path(__FILE__) . 'partials/tag-filters-default-container.php';
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
            'rewrite' => array( 'slug' => 'tagfilters' ),
            'template' => array(array('core/html'), array(
                'content'=> $this->load_default_container_partial()
            ))
        ));

        register_post_meta('tagfilters_page', '_tagfilters_categories', array(
            'type' => 'array',
            'single' => true,
            'show_in_rest' => array(
                'schema' => array(
                    'type'  => 'array',
                    'default' => array(),
                    'items' => array(
                        'type' => 'string',
                    ),
                ),
            ),
            'default' => array()
        ));
        register_post_meta('tagfilters_page', '_tagfilters_tags', array(
            'type' => 'array',
            'single' => true,
            'show_in_rest' => array(
                'schema' => array(
                    'type'  => 'array',
                    'default' => array(),
                    'items' => array(
                        'type' => 'string',
                    ),
                ),
            ),
            'default' => array()
        ));

        flush_rewrite_rules();
    }

    /**
     * Register the JavaScript and the CSS for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts($hook)
    {
        if('post.php' != $hook && 'post-new.php' != $hook) {
            return;
        }
        if('tagfilters_page' != get_post_type()) {
            return;
        }
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/tag-filters-admin.js', array('jquery'), $this->version);
        // wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/tag-filters-admin.css', array(), $this->version);
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
     * @since    1.0.0
     */
    public function load_meta_box_partial() {
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
    public function save_custom_meta_box(int $post_id, WP_Post $post): int
    {
        if(!current_user_can('edit_post', $post_id))
            return $post_id;

        if(!isset($_POST['_tagfilters_metabox_nonce'])
            || !wp_verify_nonce($_POST['_tagfilters_metabox_nonce'], 'tagfilters_metabox_page_save'))
            return $post_id;

        if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;

        if(!isset($_POST['tagfilters_categories'])
            || !isset($_POST['tagfilters_selected_tags']))
            return $post_id;

        $categories_ids = $_POST['tagfilters_categories'];
        $selected_tags_ids = $_POST['tagfilters_selected_tags'];

        if(!$this->validate_metabox_data($categories_ids, $selected_tags_ids))
            return $post_id;

        update_post_meta($post_id, '_tagfilters_categories', $categories_ids);
        update_post_meta($post_id, '_tagfilters_tags', $selected_tags_ids);
        return $post_id;
    }

    private function validate_metabox_data($categories_ids, $selected_tags_ids): bool
    {
        if(!is_array($categories_ids)) return false;
        foreach ($categories_ids as $category) {
            if(!is_numeric($category)) return false;
        }
        if(!is_array($selected_tags_ids)) return false;
        foreach ($selected_tags_ids as $tag) {
            if(!is_numeric($tag)) return false;
        }

        return true;
    }
}
