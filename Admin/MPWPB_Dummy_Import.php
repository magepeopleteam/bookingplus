<?php
	/*
   * @Author 		engr.sumonazma@gmail.com
   * Copyright: 	mage-people.com
   */
	if (!defined('ABSPATH')) {
		die;
	} // Cannot access pages directly.
	if (!class_exists('MPWPB_Dummy_Import')) {
		class MPWPB_Dummy_Import {
			public function __construct() {
				$this->dummy_import();
				$this->dummy_import_xml();

			}
			private function dummy_import() {
				$dummy_post = get_option('mpwpb_dummy_already_inserted');
				$all_post = MP_Global_Function::query_post_type('mpwpb_item');
				if ($all_post->post_count == 0 && $dummy_post != 'yes') {
					$dummy_data = $this->dummy_import_xml();
					foreach ($dummy_data as $type => $dummy) {
						if ($type == 'taxonomy') {
							foreach ($dummy as $taxonomy => $dummy_taxonomy) {
								$check_taxonomy = MP_Global_Function::get_taxonomy($taxonomy);
								if (is_string($check_taxonomy) || sizeof($check_taxonomy) == 0) {
									foreach ($dummy_taxonomy as $taxonomy_data) {
										wp_insert_term($taxonomy_data['name'], $taxonomy);
									}
								}
							}
						}
						if ($type == 'custom_post') {
							foreach ($dummy as $custom_post => $dummy_post) {
								$post = MP_Global_Function::query_post_type($custom_post);
								if ($post->post_count == 0) {
									foreach ($dummy_post as $dummy_data) {
										$title = $dummy_data['name'];
										$post_id = wp_insert_post([
											'post_title' => $title,
											'post_status' => 'publish',
											'post_type' => $custom_post
										]);
										if (array_key_exists('post_data', $dummy_data)) {
											foreach ($dummy_data['post_data'] as $meta_key => $data) {
												update_post_meta($post_id, $meta_key, $data);
											}
										}
									}
								}
							}
						}
					}
					update_option('mpwpb_dummy_already_inserted', 'yes');
				}
			}
			public function dummy_data(): array {
				return [
					'taxonomy' => [
						// 'mpwpb_category' => [
						// 	0 => ['name' => 'Fixed Tour'],
						// 	1 => ['name' => 'Flexible Tour']
						// ],
					],
					'custom_post' => [
						'mpwpb_item' => [
							0 => [
								'name' => 'Rent Your Dream Car',
								'post_data' => [
									//General_settings
									'mpwpb_shortcode_title' => 'Rent-A-Car Service',
									'mpwpb_shortcode_sub_title' => 'Rent your dream car easily with affordable price',
									//date_settings
									'mpwpb_service_start_date' => '2023-01-01',
									'mpwpb_service_end_date' => '2023-06-30',
									'mpwpb_friday_start_time' => '',
									'mpwpb_friday_end_time'=> '',
									'mpwpb_friday_start_break_time'=> '',
									'mpwpb_friday_end_break_time'=> '',
									'mpwpb_saturday_start_time'=> '',
									'mpwpb_saturday_end_time'=> '',
									'mpwpb_saturday_start_break_time'=> '',
									'mpwpb_saturday_end_break_time'=> '',
									'mpwpb_sunday_start_time'=> '',
									'mpwpb_sunday_end_time'=> '',
									'mpwpb_sunday_start_break_time'=> '',
									'mpwpb_sunday_end_break_time'=> '',
									'mpwpb_form_id'=> '',
									'mpwpb_date_type'=> 'repeated',
									'mpwpb_particular_dates'=> [],
									'mpwpb_repeated_start_date'=> '',
									'mpwpb_repeated_after'=> '',
									'mpwpb_active_days'=> '10',
									'mpwpb_theme_file'=> 'static.php',
									'mpwpb_time_slot_length' => '60',
									'mpwpb_capacity_per_session' => '1',
									'mpwpb_default_start_time' => '10',
									'mpwpb_default_end_time' => '18',
									'mpwpb_default_start_break_time' => '13',
									'mpwpb_default_end_break_time' => '15',
									'mpwpb_monday_start_time' => '10',
									'mpwpb_monday_end_time' => '18',
									'mpwpb_monday_start_break_time' => '13',
									'mpwpb_monday_end_break_time' => '15',
									'mpwpb_tuesday_start_time' => '10.5',
									'mpwpb_tuesday_end_time' => '18.5',
									'mpwpb_tuesday_start_break_time' => '13.5',
									'mpwpb_tuesday_end_break_time' => '15.5',
									'mpwpb_wednesday_start_time' => '11',
									'mpwpb_wednesday_end_time' => '19',
									'mpwpb_wednesday_start_break_time' => '14',
									'mpwpb_wednesday_end_break_time' => '16',
									'mpwpb_thursday_start_time' => '10',
									'mpwpb_thursday_end_time' => '18',
									'mpwpb_thursday_start_break_time' => '13',
									'mpwpb_thursday_end_break_time' => '15',
									'mpwpb_off_days' => 'saturday,sunday',
									'mpwpb_off_dates' => array(
										0 => '2023-03-07',
										1 => '2023-03-15',
									),
									//price_settings
									'mpwpb_category_active' => 'on',
									'mpwpb_sub_category_active' => 'off',
									'mpwpb_service_details_active' => 'off',
									'mpwpb_service_duration_active' => 'on',
									'mpwpb_category_text' => 'Car Type',
									'mpwpb_sub_category_text' => '',
									'mpwpb_service_text' => 'Service',
									'mpwpb_category_infos' => array(
										0 => array(
											'icon' => 'fas fa-car',
											'image' => '',
											'category' => 'Economy Car',
											'sub_category' => array(
												0 => array(
													'icon' => '',
													'image' => '',
													'name' => '',
													'service' => array(
														0 => array(
															'name' => 'Casinos',
															'price' => '10',
															'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
															'duration' => '1h',
															'icon' => 'fas fa-gifts',
															'image' => '',
														),
														1 => array(
															'name' => 'Birthdays',
															'price' => '10',
															'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
															'duration' => '1h',
															'icon' => 'fas fa-coffee',
															'image' => '',
														),
														2 => array(
															'name' => 'Airport Transfer',
															'price' => '10',
															'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
															'duration' => '1h',
															'icon' => 'fas fa-car-side',
															'image' => '',
														),
													)
												)
											)
										),
										1 => array(
											'icon' => 'fas fa-shuttle-van',
											'image' => '',
											'category' => 'Standard Car',
											'sub_category' => array(
												0 => array(
													'icon' => '',
													'image' => '',
													'name' => '',
													'service' => array(
														0 => array(
															'name' => 'Weddings',
															'price' => '10',
															'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
															'duration' => '1h',
															'icon' => 'fas fa-gifts',
															'image' => '',
														),
													)
												)
											)
										),
										2 => array(
											'icon' => 'fas fa-car-side',
											'image' => '',
											'category' => 'SUV Car',
											'sub_category' => array(
												0 => array(
													'icon' => '',
													'image' => '',
													'name' => '',
													'service' => array(
														0 => array(
															'name' => 'Night Parties Long Drive',
															'price' => '10',
															'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
															'duration' => '1h',
															'icon' => 'fas fa-gifts',
															'image' => '',
														),
													)
												)
											)
										),
									),
									'mpwpb_extra_service_active' => 'on',
									'mpwpb_group_extra_service_active' => 'off',
									'mpwpb_extra_service' => array(
										0 => array(
											'group_service' => '',
											'group_service_info' => array(
												0 => array(
													'name' => 'Baby Seats',
													'qty' => 5,
													'price' => 5,
													'details' => 'you will be provided a baby seat for our baby inside car',
													'icon' => 'fas fa-baby-carriage',
													'image' => '',
												),
												1 => array(
													'name' => 'Birthday Cake',
													'qty' => 10,
													'price' => 10,
													'details' => 'you will be provided a birthday Cake 1 pound',
													'icon' => 'fas fa-boxes',
													'image' => '',
												),
												2 => array(
													'name' => 'Campaig',
													'qty' => 10,
													'price' => 10,
													'details' => 'you will get 1 bottle Campaig with giftbox',
													'icon' => 'fas fa-wheelchair',
													'image' => '',
												)
											)
										)
									),
									//Galary Settings
									'mpwpb_display_slider' => 'off',
									'mpwpb_slider_images' => 'off',
								],
							],
							1 => [
								'name' => 'YOGA INSTRUCTOR',
								'post_data' => [//General_settings
									'mpwpb_shortcode_title' => 'Yoga Instructor',
									'mpwpb_shortcode_sub_title' => 'Choose your yoga instructor easily with effordable price',
									//date_settings
									//'mpwpb_service_start_date' => '2023-03-01',
									'mpwpb_time_slot_length' => '60',
									'mpwpb_capacity_per_session' => '1',
									'mpwpb_default_start_time' => '10',
									'mpwpb_default_end_time' => '18',
									'mpwpb_default_start_break_time' => '13',
									'mpwpb_default_end_break_time' => '15',
									'mpwpb_monday_start_time' => '10',
									'mpwpb_monday_end_time' => '18',
									'mpwpb_monday_start_break_time' => '13',
									'mpwpb_monday_end_break_time' => '15',
									'mpwpb_tuesday_start_time' => '10.5',
									'mpwpb_tuesday_end_time' => '18.5',
									'mpwpb_tuesday_start_break_time' => '13.5',
									'mpwpb_tuesday_end_break_time' => '15.5',
									'mpwpb_wednesday_start_time' => '11',
									'mpwpb_wednesday_end_time' => '19',
									'mpwpb_wednesday_start_break_time' => '14',
									'mpwpb_wednesday_end_break_time' => '16',
									'mpwpb_thursday_start_time' => '10',
									'mpwpb_thursday_end_time' => '18',
									'mpwpb_thursday_start_break_time' => '13',
									'mpwpb_thursday_end_break_time' => '15',
									'mpwpb_off_days' => 'saturday,sunday',
									'mpwpb_off_dates' => array(
										0 => '2023-03-07',
										1 => '2023-03-15',
									),
									//price_settings
									'mpwpb_category_active' => 'on',
									'mpwpb_sub_category_active' => 'off',
									'mpwpb_service_details_active' => 'on',
									'mpwpb_service_duration_active' => 'on',
									'mpwpb_category_text' => 'Yoga Styles',
									'mpwpb_sub_category_text' => '',
									'mpwpb_service_text' => 'Classes',
									'mpwpb_category_infos' => array(
										0 => array(
											'icon' => 'fas fa-running',
											'image' => '',
											'category' => 'Hatha Yoga',
											'sub_category' => array(
												0 => array(
													'icon' => '',
													'image' => '',
													'name' => '',
													'service' => array(
														0 => array(
															'name' => 'Back Body Space Posture',
															'price' => '10',
															'details' => 'Learn process about Back Body Space Posture',
															'duration' => '1h',
															'icon' => 'fas fa-gifts',
															'image' => '',
														),
														1 => array(
															'name' => 'Hatha-Yin Stretch',
															'price' => '12',
															'details' => 'Learn process about Hatha-Yin Stretch',
															'duration' => '1h',
															'icon' => 'fas fa-wheelchair',
															'image' => '',
														),
														2 => array(
															'name' => 'Hands Free Yoga',
															'price' => '14',
															'details' => 'Learn process about Hands Free Yoga',
															'duration' => '1h',
															'icon' => 'fas fa-thermometer',
															'image' => '',
														),
														3 => array(
															'name' => 'Shake It Off',
															'price' => '15',
															'details' => 'Learn process about Shake It Off',
															'duration' => '1h',
															'icon' => 'fas fa-id-card-alt',
															'image' => '',
														),
														4 => array(
															'name' => 'Rotation Stretch',
															'price' => '20',
															'details' => 'Learn process about Rotation Stretch',
															'duration' => '1h',
															'icon' => 'fas fa-soundcloud',
															'image' => '',
														),
														5 => array(
															'name' => 'Stretch Assist',
															'price' => '22',
															'details' => 'Learn process about Stretch Assist',
															'duration' => '1h',
															'icon' => 'fas fa-record-vinyl',
															'image' => '',
														),
													)
												),
											)
										),
										1 => array(
											'icon' => 'fas fa-user-md',
											'image' => '',
											'category' => 'Vinyasa Yoga',
											'sub_category' => array(
												0 => array(
													'icon' => '',
													'image' => '',
													'name' => '',
													'service' => array(
														0 => array(
															'name' => 'Vinyasa For Backbends',
															'price' => '10',
															'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
															'duration' => '1h',
															'icon' => 'fas fa-gifts',
															'image' => '',
														),
														1 => array(
															'name' => 'Full Body Power Flow',
															'price' => '25',
															'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
															'duration' => '1h',
															'icon' => 'fas fa-x-ray',
															'image' => '',
														),
														2 => array(
															'name' => 'Strong Flow',
															'price' => '30',
															'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
															'duration' => '1h',
															'icon' => 'fas fa-dolly-flatbed',
															'image' => '',
														),
														3 => array(
															'name' => 'Vinyasa Flow',
															'price' => '35',
															'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
															'duration' => '1h',
															'icon' => 'fas fa-anchor',
															'image' => '',
														),
														4 => array(
															'name' => 'Intuitive Flexibility',
															'price' => '40',
															'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
															'duration' => '1h',
															'icon' => 'fas fa-compass',
															'image' => '',
														),
														5 => array(
															'name' => 'Sweat Ladder Flow',
															'price' => '45',
															'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
															'duration' => '1h',
															'icon' => 'fas fa-record-vinyl',
															'image' => '',
														),
													)
												),
											)
										),
										2 => array(
											'icon' => 'fas fa-play',
											'image' => '',
											'category' => 'Kids Yoga',
											'sub_category' => array(
												0 => array(
													'icon' => '',
													'image' => '',
													'name' => '',
													'service' => array(
														0 => array(
															'name' => 'Tree Power',
															'price' => '10',
															'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
															'duration' => '1h',
															'icon' => 'fas fa-gifts',
															'image' => '',
														),
														1 => array(
															'name' => 'Strong Inside',
															'price' => '25',
															'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
															'duration' => '1h',
															'icon' => 'fas fa-dolly-flatbed',
															'image' => '',
														),
														2 => array(
															'name' => 'Rainbow Power',
															'price' => '30',
															'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
															'duration' => '1h',
															'icon' => 'fas fa-warehouse',
															'image' => '',
														),
														3 => array(
															'name' => 'Mind Muscle',
															'price' => '35',
															'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
															'duration' => '1h',
															'icon' => 'fas fa-wind',
															'image' => '',
														),
													)
												),
											)
										),
										3 => array(
											'icon' => 'fas fa-x-ray',
											'image' => '',
											'category' => 'Kundalini Yoga',
											'sub_category' => array(
												0 => array(
													'icon' => '',
													'image' => '',
													'name' => '',
													'service' => array(
														0 => array(
															'name' => 'Mental Balance',
															'price' => '10',
															'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
															'duration' => '1h',
															'icon' => 'fas fa-gifts',
															'image' => '',
														),
														1 => array(
															'name' => 'Access Your Inner Power',
															'price' => '25',
															'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
															'duration' => '1h',
															'icon' => 'fas fa-thermometer',
															'image' => '',
														),
														2 => array(
															'name' => 'Uplift Your Energy',
															'price' => '30',
															'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
															'duration' => '1h',
															'icon' => 'fas fa-soundcloud',
															'image' => '',
														),
														3 => array(
															'name' => 'Clean Sweep Your Mind',
															'price' => '35',
															'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
															'duration' => '1h',
															'icon' => 'fas fa-play',
															'image' => '',
														),
													)
												),
											)
										),
									),
									'mpwpb_extra_service_active' => 'off',
									'mpwpb_group_extra_service_active' => 'off',
									'mpwpb_extra_service' => array(),
									//Galary Settings
									'mpwpb_display_slider' => 'off',
									'mpwpb_slider_images' => 'off',
								],
							],
							2 => [
								'name' => 'Medical & Dental',
								'post_data' => [//General_settings
									'mpwpb_shortcode_title' => 'Medical & Dental Service',
									'mpwpb_shortcode_sub_title' => 'Choose your medical and dental services easily with affordable price.',
									//date_settings
									//'mpwpb_service_start_date' => '2023-03-01',
									'mpwpb_time_slot_length' => '60',
									'mpwpb_capacity_per_session' => '1',
									'mpwpb_default_start_time' => '10',
									'mpwpb_default_end_time' => '18',
									'mpwpb_default_start_break_time' => '13',
									'mpwpb_default_end_break_time' => '15',
									'mpwpb_monday_start_time' => '10',
									'mpwpb_monday_end_time' => '18',
									'mpwpb_monday_start_break_time' => '13',
									'mpwpb_monday_end_break_time' => '15',
									'mpwpb_tuesday_start_time' => '10.5',
									'mpwpb_tuesday_end_time' => '18.5',
									'mpwpb_tuesday_start_break_time' => '13.5',
									'mpwpb_tuesday_end_break_time' => '15.5',
									'mpwpb_wednesday_start_time' => '11',
									'mpwpb_wednesday_end_time' => '19',
									'mpwpb_wednesday_start_break_time' => '14',
									'mpwpb_wednesday_end_break_time' => '16',
									'mpwpb_thursday_start_time' => '10',
									'mpwpb_thursday_end_time' => '18',
									'mpwpb_thursday_start_break_time' => '13',
									'mpwpb_thursday_end_break_time' => '15',
									'mpwpb_off_days' => 'saturday,sunday',
									'mpwpb_off_dates' => array(
										0 => '2023-03-07',
										1 => '2023-03-15',
									),
									//price_settings
									'mpwpb_category_active' => 'off',
									'mpwpb_sub_category_active' => 'off',
									'mpwpb_service_details_active' => 'on',
									'mpwpb_service_duration_active' => 'off',
									'mpwpb_category_text' => '',
									'mpwpb_sub_category_text' => '',
									'mpwpb_service_text' => 'Service',
									'mpwpb_category_infos' => array(
										0 => array(
											'icon' => '',
											'image' => '',
											'category' => '',
											'sub_category' => array(
												0 => array(
													'icon' => '',
													'image' => '',
													'name' => '',
													'service' => array(
														0 => array(
															'name' => 'Fever​',
															'price' => '10',
															'details' => 'Nisl tempus, sollicitudin amet, porttitor erat magna congue dui malesuada vestibulum.',
															'duration' => '',
															'icon' => 'fas fa-ambulance',
															'image' => '',
														),
														1 => array(
															'name' => 'Tiredness',
															'price' => '12',
															'details' => 'Ultrices et ultrices enim nunc, quis pellentesque sit mauris',
															'duration' => '',
															'icon' => 'fas fa-user-md',
															'image' => '',
														),
														2 => array(
															'name' => 'Dry Cough​',
															'price' => '14',
															'details' => 'Nisl tempus, metus, sollicitudin amet, porttitor erat magna congue dui malesuada vestibulum.',
															'duration' => '',
															'icon' => 'fas fa-id-card-alt',
															'image' => '',
														),
														3 => array(
															'name' => 'Shortness of Breath​',
															'price' => '15',
															'details' => 'Nisl tempus, metus, sollicitudin amet, porttitor erat magna congue dui malesuada vestibulum.',
															'duration' => '',
															'icon' => 'fas fa-x-ray',
															'image' => '',
														),
														4 => array(
															'name' => 'Aches and Pains​',
															'price' => '20',
															'details' => 'Nisl tempus, metus, sollicitudin amet, porttitor erat magna congue dui malesuada vestibulum.',
															'duration' => '',
															'icon' => 'fas fa-thermometer',
															'image' => '',
														),
														5 => array(
															'name' => 'Sore Throat​',
															'price' => '22',
															'details' => 'Nisl tempus, metus, sollicitudin amet, porttitor erat magna congue dui malesuada vestibulum.',
															'duration' => '',
															'icon' => 'fas fa-record-vinyl',
															'image' => '',
														),
													)
												),
											)
										),
									),
									'mpwpb_extra_service_active' => 'off',
									'mpwpb_group_extra_service_active' => 'off',
									'mpwpb_extra_service' => array(),
									//Galary Settings
									'mpwpb_display_slider' => 'off',
									'mpwpb_slider_images' => 'off',
								],
							],
							3 => [
								'name' => 'Musical Class',
								'post_data' => [//General_settings
									'mpwpb_shortcode_title' => 'Musical Service',
									'mpwpb_shortcode_sub_title' => 'Find your musical instructor easily with affordable price.',
									//date_settings
									//'mpwpb_service_start_date' => '2023-03-01',
									'mpwpb_time_slot_length' => '60',
									'mpwpb_capacity_per_session' => '1',
									'mpwpb_default_start_time' => '10',
									'mpwpb_default_end_time' => '18',
									'mpwpb_default_start_break_time' => '13',
									'mpwpb_default_end_break_time' => '15',
									'mpwpb_monday_start_time' => '10',
									'mpwpb_monday_end_time' => '18',
									'mpwpb_monday_start_break_time' => '13',
									'mpwpb_monday_end_break_time' => '15',
									'mpwpb_tuesday_start_time' => '10.5',
									'mpwpb_tuesday_end_time' => '18.5',
									'mpwpb_tuesday_start_break_time' => '13.5',
									'mpwpb_tuesday_end_break_time' => '15.5',
									'mpwpb_wednesday_start_time' => '11',
									'mpwpb_wednesday_end_time' => '19',
									'mpwpb_wednesday_start_break_time' => '14',
									'mpwpb_wednesday_end_break_time' => '16',
									'mpwpb_thursday_start_time' => '10',
									'mpwpb_thursday_end_time' => '18',
									'mpwpb_thursday_start_break_time' => '13',
									'mpwpb_thursday_end_break_time' => '15',
									'mpwpb_off_days' => 'saturday,sunday',
									'mpwpb_off_dates' => array(
										0 => '2023-03-07',
										1 => '2023-03-15',
									),
									//price_settings
									'mpwpb_category_active' => 'off',
									'mpwpb_sub_category_active' => 'off',
									'mpwpb_service_details_active' => 'on',
									'mpwpb_service_duration_active' => 'on',
									'mpwpb_category_text' => '',
									'mpwpb_sub_category_text' => '',
									'mpwpb_service_text' => 'Service',
									'mpwpb_category_infos' => array(
										0 => array(
											'icon' => '',
											'image' => '',
											'category' => '',
											'sub_category' => array(
												0 => array(
													'icon' => '',
													'image' => '',
													'name' => '',
													'service' => array(
														0 => array(
															'name' => 'Classical Class (3 Months)',
															'price' => '10',
															'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
															'duration' => '1h',
															'icon' => 'fas fa-music',
															'image' => '',
														),
														1 => array(
															'name' => 'Jazz Classes (2 Months)',
															'price' => '12',
															'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
															'duration' => '1h',
															'icon' => 'fas fa-soundcloud',
															'image' => '',
														),
														2 => array(
															'name' => 'Classical Private Tutor​',
															'price' => '14',
															'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
															'duration' => '1h',
															'icon' => 'fas fa-record-vinyl',
															'image' => '',
														),
														3 => array(
															'name' => 'Pop Songs Classes​',
															'price' => '15',
															'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
															'duration' => '1h',
															'icon' => 'fas fa-play',
															'image' => '',
														),
														4 => array(
															'name' => 'Rock Music Piano Class​',
															'price' => '20',
															'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
															'duration' => '1h',
															'icon' => 'fas fa-dolly-flatbed',
															'image' => '',
														),
														5 => array(
															'name' => 'Classical Advance Class​',
															'price' => '22',
															'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
															'duration' => '1h',
															'icon' => 'fas fa-warehouse',
															'image' => '',
														),
														6 => array(
															'name' => 'Classical Private tutor​',
															'price' => '22',
															'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
															'duration' => '1h',
															'icon' => 'fas fa-wind',
															'image' => '',
														),
														7 => array(
															'name' => 'Pop Songs Advance (Annually)​',
															'price' => '22',
															'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
															'duration' => '1h',
															'icon' => 'fas fa-anchor',
															'image' => '',
														),
														8 => array(
															'name' => 'Rock Music Piano Advance​',
															'price' => '22',
															'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
															'duration' => '1h',
															'icon' => 'fas fa-compass',
															'image' => '',
														),
													)
												),
											)
										),
									),
									'mpwpb_extra_service_active' => 'off',
									'mpwpb_group_extra_service_active' => 'off',
									'mpwpb_extra_service' => array(),
									//Galary Settings
									'mpwpb_display_slider' => 'off',
									'mpwpb_slider_images' => 'off',
								],
							],
							4 => [
								'name' => 'Car Wash',
								'post_data' => [//General_settings
									'mpwpb_shortcode_title' => 'Car Wash Service',
									'mpwpb_shortcode_sub_title' => 'Wash your car easily with affordable price',
									//date_settings
									//'mpwpb_service_start_date' => '2023-03-01',
									'mpwpb_time_slot_length' => '60',
									'mpwpb_capacity_per_session' => '1',
									'mpwpb_default_start_time' => '10',
									'mpwpb_default_end_time' => '18',
									'mpwpb_default_start_break_time' => '13',
									'mpwpb_default_end_break_time' => '15',
									'mpwpb_monday_start_time' => '10',
									'mpwpb_monday_end_time' => '18',
									'mpwpb_monday_start_break_time' => '13',
									'mpwpb_monday_end_break_time' => '15',
									'mpwpb_tuesday_start_time' => '10.5',
									'mpwpb_tuesday_end_time' => '18.5',
									'mpwpb_tuesday_start_break_time' => '13.5',
									'mpwpb_tuesday_end_break_time' => '15.5',
									'mpwpb_wednesday_start_time' => '11',
									'mpwpb_wednesday_end_time' => '19',
									'mpwpb_wednesday_start_break_time' => '14',
									'mpwpb_wednesday_end_break_time' => '16',
									'mpwpb_thursday_start_time' => '10',
									'mpwpb_thursday_end_time' => '18',
									'mpwpb_thursday_start_break_time' => '13',
									'mpwpb_thursday_end_break_time' => '15',
									'mpwpb_off_days' => 'saturday,sunday',
									'mpwpb_off_dates' => array(
										0 => '2023-03-07',
										1 => '2023-03-15',
									),
									//price_settings
									'mpwpb_category_active' => 'on',
									'mpwpb_sub_category_active' => 'on',
									'mpwpb_service_details_active' => 'on',
									'mpwpb_service_duration_active' => 'on',
									'mpwpb_category_text' => 'Wash Type',
									'mpwpb_sub_category_text' => 'Car Type',
									'mpwpb_service_text' => 'Service',
									'mpwpb_category_infos' => array(
										0 => array(
											'icon' => 'fas fa-luggage-cart',
											'image' => '',
											'category' => 'Car Wash Polish',
											'sub_category' => array(
												0 => array(
													'icon' => 'fas fa-car-side',
													'image' => '',
													'name' => 'Car Type SUV',
													'service' => array(
														0 => array(
															'name' => 'Hand Wash',
															'price' => '100',
															'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
															'duration' => '1h',
															'icon' => 'fas fa-gifts',
															'image' => '',
														),
														1 => array(
															'name' => 'Exterior Handwax',
															'price' => '200',
															'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
															'duration' => '1h',
															'icon' => 'fas fa-soundcloud',
															'image' => '',
														),
														2 => array(
															'name' => 'Hand Wash Wax',
															'price' => '300',
															'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
															'duration' => '1h',
															'icon' => 'fas fa-play',
															'image' => '',
														),
													)
												),
												1 => array(
													'icon' => 'fas fa-car',
													'image' => '',
													'name' => 'Car Type Zeep',
													'service' => array(
														0 => array(
															'name' => 'Hand Wash',
															'price' => '130',
															'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
															'duration' => '1h',
															'icon' => 'fas fa-gifts',
															'image' => '',
														),
														1 => array(
															'name' => 'Exterior Handwax',
															'price' => '250',
															'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
															'duration' => '1h',
															'icon' => 'fas fa-dolly-flatbed',
															'image' => '',
														),
														2 => array(
															'name' => 'Hand Wash Wax',
															'price' => '350',
															'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
															'duration' => '1h',
															'icon' => 'fas fa-wind',
															'image' => '',
														),
													)
												),
												2 => array(
													'icon' => 'fas fa-compass',
													'image' => '',
													'name' => 'Car Type Sedan',
													'service' => array(
														0 => array(
															'name' => 'Hand Wash',
															'price' => '130',
															'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
															'duration' => '1h',
															'icon' => 'fas fa-gifts',
															'image' => '',
														),
														1 => array(
															'name' => 'Exterior Handwax',
															'price' => '250',
															'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
															'duration' => '1h',
															'icon' => 'fas fa-coffee',
															'image' => '',
														),
														2 => array(
															'name' => 'Hand Wash Wax',
															'price' => '350',
															'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
															'duration' => '1h',
															'icon' => 'fas fa-shuttle-van',
															'image' => '',
														),
													)
												),
											)
										),
										1 => array(
											'icon' => 'fas fa-ambulance',
											'image' => '',
											'category' => 'Car Detailing',
											'sub_category' => array(
												0 => array(
													'icon' => 'fas fa-car-side',
													'image' => '',
													'name' => 'Car Type Sedan',
													'service' => array(
														0 => array(
															'name' => 'Standard Interior',
															'price' => '700',
															'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
															'duration' => '1h',
															'icon' => 'fas fa-gifts',
															'image' => '',
														),
														1 => array(
															'name' => 'Premium Interior',
															'price' => '750',
															'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
															'duration' => '1h',
															'icon' => 'fas fa-user-md',
															'image' => '',
														),
														2 => array(
															'name' => 'Complete Detail',
															'price' => '900',
															'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
															'duration' => '1h',
															'icon' => 'fas fa-id-card-alt',
															'image' => '',
														),
													)
												),
											)
										),
									),
									'mpwpb_extra_service_active' => 'on',
									'mpwpb_group_extra_service_active' => 'off',
									'mpwpb_extra_service' => array(
										0 => array(
											'group_service' => '',
											'group_service_info' => array(
												0 => array(
													'name' => 'Tyre Pressure Checking',
													'qty' => 5,
													'price' => 5,
													'details' => 'A gentle but detailed hand wash procedure that keeps your car looking its best, longer. This service includes: Hand wash of the body Windows and mirrors Rims Tire & Wheel shine',
													'icon' => 'fas fa-boxes',
													'image' => '',
												),
												1 => array(
													'name' => 'Tyre Changing',
													'qty' => 10,
													'price' => 10,
													'details' => 'A gentle but detailed hand wash procedure that keeps your car looking its best, longer. This service includes: Hand wash of the body Windows and mirrors Rims Tire & Wheel shine',
													'icon' => 'fas fa-baby-carriage',
													'image' => '',
												),
												2 => array(
													'name' => 'Odor Removal',
													'qty' => 10,
													'price' => 10,
													'details' => 'A gentle but detailed hand wash procedure that keeps your car looking its best, longer. This service includes: Hand wash of the body Windows and mirrors Rims Tire & Wheel shine',
													'icon' => 'fas fa-wheelchair',
													'image' => '',
												),
											)
										)
									),
									//Galary Settings
									'mpwpb_display_slider' => 'off',
									'mpwpb_slider_images' => 'off',
								],
							],
							5 => [
								'name' => 'Repair service',
								'post_data' => [//General_settings
									'mpwpb_shortcode_title' => 'Repair Service',
									'mpwpb_shortcode_sub_title' => 'Repair anything easily with effordable price',
									//date_settings
									//'mpwpb_service_start_date' => '2023-03-01',
									'mpwpb_time_slot_length' => '60',
									'mpwpb_capacity_per_session' => '1',
									'mpwpb_default_start_time' => '10',
									'mpwpb_default_end_time' => '18',
									'mpwpb_default_start_break_time' => '13',
									'mpwpb_default_end_break_time' => '15',
									'mpwpb_monday_start_time' => '10',
									'mpwpb_monday_end_time' => '18',
									'mpwpb_monday_start_break_time' => '13',
									'mpwpb_monday_end_break_time' => '15',
									'mpwpb_tuesday_start_time' => '10.5',
									'mpwpb_tuesday_end_time' => '18.5',
									'mpwpb_tuesday_start_break_time' => '13.5',
									'mpwpb_tuesday_end_break_time' => '15.5',
									'mpwpb_wednesday_start_time' => '11',
									'mpwpb_wednesday_end_time' => '19',
									'mpwpb_wednesday_start_break_time' => '14',
									'mpwpb_wednesday_end_break_time' => '16',
									'mpwpb_thursday_start_time' => '10',
									'mpwpb_thursday_end_time' => '18',
									'mpwpb_thursday_start_break_time' => '13',
									'mpwpb_thursday_end_break_time' => '15',
									'mpwpb_off_days' => 'saturday,sunday',
									'mpwpb_off_dates' => array(
										0 => '2023-03-07',
										1 => '2023-03-15',
									),
									//price_settings
									'mpwpb_category_active' => 'on',
									'mpwpb_sub_category_active' => 'off',
									'mpwpb_service_details_active' => 'on',
									'mpwpb_service_duration_active' => 'on',
									'mpwpb_category_text' => 'Service Type',
									'mpwpb_sub_category_text' => '',
									'mpwpb_service_text' => 'Service Details',
									'mpwpb_category_infos' => array(
										0 => array(
											'icon' => 'fas fa-car-side',
											'image' => '',
											'category' => 'Car Maintenance',
											'sub_category' => array(
												0 => array(
													'icon' => '',
													'image' => '',
													'name' => '',
													'service' => array(
														0 => array(
															'name' => 'Auto Maintenance Services​',
															'price' => '100',
															'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
															'duration' => '1h',
															'icon' => 'fas fa-gifts',
															'image' => '',
														),
														1 => array(
															'name' => 'Oil Filter Change',
															'price' => '200',
															'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
															'duration' => '1h',
															'icon' => 'fas fa-ambulance',
															'image' => '',
														),
														2 => array(
															'name' => 'Cabin Air Filter Replacement',
															'price' => '300',
															'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
															'duration' => '1h',
															'icon' => 'fas fa-x-ray',
															'image' => '',
														),
														3 => array(
															'name' => 'Engine Performance',
															'price' => '300',
															'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
															'duration' => '1h',
															'icon' => 'fas fa-thermometer',
															'image' => '',
														),
													)
												),
											)
										),
										1 => array(
											'icon' => 'fas fa-running',
											'image' => '',
											'category' => 'Car Repair',
											'sub_category' => array(
												0 => array(
													'icon' => '',
													'image' => '',
													'name' => '',
													'service' => array(
														0 => array(
															'name' => 'Brake Repair Pads Rotors',
															'price' => '700',
															'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
															'duration' => '1h',
															'icon' => 'fas fa-gifts',
															'image' => '',
														),
														1 => array(
															'name' => 'Air Conditioning Services​​',
															'price' => '750',
															'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
															'duration' => '1h',
															'icon' => 'fas fa-user-md',
															'image' => '',
														),
														2 => array(
															'name' => 'Body Repair Painting',
															'price' => '900',
															'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
															'duration' => '1h',
															'icon' => 'fas fa-thermometer',
															'image' => '',
														),
													)
												),
											)
										),
									),
									'mpwpb_extra_service_active' => 'on',
									'mpwpb_group_extra_service_active' => 'off',
									'mpwpb_extra_service' => array(
										0 => array(
											'group_service' => '',
											'group_service_info' => array(
												0 => array(
													'name' => 'Driver Seating Chair',
													'qty' => 5,
													'price' => 5,
													'details' => 'A gentle but detailed hand wash procedure that keeps your car looking its best, longer. This service includes: Hand wash of the body Windows and mirrors Rims Tire & Wheel shine',
													'icon' => 'fas fa-boxes',
													'image' => '',
												),
												1 => array(
													'name' => 'Lunch box for driver',
													'qty' => 10,
													'price' => 10,
													'details' => 'A gentle but detailed hand wash procedure that keeps your car looking its best, longer. This service includes: Hand wash of the body Windows and mirrors Rims Tire & Wheel shine',
													'icon' => 'fas fa-wheelchair',
													'image' => '',
												),
											)
										)
									),
									//Galary Settings
									'mpwpb_display_slider' => 'off',
									'mpwpb_slider_images' => 'off',
								],
							],
							6 => [
								'name' => 'Hair Cut',
								'post_data' => [//General_settings
									'mpwpb_shortcode_title' => 'Hair Cut Service',
									'mpwpb_shortcode_sub_title' => 'Cut your hair beautifully with affordable price',
									//date_settings
									//'mpwpb_service_start_date' => '2023-03-01',
									'mpwpb_time_slot_length' => '60',
									'mpwpb_capacity_per_session' => '1',
									'mpwpb_default_start_time' => '10',
									'mpwpb_default_end_time' => '18',
									'mpwpb_default_start_break_time' => '13',
									'mpwpb_default_end_break_time' => '15',
									'mpwpb_monday_start_time' => '10',
									'mpwpb_monday_end_time' => '18',
									'mpwpb_monday_start_break_time' => '13',
									'mpwpb_monday_end_break_time' => '15',
									'mpwpb_tuesday_start_time' => '10.5',
									'mpwpb_tuesday_end_time' => '18.5',
									'mpwpb_tuesday_start_break_time' => '13.5',
									'mpwpb_tuesday_end_break_time' => '15.5',
									'mpwpb_wednesday_start_time' => '11',
									'mpwpb_wednesday_end_time' => '19',
									'mpwpb_wednesday_start_break_time' => '14',
									'mpwpb_wednesday_end_break_time' => '16',
									'mpwpb_thursday_start_time' => '10',
									'mpwpb_thursday_end_time' => '18',
									'mpwpb_thursday_start_break_time' => '13',
									'mpwpb_thursday_end_break_time' => '15',
									'mpwpb_off_days' => 'saturday,sunday',
									'mpwpb_off_dates' => array(
										0 => '2023-03-07',
										1 => '2023-03-15',
									),
									//price_settings
									'mpwpb_category_active' => 'off',
									'mpwpb_sub_category_active' => 'off',
									'mpwpb_service_details_active' => 'on',
									'mpwpb_service_duration_active' => 'on',
									'mpwpb_category_text' => '',
									'mpwpb_sub_category_text' => '',
									'mpwpb_service_text' => 'Service Details',
									'mpwpb_category_infos' => array(
										0 => array(
											'icon' => '',
											'image' => '',
											'category' => '',
											'sub_category' => array(
												0 => array(
													'icon' => '',
													'image' => '',
													'name' => '',
													'service' => array(
														0 => array(
															'name' => 'Fade Haircut​',
															'price' => '100',
															'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
															'duration' => '1h',
															'icon' => 'fas fa-gifts',
															'image' => '',
														),
														1 => array(
															'name' => 'Taper Haircut',
															'price' => '200',
															'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
															'duration' => '1h',
															'icon' => 'fas fa-baby-carriage',
															'image' => '',
														),
														2 => array(
															'name' => 'Buzz Cut',
															'price' => '300',
															'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
															'duration' => '1h',
															'icon' => 'fas fa-running',
															'image' => '',
														),
														3 => array(
															'name' => 'Crew Cut',
															'price' => '300',
															'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
															'duration' => '1h',
															'icon' => 'fas fa-thermometer',
															'image' => '',
														),
													)
												),
											)
										),
									),
									'mpwpb_extra_service_active' => 'on',
									'mpwpb_group_extra_service_active' => 'off',
									'mpwpb_extra_service' => array(
										0 => array(
											'group_service' => '',
											'group_service_info' => array(
												0 => array(
													'name' => 'Pre Hair Wash',
													'qty' => 5,
													'price' => 5,
													'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
													'icon' => 'fas fa-boxes',
													'image' => '',
												),
												1 => array(
													'name' => 'After Hair Wash',
													'qty' => 10,
													'price' => 10,
													'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
													'icon' => 'fas fa-wheelchair',
													'image' => '',
												),
												2 => array(
													'name' => 'Face Wash',
													'qty' => 10,
													'price' => 10,
													'details' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus vitae fringilla velit. Maecenas in purus ipsum. Integer euismod dui risus, eget porttitor enim molestie ac. Nunc ac sem a mauris vestibulum vestibulum. Duis orci massa, venenatis a gravida eget, convallis ac sapien',
													'icon' => 'fas fa-thermometer',
													'image' => '',
												),
											)
										)
									),
									//Galary Settings
									'mpwpb_display_slider' => 'off',
									'mpwpb_slider_images' => 'off',
								],
							],
						]
					]
				];
			}

			public function dummy_import_xml(){
				return [
					'taxonomy' => [
						// 'mpwpb_category' => [
						//     0 => ['name' => 'Fixed Tour'],
						//     1 => ['name' => 'Flexible Tour']
						// ],
					],
					'custom_post' => [
						'mpwpb_item' => [
							0 => [
								'name' => 'Hair Cut Salon Booking',
								'post_data' => [
									// General_settings
									'mpwpb_shortcode_title' => 'Hair Cut Service',
									'mpwpb_shortcode_sub_title' => 'Cut your hair beautifully with affordable price',
									// Date_settings
									//'mpwpb_service_start_date' => '2023-03-01',
									'mpwpb_time_slot_length' => '60',
									'mpwpb_capacity_per_session' => '1',
									'mpwpb_default_start_time' => '10',
									'mpwpb_default_end_time' => '16',
									'mpwpb_default_start_break_time' => '13',
									'mpwpb_default_end_break_time' => '15',
									'mpwpb_monday_start_time' => '',
									'mpwpb_monday_end_time' => '',
									'mpwpb_monday_start_break_time' => '',
									'mpwpb_monday_end_break_time' => '',
									'mpwpb_tuesday_start_time' => '',
									'mpwpb_tuesday_end_time' => '',
									'mpwpb_tuesday_start_break_time' => '',
									'mpwpb_tuesday_end_break_time' => '',
									'mpwpb_wednesday_start_time' => '',
									'mpwpb_wednesday_end_time' => '',
									'mpwpb_wednesday_start_break_time' => '',
									'mpwpb_wednesday_end_break_time' => '',
									'mpwpb_thursday_start_time' => '',
									'mpwpb_thursday_end_time' => '',
									'mpwpb_thursday_start_break_time' => '',
									'mpwpb_thursday_end_break_time' => '',
									'mpwpb_off_days' => 'saturday,sunday',
									'mpwpb_off_dates' => [],
									'mpwpb_service_type'=>'car_wash',
									// Price_settings
									'mpwpb_category_active' => 'off',
									'mpwpb_sub_category_active' => 'off',
									'mpwpb_service_details_active' => 'on',
									'mpwpb_service_duration_active' => 'on',
									'mpwpb_category_text' => 'Category',
									'mpwpb_sub_category_text' => 'Sub-Category',
									'mpwpb_service_text' => 'Service',
									'mpwpb_category_infos' => [
										[
											'category' => '',
											'sub_category' => [
												[
													'icon' => '',
													'image' => '',
													'name' => '',
													'service' => [
														[
															'name' => 'Fade Haircut',
															'price' => '10',
															'details' => 'Shampooing can strip your hair of all its natural oils, leaving it dry and brittle. Pre-pooing acts as a base or protective barrier against over-cleansing',
															'duration' => '60m',
															'icon' => '',
															'image' => '236',
														],
														[
															'name' => 'Taper Haircut',
															'price' => '15',
															'details' => 'Shampooing can strip your hair of all its natural oils, leaving it dry and brittle. Pre-pooing acts as a base or protective barrier against over-cleansing',
															'duration' => '60m',
															'icon' => '',
															'image' => '237',
														],
														[
															'name' => 'Buzz Cut',
															'price' => '20',
															'details' => 'Shampooing can strip your hair of all its natural oils, leaving it dry and brittle. Pre-pooing acts as a base or protective barrier against over-cleansing',
															'duration' => '60m',
															'icon' => '',
															'image' => '238',
														],
														[
															'name' => 'Crew Cut',
															'price' => '30',
															'details' => 'Shampooing can strip your hair of all its natural oils, leaving it dry and brittle. Pre-pooing acts as a base or protective barrier against over-cleansing',
															'duration' => '60m',
															'icon' => '',
															'image' => '239',
														]
													]
												]
											]
										]
									],
									'mpwpb_extra_service_active' => 'on',
									'mpwpb_group_extra_service_active' => 'off',
									'mpwpb_extra_service' => [
										[
											'group_service' => '',
											'group_service_info' => [
												[
													'name' => 'Pre Hair Wash',
													'qty' => '10',
													'price' => '10',
													'details' => 'A pre-shampoo treatment (also referred to as a pre-poo) is exactly what it says on the tin, a treatment that is applied to the hair before jumping into the shower to give your hair a good suds and rinse.',
													'icon' => '',
													'image' => ''
												],
												[
													'name' => 'After Hair Wash',
													'qty' => '15',
													'price' => '15',
													'details' => 'A pre-shampoo treatment (also referred to as a pre-poo) is exactly what it says on the tin, a treatment that is applied to the hair before jumping into the shower to give your hair a good suds and rinse.',
													'icon' => '',
													'image' => ''
												],
												[
													'name' => 'Face Wash',
													'qty' => '45',
													'price' => '45',
													'details' => 'A pre-shampoo treatment (also referred to as a pre-poo) is exactly what it says on the tin, a treatment that is applied to the hair before jumping into the shower to give your hair a good suds and rinse.',
													'icon' => '',
													'image' => ''
												]
											]
										]
									],
									// Gallery Settings
									'mpwpb_display_slider' => 'on',
									'mpwpb_slider_images' => [
										0 => ''
									],
									'mpwpb_faq_active' => 'on',
									'mpwpb_faq' =>  [
										[
											'title' => 'What services can I book?',
											'content' => '<p>You can book a variety of services, including haircuts, coloring, styling, manicures, pedicures, facials, and massages.</p>',
										],
										[
											'title' => 'Is the booking system easy to use?',
											'content' => '<p>Yes, our online booking system is user-friendly, allowing you to navigate and schedule appointments effortlessly.</p>',
										],
										[
											'title' => 'Can I choose my stylist?',
											'content' => '<ul><li><p>Yes, you can select your preferred stylist based on their expertise and availability.</p></li></ul>',
										],
										[
											'title' => 'What if I need to cancel or reschedule my appointment?',
											'content' => '<ul><li><p>You can easily cancel or reschedule your appointment online, ideally 24 hours in advance.</p></li></ul>',
										]
									],
									'mpwpb_features_status'=>'on',
									'mpwpb_features'=>[
										"Wide Range of Courses",
										"General Health Checkups",
										"What types of repair services can I book?",
										"Wide Range of Courses",
										"Wide Range of Courses"
									],
									'mpwpb_service_overview_status'=>'on',
									'mpwpb_service_overview_content'=>'<ol>
										<li><strong>Select Service</strong>: Choose from our extensive list of salon services.</li>
										<li><strong>Choose Date and Time</strong>: Pick a date and time that works best for you.</li>
										<li><strong>Select Stylist</strong>: If desired, select your preferred stylist based on their availability and expertise.</li>
										<li><strong>Confirm Appointment</strong>: Review your booking details and confirm your appointment.</li>
										<li><strong>Receive Confirmation</strong>: Get an email or text confirmation with your appointment details.</li>
									</ol>
									With our <strong>Salon Booking</strong> system, experiencing top-notch beauty and wellness services is just a few clicks away. Enjoy a seamless appointment process and a relaxing salon experience tailored to your needs!',
									'mpwpb_service_details_status'=>'on',
									'mpwpb_service_details_content'=>'<strong>Salon Booking</strong> is a streamlined and user-friendly system designed to enhance your salon experience by making it easy to schedule appointments for a wide range of beauty and wellness services. Whether you need a haircut, manicure, facial, or massage, our platform simplifies the booking process, allowing you to secure your desired time and service with just a few clicks.
									<h3>Key Features:</h3>
									<ol>
										<li><strong>User-Friendly Interface</strong>
									Our online booking system is designed for ease of use, allowing clients to navigate effortlessly through available services, appointment slots, and stylist profiles.</li>
										<li><strong>Comprehensive Service Menu</strong>
									Browse a full range of salon services, including haircuts, coloring, styling, manicures, pedicures, facials, massages, and more. Detailed descriptions help you choose the right service for your needs.</li>
										<li><strong>Flexible Appointment Scheduling</strong>
									Schedule your appointments at your convenience, with options for same-day, next-day, or future bookings. You can easily select a date and time that fits your schedule.</li>
										<li><strong>Stylist Selection</strong>
									Choose your preferred stylist based on their expertise, availability, and client reviews. Each stylist\'s profile includes their specialties and portfolio to help you make an informed choice.</li>
										<li><strong>Confirmation and Reminders</strong>
									Once your appointment is booked, you’ll receive a confirmation email or text, along with reminders as your appointment date approaches, so you never forget a scheduled visit.</li>
										<li><strong>Cancellation and Rescheduling Options</strong>
									Easily manage your appointments by canceling or rescheduling as needed, with a simple online process. We encourage you to do this at least 24 hours in advance to avoid cancellation fees.</li>
										<li><strong>Special Promotions and Packages</strong>
									Through the booking platform, you can access exclusive offers, discounts, and package deals to enhance your salon experience while saving money.</li>
										<li><strong>Secure Payment Options</strong>
									Enjoy the convenience of online payments through secure methods, including credit/debit cards and digital wallets, ensuring a hassle-free checkout process.</li>
										<li><strong>Customer Support</strong>
									Our dedicated customer support team can assist you with any booking inquiries, service questions, or technical issues you may encounter.</li>
										<li><strong>Feedback and Reviews</strong>
									After your appointment, you have the opportunity to leave feedback and reviews for your stylist and the services received, helping us maintain high standards and improve our offerings.</li>
									</ol>',
									'mpwpb_service_review_ratings'=>'4.8',
									'mpwpb_service_rating_scale'=>'out of 5',
									'mpwpb_service_rating_text'=>'total 200 review',
									'_thumbnail_id'=>'597',
								],
							],
							1 => [
								'name' => 'Car Wash',
								'post_data' => [
									// General_settings
									'mpwpb_shortcode_title' => 'Car Wash Service',
									'mpwpb_shortcode_sub_title' => 'Wash your car easily with affordable price',
									// Date_settings
									'mpwpb_service_start_date' => '2023-03-01',
									'mpwpb_time_slot_length' => '60',
									'mpwpb_capacity_per_session' => '1',
									'mpwpb_default_start_time' => '10',
									'mpwpb_default_end_time' => '16',
									'mpwpb_default_start_break_time' => '13',
									'mpwpb_default_end_break_time' => '15',
									'mpwpb_monday_start_time' => '',
									'mpwpb_monday_end_time' => '',
									'mpwpb_monday_start_break_time' => '',
									'mpwpb_monday_end_break_time' => '',
									'mpwpb_tuesday_start_time' => '',
									'mpwpb_tuesday_end_time' => '',
									'mpwpb_tuesday_start_break_time' => '',
									'mpwpb_tuesday_end_break_time' => '',
									'mpwpb_wednesday_start_time' => '',
									'mpwpb_wednesday_end_time' => '',
									'mpwpb_wednesday_start_break_time' => '',
									'mpwpb_wednesday_end_break_time' => '',
									'mpwpb_thursday_start_time' => '',
									'mpwpb_thursday_end_time' => '',
									'mpwpb_thursday_start_break_time' => '',
									'mpwpb_thursday_end_break_time' => '',
									'mpwpb_off_days' => 'saturday,sunday',
									'mpwpb_off_dates' => [],
									
									// Price_settings
									'mpwpb_category_active' => 'on',
									'mpwpb_sub_category_active' => 'on',
									'mpwpb_service_details_active' => 'on',
									'mpwpb_service_duration_active' => 'on',
									'mpwpb_category_text' => 'Wash Type',
									'mpwpb_sub_category_text' => 'Car Type',
									'mpwpb_service_text' => 'Service',
									'mpwpb_category_infos' => [
											[
												'icon' => '',
												'image' => '',
												'category' => 'Car Wash Polish',
												'sub_category' => [
													[
														'icon' => 'fas fa-dog',
														'image' => '',
														'name' => 'Car Type SUV',
														'service' => [
															[
																'name' => 'Hand Wash',
																'price' => 450,
																'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
																'duration' => '1h 30m',
																'icon' => 'fas fa-frog',
																'image' => ''
															],
															[
																'name' => 'Exterior Handwax',
																'price' => 200,
																'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
																'duration' => '1 Hour',
																'icon' => 'fas fa-paw',
																'image' => ''
															],
															[
																'name' => 'Hand Wash Wax',
																'price' => 650,
																'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
																'duration' => '1h 30m',
																'icon' => 'fas fa-dragon',
																'image' => ''
															]
														]
													],
													[
														'icon' => 'fas fa-dragon',
														'image' => '',
														'name' => 'Car Type Zeep',
														'service' => [
															[
																'name' => 'Hand Wash',
																'price' => 450,
																'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
																'duration' => '',
																'icon' => 'fas fa-spider',
																'image' => ''
															],
															[
																'name' => 'Exterior Handwax',
																'price' => 600,
																'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
																'duration' => '',
																'icon' => 'fas fa-crow',
																'image' => ''
															],
															[
																'name' => 'Hand Wash Wax',
																'price' => 500,
																'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
																'duration' => '',
																'icon' => 'fas fa-dog',
																'image' => ''
															]
														]
													],
													[
														'icon' => 'fas fa-truck-monster',
														'image' => '',
														'name' => 'Car Type Sedan',
														'service' => [
															[
																'name' => 'Hand Wash',
																'price' => 450,
																'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
																'duration' => '',
																'icon' => 'fas fa-microphone-alt',
																'image' => ''
															],
															[
																'name' => 'Exterior Handwax',
																'price' => 450,
																'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
																'duration' => '',
																'icon' => 'fas fa-cocktail',
																'image' => ''
															],
															[
																'name' => 'Hand Wash Wax',
																'price' => 500,
																'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
																'duration' => '',
																'icon' => 'fas fa-tractor',
																'image' => ''
															]
														]
													]
												]
											]
										],
									'mpwpb_extra_service_active' => 'on',
									'mpwpb_group_extra_service_active' => 'off',
									'mpwpb_extra_service' => [
										[
											'group_service' => '',
											'group_service_info' => [
												[
													'name' => 'Tyre Pressure Checking',
													'qty' => 10,
													'price' => 10,
													'details' => 'A gentle but detailed hand wash procedure that keeps your car looking its best, longer.',
													'icon' => 'fas fa-tractor',
													'image' => ''
												],
												[
													'name' => 'Tyre Changing',
													'qty' => 5,
													'price' => 5,
													'details' => 'A gentle but detailed hand wash procedure that keeps your car looking its best, longer.',
													'icon' => 'fas fa-torii-gate',
													'image' => ''
												],
												[
													'name' => 'Odor Removal',
													'qty' => 10,
													'price' => 10,
													'details' => 'A gentle but detailed hand wash procedure that keeps your car looking its best, longer.',
													'icon' => 'fas fa-user-secret',
													'image' => ''
												]
											]
										]
									],
									// Gallery Settings
									'mpwpb_display_slider' => 'on',
									'mpwpb_slider_images' => [
										0 => ''
									],
									'mpwpb_faq_active' => 'on',
									'mpwpb_faq' =>  [
										[
											"title" => "What types of car wash services do you offer?",
											"content" => ""
										],
										[
											"title" => "Do I need an appointment for a car wash?",
											"content" => ""
										],
										[
											"title" => "How long does a car wash take?",
											"content" => ""
										],
										[
											"title" => "Do you offer mobile car wash services?",
											"content" => ""
										],
										[
											"title" => "What’s the difference between a regular wash and detailing?",
											"content" => ""
										]
									],
									'mpwpb_features_status'=>'on',
									'mpwpb_features'=>[
										"Hand Wash Expertise",
										"Eco-Friendly Cleaning Products",
										"Mobile Car Wash Convenience",
										"Full Detailing Services"
									],
									'mpwpb_service_overview_status'=>'on',
									'mpwpb_service_overview_content'=>'Our car wash service is dedicated to providing top-tier care for your vehicle, offering a wide range of cleaning options to suit all needs...',
									'mpwpb_service_details_status'=>'on',
									'mpwpb_service_details_content'=>'<strong>Why Choose Us?</strong><ul><li><strong>Eco-Friendly Products:</strong> We use biodegradable, non-toxic cleaning agents...</li></ul>',
									'mpwpb_service_review_ratings'=>'4.5',
									'mpwpb_service_rating_scale'=>'out of 5',
									'mpwpb_service_rating_text'=>'2888 total customer reviews',
									'_thumbnail_id'=>'1431',
								],
							],
							2 => [
								'name' => 'Repair service Booking Online',
								'post_data' => [
									// General_settings
									'mpwpb_shortcode_title' => 'Vehicle Repair Service',
									'mpwpb_shortcode_sub_title' => 'Repair your vehicle easily with effordable price',
									// Date_settings
									'mpwpb_service_start_date' => '2023-02-01',
									'mpwpb_time_slot_length' => '60',
									'mpwpb_capacity_per_session' => '1',
									'mpwpb_default_start_time' => '10',
									'mpwpb_default_end_time' => '18',
									'mpwpb_default_start_break_time' => '13',
									'mpwpb_default_end_break_time' => '15',
									'mpwpb_monday_start_time' => '',
									'mpwpb_monday_end_time' => '',
									'mpwpb_monday_start_break_time' => '',
									'mpwpb_monday_end_break_time' => '',
									'mpwpb_tuesday_start_time' => '',
									'mpwpb_tuesday_end_time' => '',
									'mpwpb_tuesday_start_break_time' => '',
									'mpwpb_tuesday_end_break_time' => '',
									'mpwpb_wednesday_start_time' => '',
									'mpwpb_wednesday_end_time' => '',
									'mpwpb_wednesday_start_break_time' => '',
									'mpwpb_wednesday_end_break_time' => '',
									'mpwpb_thursday_start_time' => '',
									'mpwpb_thursday_end_time' => '',
									'mpwpb_thursday_start_break_time' => '',
									'mpwpb_thursday_end_break_time' => '',
									'mpwpb_off_days' => 'saturday,sunday',
									'mpwpb_off_dates' => [],
									
									// Price_settings
									'mpwpb_category_active' => 'on',
									'mpwpb_sub_category_active' => 'off',
									'mpwpb_service_details_active' => 'on',
									'mpwpb_service_duration_active' => 'on',
									'mpwpb_category_text' => 'Service Type',
									'mpwpb_sub_category_text' => 'Sub-Category',
									'mpwpb_service_text' => 'Service Details',
									'mpwpb_category_infos' => [
										[
											'icon' => '',
											'image' => '260',
											'category' => 'Car Maintenance',
											'sub_category' => [
												[
													'icon' => '',
													'image' => '',
													'name' => '',
													'service' => [
														[
															'name' => 'Auto Maintenance Services​',
															'price' => '500',
															'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book',
															'duration' => '1 hour',
															'icon' => 'fas fa-air-freshener',
															'image' => ''
														],
														[
															'name' => 'Oil Filter Change',
															'price' => '300',
															'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book',
															'duration' => '1 hour',
															'icon' => 'fas fa-tape',
															'image' => ''
														],
														[
															'name' => 'Cabin Air Filter Replacement',
															'price' => '200',
															'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book',
															'duration' => '1 hour',
															'icon' => 'fas fa-ship',
															'image' => ''
														],
														[
															'name' => 'Engine Performance',
															'price' => '300',
															'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
															'duration' => '30m',
															'icon' => 'fas fa-truck-monster',
															'image' => ''
														]
													]
												]
											]
										],
										[
											'icon' => '',
											'image' => '261',
											'category' => 'Car Repair',
											'sub_category' => [
												[
													'icon' => '',
													'image' => '',
													'name' => '',
													'service' => [
														[
															'name' => 'Brake Repair Pads Rotors',
															'price' => '200',
															'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
															'duration' => '30m',
															'icon' => '',
															'image' => ''
														],
														[
															'name' => 'Air Conditioning Services​​',
															'price' => '100',
															'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
															'duration' => '30m',
															'icon' => '',
															'image' => ''
														],
														[
															'name' => 'Body Repair Painting',
															'price' => '30',
															'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
															'duration' => '30m',
															'icon' => '',
															'image' => ''
														]
													]
												]
											]
										]
									],
									'mpwpb_extra_service_active' => 'on',
									'mpwpb_group_extra_service_active' => 'off',
									'mpwpb_extra_service' =>[
										[
											'group_service' => '',
											'group_service_info' => [
												[
													'name' => 'Driver Seating Chair',
													'qty' => '200',
													'price' => '200',
													'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book',
													'icon' => 'fas fa-ship',
													'image' => ''
												],
												[
													'name' => 'Lunch box for driver',
													'qty' => '300',
													'price' => '300',
													'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book',
													'icon' => 'fas fa-hamburger',
													'image' => ''
												]
											]
										]
									],
									// Gallery Settings
									'mpwpb_display_slider' => 'on',
									'mpwpb_slider_images' => [
										0 => ''
									],
									'mpwpb_faq_active' => 'on',
									'mpwpb_faq' => [
										[
											'title' => 'What types of repair services can I book?',
											'content' => '<p>We offer a wide range of repair services, including appliance repairs, electronics troubleshooting, plumbing fixes, HVAC servicing, and automotive repairs. You can select the specific service you need during the booking process.</p>'
										],
										[
											'title' => 'How do I book a repair service?',
											'content' => '<p>Booking a repair service is simple! Just visit our website, select the type of service you need, choose your preferred date and time, and provide any relevant details about the issue.</p>'
										],
										[
											'title' => 'Is there a fee for booking an appointment?',
											'content' => '<p>There is no fee for booking an appointment. You will only be charged for the service provided once the repair is completed.</p>'
										],
										[
											'title' => 'Can I reschedule or cancel my appointment?',
											'content' => '<p>Yes, you can reschedule or cancel your appointment through our online booking system. Please do so at least 24 hours in advance to avoid any cancellation fees.</p>'
										]
									],
									'mpwpb_features_status'=>'on',
									'mpwpb_features'=>[
										'Wide Range of Courses',
										'General Health Checkups',
										'What types of repair services can I book?',
										'General Health Checkups'
									],
									'mpwpb_service_overview_status'=>'on',
									'mpwpb_service_overview_content'=>'Experience hassle-free repair services with our <strong>Repair Service Booking</strong> system, designed to cater to your repair needs quickly and efficiently. Whether you’re dealing with a malfunctioning appliance, electronics, plumbing issues, or vehicle repairs, our user-friendly platform makes scheduling a repair simple and convenient.',
									'mpwpb_service_details_status'=>'on',
									'mpwpb_service_details_content'=>'<ol>
											<li><strong>Select Service</strong>: Choose the type of repair service you need.</li>
											<li><strong>Schedule Appointment</strong>: Pick a date and time that works for you.</li>
											<li><strong>Provide Details</strong>: Share relevant information about the repair issue.</li>
											<li><strong>Confirmation</strong>: Receive a confirmation of your appointment via email or text.</li>
											<li><strong>Service Completion</strong>: Our technician will arrive at your scheduled time to complete the repair.</li>
										</ol>
										With our <strong>Repair Service Booking</strong>, getting the help you need is easier than ever. Say goodbye to stress and hello to quick, reliable repairs!',
									'mpwpb_service_review_ratings'=>'4.5',
									'mpwpb_service_rating_scale'=>'out of 5',
									'mpwpb_service_rating_text'=>'2888 total customer reviews',
									'_thumbnail_id'=>'261',
								],
							],
							3 => [
								'name' => 'Music Learning Online',
								'post_data' => [
									// General_settings
									'mpwpb_shortcode_title' => 'Musical Service',
									'mpwpb_shortcode_sub_title' => 'Find your musical instructor easily with affordable price.',
									// Date_settings
									'mpwpb_service_start_date' => '2023-02-01',
									'mpwpb_time_slot_length' => '60',
									'mpwpb_capacity_per_session' => '1',
									'mpwpb_default_start_time' => '10',
									'mpwpb_default_end_time' => '18',
									'mpwpb_default_start_break_time' => '13',
									'mpwpb_default_end_break_time' => '15',
									'mpwpb_monday_start_time' => '',
									'mpwpb_monday_end_time' => '',
									'mpwpb_monday_start_break_time' => '',
									'mpwpb_monday_end_break_time' => '',
									'mpwpb_tuesday_start_time' => '',
									'mpwpb_tuesday_end_time' => '',
									'mpwpb_tuesday_start_break_time' => '',
									'mpwpb_tuesday_end_break_time' => '',
									'mpwpb_wednesday_start_time' => '',
									'mpwpb_wednesday_end_time' => '',
									'mpwpb_wednesday_start_break_time' => '',
									'mpwpb_wednesday_end_break_time' => '',
									'mpwpb_thursday_start_time' => '',
									'mpwpb_thursday_end_time' => '',
									'mpwpb_thursday_start_break_time' => '',
									'mpwpb_thursday_end_break_time' => '',
									'mpwpb_off_days' => 'saturday,sunday',
									'mpwpb_off_dates' => [],
									
									// Price_settings
									'mpwpb_category_active' => 'off',
									'mpwpb_sub_category_active' => 'off',
									'mpwpb_service_details_active' => 'on',
									'mpwpb_service_duration_active' => 'on',
									'mpwpb_category_text' => 'Category',
									'mpwpb_sub_category_text' => 'Sub-Category',
									'mpwpb_service_text' => 'Service',
									'mpwpb_category_infos' => [
										[
											'category' => '',
											'sub_category' => [
												[
													'icon' => '',
													'image' => '',
													'name' => '',
													'service' => [
														[
															'name' => 'Classical Class (3 Months)',
															'price' => '10',
															'details' => 'derived from the Latin word classics, which originally referred to the highest class of Ancient Roman citizens',
															'duration' => '30m',
															'icon' => '',
															'image' => '243'
														],
														[
															'name' => 'Jazz Classes (2 Months)',
															'price' => '15',
															'details' => 'Classical music, strictly defined, means music produced in the Western',
															'duration' => '30m',
															'icon' => '',
															'image' => '244'
														],
														[
															'name' => 'Classical Private Tutor',
															'price' => '20',
															'details' => 'derived from the Latin word classics, which originally referred to the highest class of Ancient Roman citizens',
															'duration' => '30m',
															'icon' => '',
															'image' => '245'
														],
														[
															'name' => 'Pop Songs Classes',
															'price' => '30',
															'details' => 'Classical music, strictly defined, means music produced in the Western',
															'duration' => '30m',
															'icon' => '',
															'image' => '246'
														],
														[
															'name' => 'Rock Music Piano Class',
															'price' => '40',
															'details' => 'derived from the Latin word classics, which originally referred to the highest class of Ancient Roman citizens',
															'duration' => '30m',
															'icon' => '',
															'image' => '247'
														],
														[
															'name' => 'Classical Advance Class',
															'price' => '78',
															'details' => 'Classical music, strictly defined, means music produced in the Western',
															'duration' => '30m',
															'icon' => '',
															'image' => '248'
														],
														[
															'name' => 'Classical Private tutor',
															'price' => '10',
															'details' => 'derived from the Latin word classics, which originally referred to the highest class of Ancient Roman citizens',
															'duration' => '30m',
															'icon' => '',
															'image' => '249'
														],
														[
															'name' => 'Pop Songs Advance (Annually)',
															'price' => '10',
															'details' => 'Classical music, strictly defined, means music produced in the Western',
															'duration' => '30m',
															'icon' => '',
															'image' => '250'
														],
														[
															'name' => 'Rock Music Piano Advance',
															'price' => '45',
															'details' => 'Classical music, strictly defined, means music produced in the Western',
															'duration' => '30m',
															'icon' => '',
															'image' => '251'
														]
													]
												]
											]
										]
									],
									'mpwpb_extra_service_active' => 'off',
									'mpwpb_group_extra_service_active' => 'off',
									'mpwpb_extra_service' =>[],
									// Gallery Settings
									'mpwpb_display_slider' => 'on',
									'mpwpb_slider_images' => [
										0 => ''
									],
									'mpwpb_faq_active' => 'on',
									'mpwpb_faq' => [
										[
											'title' => 'What instruments can I learn on the platform?',
											'content' => '<p>We offer a variety of instrument courses, including piano, guitar, drums, violin, flute, saxophone, and more. You can also learn music theory, composition, vocal training, and music production.</p>'
										],
										[
											'title' => 'Is Music Learning Online suitable for beginners?',
											'content' => '<p>Absolutely! We have beginner-friendly courses for each instrument, as well as lessons for intermediate and advanced learners. You can start with the basics and progress at your own pace.</p>'
										],
										[
											'title' => 'Do I need any prior musical knowledge to join?',
											'content' => '<p>No prior experience is necessary. Our courses are designed for learners at every skill level, with step-by-step instructions to help you build your skills from the ground up.</p>'
										],
										[
											'title' => 'How do I access the lessons?',
											'content' => '<p>All lessons are available online, so you can access them anytime from your computer, tablet, or smartphone. There are no fixed schedules, allowing you to learn at your convenience.</p>'
										]
									],
									'mpwpb_features_status'=>'on',
									'mpwpb_features'=>[
										'Wide Range of Courses',
										'Expert Instructors',
										'Flexible, Self-Paced Learning',
										'Interactive Tools',
										'Progress Tracking'
									],
									'mpwpb_service_overview_status'=>'on',
									'mpwpb_service_overview_content'=>'<strong>Music Learning Online</strong> is a dynamic and user-friendly platform designed to help learners of all levels develop their musical skills from anywhere in the world. Whether you’re a beginner eager to pick up an instrument or a seasoned musician looking to refine your abilities, our online courses cater to every type of student.',
									'mpwpb_service_details_status'=>'on',
									'mpwpb_service_details_content'=>'Discover the joy of learning music from the comfort of your home with <strong>Music Learning Online</strong>. Our platform offers a comprehensive, flexible, and interactive way to master your favorite instrument, improve your vocals, or explore music theory—all at your own pace.
										<h3>Key Features:</h3>
										<ul>
											<li><strong>Wide Range of Courses</strong>: Learn various instruments, including guitar, piano, drums, violin, and more. Plus, access courses on music theory, songwriting, music production, and vocal training.</li>
											<li><strong>Expert Instructors</strong>: Receive instruction from experienced, professional musicians who guide you through step-by-step lessons and personalized feedback.</li>
											<li><strong>Flexible Learning</strong>: Study at your own pace, with lessons available 24/7. Whether you\'re a beginner or looking to advance your skills, our platform adapts to your schedule and skill level.</li>
											<li><strong>Interactive Tools</strong>: Practice with interactive exercises, video tutorials, sheet music, and backing tracks to enhance your learning experience.</li>
											<li><strong>Community Support</strong>: Join a global community of music learners, where you can share progress, ask questions, and collaborate with fellow musicians.</li>
											<li><strong>Progress Tracking</strong>: Monitor your growth with structured lessons, quizzes, and performance tracking to stay motivated and on course.</li>
										</ul>
										With <strong>Music Learning Online</strong>, you can cultivate your musical talents and achieve your goals, whether you\'re looking to play for fun, perform professionally, or simply expand your creative horizons.',
									'mpwpb_service_review_ratings'=>'4.5',
									'mpwpb_service_rating_scale'=>'out of 5',
									'mpwpb_service_rating_text'=>'2888 total customer reviews',
									'_thumbnail_id'=>'261',
								],
							],
							4 => [
								'name' => 'Medical & Dental',
								'post_data' => [
									// General_settings
									'mpwpb_shortcode_title' => 'Medical & Dental Service',
									'mpwpb_shortcode_sub_title' => 'Choose your medical and dental services easily with affordable price.',
									// Date_settings
									'mpwpb_service_start_date' => '2023-02-01',
									'mpwpb_time_slot_length' => '60',
									'mpwpb_capacity_per_session' => '1',
									'mpwpb_default_start_time' => '10',
									'mpwpb_default_end_time' => '18',
									'mpwpb_default_start_break_time' => '13',
									'mpwpb_default_end_break_time' => '15',
									'mpwpb_monday_start_time' => '',
									'mpwpb_monday_end_time' => '',
									'mpwpb_monday_start_break_time' => '',
									'mpwpb_monday_end_break_time' => '',
									'mpwpb_tuesday_start_time' => '',
									'mpwpb_tuesday_end_time' => '',
									'mpwpb_tuesday_start_break_time' => '',
									'mpwpb_tuesday_end_break_time' => '',
									'mpwpb_wednesday_start_time' => '',
									'mpwpb_wednesday_end_time' => '',
									'mpwpb_wednesday_start_break_time' => '',
									'mpwpb_wednesday_end_break_time' => '',
									'mpwpb_thursday_start_time' => '',
									'mpwpb_thursday_end_time' => '',
									'mpwpb_thursday_start_break_time' => '',
									'mpwpb_thursday_end_break_time' => '',
									'mpwpb_off_days' => 'saturday,sunday',
									'mpwpb_off_dates' => [],
									
									// Price_settings
									'mpwpb_category_active' => 'off',
									'mpwpb_sub_category_active' => 'off',
									'mpwpb_service_details_active' => 'on',
									'mpwpb_service_duration_active' => 'on',
									'mpwpb_category_text' => 'Category',
									'mpwpb_sub_category_text' => 'Sub-Category',
									'mpwpb_service_text' => 'Service',
									'mpwpb_category_infos' => [
										0 => [
											'category' => '',
											'sub_category' => [
												0 => [
													'icon' => '',
													'image' => '',
													'name' => '',
													'service' => [
														0 => [
															'name' => 'Fever​',
															'price' => '10',
															'details' => 'Nisl tempus, sollicitudin amet, porttitor erat magna congue dui malesuada vestibulum.',
															'duration' => '30m',
															'icon' => '',
															'image' => '253'
														],
														1 => [
															'name' => 'Tiredness',
															'price' => '15',
															'details' => 'Ultrices et ultrices enim nunc, quis pellentesque sit mauris turpis augue vitae',
															'duration' => '30m',
															'icon' => '',
															'image' => '254'
														],
														2 => [
															'name' => 'Dry Cough​',
															'price' => '30',
															'details' => 'Nisl tempus, metus, sollicitudin amet, porttitor erat magna congue dui malesuada vestibulum.',
															'duration' => '30m',
															'icon' => '',
															'image' => '255'
														],
														3 => [
															'name' => 'Shortness of Breath​',
															'price' => '10',
															'details' => 'Nisl tempus, metus, sollicitudin amet, porttitor erat magna congue dui malesuada vestibulum.',
															'duration' => '30m',
															'icon' => '',
															'image' => '256'
														],
														4 => [
															'name' => 'Aches and Pains​',
															'price' => '20',
															'details' => 'Nisl tempus, metus, sollicitudin amet, porttitor erat magna congue dui malesuada vestibulum.',
															'duration' => '30m',
															'icon' => '',
															'image' => '257'
														],
														5 => [
															'name' => 'Sore Throat​',
															'price' => '30',
															'details' => 'Nisl tempus, metus, sollicitudin amet, porttitor erat magna congue dui malesuada vestibulum.',
															'duration' => '30m',
															'icon' => '',
															'image' => '258'
														],
														6 => [
															'name' => 'Sexual Disease',
															'price' => '30',
															'details' => 'Nisl tempus, metus, sollicitudin amet, porttitor erat magna congue dui malesuada vestibulum.',
															'duration' => '30m',
															'icon' => '',
															'image' => '256'
														],
														7 => [
															'name' => 'Sleep Apnea',
															'price' => '50',
															'details' => 'Nisl tempus, metus, sollicitudin amet, porttitor erat magna congue dui malesuada vestibulum.',
															'duration' => '60m',
															'icon' => '',
															'image' => '253'
														]
													]
												]
											]
										]
									],
									'mpwpb_extra_service_active' => 'off',
									'mpwpb_group_extra_service_active' => 'off',
									'mpwpb_extra_service' =>[],
									// Gallery Settings
									'mpwpb_display_slider' => 'on',
									'mpwpb_slider_images' => [
										0 => ''
									],
									'mpwpb_faq_active' => 'on',
									'mpwpb_faq' => [
										0 => [
											'title' => 'What types of medical services are available?',
											'content' => '<p>Medical services include primary care, emergency services, specialty care, preventive care, diagnostic services, surgical services, rehabilitation, mental health services, pediatric care, geriatric care, home healthcare, pharmacy services, and nutritional counseling.</p>'
										],
										1 => [
											'title' => 'How do I choose a primary care provider?',
											'content' => '<p>When selecting a primary care provider, consider factors such as location, insurance coverage, provider specialties, availability, and personal recommendations. Many facilities also offer online directories to help you find a suitable provider.</p>'
										],
										2 => [
											'title' => 'What should I expect during a primary care visit?',
											'content' => '<p>During a primary care visit, you will typically undergo a health assessment, discuss any health concerns or symptoms, receive preventive care (such as vaccinations), and may be referred to specialists if necessary.</p>'
										],
										3 => [
											'title' => 'How do I know if I need to go to the emergency room?',
											'content' => '<p>You should go to the emergency room for severe or life-threatening conditions, such as difficulty breathing, chest pain, severe bleeding, head injuries, or signs of stroke. If unsure, consider calling your healthcare provider or a telehealth service for guidance.</p>'
										]
									],
									'mpwpb_features_status'=>'on',
									'mpwpb_features'=>[
										'Wide Range of Courses',
										'Expert Instructors',
										'Flexible, Self-Paced Learning',
										'Interactive Tools',
										'Progress Tracking'
									],
									'mpwpb_service_overview_status'=>'on',
									'mpwpb_service_overview_content'=>'<ul>
										<li><strong>Comprehensive Care</strong>: Medical services cover a broad spectrum of health needs, ensuring holistic care for patients.</li>
										<li><strong>Access to Expertise</strong>: Patients receive specialized care from qualified professionals, improving health outcomes.</li>
										<li><strong>Preventive Focus</strong>: Emphasis on prevention helps reduce the risk of diseases and promotes healthier lifestyles.</li>
										<li><strong>Convenience</strong>: Services are offered in various settings, making it easier for patients to access the care they need.</li>
									</ul>
									Overall, medical services are essential for maintaining health, preventing illness, and providing treatment and support for various medical conditions, ensuring that individuals receive comprehensive and quality healthcare throughout their lives.',
									'mpwpb_service_details_status'=>'on',
									'mpwpb_service_details_content'=>'<ul>
										<li><strong>Comprehensive Care</strong>: Medical services cover a broad spectrum of health needs, ensuring holistic care for patients.</li>
										<li><strong>Access to Expertise</strong>: Patients receive specialized care from qualified professionals, improving health outcomes.</li>
										<li><strong>Preventive Focus</strong>: Emphasis on prevention helps reduce the risk of diseases and promotes healthier lifestyles.</li>
										<li><strong>Convenience</strong>: Services are offered in various settings, making it easier for patients to access the care they need.</li>
									</ul>
									Overall, medical services are essential for maintaining health, preventing illness, and providing treatment and support for various medical conditions, ensuring that individuals receive comprehensive and quality healthcare throughout their lives.',
									'mpwpb_service_review_ratings'=>'4.5',
									'mpwpb_service_rating_scale'=>'out of 5',
									'mpwpb_service_rating_text'=>'2888 total customer reviews',
									'_thumbnail_id'=>'1450',
								],
							],
							5 => [
								'name' => 'YOGA INSTRUCTOR',
								'post_data' => [
									// General_settings
									'mpwpb_shortcode_title' => 'Yoga Instructor',
									'mpwpb_shortcode_sub_title' => 'Choose your yoga instructor easily with effordable price',
									// Date_settings
									'mpwpb_service_start_date' => '2023-02-01',
									'mpwpb_time_slot_length' => '60',
									'mpwpb_capacity_per_session' => '1',
									'mpwpb_default_start_time' => '10',
									'mpwpb_default_end_time' => '18',
									'mpwpb_default_start_break_time' => '13',
									'mpwpb_default_end_break_time' => '15',
									'mpwpb_monday_start_time' => '',
									'mpwpb_monday_end_time' => '',
									'mpwpb_monday_start_break_time' => '',
									'mpwpb_monday_end_break_time' => '',
									'mpwpb_tuesday_start_time' => '',
									'mpwpb_tuesday_end_time' => '',
									'mpwpb_tuesday_start_break_time' => '',
									'mpwpb_tuesday_end_break_time' => '',
									'mpwpb_wednesday_start_time' => '',
									'mpwpb_wednesday_end_time' => '',
									'mpwpb_wednesday_start_break_time' => '',
									'mpwpb_wednesday_end_break_time' => '',
									'mpwpb_thursday_start_time' => '',
									'mpwpb_thursday_end_time' => '',
									'mpwpb_thursday_start_break_time' => '',
									'mpwpb_thursday_end_break_time' => '',
									'mpwpb_off_days' => 'saturday,sunday',
									'mpwpb_off_dates' => [],
									
									// Price_settings
									'mpwpb_category_active' => 'off',
									'mpwpb_sub_category_active' => 'off',
									'mpwpb_service_details_active' => 'on',
									'mpwpb_service_duration_active' => 'on',
									'mpwpb_category_text' => 'Yoga Styles',
									'mpwpb_sub_category_text' => 'Sub-Category',
									'mpwpb_service_text' => 'Classes',
									'mpwpb_category_infos' => [
										0 => [
											'icon' => '',
											'image' => '',
											'category' => 'Hatha Yoga',
											'sub_category' => [
												0 => [
													'icon' => '',
													'image' => '',
													'name' => '',
													'service' => [
														0 => [
															'name' => 'Back Body Space Posture',
															'price' => '10',
															'details' => 'Learn process about Back Body Space Posture',
															'duration' => '30m',
															'icon' => '',
															'image' => '264'
														],
														1 => [
															'name' => 'Hatha-Yin Stretch',
															'price' => '12',
															'details' => 'Learn process about Hatha-Yin Stretch',
															'duration' => '30m',
															'icon' => '',
															'image' => '265'
														],
														2 => [
															'name' => 'Hands Free Yoga',
															'price' => '14',
															'details' => 'Learn process about Hands Free Yoga',
															'duration' => '30m',
															'icon' => '',
															'image' => '266'
														],
														3 => [
															'name' => 'Shake It Off',
															'price' => '15',
															'details' => 'Learn process about Shake It Off',
															'duration' => '30m',
															'icon' => '',
															'image' => '267'
														],
														4 => [
															'name' => 'Rotation Stretch',
															'price' => '20',
															'details' => 'Learn process about Rotation Stretch',
															'duration' => '30m',
															'icon' => '',
															'image' => '268'
														],
														5 => [
															'name' => 'Stretch Assist',
															'price' => '25',
															'details' => 'Learn process about Stretch Assist',
															'duration' => '30m',
															'icon' => '',
															'image' => '264'
														]
													]
												]
											]
										],
										1 => [
											'icon' => '',
											'image' => '',
											'category' => 'Vinyasa Yoga',
											'sub_category' => [
												0 => [
													'icon' => '',
													'image' => '',
													'name' => '',
													'service' => [
														0 => [
															'name' => 'Vinyasa For Backbends',
															'price' => '10',
															'details' => '',
															'duration' => '30m',
															'icon' => '',
															'image' => ''
														],
														1 => [
															'name' => 'Full Body Power Flow',
															'price' => '10',
															'details' => '',
															'duration' => '30m',
															'icon' => '',
															'image' => ''
														],
														2 => [
															'name' => 'Strong Flow',
															'price' => '15',
															'details' => '',
															'duration' => '30m',
															'icon' => '',
															'image' => ''
														],
														3 => [
															'name' => 'Vinyasa Flow',
															'price' => '30',
															'details' => '',
															'duration' => '30m',
															'icon' => '',
															'image' => ''
														],
														4 => [
															'name' => 'Intuitive Flexibility',
															'price' => '45',
															'details' => '',
															'duration' => '30m',
															'icon' => '',
															'image' => ''
														],
														5 => [
															'name' => 'Sweat Ladder Flow',
															'price' => '30',
															'details' => '',
															'duration' => '30m',
															'icon' => '',
															'image' => ''
														]
													]
												]
											]
										],
										2 => [
											'icon' => '',
											'image' => '',
											'category' => 'Kids Yoga',
											'sub_category' => [
												0 => [
													'icon' => '',
													'image' => '',
													'name' => '',
													'service' => [
														0 => [
															'name' => 'Tree Power',
															'price' => '10',
															'details' => '',
															'duration' => '30m',
															'icon' => '',
															'image' => ''
														],
														1 => [
															'name' => 'Strong Inside',
															'price' => '40',
															'details' => '',
															'duration' => '30m',
															'icon' => '',
															'image' => ''
														],
														2 => [
															'name' => 'Rainbow Power',
															'price' => '20',
															'details' => '',
															'duration' => '30m',
															'icon' => '',
															'image' => ''
														],
														3 => [
															'name' => 'Mind Muscle',
															'price' => '30',
															'details' => '',
															'duration' => '30m',
															'icon' => '',
															'image' => ''
														]
													]
												]
											]
										],
										3 => [
											'icon' => '',
											'image' => '',
											'category' => 'Kundalini Yoga',
											'sub_category' => [
												0 => [
													'icon' => '',
													'image' => '',
													'name' => '',
													'service' => [
														0 => [
															'name' => 'Mental Balance',
															'price' => '30',
															'details' => '',
															'duration' => '30m',
															'icon' => '',
															'image' => ''
														],
														1 => [
															'name' => 'Access Your Inner Power',
															'price' => '30',
															'details' => '',
															'duration' => '30m',
															'icon' => '',
															'image' => ''
														],
														2 => [
															'name' => 'Uplift Your Energy',
															'price' => '30',
															'details' => '',
															'duration' => '30m',
															'icon' => '',
															'image' => ''
														],
														3 => [
															'name' => 'Clean Sweep Your Mind',
															'price' => '40',
															'details' => '',
															'duration' => '30m',
															'icon' => '',
															'image' => ''
														]
													]
												]
											]
										]
									],
									'mpwpb_extra_service_active' => 'off',
									'mpwpb_group_extra_service_active' => 'off',
									'mpwpb_extra_service' =>[],
									// Gallery Settings
									'mpwpb_display_slider' => 'on',
									'mpwpb_slider_images' => [
										0 => ''
									],
									'mpwpb_faq_active' => 'on',
									'mpwpb_faq' => [
										0 => [
											'title' => 'What types of medical services are available?',
											'content' => '<p>Medical services include primary care, emergency services, specialty care, preventive care, diagnostic services, surgical services, rehabilitation, mental health services, pediatric care, geriatric care, home healthcare, pharmacy services, and nutritional counseling.</p>'
										],
										1 => [
											'title' => 'How do I choose a primary care provider?',
											'content' => '<p>When selecting a primary care provider, consider factors such as location, insurance coverage, provider specialties, availability, and personal recommendations. Many facilities also offer online directories to help you find a suitable provider.</p>'
										],
										2 => [
											'title' => 'What should I expect during a primary care visit?',
											'content' => '<p>During a primary care visit, you will typically undergo a health assessment, discuss any health concerns or symptoms, receive preventive care (such as vaccinations), and may be referred to specialists if necessary.</p>'
										],
										3 => [
											'title' => 'How do I know if I need to go to the emergency room?',
											'content' => '<p>You should go to the emergency room for severe or life-threatening conditions, such as difficulty breathing, chest pain, severe bleeding, head injuries, or signs of stroke. If unsure, consider calling your healthcare provider or a telehealth service for guidance.</p>'
										]
									],
									'mpwpb_features_status'=>'on',
									'mpwpb_features'=>[
										'Wide Range of Courses',
										'Expert Instructors',
										'Flexible, Self-Paced Learning',
										'Interactive Tools',
										'Progress Tracking'
									],
									'mpwpb_service_overview_status'=>'on',
									'mpwpb_service_overview_content'=>'<ul>
										<li><strong>Comprehensive Care</strong>: Medical services cover a broad spectrum of health needs, ensuring holistic care for patients.</li>
										<li><strong>Access to Expertise</strong>: Patients receive specialized care from qualified professionals, improving health outcomes.</li>
										<li><strong>Preventive Focus</strong>: Emphasis on prevention helps reduce the risk of diseases and promotes healthier lifestyles.</li>
										<li><strong>Convenience</strong>: Services are offered in various settings, making it easier for patients to access the care they need.</li>
									</ul>
									Overall, medical services are essential for maintaining health, preventing illness, and providing treatment and support for various medical conditions, ensuring that individuals receive comprehensive and quality healthcare throughout their lives.',
									'mpwpb_service_details_status'=>'on',
									'mpwpb_service_details_content'=>'<ul>
										<li><strong>Comprehensive Care</strong>: Medical services cover a broad spectrum of health needs, ensuring holistic care for patients.</li>
										<li><strong>Access to Expertise</strong>: Patients receive specialized care from qualified professionals, improving health outcomes.</li>
										<li><strong>Preventive Focus</strong>: Emphasis on prevention helps reduce the risk of diseases and promotes healthier lifestyles.</li>
										<li><strong>Convenience</strong>: Services are offered in various settings, making it easier for patients to access the care they need.</li>
									</ul>
									Overall, medical services are essential for maintaining health, preventing illness, and providing treatment and support for various medical conditions, ensuring that individuals receive comprehensive and quality healthcare throughout their lives.',
									'mpwpb_service_review_ratings'=>'4.5',
									'mpwpb_service_rating_scale'=>'out of 5',
									'mpwpb_service_rating_text'=>'2888 total customer reviews',
									'_thumbnail_id'=>'1450',
								],
							]
						]
					]
				];
				
			}

		}
	}


	