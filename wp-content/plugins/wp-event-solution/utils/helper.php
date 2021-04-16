<?php

namespace Etn\Utils;

defined( 'ABSPATH' ) || exit;
/**
 * Global helper class.
 *
 * @since 1.0.0
 */

class Helper {

    use \Etn\Traits\Singleton;
    private static $settings_key = 'etn_event_options';

    /**
     * Auto generate classname from path.
     */
    public static function make_classname( $dirname ) {
        $dirname    = pathinfo( $dirname, PATHINFO_FILENAME );
        $class_name = explode( '-', $dirname );
        $class_name = array_map( 'ucfirst', $class_name );
        $class_name = implode( '_', $class_name );
        return $class_name;
    }

    /**
     * Loads google fonts
     */
    public static function google_fonts( $font_families = [] ) {
        $fonts_url = '';

        if ( $font_families ) {
            $query_args = [
                'family' => urlencode( implode( '|', $font_families ) ),
            ];

            $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
        }

        return esc_url_raw( $fonts_url );
    }

    /**
     * Renders provided markup
     */
    public static function render( $content ) {
        return $content;
    }

    /**
     * Filters only accepted kses
     */
    public static function kses( $raw ) {
        $allowed_tags = [
            'a'                             => [
                'class'  => [],
                'href'   => [],
                'rel'    => [],
                'title'  => [],
                'target' => [],
            ],
            'input'                         => [
                'value'              => [],
                'type'               => [],
                'size'               => [],
                'name'               => [],
                'checked'            => [],
                'data-value'         => [],
                'data-default-color' => [],
                'placeholder'        => [],
                'id'                 => [],
                'class'              => [],
                'min'                => [],
                'step'               => [],
                'readonly'           => 'readonly',
            ],
            'button'                        => [
                'type'    => [],
                'name'    => [],
                'id'      => [],
                'class'   => [],
                'onclick' => [],
            ],
            'select'                        => [
                'value'       => [],
                'type'        => [],
                'size'        => [],
                'name'        => [],
                'placeholder' => [],
                'id'          => [],
                'class'       => [],
                'option'      => [
                    'value'   => [],
                    'checked' => [],
                ],
            ],
            'textarea'                      => [
                'value'       => [],
                'type'        => [],
                'size'        => [],
                'name'        => [],
                'rows'        => [],
                'cols'        => [],
                'placeholder' => [],
                'id'          => [],
                'class'       => [],
            ],
            'abbr'                          => [
                'title' => [],
            ],
            'b'                             => [],
            'blockquote'                    => [
                'cite' => [],
            ],
            'cite'                          => [
                'title' => [],
            ],
            'code'                          => [],
            'del'                           => [
                'datetime' => [],
                'title'    => [],
            ],
            'dd'                            => [],
            'div'                           => [
                'class' => [],
                'title' => [],
                'style' => [],
            ],
            'dl'                            => [],
            'dt'                            => [],
            'em'                            => [],
            'h1'                            => [
                'class' => [],
            ],
            'h2'                            => [
                'class' => [],
            ],
            'h3'                            => [
                'class' => [],
            ],
            'h4'                            => [
                'class' => [],
            ],
            'h5'                            => [
                'class' => [],
            ],
            'h6'                            => [
                'class' => [],
            ],
            'i'                             => [
                'class' => [],
            ],
            'img'                           => [
                'alt'    => [],
                'class'  => [],
                'height' => [],
                'src'    => [],
                'width'  => [],
            ],
            'li'                            => [
                'class' => [],
            ],
            'ol'                            => [
                'class' => [],
            ],
            'p'                             => [
                'class' => [],
            ],
            'q'                             => [
                'cite'  => [],
                'title' => [],
            ],
            'span'                          => [
                'class' => [],
                'title' => [],
                'style' => [],
            ],
            'iframe'                        => [
                'width'       => [],
                'height'      => [],
                'scrolling'   => [],
                'frameborder' => [],
                'allow'       => [],
                'src'         => [],
            ],
            'strike'                        => [],
            'br'                            => [],
            'strong'                        => [],
            'data-wow-duration'             => [],
            'data-wow-delay'                => [],
            'data-wallpaper-options'        => [],
            'data-stellar-background-ratio' => [],
            'ul'                            => [
                'class' => [],
            ],
            'label'                         => [
                'class'      => [],
                'for'        => [],
                'data-left'  => [],
                'data-right' => [],
            ],
            'form'                          => [
                'class'  => [],
                'id'     => [],
                'role'   => [],
                'action' => [],
                'method' => [],
            ],
        ];

        if ( function_exists( 'wp_kses' ) ) { // WP is here
            return wp_kses( $raw, $allowed_tags );
        } else {
            return $raw;
        }

    }

    /**
     * internal
     *
     * @param [type] $text
     * @return void
     */
    public static function kspan( $text ) {
        return str_replace( ['{', '}'], ['<span>', '</span>'], self::kses( $text ) );
    }

    /**
     * retuns trimmed word
     */
    public static function trim_words( $text, $num_words ) {
        return wp_trim_words( $text, $num_words, '' );
    }

    public static function array_push_assoc( $array, $key, $value ) {
        $array[$key] = $value;
        return $array;
    }

