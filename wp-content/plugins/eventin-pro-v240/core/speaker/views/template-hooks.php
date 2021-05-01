<?php
defined( 'ABSPATH' ) || exit;

	// Call all hooks functions
	pro_init_speaker_template();

	function pro_init_speaker_template(){
		// Single page template hooks 
		$settings      = \Etn\Core\Settings\Settings::instance()->get_settings_option();
		$template_name = isset($settings['speaker_template']) && !is_null($settings['speaker_template']) && !empty($settings['speaker_template']) ? $settings['speaker_template'] : 'speaker-one';
				
		if ( ( ETN_DEMO_SITE === true ) || ( ETN_DEMO_SITE === false && 'speaker-two' === $template_name ) ) {
			style_two_hook();
		}
			
		if ( ( ETN_DEMO_SITE === true ) || ( ETN_DEMO_SITE === false && 'speaker-three' === $template_name ) ) {
			style_three_hook();
		}

	}

	function style_two_hook(){

		/**
		 * @see speaker_two_company()
		 */
		add_action("etn_speaker_two_company", "speaker_two_company" , 10 );

		/**
		 * @see speaker_two_designation()
		 */
		add_action("etn_speaker_two_designation", "speaker_two_designation" , 11 );

		/**
		 * @see speaker_two_meta()
		 */
		add_action("etn_speaker_two_meta", "speaker_two_meta" , 12 );

		/**
		 * @see speaker_two_social()
		 */
		add_action("etn_speaker_two_social", "speaker_two_social" , 13 );

		/**
		 * @see speaker_two_summary()
		 */
		add_action("etn_speaker_two_summary", "speaker_two_summary" , 14 );

		/**
		 * @see speaker_two_sessions_title()
		 */
		add_action("etn_speaker_two_sessions_title", "speaker_two_sessions_title", 15 );

		/**
		 * @see speaker_two_sessions_details_before()
		 */
		add_action("etn_speaker_two_sessions_details_before", "speaker_two_sessions_details_before" , 16  );

		/**
		 * @see speaker_two_sessions_details()
		 */
		add_action("etn_speaker_two_sessions_details", "speaker_two_sessions_details" , 17 , 1 );
		
		/**
		 * @see speaker_two_sessions_details_after()
		 */
		add_action("etn_speaker_two_sessions_details_after", "speaker_two_sessions_details_after" , 22  );


		/**
		 * @see schedule_two_header()
		 */
		add_action("etn_schedule_two_header", "schedule_two_header" , 18 , 2 );


		/**
		 * @see schedule_session_time()
		 */
		add_action("etn_schedule_two_session_time", "schedule_two_session_time" , 19 , 2 );

		/**
		 * @see schedule_two_session_title()
		 */
		add_action("etn_schedule_two_session_title", "schedule_two_session_title", 20 );

		/**
		 * @see schedule_two_session_location()
		 */
		add_action("etn_schedule_two_session_location", "schedule_two_session_location" , 21 );

	}

	function style_three_hook(){
		
		/**
		 * @see speaker_three_designation()
		 */
		add_action("etn_speaker_three_designation", "speaker_three_designation" , 10 );

		/**
		 * @see speaker_three_meta()
		 */
		add_action("etn_speaker_three_meta", "speaker_three_meta" , 11 );

		/**
		 * @see speaker_three_social()
		 */
		add_action("etn_speaker_three_social", "speaker_three_social" , 12 );

		/**
		 * @see speaker_three_summary()
		 */
		add_action("etn_speaker_three_summary", "speaker_three_summary" , 13 );

		/**
		 * @see speaker_three_details_before()
		 */
		add_action("etn_speaker_three_details_before", "speaker_three_details_before" , 15 );

		/**
		 * @see schedule_three_header()
		 */
		add_action("etn_schedule_three_header", "schedule_three_header" , 16 );

		/**
		 * @see schedule_three_session_time()
		 */
		add_action("etn_schedule_three_session_time", "schedule_three_session_time" , 17 , 2  );

		/**
		 * @see schedule_three_session_topic()
		 */
		add_action("etn_schedule_three_session_topic", "schedule_three_session_topic" , 18 , 1  );

		/**
		 * @see schedule_three_session_location()
		 */
		add_action("etn_schedule_three_session_location", "schedule_three_session_location" , 19 , 1  );

		/**
		 * @see speaker_three_details_after()
		 */
		add_action("etn_speaker_three_details_after", "speaker_three_details_after" , 20 );

	}









