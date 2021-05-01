<?php
namespace Etn_Pro\Core\Event;

defined( 'ABSPATH' ) || exit;

use Etn\Base\Cron as Base_Cron;
use Etn\Core\Settings\Settings as SettingsFree;
use Etn_Pro\Utils\Helper;

class Cron extends Base_Cron{

    use \Etn\Traits\Singleton;

    public $hook_name = 'send_remainder_email_hook';

    /**
     * Register event and chanage schedule
     */
    public function init(){
        // register event
        $this->config();
    }

    /**
     * Do the task
     * Register cron schedule to remove faild status attendee
     */
    public function action_name(){
        
        if ( !current_user_can('manage_options')) {
            return;
         }
         $query = array(
             'post_type'      => 'etn',
             'post_status'    => 'publish',
         );
         $current_time       = date('Y-m-d H:i');
         $get_all_posts      = get_posts( $query );
         $settings           = SettingsFree::instance()->get_settings_option();
         $admin_mail_addr    = $settings['admin_mail_address'];
         $remainder_time     = isset($settings['remainder_email_sending_day']) ? (int) $settings['remainder_email_sending_day'] : 0;
         $remainder_message  = isset($settings['remainder_message']) ? $settings['remainder_message'] : "You have an uncoming event.";
 
         if (is_array($get_all_posts) && count( $get_all_posts )>0 ) {
             foreach ($get_all_posts as $key=>$post) {
                 $event_start_date   = get_post_meta( $post->ID , 'etn_start_date' , true );
                 // mail will be sent the day before at 12pm.
                 $schedule_day       = date_i18n('Y-m-d H:i',strtotime( $event_start_date . '-' .$remainder_time .' day' .'12:00'));
                 if ($current_time >= $schedule_day ) {
                     $attendee_list = \Etn_Pro\Core\Action::instance()->total_attendee( $post->ID, true );
                     if ( is_array( $attendee_list ) &&  count( $attendee_list )>0  ) {
                         foreach ( $attendee_list as $key => $value) {
                             $mail_subject    = esc_html__("Email remainder","eventin-pro");
                             $mail_body       = $remainder_message;
                             if ( isset($value->email) && $admin_mail_addr !=='' ) {
                                 Helper::send_email( $value->email, $mail_subject , $mail_body , $admin_mail_addr , 'Admin' );
                             }
                         }
                     }
                 }
             }
        }
    }

    /**
     * recurrence action name
     */
    public function recurrence_action(){

        return 'twicedaily';
    }

}