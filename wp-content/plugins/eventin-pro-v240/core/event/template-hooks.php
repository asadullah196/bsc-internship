<?php
/**
 * Eventin Template Hooks
 *
 * Action/filter hooks used for Eventin functions/templates.
 *
 * @package Eventin\Templates
 * @version 2.3.2
 */

defined( 'ABSPATH' ) || exit;

$current_template = !empty( \Etn\Core\Settings\Settings::instance()->get_settings_option()['event_template'] ) ? \Etn\Core\Settings\Settings::instance()->get_settings_option()['event_template'] : "event-one";

if( ( ETN_DEMO_SITE == true ) || ( ETN_DEMO_SITE === false && "event-two" === $current_template ) ) {

        /**
         * @see etn_pro_after_single_event_two_content_organizer()
         */
        add_action("etn_after_single_event_content_wrap", "etn_pro_after_single_event_two_content_organizer", 10);

        /**
         * @see etn_pro_after_single_event_content_faq()
         */
        add_action("etn_after_single_event_content_wrap", "etn_pro_after_single_event_content_faq", 11);

        /**
         * @see etn_pro_before_single_event_content_title_show_categories()
         */
        add_action("etn_before_single_event_content_title", "etn_pro_before_single_event_content_title_show_categories", 10);

        /**
         * @see etn_pro_before_single_event_two_details_show_banner_module()
         */
        add_action("etn_before_single_event_details", "etn_pro_before_single_event_two_details_show_banner_module", 10);

        /**
         * @see etn_pro_before_single_event_two_details_show_location_and_counter()
         */
        add_action("etn_before_single_event_details", "etn_pro_before_single_event_two_details_show_location_and_counter", 11);

        /**
         * @see etn_pro_after_single_event_content_body_show_tags()
         */
        add_action("etn_after_single_event_content_body", "etn_pro_after_single_event_content_body_show_tags", 10);

        /**
         * @see etn_pro_after_single_event_content_body_show_schedules()
         */
        add_action("etn_after_single_event_content_body", "etn_pro_after_single_event_content_body_show_schedules", 11);
        
        /**
         * @see etn_pro_single_event_meta_details()
         */
        add_action("etn_single_event_meta", "etn_pro_single_event_meta_details", 10);

        /**
         * @see etn_after_single_event_meta_ticket_form()
         */
        add_action("etn_after_single_event_meta", "etn_after_single_event_meta_ticket_form", 10);

        /**
         * @see etn_after_single_event_meta_attendee_list()
         */
        add_action("etn_after_single_event_meta", "etn_after_single_event_meta_attendee_list", 11);

        /**
         * @see etn_pro_after_single_event_meta_related_events()
         */
        add_action("etn_after_single_event_meta", "etn_pro_after_single_event_meta_related_events", 12);
}
        
if( ( ETN_DEMO_SITE == true ) || ( ETN_DEMO_SITE === false && "event-three" === $current_template ) ) {
        
        /**
         * @see etn_pro_before_single_event_three_details_show_banner_module()
         */
        add_action("etn_before_single_event_details", "etn_pro_before_single_event_three_details_show_banner_module", 10);
        
        /**
         * @see etn_pro_after_single_event_three_content_organizer()
         */
        add_action("etn_after_single_event_content_wrap", "etn_pro_after_single_event_three_content_organizer", 11);

        /**
         * @see etn_pro_after_single_event_content_faq()
         */
        add_action("etn_after_single_event_content_wrap", "etn_pro_after_single_event_content_faq", 10);
        
        /**
         * @see etn_pro_after_single_event_content_body_show_tags()
         */
        add_action("etn_after_single_event_content_body", "etn_pro_after_single_event_content_body_show_tags", 10);

        /**
         * @see etn_pro_after_single_event_content_body_show_schedules()
         */
        add_action("etn_after_single_event_content_body", "etn_pro_after_single_event_content_body_show_schedules", 11);

        /**
         * @see etn_pro_after_single_event_meta_related_events()
         */
        add_action("etn_after_single_event_meta", "etn_pro_after_single_event_meta_related_events", 12);

        /**
         * @see etn_after_single_event_meta_attendee_list()
         */
        add_action("etn_after_single_event_meta", "etn_after_single_event_meta_attendee_list", 11);

        /**
         * @see etn_after_single_event_meta_ticket_form()
         */
        add_action("etn_after_single_event_meta", "etn_after_single_event_meta_ticket_form", 10);
           
        /**
         * @see etn_pro_single_event_meta_details()
         */
        add_action("etn_single_event_meta", "etn_pro_single_event_meta_details", 10);

        /**
         * @see etn_pro_after_single_event_three_content_title_show_counter()
         */
        add_action("etn_after_single_event_content_title", "etn_pro_after_single_event_three_content_title_show_counter", 11);

        /**
         * @see etn_pro_before_single_event_content_title_show_categories()
         */
        add_action("etn_before_single_event_content_title", "etn_pro_before_single_event_content_title_show_categories", 10);

        /**
         * @see etn_pro_after_single_event_three_content_title_show_meta()
         */
        add_action("etn_after_single_event_content_title", "etn_pro_after_single_event_three_content_title_show_meta", 10);
        
}
