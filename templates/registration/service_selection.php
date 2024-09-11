<?php
	/*
   * @Author 		engr.sumonazma@gmail.com
   * Copyright: 	mage-people.com
   */
	if (!defined('ABSPATH')) {
		exit;
	}
	$post_id = $post_id ?? get_the_id();
	$all_category = $all_category ?? MPWPB_Function::get_category($post_id);
	$all_services = $all_services ?? MP_Global_Function::get_post_info($post_id, 'mpwpb_category_infos', array());
	$all_sub_category = $all_sub_category ?? MPWPB_Function::get_sub_category($post_id);
	$all_service_list = $all_service_list ?? MPWPB_Function::get_all_service($post_id);
	$category_text = $category_text ?? MPWPB_Function::get_category_text($post_id);
	$sub_category_text = $sub_category_text ?? MPWPB_Function::get_sub_category_text($post_id);
	$service_text = $service_text ?? MPWPB_Function::get_service_text($post_id);
	$extra_services = $extra_services ?? MP_Global_Function::get_post_info($post_id, 'mpwpb_extra_service', array());
	if (sizeof($all_service_list) > 0) {
		//echo '<pre>';print_r($all_services);echo '</pre>';
		?>
        <div class="_dShadow_7_mB_xs mpwpb_service_area">
            <header>
                <input type="hidden" name="mpwpb_category" value="">
                <input type="hidden" name="mpwpb_sub_category" value="">
                <h5><?php echo esc_html__('Select', 'service-booking-manager') . ' ' . $service_text; ?></h5>
            </header>
			<?php
				foreach ($all_service_list as $service_item) {
					$category_name = array_key_exists('category', $service_item) ? $service_item['category'] : '';
					$sub_category_name = array_key_exists('sub_category', $service_item) ? $service_item['sub_category'] : '';
					$service_name = array_key_exists('service', $service_item) ? $service_item['service'] : '';
					$service_image = array_key_exists('image', $service_item) ? $service_item['image'] : '';
					$service_icon = array_key_exists('icon', $service_item) ? $service_item['icon'] : '';
					$service_price = array_key_exists('price', $service_item) ? $service_item['price'] : 0;
					$service_price = MPWPB_Function::get_price($post_id, $service_name, $category_name, $sub_category_name);
					$service_details = array_key_exists('details', $service_item) ? $service_item['details'] : '';
					$service_duration = array_key_exists('duration', $service_item) ? $service_item['duration'] : '';
					$unique_id         = '#service_' . uniqid();
					?>
                    <div class="mpwpb_item_box mpwpb_service_item" data-price="<?php echo esc_attr($service_price); ?>" data-category="<?php echo esc_attr($category_name); ?>" data-sub-category="<?php echo esc_attr($sub_category_name); ?>" data-service="<?php echo esc_attr($service_name); ?>">
                        <input type="hidden" name="mpwpb_service[]" value="">
                        <div class="dFlex">

                            <div class="_dFlex_justifyBetween_fullWidth">
                                <div class="alignCenter">
									<?php if ($service_icon) { ?>
                                        <span class="<?php echo esc_attr($service_icon); ?> mR_xs"></span>
									<?php } ?>
	                                <?php if ($service_image) { ?>
                                        <div class="bg_image_area">
                                            <div data-bg-image="<?php echo esc_attr(MP_Global_Function::get_image_url('', $service_image, 'medium')); ?>"></div>
                                        </div>
	                                <?php } ?>
                                    <h6><?php echo esc_html($service_name); ?></h6>
                                    <div class="_mL_xs" data-collapse-target="<?php echo esc_attr( $unique_id ); ?>" data-read data-open-text="<?php esc_attr_e('Load More', 'service-booking-manager'); ?>" data-close-text="<?php esc_attr_e('Less More', 'service-booking-manager'); ?>">
                                        <span data-text><?php esc_html_e('Load More', 'service-booking-manager'); ?></span>
                                    </div>
                                </div>
                                <h6 class="_textTheme_min_100"><?php echo wc_price($service_price); ?></h6>
	                            <?php if ($service_duration) { ?>
                                    <h6 class="textTheme alignCenter">
                                        <span class="fas fa-clock mR_xs"></span>
                                        <span><?php echo MP_Global_Function::esc_html($service_duration); ?></span>
                                    </h6>
	                            <?php } ?>
                                <button type="button" class="_mpBtn_btLight_2_min_150 mpwpb_price_calculation"  data-open-icon="far fa-check-circle" data-close-icon="" data-open-text="<?php esc_attr_e( 'Select', 'service-booking-manager' ); ?>" data-close-text="<?php esc_attr_e( 'Selected', 'service-booking-manager' ); ?>" data-add-class="mActive">
                                    <span data-text><?php esc_html_e( 'Select', 'service-booking-manager' ); ?></span>
                                    <span data-icon class="mL_xs"></span>
                                </button>

                            </div>
                        </div>
                        <span class="fas fa-check mpwpb_item_check _circleIcon_xs"></span>
                        <div data-collapse="<?php echo esc_attr( $unique_id ); ?>" ><?php echo esc_html($service_details); ?></div>
                    </div>
				<?php } ?>
        </div>
		<?php
	}