    public static function img_meta( $id ) {
        $attachment = get_post( $id );

        if ( $attachment == null || $attachment->post_type != 'attachment' ) {
            return null;
        }

        return [
            'alt'         => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
            'caption'     => $attachment->post_excerpt,
            'description' => $attachment->post_content,
            'href'        => get_permalink( $attachment->ID ),
            'src'         => $attachment->guid,
            'title'       => $attachment->post_title,
        ];
    }

    /**
     * Date format
     */
    public static function datepicker_formats( $translate = null ) {
        $formats = [
            0     => 'Y-m-d',
            1     => 'n/j/Y',
            2     => 'm/d/Y',
            3     => 'j/n/Y',
            4     => 'd/m/Y',
            5     => 'n-j-Y',
            6     => 'm-d-Y',
            7     => 'j-n-Y',
            8     => 'd-m-Y',
            9     => 'Y.m.d',
            10    => 'm.d.Y',
            11    => 'd M Y',
            'm0'  => 'Y-m',
            'm1'  => 'n/Y',
            'm2'  => 'm/Y',
            'm3'  => 'n/Y',
            'm4'  => 'm/Y',
            'm5'  => 'n-Y',
            'm6'  => 'm-Y',
            'm7'  => 'n-Y',
            'm8'  => 'm-Y',
            'm9'  => 'Y.m',
            'm10' => 'm.Y',
            'm11' => 'm.Y',
        ];

        if ( is_null( $translate ) ) {
            return $formats;
        }

        return isset( $formats[$translate] ) ? $formats[$translate] : $formats[1];
    }

    public static function datetime_from_format( $format, $date ) {
        $keys = [
            // Year with 4 Digits
            'Y' => ['year', '\d{4}'],

            // Year with 2 Digits
            'y' => ['year', '\d{2}'],

            // Month with leading 0
            'm' => ['month', '\d{2}'],

            // Month without the leading 0
            'n' => ['month', '\d{1,2}'],

            // Month ABBR 3 letters
            'M' => ['month', '[A-Z][a-z]{2}'],

            // Month Name
            'F' => ['month', '[A-Z][a-z]{2,8}'],

            // Day with leading 0
            'd' => ['day', '\d{2}'],

            // Day without leading 0
            'j' => ['day', '\d{1,2}'],

            // Day ABBR 3 Letters
            'D' => ['day', '[A-Z][a-z]{2}'],

            // Day Name
            'l' => ['day', '[A-Z][a-z]{5,8}'],

            // Hour 12h formatted, with leading 0
            'h' => ['hour', '\d{2}'],

            // Hour 24h formatted, with leading 0
            'H' => ['hour', '\d{2}'],

            // Hour 12h formatted, without leading 0
            'g' => ['hour', '\d{1,2}'],

            // Hour 24h formatted, without leading 0
            'G' => ['hour', '\d{1,2}'],

            // Minutes with leading 0
            'i' => ['minute', '\d{2}'],

            // Seconds with leading 0
            's' => ['second', '\d{2}'],
        ];

        $date_regex = "/{$keys['Y'][1]}-{$keys['m'][1]}-{$keys['d'][1]}( {$keys['H'][1]}:{$keys['i'][1]}:{$keys['s'][1]})?$/";

        // if the date is already in Y-m-d or Y-m-d H:i:s, just return it
        if ( preg_match( $date_regex, $date ) ) {
            return $date;
        }

        // Convert format string to regex
        $regex = '';
        $chars = str_split( $format );

        foreach ( $chars as $n => $char ) {
            $last_char    = isset( $chars[$n - 1] ) ? $chars[$n - 1] : '';
            $skip_current = '\\' == $last_char;

            if ( !$skip_current && isset( $keys[$char] ) ) {
                $regex .= '(?P<' . $keys[$char][0] . '>' . $keys[$char][1] . ')';
            } elseif ( '\\' == $char ) {
                $regex .= $char;
            } else {
                $regex .= preg_quote( $char );
            }

        }

        $dt = [];

        // Now try to match it
        if ( preg_match( '#^' . $regex . '$#', $date, $dt ) ) {

            // Remove unwanted Indexes
            foreach ( $dt as $k => $v ) {
                if ( is_int( $k ) ) {
                    unset( $dt[$k] );
                }

            }

            // We need at least Month + Day + Year to work with
            if ( !checkdate( $dt['month'], $dt['day'], $dt['year'] ) ) {
                return false;
            }

        } else {
            return false;
        }

        $dt['month'] = str_pad( $dt['month'], 2, '0', STR_PAD_LEFT );
        $dt['day']   = str_pad( $dt['day'], 2, '0', STR_PAD_LEFT );

        $formatted = '{year}-{month}-{day}' . ( isset( $dt['hour'], $dt['minute'], $dt['second'] ) ? ' {hour}:{minute}:{second}' : '' );
        foreach ( $dt as $key => $value ) {
            $formatted = str_replace( '{' . $key . '}', $value, $formatted );
        }

        return $formatted;
    }

