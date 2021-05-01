<?php
$license                = \Etn_Pro\Utils\License\License::instance();
$settings               = get_option( "etn_premium_marketplace" );
$selected_market_place  = empty( $settings ) ? "" : $settings;
?>

<div class="etn-settings-dashboard etn-license-module-parent">
    <div class="etn-settings-section">
        <div class="etn-marketplace-data-holder">
            <label for="marketplace">
                <h2 class="etn-admin-section-heaer-title etn-main-title"></i><?php esc_html_e("Marketplace", "eventin-pro" ); ?></h2>
            </label>
            <div class="etn-desc"> 
                <?php esc_html_e("Select the market place from where you bought the premium version", "eventin-pro" ); ?>
            </div>
            <div  class="attr-form-group marketplace-save-result">
                <span class="etn-marketplace-save-result"></span>
            </div>
            <div class="etn-marketplace-input-wrapper etn-label-item">
                <div class="etn-marketplace-item">
                    <select class="etn-settings-input input-select etn-select-marketplace" name="marketplace">
                        <option value="select"><?php echo esc_html('Select Marketplace'); ?></option>
                        <option value="codecanyon" <?php selected($selected_market_place, 'codecanyon', true); ?>><?php echo esc_html('CodeCanyon'); ?></option>
                        <option value="themewinter" <?php selected($selected_market_place, 'themewinter', true); ?>><?php echo esc_html('Themewinter'); ?></option>
                    </select>
                </div>

                <div  class="attr-form-group">
                    <button class="etn-btn etn-success etn-btn-save-marketplace"><?php echo esc_html__("save marketplace for future use", "eventin-pro");?></button>
                </div>
            </div>
        </div>
        
        <div class="etn-marketplace-codecanyon">
            <div class="etn_container">
                <div class="etn-admin-section-header">
                    <h2 class="etn-admin-section-heaer-title"><i class="icon icon-key2"></i><?php echo esc_html__("Codecanyon Client", "eventin-pro");?></h2>
                </div>
                <div class="etn-admin-card attr-tab-content etn-admin-card-shadow">
                    <div class="attr-card-body">
                        <p>
                            <?php echo esc_html__("No license key is required for Codecanyon users. You can only use ", "eventin-pro");?>
                            <a href="<?php echo esc_url("https://envato.com/market-plugin/");?>"><?php echo esc_html__("Envato Market"); ?></a>
                            <?php echo esc_html__(" plugin to get auto update of premium version ", "eventin-pro");?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="etn-marketplace-themewinter etn-license-parent">
            <?php
            if( $license->status() !== 'valid' ){
                ?>
                <div class="etn_container">
                    <form action="" method="POST" class="etn-admin-form" id="etn-admin-license-form">
                        <div class="etn_tab_wraper">
                            <div class="etn-admin-section-header">
                                <h2 class="etn-admin-section-heaer-title"><i class="icon icon-key2"></i><?php echo esc_html__("Themewinter CLient", "eventin-pro");?></h2>
                            </div>
                            <div class="etn-admin-card attr-tab-content etn-admin-card-shadow">
                                <div class="attr-card-body">
                                    <p>
                                        <?php echo esc_html__("Enter your license key here, to get auto updates.", "eventin-pro");?>
                                    </p>
                                    <ol class="etn-license-link">
                                        <li><?php echo esc_html__("If you don", "eventin-pro"); ?>&#039;<?php echo esc_html__("t yet have a license key, get ", "eventin-pro"); ?><a href="https://themewinter.com/eventin" target="_blank"><?php echo esc_html__("Eventin Pro", "eventin-pro"); ?></a><?php echo esc_html__(" now.", "eventin-pro");?></li>
                                        <li><?php echo esc_html__( "Log in to your ", "eventin-pro" ); ?><a href="https://themewinter.com/purchase-history/" target="_blank"><?php echo esc_html__("Themewinter account", "eventin-pro"); ?></a><?php echo esc_html__(" to get your license key.", "eventin-pro");?></li>
                                        <li><?php echo esc_html__("Copy the Eventin license key from your account and paste it below.", "eventin-pro");?></li>
                                        <li><?php echo esc_html__("Follow the ", "eventin-pro");?> 
                                            <a href="https://support.themewinter.com/docs/plugins/docs/license/" target="_blank"><?php echo esc_html__("Official Documentation", "eventin-pro"); ?></a>
                                            <?php echo esc_html__("for details ", "eventin-pro");?> 
                                        </li>
                                    </ol>
                                    <div><label class="etn-admin-option-text-etn-license-key" for="etn-admin-option-text-etn-license-key" ><?php echo esc_html__("Your License Key", "eventin-pro");?></label></div>
                                    <div class="etn-admin-input-text  etn-license-input-box">
                                        <input
                                            type="text"
                                            class="attr-form-control"
                                            id="etn-admin-option-text-etn-license-key"
                                            aria-describedby="etn-admin-option-text-help-etn-license-key"
                                            placeholder="Please insert your license key here"
                                            name="elementkit_pro_license_key"
                                            value=""
                                        >
                                    </div>
                                    <div class="etn-license-form-result etn-license-input-box">
                                        <p class="attr-alert attr-alert-info">
                                            <?php echo esc_html__("Still can", "eventin-pro");?>&#039;<?php echo esc_html__("t find your license key? ", "eventin-pro");?><a target="_blank" href="http://support.themewinter.com/support-center/login"><?php echo esc_html__("Knock us here!", "eventin-pro");?></a>
                                        </p>
                                    </div>
                                    <div class="attr-input-group-btn etn-license-input-box">
                                        <input type="hidden" name="type" value="activate" />
                                        <button class="attr-btn btn-license-activate attr-btn-primary etn-admin-license-form-submit" type="submit" ><div class="etn-spinner"></div><i class="etn-admin-save-icon fa fa-check-circle"></i> <?php echo esc_html__("Activate", "eventin-pro");?></button>
                                    </div>
                                    <div class="etn-license-result-box">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <?php
            } else {
                ?>
                <div class="etn-license-form-result">
                    <p class="attr-alert attr-alert-success">
                        <?php 
                        echo esc_html__("Congratulations! Your product is activated for '". parse_url(home_url(), PHP_URL_HOST) ."'.", 'eventin-pro');
                        ?>
                    </p>
                    <a href="#" class='etn-btn etn-btn-secondary etn-revoke-license-text'><?php echo esc_html__('Revoke License', 'eventin-pro');?></a>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>
