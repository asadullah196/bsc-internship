<?php

namespace Etn\Core\Metaboxs;

use Etn\Core\Metaboxs\Event_manager_repeater_metabox as Event_manager_repeater_metabox;
use Etn\Utils\Helper as Helper;
use Exception;
use WP_Error;

defined( 'ABSPATH' ) || exit;

abstract class Event_manager_metabox extends Event_manager_repeater_metabox {

    public function display_callback( $post ) {

        $meta_field_function_name = $this->get_meta_field_function_name_by_post_id( $post->ID );

        foreach ( $this->$meta_field_function_name() as $key => $item ) {
            $this->get_markup( $item, $key );
        }

        wp_nonce_field( 'etn_event_data', 'etn_event_n_fields' );

    }

    /**
     * Undocumented function
     *
     * @param [type] $post_id
     * @return void
     */
    private function get_meta_field_function_name_by_post_id( $post_id ) {

        $post_type                = get_post_type( $post_id );
        $post_type                = str_replace( '-', '_', $post_type );
        $meta_field_function_name = $post_type . '_meta_fields';

        return $meta_field_function_name;
    }

    public function banner_item_display( $post ) {

        foreach ( $this->banner_meta_field() as $key => $item ):
            $this->get_markup( $item, $key );
        endforeach;
        wp_nonce_field( 'etn_event_data', 'etn_event_n_fields' );
    }

    public function save_meta_box_data( $post_id ) {

        $post_arr = Helper::render( $_POST );

        if ( !Helper::is_secured( 'etn_event_n_fields', 'etn_event_data', $post_id, $post_arr ) ) {
            return $post_id;
        }
        
        switch ( get_post_type( $post_id ) ) {

            case 'etn':
                $instance = new \Etn\Core\Metaboxs\Event_meta();
                break;
            case 'etn-speaker':
                $instance = new \Etn\Core\Metaboxs\Speaker_meta();
                break;
            case 'etn-schedule':
                $instance = new \Etn\Core\Metaboxs\Schedule_meta();
                break;
            case 'etn-attendee':
                $instance = new \Etn\Core\Metaboxs\Attendee_Meta();
                break;
            case 'etn-zoom-meeting':
                $instance = new \Etn\Core\Zoom_Meeting\Zoom_Meeting_Meta();
                break;

        }

        try {

            $meta_field_function_name = $this->get_meta_field_function_name_by_post_id( $post_id );
            $meta_fields              = $instance->$meta_field_function_name();

            $this->update( $meta_fields, $post_arr );

            if ( isset( $post_arr['alignment'] ) ) {
                $this->update( $instance->banner_meta_field(), $post_arr );
            }

        } catch ( Exception $e ) {
            $error = new WP_Error( $e->getCode(), $e->getMessage() );
        }

    }