    public static function get_date_formats() {
        return [
            '0'  => 'Y-m-d',
            '1'  => 'n/j/Y',
            '2'  => 'm/d/Y',
            '3'  => 'j/n/Y',
            '4'  => 'd/m/Y',
            '5'  => 'n-j-Y',
            '6'  => 'm-d-Y',
            '7'  => 'j-n-Y',
            '8'  => 'd-m-Y',
            '9'  => 'Y.m.d',
            '10' => 'm.d.Y',
            '11' => 'd.m.Y',
            '11' => 'd M Y ',
        ];
    }

    public static function safe_path( $path ) {
        $path = str_replace( ['//', '\\\\'], ['/', '\\'], $path );
        return str_replace( ['/', '\\'], DIRECTORY_SEPARATOR, $path );
    }

    /**
     * Convert a multi-dimensional array into a single-dimensional array.
     * @author Sean Cannon, LitmusBox.com | seanc@litmusbox.com
     * @param  array $array The multi-dimensional array.
     * @return array
     */
    public static function array_flatten( $array ) {
        if ( !is_array( $array ) ) {
            return false;
        }

        $result = [];
        foreach ( $array as $key => $value ) {
            if ( is_array( $value ) ) {
                $result = array_merge( $result, self::array_flatten( $value ) );
            } else {
                $result = array_merge( $result, [$key => $value] );
            }

        }

        return $result;
    }

    /**
     * Post query to get data for widget and shortcode
     */
    public static function post_data_query( $post_type, 
                                            $count = null, 
                                            $order = 'DESC', 
                                            $term_arr = null,
                                            $taxonomy_slug = null,
                                            $post__in = null,
                                            $post_not_in = null,
                                            $tag__in = null,
                                            $orderby_meta = null,
                                            $orderby = 'post_date'
                                            ) {

        $data = [];
        $args = [
            'post_type'        => $post_type,
            'post_status'      => 'publish',
            'suppress_filters' => false,
            'tax_query'        => [
                'relation' => 'AND',
            ],
        ];

        if ( $order != null ) {
            if ( $orderby_meta == null ) {
                $args['orderby']    = $orderby;
            } else {
                $args['meta_key']   = $orderby;
                $args['orderby']    = $orderby_meta;
            }
            $args['order']      = strtoupper( $order );
        }

        if ( $post_not_in != null ) {
            $args['post__not_in'] = $post_not_in;
        }

        if ( $count != null ) {
            $args['posts_per_page'] = $count;
        }

        if ( $post__in != null ) {
            $args['post__in'] = $post__in;
        }

        // Elementor::If categories selected, add them to tax_query
        if ( is_array( $term_arr ) && !empty( $term_arr ) ) {
            $categories = [
                'taxonomy'         => $taxonomy_slug,
                'terms'            => $term_arr,
                'field'            => 'id',
                'include_children' => true,
                'operator'         => 'IN',
            ];
            array_push( $args['tax_query'], $categories );
        }

        // Elementor::If tags selected, add them to tax_query
        if ( !empty( $tag__in ) && is_array( $tag__in ) ) {
            $tags = [
                'taxonomy'         => 'etn_tags',
                'terms'            => $tag__in,
                'field'            => 'id',
                'include_children' => true,
                'operator'         => 'IN',
            ];
            array_push( $args['tax_query'], $tags );
        }

        // Settings::If hide Expired event is checked, filter out the expired events
        if ( !empty( get_option( "etn_event_options" )['checked_expired_event'] )
            && get_option( "etn_event_options" )['checked_expired_event'] == 'on'
            && $post_type == "etn" ) {
            $args['meta_query'] = [
                'relation' => 'OR',
                [
                    'key'     => 'etn_end_date',
                    'value'   => date( 'Y-m-d' ),
                    'compare' => '>',
                ],
                [
                    'key'     => 'etn_end_date',
                    'value'   => '',
                    'compare' => '=',
                ],
            ];
        }

        $data = get_posts( $args );
        
        return $data;
    }

    /**
     * Get zoom meeting data by meeting id
     *
     * @param [type] $meeting_id
     * @return void
     */
    public static function get_zoom_meetings( $meeting_id = null ) {
        $return_zoom_meetings = [];
        try {
            if ( is_null( $meeting_id ) ) {
                $meetings = get_posts( [
                    'post_type'      => 'etn-zoom-meeting',
                    'posts_per_page' => -1,
                ] );
                foreach ( $meetings as $meeting ) {
                    $return_zoom_meetings[$meeting->ID] = $meeting->post_title;
                }

                return $return_zoom_meetings;
            } else {
                // return single meeting

            }

        } catch ( \Exception $es ) {
            return [];
        }

    }

    public static function get_settings() {
        return get_option( "etn_event_options" );
    }

    /**
     * get single data by meta
     */
    public static function get_single_data_by_meta( $post_type, $limit, $key, $value, $sign = "=" ) {
        $args = [
            'post_type'      => $post_type,
            'posts_per_page' => $limit,
            'meta_query'     => [
                [
                    'key'     => $key,
                    'value'   => $value,
                    'compare' => $sign,
                ],
            ],
        ];
        $query_result = get_posts( $args );
        return $query_result;
    }

    public static function get_option( $key, $default = '' ) {
        $all_settings = get_option( self::$settings_key );
        return ( isset( $all_settings[$key] ) && $all_settings[$key] != '' ) ? $all_settings[$key] : $default;
    }

