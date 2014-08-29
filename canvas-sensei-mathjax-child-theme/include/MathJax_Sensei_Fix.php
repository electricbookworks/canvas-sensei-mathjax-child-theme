<?php
/**
 * MathJax_Sensei_Fix class.
 *
 * @package   MathJax_Sensei_Fix
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Your Name or Company Name
 */

//namespace training_teachers_canvas;


class MathJax_Sensei_Fix {

    /**
     * Instance of this class.
     *
     * @since    1.0.0
     *
     * @var      object
     */
    protected static $instance = null;

    /**
     * Initialize the class by setting localization, filters, and administration functions.
     *
     * @since     1.0.0
     */
    private function __construct() {

        // Load plugin text domain
        if (class_exists("MathJax"))
        {
            add_action('init', array( $this, 'init' ) );
            add_action('wp_footer', array($this, 'print_script'));
        }
    }

    /**
     * Setup init.
     *
     * @since    1.0.0
     */
    public function init() {

        add_filter( 'the_title',
            array(__CLASS__, 'content_latex_shortcode' ));

        add_filter( 'the_excerpt',
            array(__CLASS__, 'content_latex_shortcode' ));

        add_filter( 'get_the_excerpt',
            array(__CLASS__, 'esc_html' ), 10);

        add_action( 'mathjax_sensei_fix_course_archive_course_title', array($this, 'course_archive_course_title' ));
        add_action( 'mathjax_sensei_fix_lesson_archive_lesson_title', array($this, 'lesson_archive_lesson_title' ));
        add_action( 'mathjax_sensei_fix_course_single_title', array( $this, 'single_title' ), 10 );
        add_action( 'mathjax_sensei_fix_lesson_single_title', array( $this, 'single_title' ), 10 );
        add_action( 'mathjax_sensei_fix_quiz_single_title', array( $this, 'single_title' ), 10 );

        //define('WP_DEBUG', true);
//        add_filter('esc_html',
//            array(__CLASS__, 'esc_html_filter' ), 9, 2);

    }

    /**
     * single_title output for single page title
     * @since  1.1.0
     * @return void
     */
    function single_title() {
        ?><header><h1><?php the_title(); ?></h1></header><?php
    } // End single_title()


    /**
     * sensei_course_archive_course_title output for course archive page individual course title
     * @since  1.2.0
     * @return void
     */
    function course_archive_course_title( $post_item ) {
        if ( isset( $post_item->ID ) && ( 0 < $post_item->ID ) ) {
            $post_id = absint( $post_item->ID );
            $post_title = $post_item->post_title;
        } else {
            $post_id = get_the_ID();
            $post_title = get_the_title();
        } // End If Statement
        ?><header><h2><a href="<?php echo get_permalink( $post_id ); ?>" title="<?php echo esc_attr( $post_title ); ?>"><?php echo self::esc_html($post_title, $post_title); ?></a></h2></header><?php
    } // End sensei_course_archive_course_title()

    /**
     * sensei_lesson_archive_lesson_title output for course archive page individual course title
     * @since  1.2.1
     * @return void
     */
    public function lesson_archive_lesson_title() {
        $post_id = get_the_ID();
        $post_title = get_the_title();
        ?><header><h2><a href="<?php echo get_permalink( $post_id ); ?>" title="<?php echo esc_attr( $post_title ); ?>"><?php echo self::esc_html($post_title, $post_title); ?></a></h2></header><?php
    } // End sensei_lesson_archive_lesson_title()

    /**
     * Makes sure images and latex shortcode are in correct format.
     *
     * @since     1.0.0
     *
     * @return    string    Return parsed string.
     */
    public static function esc_html($safe_text, $text = ""){
        $image_pattern = '/\&lt\;(img.+)(\/*)\&gt\;/i';
        $replacement = '<${1}/>';

        $latex_pattern = '/\[latex\]/i';

        if (empty($text))
            $text = $safe_text;

        //if (preg_match($latex_pattern, $text) === 1)
        if (is_admin())
            return $text;

        //removed esc_html($text)
        return self::content_latex_shortcode(str_replace("&quot;","\"", preg_replace($image_pattern, $replacement, $text)));
    }

    /**
     * Makes sure images and latex shortcode are in correct format.
     *
     * @since     1.0.0
     *
     * @return    string    Return parsed string.
     */
    public static function esc_html_filter($safe_text, $text){
        if (empty($text))
            $text = $safe_text;

        //if (preg_match($latex_pattern, $text) === 1)
        if (is_admin())
            return $text;

        //removed esc_html($text)
        return self::content_latex_shortcode($text);
    }


    /**
     * Makes sure latex shortcode are in correct format.
     *
     * @since     1.0.0
     *
     * @return    string    Return parsed string.
     */
    public static function content_latex_shortcode($content)
    {
        if (is_admin())
            return $content;

         $latex_pattern = '/\[latex\](.+)\[\/latex\]/i';

        //this gives us an optional "syntax" attribute, which defaults to "inline", but can also be "display"

        return preg_replace_callback($latex_pattern, function ($matches)
        {
            $syntax =  get_option('kblog_mathjax_latex_inline');

            $start_bracket = '\(';
            $end_bracket = '\)';

            if ($syntax == 'inline') {
                $start_bracket = '\(';
                $end_bracket = '\)';
            }
            else if ($syntax == 'display') {
                $start_bracket = '\[';
                $end_bracket = '\]';
            }

            return $start_bracket.str_replace("[/latex]", $end_bracket, str_replace("[latex]", $start_bracket, str_replace("|", "\\", $matches[1]))).$end_bracket;
        }, $content);
    }

    public static function content_latex_shortcode_old($content)
    {
        if (is_admin())
            return $content;

        //this gives us an optional "syntax" attribute, which defaults to "inline", but can also be "display"
        $syntax =  get_option('kblog_mathjax_latex_inline');

        if ($syntax == 'inline') {
            return str_replace("[/latex]", "\)", str_replace("[latex]", "\(", $content));
        }
        else if ($syntax == 'display') {
            return str_replace("[/latex]", "\]", str_replace("[latex]", "\[", $content));
        }

        return $content;
    }

    /**
     * Return an instance of this class.
     *
     * @since     1.0.0
     *
     * @return    object    A single instance of this class.
     */
    public static function get_instance() {

        // If the single instance hasn't been set, set it now.
        if ( null == self::$instance ) {
            self::$instance = new self;
        }

        self::$instance->init();

        return self::$instance;
    }
}
