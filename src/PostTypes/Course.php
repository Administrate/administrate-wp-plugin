<?php
namespace ADM\WPPlugin\PostTypes;

use ADM\WPPlugin as ADMWPP;
use ADM\WPPlugin\Oauth2;
use ADM\WPPlugin\Settings;

use ADM\WPPlugin\Taxonomies;
use ADM\WPPlugin\Webhooks;

use Administrate\PhpSdk\Course as SDKCourse;
use Administrate\PhpSdk\LearningPath as SDKLearningPath;
use Administrate\PhpSdk\GraphQl\Client as SDKClient;

/**
 * Construct the "Course" post type
 * */
if (!class_exists('Course')) {

    /**
     * Custom Post Type class called Minions
     *
     * @package default
     *
     */
    class Course
    {
        protected static $instance;

        static $slug = 'course'; // WP post type key
        static $singular = 'Course';
        static $plural = 'Courses';
        static $has_archive = true;
        static $public = true;
        static $taxonomies = array();
        static $capabilityType = 'post';
        static $hierarchical = false;
        static $publiclyQueryable = true;
        static $supports = array(
            'title',
            'editor',
            'thumbnail',
            'excerpt',
        );

        static $metas = array(
            'admwpp_tms_type' => array(
                'type' => 'text',
                'label' => 'Type',
                'tmsKey' => '',
                'showOnFront' => false,
            ),
            'admwpp_tms_id' => array(
                'type' => 'text',
                'label' => 'ID',
                'tmsKey' => 'id',
                'showOnFront' => false,
            ),
            'admwpp_tms_legacy_id' => array(
                'type' => 'text',
                'label' => 'Legacy ID',
                'tmsKey' => 'legacyId',
                'showOnFront' => false,
            ),
            'admwpp_tms_code' => array(
                'type' => 'text',
                'label' => 'Code',
                'tmsKey' => 'code',
                'showOnFront' => true,
            ),
            'admwpp_tms_image_id' => array(
                'type' => 'text',
                'label' => 'Image ID',
                'tmsKey' => 'image',
                'showOnFront' => false,
            ),
            'admwpp_tms_gallery' => array(
                'type' => 'text',
                'label' => 'Image Gallery',
                'tmsKey' => 'imageGallery',
                'showOnFront' => true,
            ),
            'admwpp_tms_life_cycle_state' => array(
                'type' => 'text',
                'label' => 'Lifecycle State',
                'tmsKey' => 'lifecycleState',
                'showOnFront' => false,
            ),
            'admwpp_tms_learning_categories' => array(
                'type' => 'text',
                'label' => 'learning Categories IDs',
                'tmsKey' => 'learningCategories',
                'showOnFront' => false,
            ),
            'admwpp_tms_price' => array(
                'type' => 'text',
                'label' => 'Price',
                'tmsKey' => 'publicPrices',
                'showOnFront' => true,
            ),
            'admwpp_tms_currency' => array(
                'type' => 'text',
                'label' => 'Currency',
                'tmsKey' => 'financialUnit',
                'showOnFront' => false,
            ),
            'admwpp_tms_tax' => array(
                'type' => 'text',
                'label' => 'Tax',
                'tmsKey' => 'regionTax',
                'showOnFront' => false,
            ),
            'admwpp_tms_accounts_associations' => array(
                'type' => 'text',
                'label' => 'Account Associations',
                'tmsKey' => 'accountAssociations',
                'showOnFront' => false,
            ),
            'admwpp_tms_locations' => array(
                'type' => 'text',
                'label' => 'Locations IDs',
                'tmsKey' => 'locations',
                'showOnFront' => false,
            ),
            'admwpp_tms_events' => array(
                'type' => 'text',
                'label' => 'Event IDs',
                'tmsKey' => 'events',
                'showOnFront' => false,
            ),
            'admwpp_tms_is_bundle' => array(
                'type' => 'text',
                'label' => 'isBundle',
                'tmsKey' => 'isBundle',
                'showOnFront' => false,
            ),
        );

        static $inlineMetas = array();

        static $taxonomy = 'learning-category';

        static $courseFields = array(
            'id',
            'legacyId',
            'lifecycleState',
            'code',
            'title',
            'introduction',
            'image' => array(
                'id',
                'name',
                'latest' => array('revisionNumber')
            ),
            'imageGallery' => array(
                'type' => 'edges',
                'fields' => array(
                    'id',
                    'name',
                    'latest' => array('revisionNumber')
                )
            ),
            'learningCategories' => array(
                'type' => 'edges',
                'fields' => array(
                    'id',
                    'legacyId',
                    'name',
                    'description',
                    'parentCategory' => array(
                        'id',
                        'legacyId',
                        'name',
                        'description'
                    ),
                ),
            ),
            'publicPrices' => array(
                'type' => 'edges',
                'fields' => array(
                    'amount',
                    'priceLevel' => array(
                        'id',
                        'name'
                    ),
                    'financialUnit' => array(
                        'name',
                        '... on Currency' => array('symbol')
                    ),
                    'region' => array(
                        'code',
                        'defaultTax' => array('effectiveRate'),
                    ),
                ),
            ),
            'customFieldValues' => array(
                'definitionKey',
                'definitionLocator',
                'value'
            ),
            'accountAssociations' => array(
                'type' => 'edges',
                'fields' => array(
                    'account' => array('id', 'name'),
                    'associationType' => array('id', 'name'),
                )
            ),
            'events' => array(
                'type' => 'edges',
                'filtersType' => 'EventFieldGraphFilter',
                'filters' => array(
                    array(
                        'field' => 'status',
                        'operation' => 'eq',
                        'value' => 'Active'
                    ),
                ),
                'fields' => array(
                    'id',
                    'title',
                    'price',
                    'location' => array('id', 'name')
                )
            ),
        );

        static $learningPathFields = array(
            'id',
            'legacyId',
            'lifecycleState',
            'code',
            'name',
            'description',
            'isBundle',
            'image' => array(
                'id',
                'name',
                'latest' => array('revisionNumber')
            ),
            'imageGallery' => array(
                'type' => 'edges',
                'fields' => array(
                    'id',
                    'name',
                    'latest' => array('revisionNumber')
                )
            ),
            'learningCategories' => array(
                'type' => 'edges',
                'fields' => array(
                    'id',
                    'legacyId',
                    'name',
                    'description',
                    'parentCategory' => array(
                        'id',
                        'legacyId',
                        'name',
                        'description'
                    ),
                ),
            ),
            'prices' => array(
                'type' => 'edges',
                'fields' => array(
                    'amount',
                    'priceLevel' => array(
                        'id',
                        'name'
                    ),
                    'financialUnit' => array(
                        'name',
                        '... on Currency' => array('symbol')
                    ),
                    'region' => array(
                        'code',
                        'defaultTax' => array('effectiveRate'),
                    ),
                ),
            ),
            'customFieldValues' => array(
                'definitionKey',
                'definitionLocator',
                'value'
            ),
            'accountAssociations' => array(
                'type' => 'edges',
                'fields' => array(
                    'account' => array('id', 'name'),
                    'associationType' => array('id', 'name'),
                )
            ),
            'learningObjectives' => array(
                'type' => 'edges',
                'fields' => array(
                    'id',
                    '__typename',
                    '... on CourseObjective' => array(
                        'courseTemplate' => array(
                            'id',
                            'events' => array(
                                'type' => 'edges',
                                'filtersType' => 'EventFieldGraphFilter',
                                'filters' => array(
                                    array(
                                        'field' => 'status',
                                        'operation' => 'eq',
                                        'value' => 'Active'
                                    ),
                                ),
                                'fields' => array(
                                    'id',
                                    'title',
                                    'location' => array('id', 'name')
                                )
                            )
                        )
                    )
                )
            ),
        );

        function __construct()
        {
            if (file_exists(ABSPATH . 'wp-load.php')) {
                require_once(ABSPATH . 'wp-load.php');
            }

            // Add all actions and filters
            $this->addFilters();
            $this->addActions();
            $this->addShortcodes();
        }

        /**
         * Static Singleton Factory Method
         * Return an instance of the current class if it exists
         * Construct a new one otherwise
         *
         * @return Course object
         * */
        public static function instance()
        {
            if (!isset(self::$instance)) {
                $className = __CLASS__;
                self::$instance = new $className;
            }

            //ADD taxonomies
            Taxonomies\LearningCategory::instance();

            return self::$instance;
        }

        /**
         * Add Custom Post Type filters
         *
         * @return void
         *
         */
        protected function addFilters()
        {
            $learningCategory = Taxonomies\LearningCategory::$system_name;
            // Learning categories Filters
            add_filter(
                'manage_edit-' . $learningCategory . '_columns',
                array('ADM\WPPlugin\Taxonomies\LearningCategory', 'termMetasColumns'),
                10,
                1
            );
            add_filter(
                'manage_' . $learningCategory . '_custom_column',
                array('ADM\WPPlugin\Taxonomies\LearningCategory', 'termMetasCustomColumns'),
                10,
                3
            );

            // Admin Columns
            add_filter(
                'manage_posts_columns',
                array($this, 'adminColumnsHead'),
                10,
                1
            );

            // Admin Custom Filter query hook
            add_filter('parse_query', array($this, 'typeFilter'));

            $courseContentSettings = (int) Settings::instance()->getSettingsOption('general', 'course_content');
            if (!$courseContentSettings) {
                // Custom Content
                add_filter(
                    'the_content',
                    array($this, 'customContent'),
                    10,
                    1
                );
            }
        }

        public static function getSlug()
        {
            $class = get_called_class();
            return $class::$slug;
        }

        public static function getTitle($id)
        {
            return get_the_title($id);
        }

        public static function customContent($content)
        {
            global $post_type;
            if ($post_type !== self::getSlug() && !is_single()) :
                return $content;
            endif;

            ob_start();
            include(ADMWPP_TEMPLATES_DIR . 'course/categories.php');
            $content = ob_get_contents() . $content;
            ob_end_clean();

            ob_start();
            include(ADMWPP_TEMPLATES_DIR . 'course/information.php');
            $content .= ob_get_contents();
            ob_end_clean();

            return $content;
        }

        /**
         * Function to return the Design HTML template path.
         *
         * @params  $template, string, template name.
         *
         * @return string, template path.
         *
         */
        public static function getTemplatePath($template)
        {
            // Active theme template overide
            $themeTemplatePath = get_stylesheet_directory() . '/' . ADMWPP_PREFIX .'/' . self::getSlug() . '/';

            // Default Plugin Template
            $pluginTemplatePath = ADMWPP_TEMPLATES_DIR . self::getSlug() . '/';

            $template = $template . ".php";

            if (file_exists($themeTemplatePath . $template)) {
                return $themeTemplatePath . $template;
            }

            return $pluginTemplatePath . $template;
        }

        /**
         * Add Custom Post Type actions
         *
         * @return void
         *
         */
        protected function addActions()
        {
            add_action('init', array($this, 'Init'));
            add_action('admin_init', array($this, 'adminInit'));
            add_action('add_meta_boxes', array($this, 'addMetaBoxes'), 10, 2);

            // Save post hook
            add_action('save_post', array($this, 'savePost'), 10, 3);

            $learningCategory = Taxonomies\LearningCategory::$system_name;
            // Learning categories Actions
            add_action(
                $learningCategory . '_add_form_fields',
                array('ADM\WPPlugin\Taxonomies\LearningCategory', 'AddCustomMetasToForm'),
                10,
                2
            );
            add_action(
                $learningCategory . '_edit_form_fields',
                array('ADM\WPPlugin\Taxonomies\LearningCategory', 'EditCustomMetasToForm'),
                10,
                2
            );
            add_action(
                'edit_' . $learningCategory,
                array('ADM\WPPlugin\Taxonomies\LearningCategory','saveTermMetas'),
                10,
                1
            );
            add_action(
                'create_' . $learningCategory,
                array('ADM\WPPlugin\Taxonomies\LearningCategory', 'saveTermMetas'),
                10,
                1
            );

            // Admin Columns
            add_action(
                'manage_posts_custom_column',
                array($this, 'adminColumnsContent'),
                10,
                2
            );

            // Admin Custom Filter on Course Types
            add_action('restrict_manage_posts', array($this, 'typeDropdown'));
        }

        /**
         * [addShortcodes description]
         */
        protected function addShortcodes()
        {
        }

        public function Init()
        {
            $this->createPostType();

            Taxonomies\LearningCategory::registerTerms();
        }

        /**
         * Register the Custom Post Type
         *
         * @return void
         *
         */
        protected function createPostType()
        {
            $labels   = array(
                'name'               => self::$plural,
                'singular_name'      => self::$singular,
                'add_new'            => 'Add New',
                'add_new_item'       => 'Add New ' . self::$singular,
                'edit_item'          => 'Edit ' . self::$singular,
                'new_item'           => 'New ' . self::$singular,
                'all_items'          => 'All ' . self::$plural,
                'view_item'          => 'View ' . self::$singular,
                'search_items'       => 'Search ' . self::$plural,
                'not_found'          => 'No ' . self::$plural . ' found',
                'not_found_in_trash' => 'No ' . self::$plural . ' found in Trash',
                'parent_item_colon'  => '',
                'menu_name'          => self::$plural,
            );

            $args = array(
                 'labels'             => $labels,
                 'public'             => self::$public,
                 'publicly_queryable' => self::$publiclyQueryable,
                 'show_ui'            => true,
                 'show_in_menu'       => true,
                 'query_var'          => false,
                 'rewrite'            => array(
                     'slug'       => self::$slug,
                     'with_front' => true
                 ),
                 'capability_type'    => self::$capabilityType,
                 'has_archive'        => self::$has_archive,
                 'hierarchical'       => self::$hierarchical,
                 'menu_position'      => null,
                 'supports'           => self::$supports,
                 'taxonomies'         => self::$taxonomies,
                 'menu_icon'          => 'dashicons-shield-alt',
             );

            $args = apply_filters('admwpp_course_args', $args);
            
            register_post_type(self::$slug, $args);
        }

        /**
         * CALLBACK FUNCTION FOR:
         * add_action('admin_init', array($this, 'admin_init'));
         * Add all the admin interface related stuff for the Custom Post Type
         *
         * @return void
         *
         */
        public function adminInit()
        {
        }

        /**
         * CALLBACK FUNCTION FOR:
         * add_action('add_meta_boxes', 'add_meta_boxes');
         * Hooks the function to add meta boxes
         *
         * @return void
         *
         */
        public function addMetaBoxes($postType, $post)
        {
            if (self::getSlug() == $postType) {
                add_meta_box(
                    'admwpp-metas',
                    __('Course / Learning Path Metas', ADMWPP_TEXT_DOMAIN),
                    array($this, 'metasMetabox'),
                    $postType,
                    'normal',
                    'high',
                    array(
                      'info' => __('Meta Data Synched from TMS', ADMWPP_TEXT_DOMAIN),
                      'class' => get_called_class(),
                    )
                );
            }
        }

        /**
         * Render Meta Box content.
         *
         * @param WP_Post $post The post object.
         */
        public static function metasMetabox($post, $metabox)
        {
            $nonce = "admwpp-" . self::getSlug() . '-nonce';
            // Add an nonce field so we can check for it later.
            wp_nonce_field(ADMWPP_PLUGIN_NAME, $nonce);
            include(ADMWPP_ADMIN_TEMPLATES_DIR . self::getSlug() .'/metas-metabox.php');
        }

        /**
         * CALLBACK FUNCTION FOR:
         * add_action('save_post', array($this, 'save_post'));
         * Save the metaboxes for the Custom Post Type
         *
         * @return void
         * @author Jad khater
        **/
        public function savePost($post_id, $post, $update)
        {
            $post_type = self::getSlug();

            // pointless if $_POST is empty (this happens on bulk edit)
            if (empty($_POST)) {
                return;
            }

            // verify quick edit nonce
            if (isset($_POST[ '_inline_edit' ]) && ! wp_verify_nonce($_POST[ '_inline_edit' ], 'inlineeditnonce')) {
                return;
            }

            // verify if this is an auto save routine.
            // If it is our form has not been submitted, so we don't want to do anything
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }

            // don't save for revisions
            if (isset($post->post_type) && $post->post_type == 'revision') {
                return;
            }

            // Check that the user has permission to edit
            if (isset($_POST['post_type']) && $_POST['post_type'] == $post_type && current_user_can('edit_post', $post_id)) {
                switch ($_POST['action']) {
                    case 'inline-save':
                        self::saveInlineMetas($post_id);
                    default:
                        self::saveMetas($post_id, $post);
                        break;
                }
            } else {
                return;
            }
        }

        /**
         *
         * Save the custom post type inline meta
         *
         * @return void
         * @author Jad khater
         **/
        public function saveInlineMetas($postId)
        {
            foreach (self::$inlineMetas as $fieldName => $fieldType) {
                // Sanitize user input
                switch ($fieldType) {
                    case 'bool':
                        if (isset($_POST[$fieldName])) {
                            $value = $_POST[$fieldName];
                        } else {
                            $value = 0;
                        }
                        break;
                    default:
                        $value = sanitize_text_field($_POST[$fieldName]);
                        break;
                }
                // Update the post's meta field
                update_post_meta($postId, $fieldName, $value);
            }
        }

        /**
         *
         * Save the custom post type meta
         *
         * @return void
         * @author Jad khater
         **/
        public function saveMetas($postId, $post)
        {

            $postType = self::getSlug();

            $nonce = "admwpp-" . $postType . '-nonce';

            // Verify nonce to check if the user intended to change this value.
            if (!isset($_POST[$nonce]) ||
            !wp_verify_nonce($_POST[$nonce], ADMWPP_PLUGIN_NAME)) {
                return;
            }

            foreach (self::$metas as $fieldName => $field) {
                // Sanitize user input
                switch ($field['type']) {
                    case 'url':
                        $value = esc_url($_POST[$fieldName]);
                        break;
                    default:
                        $value = sanitize_text_field($_POST[$fieldName]);
                        break;
                }
                // Update the post's meta field
                update_post_meta($postId, $fieldName, $value);
            }
        }

        public static function adminColumnsHead($defaults)
        {
            global $post_type;
            if ($post_type !== self::getSlug()) :
                return $defaults;
            endif;

            $defaults['type'] = 'Type';
            $defaults['code'] = 'Code';
            $defaults['image'] = 'Image';
            $defaults['price'] = 'Price';
            return $defaults;
        }

        public static function adminColumnsContent($columnName, $postId)
        {
            if ($columnName === 'type') {
                echo get_post_meta($postId, 'admwpp_tms_type', true);
            }
            if ($columnName === 'image') {
                $postFeaturedImageUrl = get_the_post_thumbnail_url($postId, 'thumbnail');
                if ($postFeaturedImageUrl) {
                    echo '<img src="' . $postFeaturedImageUrl . '" />';
                }
            }
            if ($columnName === 'code') {
                echo get_post_meta($postId, 'admwpp_tms_code', true);
            }
            if ($columnName === 'price') {
                echo get_post_meta($postId, 'admwpp_tms_price', true);
            }
        }

        /**
         * Add a select dropdown filter with meta values.
         */
        public static function typeDropdown()
        {

            global $post_type;
            if ($post_type !== self::getSlug()) :
                return;
            endif;

            $selected = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING);

            $choices = [
                'COURSE' => 'Course ',
                'LP' => 'Learning Path',
            ];

            echo'<select name="type">';
                echo '<option value="all" '. (( $selected == 'all' ) ? 'selected="selected"' : "") . '>' . __('All Types', 'admwpp') . '</option>';
            foreach ($choices as $key => $value) {
                echo '<option value="' . $key . '" '. (( $selected == $key ) ? 'selected="selected"' : "") . '>' . $value . '</option>';
            }
            echo'</select>';
        }

        /**
         * Filter the results based on meta data.
         */
        public function typeFilter($query)
        {
            if (is_admin() && $query->is_main_query()) {
                global $post_type;
                if ($post_type !== self::getSlug()) :
                    return;
                endif;

                if (isset($_GET['type']) && $_GET['type'] != 'all') {
                    $query->query_vars['meta_key'] = 'admwpp_tms_type';
                    $query->query_vars['meta_value'] = sanitize_text_field($_GET['type']);
                }
            }
        }

        public static function checkifExists($tmsId)
        {
            global $wpdb;
            $postMetasTable = $wpdb->postmeta;
            $sql = "SELECT post_id FROM $postMetasTable WHERE meta_key = %s AND meta_value = %s";
            $sql = $wpdb->prepare($sql, 'admwpp_tms_id', $tmsId);
            $wpPost = $wpdb->get_results($sql);
            if (isset($wpPost[0])) {
                return (int) $wpPost[0]->post_id;
            }
            return 0;
        }

        public static function getPostIdsByEventId($tmsId)
        {
            global $wpdb;
            $wpPostsIds = array();
            $postMetasTable = $wpdb->postmeta;
            $sql = "SELECT post_id FROM $postMetasTable WHERE meta_key = %s AND meta_value LIKE '%s'";
            $sql = $wpdb->prepare($sql, 'admwpp_tms_events', '%' . $wpdb->esc_like($tmsId) . '%');
            $wpPosts = $wpdb->get_results($sql);
            foreach ($wpPosts as $wpPost) {
                $wpPostsIds[] = $wpPost->post_id;
            }
            return $wpPostsIds;
        }

        public static function setTerms($postId, $learningCategories)
        {
            global $wpdb;
            // Remove terms before adding new ones.
            wp_delete_object_term_relationships($postId, self::$taxonomy);
            $termIds = array();
            foreach ($learningCategories as $node) {
                $node = $node['node'];
                $tmsId = $node['id'];
                $termId = Taxonomies\LearningCategory::checkifExists($tmsId);
                if (!$termId) {
                    $results = Taxonomies\LearningCategory::nodeToTerm($node);
                    if (!empty($results['termId'])) {
                        $termId[] = $results['termId'];
                    }
                }
                if ($termId) {
                    $termIds[] = $termId;
                }
            }
            if ($termIds) {
                wp_set_post_terms($postId, $termIds, self::$taxonomy);
                return $termIds;
            }
            return array();
        }

        public static function setLang($postId, $lang)
        {
            global $sitepress;
            $contentType = "post_" . self::$slug;
            $transId = $sitepress->get_element_trid($postId, $contentType);
            if ($transId) {
                return (int) $sitepress->set_element_language_details(
                    $postId,
                    $contentType,
                    $transId,
                    strtolower($lang)
                );
            }
            return 0;
        }

        public static function setTermsLang($postId, $lang, $postTermIds)
        {
            $transIds = array();
            if ($postTermIds) {
                foreach ($postTermIds as $termid) {
                    global $sitepress;
                    $contentType = "tax_" . self::$taxonomy;
                    $transId = $sitepress->get_element_trid($termid, $contentType);
                    if ($transId) {
                        $transIds[] = (int) $sitepress->set_element_language_details(
                            $termid,
                            $contentType,
                            $transId,
                            strtolower($lang)
                        );
                    }
                }
            }
            return $transIds;
        }

        public static function getApiParams()
        {
            $activate = Oauth2\Activate::instance();
            $apiParams = $activate::$params;

            $accessToken = $activate->getAuthorizeToken()['token'];
            $appId = Settings::instance()->getSettingsOption('account', 'app_id');
            $instance = Settings::instance()->getSettingsOption('account', 'instance');

            $apiParams['accessToken'] = $accessToken;
            $apiParams['clientId'] = $appId;
            $apiParams['instance'] = $instance;
            return $apiParams;
        }

        public static function getDocumentById($imageTmsId)
        {
            // Get Image Url
            $gql = '
            query document {
                downloadDocument (documentId: "' . $imageTmsId . '") {
                    url
                    document {
                      id
                      name
                      description
                    }
                }
            }';

            $apiParams = self::getApiParams();
            $authorizationHeaders = SDKClient::setHeaders($apiParams);
            $client = new SDKClient($apiParams['apiUri'], $authorizationHeaders);
            $results = $client->runRawQuery($gql);
            $document = $results->getData();
            $documentData = array();
            if ($document) {
                $documentData = array(
                    'url' => $document->downloadDocument->url,
                    'name' => $document->downloadDocument->document->name,
                    'description' => $document->downloadDocument->document->description
                );
            }

            return $documentData;
        }

        public static function setImageGallery($postId, $imageGalleryTmsIds)
        {

            $imagePostIds = array();
            foreach ($imageGalleryTmsIds as $imageTmsId) {
                // Check if image already synced and use it before uploading another one
                $imagePostId = self::checkifExists($imageTmsId);
                if ($imagePostId) {
                    $imagePostIds[] = $imagePostId;
                    continue;
                }

                $imageTmsIdArray = explode("-", $imageTmsId);

                $document = self::getDocumentById($imageTmsIdArray[0]);
                $imageURL = "";
                $imageName = "";
                $imageDesc = "";
                if (!empty($document)) {
                    $imageURL  = $document['url'];
                    $imageName = $document['name'];
                    $imageDesc = $document['description'];
                }

                include_once(ABSPATH . 'wp-admin/includes/admin.php');

                if ($imageURL != "") {
                    $file = array();
                    $file['name'] = $imageName;
                    $file['caption'] = $imageDesc;
                    $file['tmp_name'] = download_url($imageURL);
                    if (is_wp_error($file['tmp_name'])) {
                        @unlink($file['tmp_name']);
                        return $file['tmp_name']->get_error_messages();
                    } else {
                        $imageArgs = array(
                            'post_title' => $imageName,
                            'post_name' => sanitize_title($imageName),
                            'post_content' => $imageDesc,
                            'meta_input' => array(
                                'admwpp_tms_id' => $imageTmsId
                            ),
                        );

                        $attachmentId = media_handle_sideload($file, 0, $imageName, $imageArgs);

                        if (is_wp_error($attachmentId)) {
                            @unlink($file['tmp_name']);
                            return $attachmentId->get_error_messages();
                        } else {
                            $imagePostIds[] = $attachmentId;
                        }
                    }
                }
            }
            update_post_meta($postId, 'admwpp_image_gallery', $imagePostIds);
            return $imagePostIds;
        }

        public static function setImage($postId, $imageTmsId)
        {

            // Check if image already synced and use it before uploading another one
            $imagePostId = self::checkifExists($imageTmsId);
            if ($imagePostId) {
                set_post_thumbnail($postId, $imagePostId);
                return wp_get_attachment_url($imagePostId);
            }

            $imageTmsIdArray = explode("-", $imageTmsId);

            $document = self::getDocumentById($imageTmsIdArray[0]);
            $imageURL = "";
            $imageName = "";
            $imageDesc = "";
            if (!empty($document)) {
                $imageURL  = $document['url'];
                $imageName = $document['name'];
                $imageDesc = $document['description'];
            }

            include_once(ABSPATH . 'wp-admin/includes/admin.php');

            if ($imageURL != "") {
                $file = array();
                $file['caption'] = $imageDesc;
                $file['name'] = $imageName;
                $file['tmp_name'] = download_url($imageURL);

                if (is_wp_error($file['tmp_name'])) {
                    @unlink($file['tmp_name']);
                    return $file['tmp_name']->get_error_messages();
                } else {
                    $imageArgs = array(
                        'post_title' => $imageName,
                        'post_name' => sanitize_title($imageName),
                        'post_content' => $imageDesc,
                        'meta_input' => array(
                            'admwpp_tms_id' => $imageTmsId
                        ),
                    );

                    $attachmentId = media_handle_sideload($file, $postId, $imageName, $imageArgs);

                    if (is_wp_error($attachmentId)) {
                        @unlink($file['tmp_name']);
                        return $attachmentId->get_error_messages();
                    } else {
                        set_post_thumbnail($postId, $attachmentId);
                        return wp_get_attachment_url($attachmentId);
                    }
                }
            }
        }

        /**
         * Exposes the capabilty to ovveride the selection of TMS custom fields
         * to map to the course post metas.
         * @param  string $type Course Type (COURSE or LP)
         * @return array
         *
         * Example override:
         * $TMS_CUSTOM_FILEDS = array(
         *    'admwpp_tms_language' => array(
         *         'type' => 'text',
         *         'label' => 'Language',
         *         'tmsKey' => 'Q3Vz...jEzMA==',
         *     ),
         *     'admwpp_tms_general_info' => array(
         *         'type' => 'textarea',
         *         'label' => 'General Info',
         *         'tmsKey' => 'Q3Vz...jEyMQ==',
         *     ),
         * );
         */
        public static function getTmsCustomFiledsMapping($type)
        {
            $tmsCustomFiledsMapping = array(); // TODO: populate this array from settings
            $tmsCustomFiledsMapping = apply_filters(
                'admwpp_tms_custom_fileds_maping',
                $tmsCustomFiledsMapping,
                $type
            );
            return $tmsCustomFiledsMapping;
        }

        public static function getNodeById($nodeId, $type)
        {
            if ('LP' === $type) {
                return self::getLearningPatheById($nodeId);
            }
            return self::getCourseById($nodeId);
        }

        public static function deleteCourseByNodeId($tmsId)
        {
            $postId = self::checkifExists($tmsId);
            if ($postId) {
                return wp_delete_post($postId, true);
            }
            return false;
        }

        public static function getCourseById($nodeId)
        {
            $SDKCourse = new SDKCourse(self::getApiParams());

            $args = array(
                'filters' => array(
                    array(
                        'field' => 'id',
                        'operation' => 'eq',
                        'value' => $nodeId,
                    )
                ),
                'fields' => self::$courseFields,
                'returnType' => 'array', //array, obj, json
                'coreApi' => true,
            );

            return $SDKCourse->load($args);
        }

        public static function getLearningPatheById($nodeId)
        {
            $SDKLearningPath = new SDKLearningPath(self::getApiParams());

            $args = array(
                'filters' => array(
                    array(
                        'field' => 'id',
                        'operation' => 'eq',
                        'value' => $nodeId,
                    )
                ),
                'fields' => self::$learningPathFields,
                'returnType' => 'array', //array, obj, json
                'coreApi' => true,
            );

            return $SDKLearningPath->load($args);
        }

        public static function getCourses($params)
        {
            $SDKCourse = new SDKCourse(self::getApiParams());

            $args = array(
                'filters' => array(
                    array(
                        'field' => 'lifecycleState',
                        'operation' => 'eq',
                        'value' => 'published',
                    ),
                    // array(
                    //     'field' => 'code',
                    //     'operation' => 'eq',
                    //     'value' => 'WS-0040-NL',
                    // )
                ),
                'fields' => self::$courseFields,
                'paging' => array(
                    'page' => (int) $params['page'],
                    'perPage' => (int) $params['per_page']
                ),
                'sorting' => array(
                    'field' => 'id',
                    'direction' => 'asc'
                ),
                'returnType' => 'array', //array, obj, json
                'coreApi' => true,
            );

            return $SDKCourse->loadAll($args);
        }

        public static function getLearningPathes($params)
        {
            $SDKLearningPath = new SDKLearningPath(self::getApiParams());

            $args = array(
                'filters' => array(
                    array(
                        'field' => 'lifecycleState',
                        'operation' => 'eq',
                        'value' => 'active',
                    ),
                    // array(
                    //     'field' => 'id',
                    //     'operation' => 'eq',
                    //     'value' => 'TGVhcm5pbmdQYXRoOjk=',
                    // )
                ),
                'fields' => self::$learningPathFields,
                'paging' => array(
                    'page' => (int) $params['page'],
                    'perPage' => (int) $params['per_page']
                ),
                'sorting' => array(
                    'field' => 'id',
                    'direction' => 'asc'
                ),
                'returnType' => 'array', //array, obj, json
                'coreApi' => true,
            );

            return $SDKLearningPath->loadAll($args);
        }

        public static function nodeToPost($node, $type)
        {
            $results = array(
                'imported' => 0,
                'exists' => 0
            );

            if (isset($node['title'])) {
                $title = $node['title'];
            }
            if (isset($node['name'])) {
                $title = $node['name'];
            }

            $postStatus = 'pending';
            $postArgs = array(
                'post_type' => self::$slug,
                'post_title' => $title,
                'post_name' => sanitize_title($title),
                'post_content' => '',
                'post_status' => $postStatus,
            );

            // "published" is used for Courses
            // "active" is used for LPs
            if ($node['lifecycleState'] === 'published' || $node['lifecycleState'] === 'active') {
                $postStatus = 'publish';
            }

            // Process Custom Fields
            $customFields = array();
            $customFieldValues = $node['customFieldValues'];
            foreach ($customFieldValues as $field) {
                $key = $field['definitionKey'];
                if ($field['definitionLocator']) {
                    $key = $field['definitionLocator'];
                }
                $customFields[$key] = $field['value'];
            }

            $priceLevelNames =  array('Normal'); // TODO: populate this array from settings
            // Use admwpp_course_price_level_names filter in active theme or plugins
            // to set the custom price levels to be synched
            $priceLevelNames = apply_filters('admwpp_course_price_level_names', $priceLevelNames, $type, $customFields);

            $postMetas = array();
            $metas = self::$metas;
            $learningCategories = array();
            $imageGallery = array();
            $imageGalleryTmsIds = array();
            $imageTmsId = '';
            foreach ($metas as $key => $value) {
                $tmsKey = $value['tmsKey'];

                $tmsValue = '';

                switch ($tmsKey) {
                    case 'image':
                        if (isset($node[$tmsKey])) {
                            $tmsValue = $node[$tmsKey]['id'];
                            $revisionNumber = (int) $node[$tmsKey]['latest']['revisionNumber'];
                            if ($revisionNumber > 0) {
                                $tmsValue .= "-REV" . $revisionNumber;
                            }
                            $imageTmsId = $tmsValue;
                        }
                        break;
                    case 'imageGallery':
                        if (isset($node[$tmsKey])) {
                            $imageGallery = $node[$tmsKey]['edges'];
                            $imageGalleryString = array();
                            foreach ($imageGallery as $image) {
                                if (isset($image['node']) && !empty($image['node'])) {
                                    $imageNode = $image['node'];
                                    $tmsValue = $imageNode['id'];
                                    $revisionNumber = (int) $imageNode['latest']['revisionNumber'];
                                    if ($revisionNumber > 0) {
                                        $tmsValue .= "-REV" . $revisionNumber;
                                    }
                                    $imageGalleryTmsIds[] = $tmsValue;
                                    $imageGalleryString[] = $tmsValue;
                                }
                            }
                            $tmsValue = implode('|', $imageGalleryString);
                        }
                        break;
                    case 'learningCategories':
                        if (isset($node[$tmsKey])) {
                            $learningCategories = $node[$tmsKey]['edges'];
                            $learningCategoriesIds = array();
                            foreach ($learningCategories as $category) {
                                $learningCategoriesIds[] = $category['node']['id'];
                            }
                            $tmsValue = implode('|', $learningCategoriesIds);
                        }
                        break;
                    case 'publicPrices':
                        if ('LP' === $type) {
                            $tmsKey = 'prices';
                        }

                        if (isset($node[$tmsKey])) {
                            $publicPrices = $node[$tmsKey]['edges'];
                            $pricesAmounts = array();
                            foreach ($publicPrices as $prices) {
                                if (isset($prices['node']['priceLevel'])) {
                                    if (in_array($prices['node']['priceLevel']['name'], $priceLevelNames)) {
                                        $currencySymbol = '';
                                        if (isset($prices['node']['financialUnit']) &&
                                            isset($prices['node']['financialUnit']['symbol'])) {
                                                $currencySymbol = $prices['node']['financialUnit']['symbol'] . " ";
                                        }
                                        $pricesAmounts[] = $currencySymbol . $prices['node']['amount'];
                                        break;
                                    }
                                }
                            }
                            $tmsValue = implode('|', $pricesAmounts);
                        }
                        break;
                    case 'financialUnit':
                        $tmsKey = 'publicPrices';
                        if ('LP' === $type) {
                            $tmsKey = 'prices';
                        }
                        if (isset($node[$tmsKey])) {
                            $publicPrices = $node[$tmsKey]['edges'];
                            $pricesCurencies = array();
                            foreach ($publicPrices as $prices) {
                                if (isset($prices['node']['priceLevel'])) {
                                    if (in_array($prices['node']['priceLevel']['name'], $priceLevelNames)) {
                                        if (isset($prices['node']['financialUnit']['name']) &&
                                            isset($prices['node']['financialUnit']['symbol'])) {
                                            $pricesCurencies[] = $prices['node']['financialUnit']['name'] .
                                            "|" . $prices['node']['financialUnit']['symbol'];
                                        }
                                        break;
                                    }
                                }
                            }
                            $tmsValue = implode('|', $pricesCurencies);
                        }
                        break;
                    case 'regionTax':
                        $tmsKey = 'publicPrices';
                        if ('LP' === $type) {
                            $tmsKey = 'prices';
                        }
                        if (isset($node[$tmsKey])) {
                            $publicPrices = $node[$tmsKey]['edges'];
                            $taxRates = array();
                            foreach ($publicPrices as $prices) {
                                if (isset($prices['node']['region'])) {
                                    if (in_array($prices['node']['priceLevel']['name'], $priceLevelNames)) {
                                        if (isset($prices['node']['region']['defaultTax'])) {
                                            $taxRates[] = $prices['node']['region']['defaultTax']['effectiveRate'];
                                        }
                                        break;
                                    }
                                }
                            }
                            $tmsValue = implode('|', $taxRates);
                        }
                        break;
                    case 'accountAssociations':
                        if (isset($node[$tmsKey])) {
                            $accountAssociations = $node[$tmsKey]['edges'];
                            $accountArray = array();
                            foreach ($accountAssociations as $accountAssociation) {
                                $account = $accountAssociation['node']['account'];
                                $associationType = $accountAssociation['node']['associationType'];
                                $accountArray[$account['id']]['name'] = $account['name'];
                                $accountArray[$account['id']]['type'] = $associationType['name'];
                            }
                            $tmsValue = json_encode($accountArray);
                        }
                        break;
                    case 'events':
                        $eventsIds = array();
                        if ('LP' === $type) {
                            $tmsKey = 'learningObjectives';
                            if (isset($node[$tmsKey])) {
                                if (isset($node[$tmsKey]['edges'])) {
                                    $learningObjectives = $node[$tmsKey]['edges'];
                                    foreach ($learningObjectives as $objective) {
                                        if (isset($objective['node']['courseTemplate'])) {
                                            $courseTemplate = $objective['node']['courseTemplate'];
                                            if (isset($courseTemplate['events'])) {
                                                $events = $courseTemplate['events']['edges'];
                                                foreach ($events as $event) {
                                                    $eventsIds[] = $event['node']['id'];
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        } else {
                            $tmsKey = 'events';
                            if (isset($node[$tmsKey])) {
                                $events = $node[$tmsKey]['edges'];
                                foreach ($events as $event) {
                                    $eventsIds[] = $event['node']['id'];
                                }
                            }
                        }
                        $tmsValue = implode('|', $eventsIds);
                        break;
                    case 'locations':
                        $locationIds = array();
                        if ('LP' === $type) {
                            $tmsKey = 'learningObjectives';
                            if (isset($node[$tmsKey])) {
                                if (isset($node[$tmsKey]['edges'])) {
                                    $learningObjectives = $node[$tmsKey]['edges'];
                                    foreach ($learningObjectives as $objective) {
                                        if (isset($objective['node']['courseTemplate'])) {
                                            $courseTemplate = $objective['node']['courseTemplate'];
                                            if (isset($courseTemplate['events'])) {
                                                $events = $courseTemplate['events']['edges'];
                                                foreach ($events as $event) {
                                                    if (isset($event['node']['location'])) {
                                                        $location = $event['node']['location'];
                                                        if (!in_array($location['id'], $locationIds)) {
                                                            $locationIds[] = $location['id'];
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        } else {
                            $tmsKey = 'events';
                            if (isset($node[$tmsKey])) {
                                $events = $node[$tmsKey]['edges'];
                                foreach ($events as $event) {
                                    if (isset($event['node']['location'])) {
                                        $location = $event['node']['location'];
                                        if (!in_array($location['id'], $locationIds)) {
                                            $locationIds[] = $location['id'];
                                        }
                                    }
                                }
                            }
                        }
                        $tmsValue = implode('|', $locationIds);
                        break;
                    case 'isBundle':
                        if ($node[$tmsKey]) {
                            $tmsValue = 'true';
                        } else {
                            $tmsValue = 'false';
                        }
                        break;
                    default:
                        if (isset($node[$tmsKey])) {
                            $tmsValue = $node[$tmsKey];
                        }
                        break;
                }
                $postMetas[$key] = $tmsValue;
            }

            // Set Course Type
            $postMetas['admwpp_tms_type'] = $type;
            $tmsCustomFiledsMapping = self::getTmsCustomFiledsMapping($type);

            if (!empty($tmsCustomFiledsMapping) && $customFieldValues) {
                foreach ($tmsCustomFiledsMapping as $key => $value) {
                    $tmsKey = $value['tmsKey'];
                    if ($value['definitionLocator']) {
                        $tmsKey = $value['definitionLocator'];
                    }
                    if (isset($customFields[$tmsKey])) {
                        $postMetas[$key] = $customFields[$tmsKey];
                    } else {
                        $postMetas[$key] = '';
                    }
                }
            }

            // Use admwpp_course_post_status to alter the post status based on synced post meta values
            // To be used to apply some custom handling on special meta values condition based on client integrations
            $postStatus = apply_filters('admwpp_course_post_status', $postStatus, $type, $postMetas, $node);
            $postArgs['post_status'] = $postStatus;

            $content = '';
            if ('LP' == $type) {
                $content = $node['description'];
            }
            $postArgs['post_content'] = $content;

            if ($postMetas) {
                $postArgs['meta_input'] = $postMetas;

                if (isset($postMetas[TMS_SHORT_DESCRIPTION_KEY])) {
                    $postArgs['post_excerpt'] = strip_tags($postMetas[TMS_SHORT_DESCRIPTION_KEY]);
                }

                // Post content is a contact of several custom fields from the TMS
                // Use admwpp_course_content_meta_keys filter in active theme or plugins
                // to set the course meta keys to be synched to the content
                $tmsCourseContentMetaKeys = array(); // TODO: populate this array from settings
                $tmsCourseContentMetaKeys = apply_filters('admwpp_course_content_meta_keys', $tmsCourseContentMetaKeys);

                if ($content && !empty($tmsCourseContentMetaKeys)) {
                    $content .= "<br/>";
                }
                foreach ($tmsCourseContentMetaKeys as $fieldKey) {
                    $content .= $postMetas[$fieldKey];
                    $content .= "<br/>";
                }
                $postArgs['post_content'] = $content;
            }

            // Check if course exists and set ID in postArgs
            $postId = self::checkifExists($node['id']);

            if ($postId) {
                $postArgs['ID'] = $postId;
                $updated = wp_insert_post($postArgs);
                if ($updated) {
                    $results['exists'] = 1;
                }
            } else {
                $postId = wp_insert_post($postArgs);
                if ($postId) {
                    $results['imported'] = 1;
                }
            }

            // Set post id in results
            $results['postId'] = $postId;

            // Update Post Terms
            $postTermIds = array();
            if ($postId && $learningCategories) {
                $postTermIds = self::setTerms($postId, $learningCategories);
                $results['terms'] = $postTermIds;
            }

            // Update Post Image
            if ($postId && $imageTmsId) {
                $results['image'] = self::setImage($postId, $imageTmsId);
            }

            // Update Post Image Gallery
            if ($postId && !empty($imageGalleryTmsIds)) {
                $results['imageGallery'] = self::setImageGallery($postId, $imageGalleryTmsIds);
            }

            if (isset($postArgs['meta_input'][TMS_STICKY_POST_KEY])) {
                if ($postArgs['meta_input'][TMS_STICKY_POST_KEY] === 'true') {
                    // Add post to sticky posts
                    stick_post($postId);
                } else {
                    // Remove from sticky posts
                    unstick_post($postId);
                }
            }

            // Set course language if WPML exists
            include_once(ABSPATH . 'wp-admin/includes/plugin.php');
            if (is_plugin_active(ADMWPP_WPML_PATH) && !empty($postArgs['meta_input'][TMS_LANGUAGE_KEY])) {
                $langCode = strtolower($postArgs['meta_input'][TMS_LANGUAGE_KEY]);
                if (in_array($langCode, array_keys(icl_get_languages()))) {
                    $results['transId'] = self::setLang($postId, $langCode);
                    // Check for settings Flag before translating Terms
                    $synchTermLang = (int) Settings::instance()->getSettingsOption('advanced', 'synch_term_lang');
                    if ($postId && $postTermIds && $synchTermLang) {
                        $results['termsTransId'] = self::setTermsLang($postId, $langCode, $postTermIds);
                    }
                }
            }

            return $results;
        }
    }

// END class Minions
}