    protected function update( $fields = null, $post ) {

        if ( !is_array( $fields ) || !count( $fields ) ) {
            throw new Exception( esc_html__( "meta data field not found", 'eventin' ) );
        }

        foreach ( $fields as $field_key => $field ) {

            if ( $field['type'] == 'radio' || $field['type'] == 'select2' ) {

                if ( isset( $post[$field_key] ) ) {
                    $upload_key = isset( $post[$field_key] ) ? $post[$field_key] : '';
                    $rv         = $upload_key;
                    update_post_meta( get_the_ID(), $field_key, $rv );
                } else {
                    update_post_meta( get_the_ID(), $field_key, '' );
                }

            } elseif ( $field['type'] == 'upload' ) {

                if ( isset( $post[$field_key] ) ) {
                    $upload_key = isset( $post[$field_key] ) ? sanitize_text_field( $post[$field_key] ) : '';
                    update_post_meta( get_the_ID(), $field_key, $upload_key );
                }

            } elseif ( $field['type'] == 'wp_editor' ) {

                if ( isset( $post[$field_key] ) ) {
                    $upload_key = isset( $post[$field_key] ) ? sanitize_textarea_field( $post[$field_key] ) : '';
                    update_post_meta( get_the_ID(), $field_key, $upload_key );
                }

            } elseif ( $field['type'] == 'social_reapeater' ) {

                if ( isset( $post[$field_key] ) ) {
                    $social_key = isset( $post[$field_key] ) ? $post[$field_key] : '';

                    if ( is_array( $social_key ) ) {

                        if ( count( $social_key ) == 1 ) {

                            if ( $social_key[0]['icon'] == '' ) {
                                update_post_meta( get_the_ID(), $field_key, "" );
                            } else {
                                update_post_meta( get_the_ID(), $field_key, $social_key );
                            }

                        } else {
                            update_post_meta( get_the_ID(), $field_key, $social_key );
                        }

                    }

                } else {
                    update_post_meta( get_the_ID(), $field_key, '' );
                }

            } elseif ( $field['type'] == 'repeater' ) {
                if ( isset( $post[$field_key] ) ) {
                    $etn_rep_key = isset( $post[$field_key] ) ? $post[$field_key] : '';
                    if ( is_array( $etn_rep_key ) ) {
                        if ( count( $etn_rep_key ) == 1 ) {
                            //only one item in repeater field
                            if ( strlen( trim( join( "", Helper::array_flatten( $etn_rep_key[0] ) ) ) ) == 0 ) {
                                update_post_meta( get_the_ID(), $field_key, "" );
                            } else {
                                update_post_meta( get_the_ID(), $field_key, $etn_rep_key );
                            }
                        } else {
                            // multiple items in repeater field. sort repeater data and update value
                            if ( !empty( $_POST['etn_schedule_sorting'] )){
                                \Etn\Utils\Helper::sort_schedule_items( get_the_ID(), $etn_rep_key );
                            }else {
                                update_post_meta( get_the_ID(), $field_key, $etn_rep_key );
                            }
                        }

                    }

                } else {
                    
                    update_post_meta( get_the_ID(), $field_key, '' );
                }

            } elseif ( $field['type'] == 'email' ) {

                if ( isset( $post[$field_key] ) ) {
                    $email_value = isset( $post[$field_key] ) ? sanitize_email( $post[$field_key] ) : '';
                    update_post_meta( get_the_ID(), $field_key, $email_value );
                }

            } else {

                if ( isset( $post[$field_key] ) ) {
                    $text_value = isset( $post[$field_key] ) ? $post[$field_key] : '';
                    update_post_meta( get_the_ID(), $field_key, $text_value );

                    // add the event ticket price as an extra meta so woocommerce extensions can use it
                    if ( "etn_ticket_price" === $field_key ) {
                        update_post_meta( get_the_ID(), "_price", $text_value );
                        update_post_meta( get_the_ID(), "_regular_price", $text_value );
                        update_post_meta( get_the_ID(), "_sale_price", $text_value );
                    }

                }

            }

        }

    }

    protected function get_markup( $item = null, $key = '' ) {

        if ( is_null( $item ) ) {
            return;
        }

        if ( isset( $item['type'] ) ) {

            switch ( $item['type'] ) {
                case "text":
                    return $this->get_textinput( $item, $key );
                    break;
                case "number":
                    return $this->get_number_input( $item, $key );
                    break;
                case "date":
                    return $this->get_textinput( $item, $key );
                    break;
                case "time":
                    return $this->get_textinput( $item, $key );
                    break;
                case "textarea":
                    return $this->get_textarea( $item, $key );
                    break;
                case "url":
                    return $this->get_url_input( $item, $key );
                    break;
                case "email":
                    return $this->get_email_input( $item, $key );
                    break;
                case "radio":
                    return $this->get_radio_input( $item, $key );
                    break;
                case "select2":
                    return $this->get_select2( $item, $key );
                    break;
                case "select_single":
                    return $this->get_select_single( $item, $key );
                    break;
                case "upload":
                    return $this->get_upload( $item, $key );
                    break;
                case "wp_editor":
                    return $this->get_wp_editor( $item, $key );
                    break;
                case "map":
                    return $this->get_wp_map( $item, $key );
                    break;
                case "social_reapeater":
                    return $this->get_wp_social_repeater( $item, $key );
                    break;
                case "repeater":
                    return $this->get_wp_repeater( $item, $key );
                    break;
                case "heading":
                    return $this->get_heading( $item, $key );
                    break;
                case "separator":
                    return $this->get_separator( $item, $key );
                    break;
                case "checkbox":
                    return $this->get_checkbox( $item, $key );
                    break;
                case "color_picker":
                    return $this->get_color_picker( $item, $key );
                    break;
                case "hidden":
                    return $this->get_hidden_input( $item, $key );
                    break;
                default:
                    return;
            }

        }

        return;
    }