    public static function update_option( $key, $value = '' ) {
        $all_settings       = get_option( self::$settings_key );
        $all_settings[$key] = $value;
        update_option( self::$settings_key, $all_settings );
        return true;
    }

    /**
     * checks if attachment is an image
     *
     * @param [type] $attachment_id
     * @return void
     */
    public static function event_attachment_type_is_image( $attachment_id = null ) {

        if ( is_null( $attachment_id ) || $attachment_id == '' ) {
            return false;
        }

        $path = wp_get_attachment_url( $attachment_id );

        if ( $path == '' ) {
            return false;
        }

        $image      = getimagesize( $path );
        $image_type = $image[2];

        if ( in_array( $image_type, [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_BMP] ) ) {
            return true;
        }

        return false;
    }

    /**
     * sanitizes given input
     *
     * @param string $data
     * @return void
     */
    public static function sanitize( string $data ) {
        return strip_tags(
            stripslashes(
                sanitize_text_field(
                    filter_input( INPUT_POST, $data )
                )
            )
        );
    }

    /**
     * returns list of all speaker
     * returns single speaker if speaker id is provuded
     */
    public static function get_speakers( $id = null ) {
        $return_organizers = [];
        try {

            if ( is_null( $id ) ) {
                $args = [
                    'post_type'      => 'etn-speaker',
                    'post_status'    => 'publish',
                    'posts_per_page' => -1,
                ];
                $organizers = get_posts( $args );

                foreach ( $organizers as $value ) {
                    $return_organizers[$value->ID] = $value->post_title;
                }

                return $return_organizers;
            } else {
                // return single speaker
                return get_post( $id );
            }

        } catch ( \Exception $es ) {
            return [];
        }

    }

    /**
     * returns category of a speaker
     */
    public static function get_speakers_category( $id = null ) {
        $speaker_category = [];
        try {

            if ( is_null( $id ) ) {
                $terms = get_terms( [
                    'taxonomy'   => 'etn_speaker_category',
                    'hide_empty' => false,
                ] );

                foreach ( $terms as $speakers ) {
                    $speaker_category[$speakers->term_id] = $speakers->name;
                }

                return $speaker_category;
            } else {
                // return single speaker
                return get_post( $id );
            }

        } catch ( \Exception $es ) {
            return [];
        }

    }

    /**
     * returns category of an event
     *
     * @param [type] $id
     * @return void
     */
    public static function get_event_category( $id = null ) {
        $event_category = [];
        try {

            if ( is_null( $id ) ) {
                $terms = get_terms( [
                    'taxonomy'   => 'etn_category',
                    'hide_empty' => false,
                ] );

                foreach ( $terms as $event ) {
                    $event_category[$event->term_id] = $event->name;
                }

                return $event_category;
            } else {
                // return single speaker
                return get_post( $id );
            }

        } catch ( \Exception $es ) {
            return [];
        }

    }

    /**
     * returns tag of an event
     */
    public static function get_event_tag( $id = null ) {
        $event_tag = [];
        try {

            if ( is_null( $id ) ) {
                $terms = get_terms( [
                    'taxonomy'   => 'etn_tags',
                    'hide_empty' => false,
                ] );

                foreach ( $terms as $event ) {
                    $event_tag[$event->term_id] = $event->name;
                }

                return $event_tag;
            } else {
                // return single speaker
                return get_post( $id );
            }

        } catch ( \Exception $es ) {
            return [];
        }

    }

    public static function get_schedules( $id = null ) {
        $return_schedules = [];
        try {

            if ( is_null( $id ) ) {
                $args = [
                    'post_type'      => 'etn-schedule',
                    'post_status'    => 'publish',
                    'posts_per_page' => -1,
                ];
                $schedules = get_posts( $args );

                foreach ( $schedules as $value ) {
                    $schedule_date                = get_post_meta( $value->ID, 'etn_schedule_date', true );
                    $return_schedules[$value->ID] = $value->post_title . " ($schedule_date)";
                }

                return $return_schedules;
            } else {
                // return single speaker
                return get_post( $id );
            }

        } catch ( \Exception $es ) {
            return [];
        }

    }

    public static function get_events( $id = null ) {
        $return_events = [];
        try {

            if ( is_null( $id ) ) {
                $args = [
                    'post_type'      => 'etn',
                    'post_status'    => 'publish',
                    'posts_per_page' => -1,
                ];
                $events = get_posts( $args );

                foreach ( $events as $value ) {
                    $return_events[$value->ID] = $value->post_title;
                }

                return $return_events;
            } else {
                // return single speaker
                return get_post( $id );
            }

        } catch ( \Exception $es ) {
            return [];
        }

    }

    public static function get_users( $id = null ) {
        $return_organizers = ['' => esc_html__( 'select organizer', 'eventin' )];
        try {
            $blogusers = get_users(
                [
                    'order'    => 'DESC',
                    'role__in' => ['etn_organizer', 'administrator'],
                ]
            );

            foreach ( $blogusers as $user ) {
                $name                         = isset( $user->display_name ) ? $user->display_name : $user->user_nicename;
                $return_organizers[$user->ID] = $name . ' - ' . $user->user_email;
            }

            return $return_organizers;
        } catch ( \Exception $es ) {
            return [];
        }

    }

