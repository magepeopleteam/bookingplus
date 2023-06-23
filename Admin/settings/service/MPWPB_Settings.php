<?php
	if (!defined('ABSPATH')) {
		die;
	} // Cannot access pages directly.
	if (!class_exists('MPWPB_Settings')) {
		class MPWPB_Settings {
			public function __construct() {
				add_action('add_meta_boxes', [$this, 'settings_meta']);
				add_action('save_post', array($this, 'save_settings'), 99, 1);
			}
			//************************//
			public function settings_meta() {
				$label = MPWPB_Function::get_name();
				$cpt = MPWPB_Function::get_cpt();
				add_meta_box('mp_meta_box_panel', '<span class="fas fa-cogs"></span>' . $label . esc_html__(' Information Settings : ', 'service-booking-manager') . get_the_title(get_the_id()), array($this, 'settings'), $cpt, 'normal', 'high');
			}
			//******************************//
			public function settings() {
				$post_id = get_the_id();
				wp_nonce_field('mpwpb_nonce', 'mpwpb_nonce');
				?>
				<div class="mpStyle">
					<div class="mpTabs leftTabs">
						<ul class="tabLists">
							<li data-tabs-target="#mpwpb_general_info">
								<span class="fas fa-tools"></span><?php esc_html_e('General Info', 'service-booking-manager'); ?>
							</li>
							<li data-tabs-target="#mpwpb_price_settings">
								<span class="fas fa-hand-holding-usd"></span><?php esc_html_e('Pricing', 'service-booking-manager'); ?>
							</li>
							<li data-tabs-target="#mpwpb_settings_date_time">
								<span class="far fa-clock"></span><?php esc_html_e('Date & Time', 'service-booking-manager'); ?>
							</li>
							<?php do_action('add_mpwpb_settings_tab_after_date', $post_id); ?>
						</ul>
						<div class="tabsContent">
							<?php do_action('add_mpwpb_settings_tab_content', $post_id); ?>
						</div>
					</div>
				</div>
				<?php
			}
			public function save_settings($post_id) {
				if (!isset($_POST['mpwpb_nonce']) || !wp_verify_nonce($_POST['mpwpb_nonce'], 'mpwpb_nonce') && defined('DOING_AUTOSAVE') && DOING_AUTOSAVE && !current_user_can('edit_post', $post_id)) {
					return;
				}
				do_action('mpwpb_settings_save', $post_id);
			}
			public static function description_array($key) {
				$des = array('mpwpb_category_active' => esc_html__('By default Category  is ON but you can keep it off by switching this option', 'service-booking-manager'), 'mpwpb_sub_category_active' => esc_html__('By default Sub-Category  is ON but you can keep it off by switching this option', 'service-booking-manager'), 'mpwpb_service_details_active' => esc_html__('By default Service Details  is OFF but you can keep it ON by switching this option', 'service-booking-manager'), 'mpwpb_service_duration_active' => esc_html__('By default Service Duration  is ON but you can keep it OFF by switching this option', 'service-booking-manager'), 'mpwpb_extra_service_active' => esc_html__('By default extra service  is OFF but you can keep it ON by switching this option', 'service-booking-manager'), //======Slider==========//
				             'mpwpb_display_slider' => esc_html__('By default slider is ON but you can keep it off by switching this option', 'service-booking-manager'), 'mpwpb_slider_images' => esc_html__('Please upload images for gallery', 'service-booking-manager'),//''          => esc_html__( '', 'service-booking-manager' ),
				);
				$des = apply_filters('mptbm_filter_description_array', $des);
				return $des[$key];
			}
			public static function info_text($key) {
				$data = self::description_array($key);
				if ($data) {
					?>
					<i class="info_text">
						<span class="fas fa-info-circle"></span>
						<?php echo esc_html($data); ?>
					</i>
					<?php
				}
			}
		}
		new MPWPB_Settings();
	}