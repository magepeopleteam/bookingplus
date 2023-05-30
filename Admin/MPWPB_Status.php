<?phpif (!defined('ABSPATH')) {    die;} // Cannot access pages directly.if (!class_exists('MPWPB_Status')) {    class MPWPB_Status {        public function __construct() {            add_action('admin_menu', array($this, 'status_menu'));        }        public function status_menu() {            $cpt = MPWPB_Function::get_cpt();            add_submenu_page('edit.php?post_type=' . $cpt, __('Status', 'service-booking-manager'), __('<span style="color:yellow">Status</span>', 'service-booking-manager'), 'manage_options', 'mpwpb_status_page', array($this, 'status_page'));        }        public function status_page() {            $label = MPWPB_Function::get_name();            $wc_i = MP_Global_Function::check_woocommerce();            $wc_i_text = $wc_i == 1 ? esc_html__('Yes', 'service-booking-manager') : esc_html__('No', 'service-booking-manager');            $wp_v = get_bloginfo('version');            $wc_v = WC()->version;            $from_name = get_option('woocommerce_email_from_name');            $from_email = get_option('woocommerce_email_from_address');            ?>            <div class="wrap">            </div>            <div class="mpStyle">                <?php do_action('mp_status_notice_sec'); ?>                <div class=_dShadow_6_adminLayout">                    <h2 class="textCenter"><?php echo esc_html($label) . '  ' . esc_html__('For Woocommerce Environment Status', 'service-booking-manager'); ?></h2>                    <div class="divider"></div>                    <table>                        <tbody>                        <tr>                            <th data-export-label="WC Version"><?php esc_html_e('WordPress Version : ', 'service-booking-manager'); ?></th>                            <th class="<?php echo esc_attr($wp_v > 5.5 ? 'textSuccess' : 'textWarning'); ?>">                                <span class="<?php echo esc_attr($wp_v > 5.5 ? 'far fa-check-circle' : 'fas fa-exclamation-triangle'); ?> mR_xs"></span><?php echo esc_html($wp_v); ?>                            </th>                        </tr>                        <tr>                            <th data-export-label="WC Version"><?php esc_html_e('Woocommerce Installed : ', 'service-booking-manager'); ?></th>                            <th class="<?php echo esc_attr($wc_i == 1 ? 'textSuccess' : 'textWarning'); ?>">                                <span class="<?php echo esc_attr($wc_i == 1 ? 'far fa-check-circle' : 'fas fa-exclamation-triangle'); ?> mR_xs"></span><?php echo esc_html($wc_i_text); ?>                            </th>                        </tr>                        <?php if ($wc_i == 1) { ?>                            <tr>                                <th data-export-label="WC Version"><?php esc_html_e('Woocommerce Version : ', 'service-booking-manager'); ?></th>                                <th class="<?php echo esc_attr($wc_v > 4.8 ? 'textSuccess' : 'textWarning'); ?>">                                    <span class="<?php echo esc_attr($wc_v > 4.8 ? 'far fa-check-circle' : 'fas fa-exclamation-triangle'); ?> mR_xs"></span><?php echo esc_html($wc_v); ?>                                </th>                            </tr>                            <tr>                                <th data-export-label="WC Version"><?php esc_html_e('Name : ', 'service-booking-manager'); ?></th>                                <th class="<?php echo esc_attr($from_name ? 'textSuccess' : 'textWarning'); ?>">                                    <span class="<?php echo esc_attr($from_name ? 'far fa-check-circle' : 'fas fa-exclamation-triangle'); ?> mR_xs"></span><?php echo esc_html($from_name); ?>                                </th>                            </tr>                            <tr>                                <th data-export-label="WC Version"><?php esc_html_e('Email Address : ', 'service-booking-manager'); ?></th>                                <th class="<?php echo esc_attr($from_email ? 'textSuccess' : 'textWarning'); ?>">                                    <span class="<?php echo esc_attr($from_email ? 'far fa-check-circle' : 'fas fa-exclamation-triangle'); ?> mR_xs"></span><?php echo esc_html($from_email); ?>                                </th>                            </tr>                        <?php }                        do_action('mp_status_table_item_sec'); ?>                        </tbody>                    </table>                </div>            </div>            <?php        }    }    new MPWPB_Status();}