    public static function user_can_access( $cap = null ) {
        include_once ABSPATH . 'wp-includes/pluggable.php';

        if ( current_user_can( $cap ) ) {
            return true;
        }

        return false;
    }

    public static function etn_event_manager_fontawesome_icons( $prefix = 'fab' ) {
        $prefix       = apply_filters( 'etn_event_social_icons_prefix', $prefix );
        $social_icons = [
            "$prefix fa-facebook"           => esc_html__( 'facebook', 'eventin' ),
            "$prefix fa-facebook-f"         => esc_html__( 'facebook-f', 'eventin' ),
            "$prefix fa-facebook-messenger" => esc_html__( 'facebook-messenger', 'eventin' ),
            "$prefix fa-facebook-square"    => esc_html__( 'facebook-square', 'eventin' ),
            "$prefix fa-linkedin"           => esc_html__( 'linkedin', 'eventin' ),
            "$prefix fa-linkedin-in"        => esc_html__( 'linkedin-in', 'eventin' ),
            "$prefix fa-twitter"            => esc_html__( 'twitter', 'eventin' ),
            "$prefix fa-twitter-square"     => esc_html__( 'twitter-square', 'eventin' ),
            "$prefix fa-uber"               => esc_html__( 'uber', 'eventin' ),
            "$prefix fa-google"             => esc_html__( 'google', 'eventin' ),
            "$prefix fa-google-drive"       => esc_html__( 'google-drive', 'eventin' ),
            "$prefix fa-google-play"        => esc_html__( 'google-play', 'eventin' ),
            "$prefix fa-google-wallet"      => esc_html__( 'google-wallet', 'eventin' ),
            "$prefix fa-linkedin"           => esc_html__( 'linkedin', 'eventin' ),
            "$prefix fa-linkedin-in"        => esc_html__( 'linkedin-in', 'eventin' ),
            "$prefix fa-whatsapp"           => esc_html__( 'whatsapp', 'eventin' ),
            "$prefix fa-whatsapp-square"    => esc_html__( 'whatsapp-square', 'eventin' ),
            "$prefix fa-wordpress"          => esc_html__( 'wordpress', 'eventin' ),
            "$prefix fa-wordpress-simple"   => esc_html__( 'wordpress-simple', 'eventin' ),
            "$prefix fa-youtube"            => esc_html__( 'youtube', 'eventin' ),
            "$prefix fa-youtube-square"     => esc_html__( 'youtube-square', 'eventin' ),
            "$prefix fa-xbox"               => esc_html__( 'xbox', 'eventin' ),
            "$prefix fa-vk"                 => esc_html__( 'vk', 'eventin' ),
            "$prefix fa-vnv"                => esc_html__( 'vnv', 'eventin' ),
            "$prefix fa-instagram"          => esc_html__( 'instagram', 'eventin' ),
            "$prefix fa-reddit"             => esc_html__( 'reddit', 'eventin' ),
            "$prefix fa-reddit-alien"       => esc_html__( 'reddit-alien', 'eventin' ),
            "$prefix fa-reddit-square"      => esc_html__( 'reddit-square', 'eventin' ),
            "$prefix fa-pinterest"          => esc_html__( 'pinterest', 'eventin' ),
            "$prefix fa-pinterest-p"        => esc_html__( 'pinterest-p', 'eventin' ),
            "$prefix fa-pinterest-square"   => esc_html__( 'pinterest-square', 'eventin' ),
            "$prefix fa-tumblr"             => esc_html__( 'tumblr', 'eventin' ),
            "$prefix fa-tumblr-square"      => esc_html__( 'tumblr-square', 'eventin' ),
            "$prefix fa-flickr"             => esc_html__( 'flickr', 'eventin' ),
            "$prefix fa-meetup"             => esc_html__( 'meetup', 'eventin' ),
            "$prefix fa-share"              => esc_html__( 'share', 'eventin' ),
            "$prefix fa-vimeo-v"            => esc_html__( 'vimeo', 'eventin' ),
            "$prefix fa-weixin"             => esc_html__( 'Wechat', 'eventin' ),
        ];
        return apply_filters( 'etn_social_icons', $social_icons );
    }

    /**
     * returns all organizers list
     */
    public static function get_orgs() {
        $return_organizers = [];
        try {
            $terms = get_terms( [
                'taxonomy'   => 'etn_speaker_category',
                'orderby'    => 'count',
                'hide_empty' => false,
                'fields'     => 'all',
            ] );

            foreach ( $terms as $term ) {
                $return_organizers[$term->slug] = $term->name;
            }

            return $return_organizers;
        } catch ( \Exception $es ) {
            return [];
        }

    }

    /**
     * returns all categories of an event
     */
    public static function cate_with_link( $post_id = null, $category, $single = false ) {
        $terms         = get_the_terms( $post_id, $category );
        $category_name = '';

        if ( is_array( $terms ) ):

            foreach ( $terms as $tkey => $term ):
                $cat = $term->name;

                $category_name .= sprintf( "<span>%s</span> ", $cat );

                if ( $single ) {
                    break;
                }

                if ( $tkey == 1 ) {
                    break;
                }

            endforeach;
        endif;
        return $category_name;
    }