    public function get_checkbox( $item, $key ) {
        $class                  = $key;
        $value                  = get_post_meta( get_the_ID(), $key, true );
        $checked                = isset( $value ) && $value !== '' && $value !== 'no' ? 'checked' : '';
        $left_choice            = isset( $item['left_choice'] ) ? $item['left_choice'] : 'yes';
        $right_choice           = isset( $item['right_choice'] ) ? $item['right_choice'] : 'no';
        $condition_class        = ( isset( $item["conditional"] ) && $item["conditional"] == true ) ? "etn-conditional-control" : "";
        $conditional_control_id = isset( $item["condition-id"] ) ? "data-conditional_id=" . $item['condition-id'] : "";

        if ( isset( $item['attr'] ) ) {
            $class = isset( $item['attr']['class'] ) && $item['attr']['class'] != '' ? $item['attr']['class'] . ' etn_event_meta_field' : 'etn_event_meta_field';
        }

        ?>
        <div class="<?php echo esc_attr( $class ); ?>">
            <div class="etn-label">
                <label> <?php echo esc_html( $item['label'] ); ?> : </label>
                <div class="etn-desc"> <?php echo esc_html( $item['desc'] ); ?> </div>
            </div>
            <div class="etn-meta">
                <input type="hidden" name="<?php echo esc_attr( $key ); ?>" value="no"/>
                <input class="etn-admin-control-input <?php echo esc_attr( $condition_class ); ?>" type="<?php echo esc_attr( $item['type'] ); ?>" name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>" <?php echo esc_attr( $conditional_control_id ); ?> <?php echo esc_attr( $checked ); ?>/>
                <label for="<?php echo esc_attr( $key ); ?>" data-left="<?php echo esc_attr( $left_choice ); ?>" data-right="<?php echo esc_attr( $right_choice ); ?>" class="etn_switch_button_label"></label>
            </div>
        </div>
        <?php
        }

    
        public function get_color_picker( $item, $key ) {
        $class         = $key;
        $value         = get_post_meta( get_the_ID(), $key, true );
        $default_color = isset( $item['default-color'] ) ? $item['default-color'] : '#fff';
        if ( isset( $item['attr'] ) ) {
            $class = isset( $item['attr']['class'] ) && $item['attr']['class'] != '' ? $item['attr']['class'] . ' etn_event_meta_field' : 'etn_event_meta_field';
        }

        $html = sprintf( '<div class="%s">
                            <div class="etn-label"> <label> %s : </label><div class="etn-desc">  %s  </div> </div>
                            <div class="etn-meta">
                                <input data-default-color="%s" data-value="%s" value="%s" class="banner_color_picker"
                                type="hidden" name="%s" id="%s"/>
                            </div>
                         </div>', $class, $item['label'], $item['desc'], $default_color, $value, $value, $key, $key );

        echo Helper::kses( $html );
    }

    public function get_wp_repeater( $item, $key ) {
        $value          = [];
        $class          = $key;
        $options_fields = $item['options'];
        $repeater_arr   = get_post_meta( get_the_ID(), $key, true );
        $sort_arr       =(array) json_decode( get_post_meta( get_the_ID(), 'etn_schedule_sorting', true ) );
        $count          = is_array( $repeater_arr ) ? count( $repeater_arr ) : 1;
        ?>
        <div class='etn-event-repeater-clearfix etn-repeater-item'>
            <h3 class='etn-title'><?php echo esc_html( $item['label'] ); ?></h3>
            <div class='etn-event-manager-repeater-fld <?php echo esc_attr( $class ); ?>'>
                <div data-repeater-list='<?php echo esc_html( $key ); ?>' <?php echo ( $key == 'etn_schedule_topics' ) ? "class='schedule_repeater'" : ''; ?>>
                <?php
                for ( $x = 0; $x < $count; $x++ ) {
                    $label_no       = $x;
                    ?>
                    <div data-repeater-list="etn-event-repeater-options" class="etn-repeater-item sort_repeat" data-repeater-item="<?php echo esc_attr( !empty($sort_arr[$x]) ? $sort_arr[$x] : $x ) ?>">
                        <div class="form-group mb-3">
                        <div class="etn-event-shedule-collapsible">
                            <span class="event-title"><?php echo esc_html( $item['label'] . ' ' . ++$label_no ); ?></span>
                            <i data-repeater-delete type="button" class="dashicons dashicons-no-alt" aria-hidden="true"></i>
                        </div>
                        <div class="etn-event-repeater-collapsible-content" style="display: none">
                            <?php $i = $x;
                            foreach ( $options_fields as $op_fld_key => $options_field ){
                                $nested_data = isset( $repeater_arr[$i] ) ? $repeater_arr[$i] : [];
                                echo Helper::render( $this->get_repeater_markup( $options_field, $op_fld_key, $nested_data ) );
                            }
                            ?>
                        </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                </div>
                <input data-repeater-create type='button' class='etn-btn attr-btn-primary mb-2 clearfix repeater_button' value='<?php echo esc_html__( "Add", "eventin" ); ?>' />
            </div>
        </div>
        <?php
    }

    public function get_wp_repeaterpublic( $item, $key, $id ) {
        $value          = [];
        $class          = $key;
        $options_fields = $item['options'];
        $repeater_arr   = get_post_meta( $id, $key, true );
        $count          = is_array( $repeater_arr ) ? !empty( $repeater_arr ) : 1;

        ?>
        <div class='etn-event-repeater-clearfix'>
            <h3><?php echo esc_html( $item['label'] ); ?></h3>
            <div class='form-inline etn-event-repeater <?php echo esc_attr( $class ); ?>'>
                <div data-repeater-list='<?php echo esc_html( $key ); ?>'>
                <input data-repeater-create type='button' class='etn-btn attr-btn-primary mb-2 clearfix' value='<?php echo esc_html__( "Add", "eventin" ); ?>' />
                <?php
                for ( $x = 0; $x < $count; $x++ ) {
                    $label_no = $x;
                    ?>
                    <div data-repeater-list="etn-event-repeater-options" class="etn-repeater-item repeater_<?php echo esc_attr( $key ); ?>">
                        <div class="form-group mb-3" data-repeater-item>
                        <div onclick="etn_essential_event_reapeater_collapse_public(this)" class="etn-event-repeater-collapsible">
                            <?php echo esc_html( $item['label'] . ' ' . ++$label_no ); ?>
                            <i data-repeater-delete type="button" class="dashicons dashicons-no-alt" aria-hidden="true"></i>
                        </div>
                        <div class="etn-event-repeater-collapsible-content">
                            <?php $i = $x;
                            foreach ( $options_fields as $op_fld_key => $options_field ):
                                $nested_data = isset( $repeater_arr[$i] ) ? $repeater_arr[$i] : [];
                                echo Helper::render( $this->get_repeater_markup( $options_field, $op_fld_key, $nested_data ) );
                            endforeach;
                            ?>
                        </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
    }

    public function get_wp_repeaterpublicnull( $item, $key ) {

        $value          = [];
        $class          = $key;
        $options_fields = $item['options'];

        $count = 1;
        ?>
        <div class='etn-event-repeater-clearfix'>
            <h3><?php echo esc_html( $item['label'] ); ?></h3>
            <?php echo sprintf( "<div class='form-inline etn-event-repeater %s'><div data-repeater-list='%s'>", $class, $key );?>
            <input data-repeater-create type="button" class="etn-btn attr-btn-primary mb-2 clearfix" value="<?php echo esc_html__( "Add", "eventin" ); ?>" />
            <?php
            for ( $x = 0; $x < $count; $x++ ) {
                $label_no = $x;
                ?>
                <div data-repeater-list="etn-event-repeater-options" class="etn-repeater-item">
                    <div class="form-group mb-3" data-repeater-item>

                    <div onclick="etn_essential_event_repeater_collapse_publicnull(this)" class="etn-event-repeater-collapsible">
                        <?php echo esc_html( $item['label'] . ' ' . ++$label_no ); ?>
                        <i data-repeater-delete type="button" class="dashicons dashicons-no-alt" aria-hidden="true"></i>
                    </div>

                    <div class="etn-event-repeater-collapsible-content">
                        <?php $i = $x;
                        foreach ( $options_fields as $op_fld_key => $options_field ):
                            $nested_data = isset( $repeater_arr[$i] ) ? $repeater_arr[$i] : [];
                            echo Helper::render( $this->get_repeater_markup( $options_field, $op_fld_key, $nested_data ) );
                        endforeach;
                        ?>
                    </div>
                    </div>
                </div>
                <?php
            }
            ?>
            <script>
                function etn_essential_event_repeater_collapse_publicnull(e) {

                    e.classList.toggle("etn-repeater-fld-active");
                    var content = e.nextElementSibling;
                    if (content.style.display === "block") {
                    content.style.display = "none";
                    } else {
                    content.style.display = "block";
                    }
                    jQuery('.etn_event_date').datepicker({
                    dateFormat: "yy,MM,dd",
                    onSelect: function() {
                        jQuery(this).val();
                    }
                    });
                    jQuery('.etn_es_event_repeater_select2').select2();
                    jQuery('.etn_es_event_repeater_select2').select2();
                    if (jQuery(e).next().find('span.select2:eq(1)').length) {
                    jQuery(e).next().find('span.select2:eq(1)').hide();
                    }

                }
            </script>
            </div>
        </div>
        <?php
    }

    public function get_wp_social_repeater( $item, $key ) {
        $value        = '';
        $class        = $key;
        $social_items = $key;

        $dbvalue = get_post_meta( get_the_ID(), $key, true );

        require ETN_DIR . '/core/metaboxs/views/fields/icons.php';
        ?>
        <div class='etn-social-clearfix etn-label-item'>
        <div class='etn-label'>
            <label><?php echo esc_html( $item['label'] ); ?></label>
            <div class="etn-desc"><?php echo esc_html( $item['desc'] ); ?></div>
        </div>
        <?php

        if ( is_array( $dbvalue ) ) {
            echo sprintf( "<div class='form-inline etn-meta social-repeater %s'>
            <div class='etn-repeater-wrap' data-repeater-list='%s'>", $class, $social_items );

            foreach ( $dbvalue as $db_socail ) {
                ?>
                    <div data-repeater-item>
                        <div class='etn-form-group mb-2'>
                            <i class='<?php echo esc_attr( $db_socail['icon'] ); ?> show-repeater-icon'></i>
                            <input type='text' value='<?php echo esc_html( $db_socail['icon'] ); ?>' name='icon' class='etn-social-icon etn-form-control' data-toggle='modal' data-target='#etn-event-es-social-modal'/>
                            <input type='text' class='etn-form-control' value='<?php echo esc_html( $db_socail['etn_social_title'] ); ?>' name='etn_social_title' placeholder='<?php echo esc_html__( "title", "eventin" ); ?>' />
                            <input type='text' class='etn-form-control' value='<?php echo esc_html( $db_socail['etn_social_url'] ); ?>' name='etn_social_url' placeholder='<?php echo esc_html__( "url", "eventin" ); ?>' />
                            <button data-repeater-delete type='button' class='etn-btn btn-danger'>
                            <span class='dashicons dashicons-no-alt'></span>
                            </button>
                        </div>
                    </div>
                    <?php
}

            ?>
                </div>
                    <div class='add-social'>
                    <input class='etn-btn attr-btn-primary' data-repeater-create type='button' value='<?php echo esc_html__( "Add Social", "eventin" ); ?>'/>
                    </div>
                </div>
                <?php
} else {
            ?>
                <div class='form-inline etn-meta social-repeater <?php echo esc_attr( $class ); ?>'><div data-repeater-list='<?php echo esc_attr( $social_items ); ?>'>
                    <div data-repeater-item>
                        <div class='etn-form-group mb-2'>
                            <i class=''></i>
                            <input  type='text' name='icon' class='etn-social-icon etn-form-control'  data-toggle='modal' data-target='#etn-event-es-social-modal'/>
                            <input type='text' class='etn-form-control' name='etn_social_title' placeholder='<?php echo esc_html__( "title here", "eventin" ); ?>' />
                            <input type='text' class='etn-form-control' name='etn_social_url' placeholder='<?php echo esc_html__( "url here", "eventin" ); ?>' />
                            <button data-repeater-delete type='button' class='etn-btn btn-danger'>
                                <span class='dashicons dashicons-no-alt'></span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class='add-social'>
                    <input class='etn-btn attr-btn-primary' data-repeater-create type='button' value='<?php echo esc_html__( "Add", "eventin" ); ?>'/>
                </div>
                </div>
                <?php
}

        ?>
        </div>
        <?php
}

    public function get_separator( $item, $key ) {

        $class = $key;

        if ( isset( $item['attr'] ) ) {
            $class = isset( $item['attr']['class'] ) && $item['attr']['class'] != '' ? $item['attr']['class'] . ' etn_event_meta_field' : 'etn_event_meta_field';
        }

        ?>
        <div class='<?php echo esc_attr( $class ); ?>'>
            <hr/>
        </div>
        <?php
}

    public function get_wp_map( $item, $key ) {
        $options = get_option( 'etn_event_general_options' );
        $value   = '';
        $class   = $key;

        if ( isset( $item['value'] ) ) {
            $value = get_post_meta( get_the_ID(), $key, true );
        }

        if ( isset( $item['attr'] ) ) {
            $class = isset( $item['attr']['class'] ) && $item['attr']['class'] != '' ? $item['attr']['class'] . ' etn_event_meta_field ' : ' etn_event_meta_field';
        }

        require ETN_DIR . '/views/fields/map.php';
    }

    public function get_heading( $item, $key ) {

        if ( !isset( $item['label'] ) ) {
            return;
        }

        $class = $key;

        if ( isset( $item['attr'] ) ) {
            $class = isset( $item['attr']['class'] ) && $item['attr']['class'] != '' ? $item['attr']['class'] . ' etn_event_meta_field' : 'etn_event_meta_field';
        }

        $html = sprintf( '<div class="%s">
      <h3 for="%s"> %s  </h3>

     </div>', $class, $key, $item['label'] );

        echo Helper::kses( $html );
    }

    public function get_textinput( $item, $key ) {
        $value = '';
        $class = $key;

        $value = !empty( get_post_meta( get_the_ID(), $key, true ) ) ? get_post_meta( get_the_ID(), $key, true ) : ( !empty( $item['value'] ) ? $item['value'] : "" );

        if ( isset( $item['attr'] ) ) {
            $class = isset( $item['attr']['class'] ) && $item['attr']['class'] != '' ? $item['attr']['class'] . ' etn_event_meta_field' : 'etn_event_meta_field';
        }

        $readonly = ( !empty( $item['readonly'] ) ) ? 'readonly' : "";
        $disabled = ( !empty( $item['disabled'] ) ) ? 'disabled' : "";
        ?>
        <div class="<?php echo esc_html( $class ); ?>">
            <div class="etn-label">
                <label for="<?php echo esc_html( $key ); ?>"> <?php echo esc_html( $item['label'] ); ?> : </label>
                <div class="etn-desc">  <?php echo esc_html( $item['desc'] ); ?>  </div>
            </div>
            <div class="etn-meta">
                <input autocomplete="off" class="etn-form-control" type="<?php echo esc_html( $item['type'] ); ?>" name="<?php echo esc_html( $key ); ?>" id="<?php echo esc_html( $key ); ?>" value="<?php echo esc_html( $value ); ?>" <?php echo esc_html( $readonly ); ?> <?php echo esc_html( $disabled ); ?>/>
            </div>
        </div>
        <?php
    }
    
    public function get_hidden_input( $item, $key ) {
        $value = '';
        $class = $key;

        $value = !empty( get_post_meta( get_the_ID(), $key, true ) ) ? get_post_meta( get_the_ID(), $key, true ) : ( !empty( $item['value'] ) ? $item['value'] : "" );

        if ( isset( $item['attr'] ) ) {
            $class = isset( $item['attr']['class'] ) && $item['attr']['class'] != '' ? $item['attr']['class'] . ' etn_event_meta_field' : 'etn_event_meta_field';
        }

        $readonly = ( !empty( $item['readonly'] ) ) ? 'readonly' : "";
        $disabled = ( !empty( $item['disabled'] ) ) ? 'disabled' : "";
        ?>
        <div class="<?php echo esc_html( $class ); ?>" style='display:none'>
            <div class="etn-label">
                <label for="<?php echo esc_html( $key ); ?>"> <?php echo esc_html( $item['label'] ); ?> : </label>
                <div class="etn-desc">  <?php echo esc_html( $item['desc'] ); ?>  </div>
            </div>
            <div class="etn-meta">
                <input autocomplete="off" class="etn-form-control" type="hidden" name="<?php echo esc_html( $key ); ?>" id="<?php echo esc_html( $key ); ?>" value="<?php echo esc_html( $value ); ?>" <?php echo esc_html( $readonly ); ?> <?php echo esc_html( $disabled ); ?>/>
            </div>
        </div>
        <?php
    }

    public function get_number_input( $item, $key ) {

        $value = '';
        $class = $key;

        if ( isset( $item['value'] ) ) {
            $value = get_post_meta( get_the_ID(), $key, true );
        }

        $value = get_post_meta( get_the_ID(), $key, true );

        $step = isset( $item['step'] ) ? $item['step'] : "1";

        if ( isset( $item['attr'] ) ) {
            $class = isset( $item['attr']['class'] ) && $item['attr']['class'] != '' ? $item['attr']['class'] . ' etn_event_meta_field' : 'etn_event_meta_field';
        }

        $html = sprintf(
            '<div class="%s">
                           <div class="etn-label"> <label for="%s"> %s : </label><div class="etn-desc">%s</div></div>
                           <div class="etn-meta">
                              <input autocomplete="off" class="etn-form-control" type="%s" name="%s" id="%s" value="%s" min="0" step="%s" />
                           </div>
                     </div>', $class, $key, $item['label'], $item['desc'], $item['type'], $key, $key, $value, $step );

        echo Helper::kses( $html );
    }

    public function get_email_input( $item, $key ) {

        $value = '';
        $class = $key;

        if ( isset( $item['value'] ) ) {
            $value = get_post_meta( get_the_ID(), $key, true );
        }

        if ( isset( $item['attr'] ) ) {
            $class = isset( $item['attr']['class'] ) && $item['attr']['class'] != '' ? $item['attr']['class'] . ' etn_event_meta_field ' : ' etn_event_meta_field';
        }

        ?>
        <div class="<?php echo esc_attr( $class ); ?>">
            <div class="etn-label">
                <label for="<?php echo esc_attr( $key ); ?>"> <?php echo esc_html( $item['label'] ); ?> : </label>
                <div class="etn-desc">  <?php echo esc_html( $item['desc'] ); ?>  </div>
            </div>
            <div class="etn-meta">
                <input autocomplete="off" class="etn-form-control" type="<?php echo esc_attr( $item['type'] ); ?>" name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $value ); ?>"/>
            </div>
        </div>
        <?php
}

    public function get_radio_input( $item, $key ) {

        $value = '';
        $class = $key;
        $input = '';

        $value = get_post_meta( get_the_ID(), $key, true );

        if ( isset( $item['attr'] ) ) {
            $class = isset( $item['attr']['class'] ) && $item['attr']['class'] != '' ? $item['attr']['class'] . ' etn_event_meta_field ' : 'etn_event_meta_field ';
        }
        ?>
        <div class="etn-label-item  <?php echo esc_html( $class ); ?>">
            <div class="etn-label">
                <label for="<?php echo esc_html( $key ); ?>"> <?php echo esc_html( $item['label'] ); ?> : </label>
                <div class="etn-desc">  <?php echo esc_html( $item['desc'] ); ?>  </div>
            </div>
            <div class="etn-meta">
                <?php
                if ( isset( $item['options'] ) && !empty( $item['options'] ) ) {
                    $options = $item['options'];
        
                    foreach ( $options as $option_key => $option ) {
                        $checked = ( $option_key == $value ) ? 'checked' : '';
                        ?>
                        <input  <?php echo esc_attr( $checked ); ?> type="<?php echo esc_attr($item['type']); ?>" id="<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ); ?>"  value="<?php echo esc_attr( $option_key ); ?>"/>
                        <span> <?php echo esc_html( $option ); ?>  </span>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
        <?php
    }

    public function get_select2( $item, $key ) {
        $value = '';
        $class = $key;
        $input = '';
        $value = get_post_meta( get_the_ID(), $key, true );

        if ( isset( $item['attr'] ) ) {
            $class = isset( $item['attr']['class'] ) && $item['attr']['class'] != '' ? $item['attr']['class'] . ' etn_event_meta_field' : 'etn_event_meta_field';
        }

        ?>
        <div class="<?php echo esc_attr( $class ); ?>">
            <div class="etn-label">
                <label> <?php echo esc_html( $item['label'] ); ?>  </label>
            </div>
            <?php
            $options = $item['options'];
            ?>
            <select multiple name="<?php echo esc_attr( $key ); ?>[]" class="etn_es_event_select2 <?php echo esc_attr( $key ); ?>">
                <?php
                if ( !empty( $options ) ) {
                    foreach ( $options as $option_key => $option ) {
                        if ( is_array( $value ) && in_array( $option_key, $value ) ) {
                            ?>
                            <option selected value="<?php echo esc_attr( $option_key ); ?>"> <?php echo esc_html( $option ); ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo esc_attr( $option_key ); ?>"> <?php echo esc_html( $option ); ?> </option>
                            <?php
                        }

                    }

                }
                ?>
            </select>
        </div>
        <?php
}

    public function get_select_single( $item, $key ) {
        $value = '';
        $class = $key;
        $input = '';
        $value = get_post_meta( get_the_ID(), $key, true );

        if ( isset( $item['attr'] ) ) {
            $class = isset( $item['attr']['class'] ) && $item['attr']['class'] != '' ? $item['attr']['class'] . ' etn_event_meta_field' : 'etn_event_meta_field';
        }

        ?>
        <div class="<?php echo esc_attr( $class ); ?>">
            <div class="etn-label">
                <label> <?php echo esc_html( $item['label'] ); ?>  </label>
                <div class="etn-desc"><?php echo esc_html( $item['desc'] ); ?></div>
            </div>
            <?php
        $options = $item['options'];
                ?>
                    <select name="<?php echo esc_attr( $key ); ?>" class="etn_es_event_select2 <?php echo esc_attr( $key ); ?>">
                        <?php
        if ( is_array( $options ) && !empty( $options ) ) {
                    foreach ( $options as $option_key => $option ) {
                        if ( $option_key == $value ) {
                            ?>
                                            <option selected value="<?php echo esc_attr( $option_key ); ?>"><?php echo esc_html( $option ); ?></option>
                                            <?php
                } else {
                                    ?>
                                            <option value="<?php echo esc_attr( $option_key ); ?>"><?php echo esc_html( $option ); ?></option>
                                            <?php
                }

        }

        }

        ?>
            </select>
        </div>
        <?php
}

    public function get_url_input( $item, $key ) {
        $value = '';
        $class = $key;

        if ( isset( $item['value'] ) ) {
            $value = get_post_meta( get_the_ID(), $key, true );
        }

        if ( isset( $item['attr'] ) ) {
            $class = isset( $item['attr']['class'] ) && $item['attr']['class'] != '' ? $item['attr']['class'] . ' etn_event_meta_field ' : 'etn_event_meta_field ';
        }

        $html = sprintf( '<div class="%s">
      <div class="etn-label"> <label for="%s"> %s : </label><div class="etn-desc">  %s  </div></div>
      <div class="etn-meta">
                <input class="etn-form-control" type="%s" name="%s" id="%s" value="%s"/>
          </div></div>', $class, $key, $item['label'], $item['desc'], $item['type'], $key, $key, $value );

        echo Helper::kses( $html );
    }

    public function get_upload( $item, $key ) {

        $class      = $key;
        $value      = get_post_meta( get_the_ID(), $key, true );
        $image      = ' button">Upload image';
        $image_size = 'full';
        $display    = 'none';
        $multiple   = 0;

        if ( isset( $item['multiple'] ) && $item['multiple'] ) {
            $multiple = true;
        }

        if ( isset( $item['attr'] ) ) {

            if ( isset( $item['attr']['class'] ) && $item['attr']['class'] != '' ) {
                $class = ' etn_event_meta_field ' . $class . ' ' . $item['attr']['class'];
            } else {
                $class = ' etn_event_meta_field ';
            }

        }

        if ( $image_attributes = wp_get_attachment_image_src( $value, $image_size ) ) {

            $image   = '"><img src="' . $image_attributes[0] . '" alt="" style="max-width:95%;display:block;" />';
            $display = 'inline-block';
        }

        echo "<div class='{$class}'>";
        echo '

      <div class="etn-label"> <label>' . $item['label'] . '</label><div class="etn-desc"> ' . $item['desc'] . ' </div></div>
      <div class="etn-meta">
      <a data-multiple="' . $multiple . '" class="etn_event_upload_image_button' . $image . '</a>
      		<input type="hidden" name="' . $key . '" id="' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '" />
		<a href="#" class="essential_event_remove_image_button" style="display:inline-block;display:' . $display . '">' . esc_html__( 'Remove image', 'eventin' ) . '</a>
        </div></div>';
    }

    public function get_textarea( $item, $key ) {

        $rows  = 30;
        $cols  = 50;
        $value = '';
        $class = $key;

        if ( isset( $item['value'] ) ) {
            $value = get_post_meta( get_the_ID(), $key, true );
        }

        if ( isset( $item['attr'] ) ) {
            $rows  = isset( $item['attr']['row'] ) && $item['attr']['row'] != '' ? $item['attr']['row'] : 30;
            $cols  = isset( $item['attr']['col'] ) && $item['attr']['col'] != '' ? $item['attr']['col'] : 50;
            $class = isset( $item['attr']['class'] ) && $item['attr']['class'] != '' ? $item['attr']['class'] . ' etn_event_meta_field ' : 'etn_event_meta_field ';
        }

        ?>
        <div class="<?php echo esc_attr( $class ); ?> form-group">
            <div class="etn-label">
                <label for="<?php echo esc_attr( $key ); ?>"> <?php echo esc_html( $item['label'] ); ?> : </label>
                <div class="etn-desc">  <?php echo esc_html( $item['desc'] ); ?>  </div>
            </div>
            <div class="etn-meta">
                <textarea class="etn-form-control msg-control-box" id="<?php echo esc_attr( $key ); ?>" rows="<?php echo esc_attr( $rows ); ?>" cols="<?php echo esc_attr( $cols ); ?>" name="<?php echo esc_attr( $key ); ?>"><?php echo Helper::render( $value ) ?></textarea>
            </div>
        </div>
        <?php
}

    public function get_wp_editor( $item, $key ) {

        $rows  = 14;
        $cols  = 50;
        $value = '';
        $class = $key;

        if ( isset( $item['settings'] ) && is_array( $item['settings'] ) ) {
            $settings = $item['settings'];
        }

        if ( isset( $item['value'] ) ) {
            $value = get_post_meta( get_the_ID(), $key, true );
        }

        if ( isset( $item['attr'] ) ) {
            $rows  = isset( $item['attr']['row'] ) && $item['attr']['row'] != '' ? $item['attr']['row'] : 14;
            $cols  = isset( $item['attr']['col'] ) && $item['attr']['col'] != '' ? $item['attr']['col'] : 50;
            $class = isset( $item['attr']['class'] ) && $item['attr']['class'] != '' ? $item['attr']['class'] . ' etn_event_meta_field ' : 'etn_event_meta_field ';
        }

        ?>
        <div class='<?php echo esc_attr( $class ); ?>'>
        <?php
wp_editor( $value, $key, $settings );
        ?>
        </div>
        <?php
}

}
