<?php
/**
 * BREAKER DIGITAL functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package BREAKER_DIGITAL
 */

if (!function_exists('breaker_digital_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function breaker_digital_setup()
    {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on BREAKER DIGITAL, use a find and replace
         * to change 'breaker-digital' to the name of your theme in all the template files.
         */
        load_theme_textdomain('breaker-digital', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        //Add thumbnail size for carousel slides
        add_image_size('media-thumbnail', 414, 256, true);

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'menu-1' => esc_html__('Primary', 'breaker-digital'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('breaker_digital_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        // Add theme support for video post-formats.
        add_theme_support( 'post-formats', array( 'video') );
    }
endif;
add_action('after_setup_theme', 'breaker_digital_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function breaker_digital_content_width()
{
    $GLOBALS['content_width'] = apply_filters('breaker_digital_content_width', 640);
}

add_action('after_setup_theme', 'breaker_digital_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function breaker_digital_widgets_init()
{
    register_sidebar(array(
        'name' => esc_html__('Sidebar', 'breaker-digital'),
        'id' => 'sidebar-1',
        'description' => esc_html__('Add widgets here.', 'breaker-digital'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}

add_action('widgets_init', 'breaker_digital_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function breaker_digital_scripts()
{
    wp_enqueue_style('breaker-digital-style', get_stylesheet_uri());

    wp_enqueue_script('breaker-digital-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true);

    wp_enqueue_script('breaker-digital-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true);

    //Register jQuery
    wp_enqueue_script('jquery');

    //Register jquery.magnific-popup.js
    wp_enqueue_script('jquery.magnific-popup.js-file', get_template_directory_uri() . '/libs/magnific/jquery.magnific-popup.js');

    //Rgister magnific-popup.css
    wp_register_style('magnific-styles', get_template_directory_uri() . '/libs/magnific/magnific-popup.css', false, '0.1');
    wp_enqueue_style('magnific-styles');

    //Register main.js file
    wp_enqueue_script('main-js-file', get_template_directory_uri() . '/js/main.js');

    //Register main.css file
    $theme_uri = get_template_directory_uri();
    wp_register_style('theme-style', $theme_uri . '/css/main.css', false, '0.1');
    wp_enqueue_style('theme-style');


    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'breaker_digital_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


function add_metabox()
{
    //Add metabox to front page
    global $post;
    if ($post->ID == 7) :
        add_meta_box(
            'section_1', // Идентификатор(id)
            'Редактирование контента страницы', // Заголовок области с мета-полями(title)
            'show_my_metabox', // Вызов(callback)
            'page', // Где будет отображаться наше поле
            'normal',
            'high');
    endif;
}

add_action('add_meta_boxes', 'add_metabox'); // Запускаем функцию

$meta_fields = array(
    array(
        'label' => 'Текст для страницы',
        'desc' => 'Контент',
        'id' => 'textarea_homepage',  // даем идентификатор.
        'type' => 'textarea'  // Указываем тип поля.
    ),
    array(
        'label' => 'Заголовок для секции Медиа',
        'desc' => 'Контент',
        'id' => 'mediatitle_homepage',  // даем идентификатор.
        'type' => 'text'  // Указываем тип поля.
    )
);

// Вызов метаполей
function show_my_metabox()
{
    global $meta_fields; // Обозначим наш массив с полями глобальным
    global $post;  // Глобальный $post для получения id создаваемого/редактируемого поста
// Выводим скрытый input, для верификации. Безопасность прежде всего!
    echo '<input type="hidden" name="custom_meta_box_nonce" value="' . wp_create_nonce(basename(__FILE__)) . '" />';

    // Начинаем выводить таблицу с полями через цикл
    echo '<table class="form-table">';
    foreach ($meta_fields as $field) {
        // Получаем значение если оно есть для этого поля
        $meta = get_post_meta($post->ID, $field['id'], true);
        // Начинаем выводить таблицу
        echo '<tr> 
                <th><label for="' . $field['id'] . '">' . $field['label'] . '</label></th> 
                <td>';
        switch ($field['type']) {
            case 'text':
                echo '<input type="text" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . $meta . '" size="30" />
        <br /><span class="description">' . $field['desc'] . '</span>';
                break;
            case 'textarea':
                echo '<textarea name="' . $field['id'] . '" id="' . $field['id'] . '" cols="100" rows="6">' . $meta . '</textarea> 
        <br /><span class="description">' . $field['desc'] . '</span>';
                break;
        }
        echo '</td></tr>';
    }
    echo '</table>';
}


// Пишем функцию для сохранения
function save_my_meta_fields($post_id)
{
    global $meta_fields;  // Массив с нашими полями

    // проверяем наш проверочный код
    if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))
        return $post_id;
    // Проверяем авто-сохранение
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    // Проверяем права доступа
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    // Если все отлично, прогоняем массив через foreach
    foreach ($meta_fields as $field) {
        $old = get_post_meta($post_id, $field['id'], true); // Получаем старые данные (если они есть), для сверки
        $new = $_POST[$field['id']];
        if ($new && $new != $old) {  // Если данные новые
            update_post_meta($post_id, $field['id'], $new); // Обновляем данные
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old); // Если данных нету, удаляем мету.
        }
    } // end foreach
}

add_action('save_post', 'save_my_meta_fields'); // Запускаем функцию сохранения