    /**
     * validation for nonce
     */
    public static function is_secured( $nonce_field, $action, $post_id = null, $post ) {

        $nonce = isset( $post[$nonce_field] ) ? sanitize_text_field( $post[$nonce_field] ) : '';

        if ( $nonce == '' ) {
            return false;
        }

        if ( null !== $post_id ) {

            if ( !current_user_can( 'edit_post', $post_id ) ) {
                return false;
            }

            if ( wp_is_post_autosave( $post_id ) ) {
                return false;
            }

            if ( wp_is_post_revision( $post_id ) ) {
                return false;
            }

        }

        if ( !wp_verify_nonce( $nonce, $action ) ) {
            return false;
        }

        return true;
    }

    /**
     * Single page settings option
     */
    public static function single_template_options( $single_event_id ) {
        $data                     = [];
        $date_options             = Helper::get_date_formats();
        $text_domain              = 'eventin';
        $etn_start_date           = strtotime( get_post_meta( $single_event_id, 'etn_start_date', true ) );
        $etn_start_time           = strtotime( get_post_meta( $single_event_id, 'etn_start_time', true ) );
        $etn_event_location       = get_post_meta( $single_event_id, 'etn_event_location', true );
        $etn_event_tags           = get_post_meta( $single_event_id, 'etn_event_tags', true );
        $etn_event_description    = get_post_meta( $single_event_id, 'etn_event_description', true );
        $etn_event_schedule       = get_post_meta( $single_event_id, 'etn_event_schedule', true );
        $etn_online_event         = get_post_meta( $single_event_id, 'etn_online_event', true );
        $etn_es_event_feature     = get_post_meta( $single_event_id, 'etn_es_event_feature', true );
        $etn_event_banner         = get_post_meta( $single_event_id, 'etn_event_banner', true );
        $etn_event_banner_url     = wp_get_attachment_image_src( $etn_event_banner );
        $etn_organizer_banner     = get_post_meta( $single_event_id, 'etn_organizer_banner', true );
        $etn_organizer_banner_url = wp_get_attachment_image_src( $etn_organizer_banner );
        $etn_end_date             = strtotime( get_post_meta( $single_event_id, 'etn_end_date', true ) );
        $etn_end_time             = strtotime( get_post_meta( $single_event_id, 'etn_end_time', true ) );
        $etn_event_socials        = get_post_meta( $single_event_id, 'etn_event_socials', true );
        $etn_event_page           = get_post_meta( $single_event_id, 'etn_event_page', true );
        $etn_organizer_events     = get_post_meta( $single_event_id, 'etn_event_organizer', true );
        $etn_avaiilable_tickets   = get_post_meta( $single_event_id, 'etn_avaiilable_tickets', true );
        $etn_avaiilable_tickets   = isset( $etn_avaiilable_tickets ) ? ( intval( $etn_avaiilable_tickets ) ) : 0;
        $etn_ticket_unlimited     = get_post_meta( $single_event_id, 'etn_ticket_availability', true );

        $cart_product_id = get_post_meta( $single_event_id, 'link_wc_product', true ) ? esc_attr( get_post_meta( $single_event_id, 'link_wc_product', true ) ) : esc_attr( $single_event_id );

        $etn_sold_tickets = get_post_meta( $single_event_id, 'etn_sold_tickets', true );

        if ( !$etn_sold_tickets ) {
            $etn_sold_tickets = 0;
        }

        $etn_ticket_price  = get_post_meta( $single_event_id, 'etn_ticket_price', true );
        $etn_ticket_price  = isset( $etn_ticket_price ) ? ( floatval( $etn_ticket_price ) ) : 0;
        $etn_left_tickets  = $etn_avaiilable_tickets - $etn_sold_tickets;
        $event_options     = get_option( "etn_event_options" );
        $event_time_format = empty( $event_options["time_format"] ) ? '12' : $event_options["time_format"];
        $event_start_time  = ( $event_time_format == "24" || $event_time_format == "" ) ? date_i18n( 'H:i', $etn_start_time ) : date_i18n( 'h:i A', $etn_start_time );
        $event_end_time    = ( $event_time_format == "24" || $event_time_format == "" ) ? date_i18n( 'H:i', $etn_end_time ) : date_i18n( 'h:i A', $etn_end_time );
        $event_start_date  = ( isset( $event_options["date_format"] ) && $event_options["date_format"] !== '' ) ? date_i18n( $date_options[$event_options["date_format"]], $etn_start_date ) : date_i18n( 'd/m/Y', $etn_start_date );
        $event_end_date    = '';

        if ( $etn_end_date ) {
            $event_end_date = isset( $event_options["date_format"] ) && ( "" != $event_options["date_format"] ) ? date_i18n( $date_options[$event_options["date_format"]], $etn_end_date ) : date_i18n( 'd/m/Y', $etn_end_date );
        }

        $etn_deadline       = strtotime( get_post_meta( $single_event_id, 'etn_registration_deadline', true ) );
        $etn_deadline_value = '';

        if ( $etn_deadline ) {
            $etn_deadline_value = isset( $event_options["date_format"] ) && $event_options["date_format"] !== '' ? date_i18n( $date_options[$event_options["date_format"]], $etn_deadline ) : date_i18n( 'd/m/Y', $etn_deadline );
        }

        $category = self::cate_with_link( $single_event_id, 'etn_category' );

        $data['category']             = $category;
        $data['etn_event_schedule']   = $etn_event_schedule;
        $data['event_options']        = $event_options;
        $data['text_domain']          = $text_domain;
        $data['event_start_date']     = $event_start_date;
        $data['event_end_date']       = $event_end_date;
        $data['event_start_time']     = $event_start_time;
        $data['event_end_time']       = $event_end_time;
        $data['etn_deadline_value']   = $etn_deadline_value;
        $data['etn_event_location']   = $etn_event_location;
        $data['etn_left_tickets']     = $etn_left_tickets;
        $data['etn_organizer_events'] = $etn_organizer_events;
        $data['date_options']         = $date_options;
        $data['etn_event_socials']    = $etn_event_socials;
        $data['etn_ticket_price']     = $etn_ticket_price;
        $data['etn_ticket_unlimited'] = $etn_ticket_unlimited;
        return $data;
    }

    /**
     * Single page organizer
     */
    public static function single_template_organizer_free( $etn_organizer_events ) {

        if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-organizers-free.php' ) ) {
            require_once get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-organizers-free.php';
        } elseif ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-organizers-free.php' ) ) {
            require_once get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-organizers-free.php';
        } else {
            require_once ETN_PLUGIN_TEMPLATE_DIR . 'event/event-organizers-free.php';
        }

    }

    /**
     * Speaker sessions in single page
     */
    public static function speaker_sessions( $speaker_id ) {
        global $wpdb;
        $orgs = $wpdb->get_results( "SELECT * FROM $wpdb->postmeta WHERE meta_key = 'etn_schedule_topics' AND  meta_value LIKE '%\"$speaker_id\"%' ORDER BY post_id DESC", ARRAY_A );

        return $orgs;
    }

    /**
     * Remove attendee data when status faild
     */
    public static function remove_attendee_data() {
        global $wpdb;
        $query = $wpdb->query(
            " DELETE etn_postmeta , etn_post
                FROM $wpdb->posts etn_post
                INNER JOIN $wpdb->postmeta etn_postmeta
                ON  etn_postmeta.post_id = etn_post.ID
                WHERE etn_postmeta.meta_key = 'etn_status'
                AND etn_postmeta.meta_value = 'failed'"
        );
        return $query;
    }

    /**
     * get  corn shcedule days
     */
    public static function get_schedule_days() {
        // attendee_remove
        $event_options   = get_option( "etn_event_options" );
        $attendee_remove = isset( $event_options['attendee_remove'] ) && $event_options['attendee_remove'] !== "" ? $event_options['attendee_remove'] : 1;

        return 60 * 60 * 24 * $attendee_remove;
    }

    /**
     * Send email function
     */
    public static function send_email( $to, $subject, $mail_body, $from, $from_name ) {
        $body    = html_entity_decode( $mail_body );
        $headers = ['Content-Type: text/html; charset=UTF-8', 'From: ' . $from_name . ' <' . $from . '>'];
        $result  = wp_mail( $to, $subject, $body, $headers );

        return $result;
    }

    /**
     * Get all tickets of event
     */
    public static function get_tickets_by_event( $current_post_id, $report_sorting ) {
        global $wpdb;
        $response_data = [];
        $data          = [];

        $data = $wpdb->get_results( "SELECT * FROM wp_etn_events WHERE post_id = $current_post_id ORDER BY event_id $report_sorting" );

        if ( is_array( $data ) && count( $data ) > 0 ) {
            $total_sale_price = 0;

            foreach ( $data as &$single_sale ) {
                $total_sale_price += $single_sale->event_amount;
                $single_sale_meta = $wpdb->get_results( "SELECT * FROM wp_etn_trans_meta WHERE event_id = $single_sale->event_id AND meta_key = '_etn_order_qty'" );
                $single_sale->{'single_sale_meta'}
                = $single_sale_meta[0]->meta_value;
            }

        }

        $response_data['all_sales']        = $data;
        $response_data['total_sale_price'] = isset( $total_sale_price ) ? $total_sale_price : 0;

        return $response_data;
    }

    public static function woocommerce_ticket_widget( $single_event_id, $class = "" ) {

        $data = self::single_template_options( $single_event_id );

        if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/purchase-form/event-ticket.php' ) ) {
            $purchase_form_widget = get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/purchase-form/event-ticket.php';
        } elseif ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/purchase-form/event-ticket.php' ) ) {
            $purchase_form_widget = get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/purchase-form/event-ticket.php';
        } else {
            $purchase_form_widget = ETN_PLUGIN_TEMPLATE_DIR . 'event/purchase-form/event-ticket.php';
        }

        include $purchase_form_widget;
    }

    /**
     * module for related events
     *
     * @param [type] $single_event_id
     * @return void
     */
    public static function related_events_widget( $single_event_id, $configs = [] ) {

        $etn_terms    = wp_get_post_terms( $single_event_id, 'etn_tags' );
        $etn_term_ids = [];

        if ( $etn_terms ) {

            foreach ( $etn_terms as $terms ) {
                array_push( $etn_term_ids, $terms->term_id );
            }

        }

        $event_options = get_option( "etn_event_options" );
        $date_options  = self::get_date_formats();
        $data          = self::post_data_query( 'etn', null, null, $etn_term_ids, "etn_tags", null, [ $single_event_id ] );

        $column = "4";

        if ( !empty( $configs ) && !empty( $configs["column"] ) ) {
            $column = $configs["column"];
        }

        $title = (is_array( $configs ) && !empty( $configs["title"] )) ? $configs["title"] : esc_html__( 'Related Events', 'eventin' );

        if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/related-events-free.php' ) ) {
            $template = get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/related-events-free.php';
        } elseif ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/related-events-free.php' ) ) {
            $template = get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/related-events-free.php';
        } elseif ( file_exists( ETN_PLUGIN_TEMPLATE_DIR . 'event/related-events-free.php' ) ){
            $template = ETN_PLUGIN_TEMPLATE_DIR . 'event/related-events-free.php';
        }

        include $template;

    }

    public static function get_attendee_by_token( $key, $value ) {
        global $wpdb;
        $query_result = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key='$key' AND meta_value='$value'" );
        return $query_result;
    }

    
    /**
     * Sorting Schedule repeater data
     */
    public static function sort_schedule_items( $post_id, $etn_rep_key ){
        $new_order  = sanitize_text_field(stripslashes($_POST['etn_schedule_sorting']));
        $order      = json_decode($new_order, true);
        $order      = array_values($order);

        if (is_array($order) && !empty($order)){
            $schedules  = $etn_rep_key;
            $new_arr    = []; 
            $sort_arr   = [];
            foreach($order as $key => $value) {
                $new_arr[$key]  = $schedules[$value];
                $sort_arr[$key] = $key;
            }
            $new_sort =  json_encode($sort_arr);
            update_post_meta( $post_id, 'etn_schedule_topics', $new_arr );
            update_post_meta( $post_id, 'etn_schedule_sorting', $new_sort );
        }
    }

    public static function generate_name_from_label( $prefix, $label ){
        return  $prefix . self::get_name_structure_from_label($label);
    }

    public static function get_name_structure_from_label($label){
        return strtolower( preg_replace("/[^a-zA-Z0-9]/", "_", $label ) );
    }

        
    public static function prepare_event_template_path( $default_template_name, $template_name ){
        if ( "event-one" !== $template_name && class_exists( 'Etn_Pro\Bootstrap' ) ) {
            $single_template_path = ETN_PRO_PLUGIN_TEMPLATE_DIR . $template_name . ".php";
        } else {
            $single_template_path = ETN_PLUGIN_TEMPLATE_DIR . $default_template_name . ".php";
        } 

        $single_template_path = apply_filters( "etn_event_content_template_path", $single_template_path );
        
        return $single_template_path;
    }
        
    public static function prepare_speaker_template_path( $default_template_name, $template_name ){
        if ( "" !== $template_name && "speaker-one" !== $template_name && class_exists( 'Etn_Pro\Bootstrap' ) ) {
            $single_template_path = ETN_PRO_PLUGIN_TEMPLATE_DIR . $template_name . ".php";
        } else {
            $single_template_path = ETN_PLUGIN_TEMPLATE_DIR . $default_template_name . ".php";
        }

        $single_template_path = apply_filters( "etn_speaker_content_template_path", $single_template_path );
        
        return $single_template_path;
    }

    public static function get_attendee_by_woo_order( $order_id ){
        $all_attendee = [];
        global $wpdb;
        $table_name = $wpdb->prefix . "postmeta";
        $sql        = "SELECT post_id FROM $table_name WHERE meta_key='etn_attendee_order_id' AND meta_value=$order_id";
        $results    = $wpdb->get_results($sql);

        if(is_array( $results ) && !empty($results)){
            foreach( $results as $result ){
                array_push($all_attendee, $result->post_id);
            }
        }
        return $all_attendee;
    }

    public static function update_attendee_payment_status( $attendee_id, $order_status ){
        $payment_success_status_array = [
            // 'pending',
            'processing',
            // 'on-hold',
            'completed',
            // 'cancelled',
            'refunded',
            // 'failed',
        ];

        if( in_array($order_status, $payment_success_status_array) ){
            //payment complete, update payment status to success
            update_post_meta( $attendee_id, 'etn_status', 'success' );
        }else{
            //payment failed, update payment status to falied
            update_post_meta( $attendee_id, 'etn_status', 'failed' );
        }
    }

    public static function verify_attendee_edit_token( $attendee_id, $check_info_edit_token ){
        if( empty( $attendee_id ) || empty( $check_info_edit_token ) ){
            return false;
        }

        $stored_edit_token = get_post_meta( $attendee_id, "etn_info_edit_token", true );
        if( $stored_edit_token == $check_info_edit_token ){
            return true;
        }
        return false;

    }

    public static function show_attendee_pdf_invalid_data_page(){
        wp_head();
        ?>
        <div class="section-inner">
            <h3 class="entry-title">
                <?php echo esc_html__( "Invalid data. ", "eventin" ); ?>
            </h3>
            <div class="intro-text">
                <a href="<?php echo esc_url( home_url() ); ?>"><?php echo esc_html__( "Return to homepage", "eventin" ); ?></a>
            </div>
        </div>
        <?php
        wp_footer();
    }

}
