<?php
	if ( ! defined( 'ABSPATH' ) ) {
		die;
	} // Cannot access pages directly.
	if ( ! class_exists( 'MPWPB_Order_layout' ) ) {
		class MPWPB_Order_layout {
			public function __construct() {
				add_action( 'mpwpb_direct_order_place', array( $this, 'direct_order_place' ) );
				add_action( 'mpwpb_order_details', array( $this, 'order_details' ), 10, 1 );
			}
			public function direct_order_place() {
				if ( isset( $_POST['mpwpb_product_id'] ) && sanitize_text_field($_POST['mpwpb_product_id']) > 0 ) {
					$post_id          = MP_Global_Function::get_submit_info( 'post_id', 0 );
					$total_price      = MPWPB_Woocommerce::get_cart_total_price( $post_id );
					$order_date       = date( 'M-d-Y-hi-a' );
					$order_date_title = date( 'F d, Y @ h:i A' );
					$order_status     = MPWPB_Function::get_general_settings( 'direct_book_status', 'completed' );
					$wc_order_status  = $order_status == 'pending' ? 'wc-pending' : 'wc-completed';
					$wc_order_status  = $order_status == 'requested' ? 'wc-requested' : $wc_order_status;
					$billing_name     = MP_Global_Function::get_submit_info( 'mpwpb_bill_name' );
					$billing_email    = MP_Global_Function::get_submit_info( 'mpwpb_bill_email' );
					$order_data       = array(
						'post_name'      => 'order-' . $order_date,
						'post_type'      => 'shop_order',
						'post_title'     => 'Order &ndash; ' . $order_date_title,
						'post_status'    => $wc_order_status,
						'ping_status'    => 'closed',
						'post_excerpt'   => 'Order Created From customer.',
						//'post_author' => $user_id,
						'post_password'  => uniqid( 'order_' ),
						'post_date'      => date( 'Y-m-d H:i:s e' ),
						'comment_status' => 'open'
					);
					// create order
					$order_id = wp_insert_post( $order_data, true );
					if ( ! is_wp_error( $order_id ) ) {
						add_post_meta( $order_id, '_payment_method_title', 'Import', true );
						add_post_meta( $order_id, '_order_total', $total_price, true );
						add_post_meta( $order_id, '_completed_date', $order_date, true );
						add_post_meta( $order_id, '_order_currency', get_woocommerce_currency_symbol(), true );
						add_post_meta( $order_id, '_paid_date', $order_date, true );
						add_post_meta( $order_id, '_billing_first_name', $billing_name, true );
						add_post_meta( $order_id, '_billing_last_name', '', true );
						add_post_meta( $order_id, '_billing_phone', '', true );
						add_post_meta( $order_id, '_billing_address_2', '', true );
						add_post_meta( $order_id, '_billing_address_1', '', true );
						add_post_meta( $order_id, '_billing_email', $billing_email, true );
						// get product by item_id
						$product_id = MP_Global_Function::get_post_info($post_id,'link_wc_product');
						$product    = MP_Global_Function::wc_product_sku( $product_id );
						if ( $product ) {
							// add item
							$item_id = wc_add_order_item( $order_id, array(
								'order_item_name' => $product->get_title(),
								'order_item_type' => 'line_item'
							) );
							if ( $item_id ) {
								wc_add_order_item_meta( $item_id, '_qty', 1 );
								wc_add_order_item_meta( $item_id, '_tax_class', 'no_tax' );
								wc_add_order_item_meta( $item_id, '_product_id', $product_id );
								wc_add_order_item_meta( $item_id, '_variation_id', '' );
								wc_add_order_item_meta( $item_id, '_line_subtotal', wc_format_decimal( $total_price ) );
								wc_add_order_item_meta( $item_id, '_line_total', wc_format_decimal( $total_price ) );
								wc_add_order_item_meta( $item_id, '_line_tax', wc_format_decimal( 0 ) );
								wc_add_order_item_meta( $item_id, '_line_subtotal_tax', wc_format_decimal( 0 ) );
								/*************************************/
								$category       = MP_Global_Function::get_submit_info( 'mpwpb_category' );
								$sub_category   = MP_Global_Function::get_submit_info( 'mpwpb_sub_category' );
								$service        = MP_Global_Function::get_submit_info( 'mpwpb_service' );
								$date           = MP_Global_Function::get_submit_info( 'mpwpb_date' );
								$price          = MPWPB_Function::get_price( $post_id, $service, $category, $sub_category, $date );
								$attendee_info  = apply_filters( 'add_mpwpb_user_info_data', array(), $post_id );
								$extra_services = MPWPB_Woocommerce::cart_extra_service_info( $post_id );
								/*************************************/
								if ( $category ) {
									wc_add_order_item_meta( $item_id, MPWPB_Function::get_category_text( $post_id ), $category );
									if ( $sub_category ) {
										wc_add_order_item_meta( $item_id, MPWPB_Function::get_sub_category_text( $post_id ), $sub_category );
									}
								}
								wc_add_order_item_meta( $item_id, esc_html__( 'Price ', 'service-booking-manager' ), $price );
								wc_add_order_item_meta( $item_id, esc_html__( 'Date ', 'service-booking-manager' ), esc_html( MP_Global_Function::date_format( $date ) ) );
								wc_add_order_item_meta( $item_id, esc_html__( 'Time ', 'service-booking-manager' ), esc_html( MP_Global_Function::date_format( $date, 'time' ) ) );
								/*************************************/
								if ( sizeof( $extra_services ) > 0 ) {
									foreach ( $extra_services as $ex_service ) {
										wc_add_order_item_meta( $item_id, MPWPB_Function::get_service_text( $post_id ), $ex_service['ex_name'] . ' (' . esc_html( $ex_service['ex_group_name'] ) . ')' );
										wc_add_order_item_meta( $item_id, esc_html__( 'Quantity ', 'service-booking-manager' ), $ex_service['ex_qty'] );
										wc_add_order_item_meta( $item_id, esc_html__( 'Price ', 'service-booking-manager' ), ' ( ' . MP_Global_Function::wc_price( $post_id, $ex_service['ex_price'] ) . ' x ' . $ex_service['ex_qty'] . ') = ' . MP_Global_Function::wc_price( $post_id, ( $ex_service['ex_price'] * $ex_service['ex_qty'] ) ) );
									}
								}
								/*************************************/
								wc_add_order_item_meta( $item_id, '_mpwpb_id', $post_id );
								wc_add_order_item_meta( $item_id, '_mpwpb_date', $date );
								if ( $category ) {
									wc_add_order_item_meta( $item_id, '_mpwpb_category', $category );
									if ( $sub_category ) {
										wc_add_order_item_meta( $item_id, '_mpwpb_sub_category', $sub_category );
									}
								}
								wc_add_order_item_meta( $item_id, '_mpwpb_service', $service );
								wc_add_order_item_meta( $item_id, '_mpwpb_price', $price );
								wc_add_order_item_meta( $item_id, '_mpwpb_user_info', $attendee_info );
								wc_add_order_item_meta( $item_id, '_mpwpb_extra_service_info', $extra_services );
								wc_add_order_item_meta( $item_id, '_product_id', $post_id );
								MPWPB_Woocommerce::add_billing_data( $order_id );
							}
							// set order status as completed
							wp_set_object_terms( $order_id, $order_status, 'shop_order_status' );
							$order_url = home_url() . '/mpwpb-order-details/?order_id=' . $order_id;
							?>
							<script>
											  window.location.href = "<?php echo esc_url( $order_url ); ?>";
							</script>
							<?php
						} else {
							echo MPWPB_Function::get_service_text( $post_id ) . ' ' . esc_html__( ' not found', 'service-booking-manager' );
						}
					}
					// }
				}
			}
			public function order_details( $order_id ) {
				if ( $order_id ) {
					$wc_order     = wc_get_order( $order_id );
					$item_id      = current( array_keys( $wc_order->get_items() ) );
					$order_status = $wc_order->get_status();
					if ( $order_status != 'failed' ) {
						$total       = MP_Global_Function::get_post_info( $order_id, '_order_total' );
						$order_infos = MPWPB_Query::get_order_info( $order_id );
						if ( $order_infos->found_posts > 0 ) {
							$order_info = $order_infos->posts;
							if ( sizeof( $order_info ) > 0 ) {
								foreach ( $order_info as $order ) {
									$attendee_id = $order->ID;
									?>
									<div class="mpStyle">
										<div class="dLayout">
											<div class="flexWrap">
												<div class="col_5 col_xs_12">
													<?php self::order_info( $attendee_id ); ?>
													<div class="divider"></div>
													<?php self::billing_info( $attendee_id ); ?>
													<div class="divider"></div>
													<?php do_action( 'mpwpb_attendee_info', $attendee_id, $item_id ); ?>
												</div>
												<div class="col_1"></div>
												<div class="col_6 col_xs_12">
													<?php self::service_info( $attendee_id ); ?>
													<div class="divider"></div>
													<?php self::ex_service_info( $item_id ); ?>
													<div class="divider"></div>
													<h4 class="justifyBetween">
														<span><?php esc_html_e( 'Total Bill : ', 'service-booking-manager' ) ?></span>
														<span class="textTheme"><?php echo wc_price( $total ); ?></span>
													</h4>
												</div>
											</div>
										</div>
									</div>
									<?php
								}
							}
						}
					}
				}
			}
			public static function order_info( $attendee_id ) {
				if ( $attendee_id > 0 ) {
					$post_id       = MP_Global_Function::get_post_info( $attendee_id, 'mpwpb_id' );
					$order_id      = MP_Global_Function::get_post_info( $attendee_id, 'mpwpb_order_id' );
					$attendee_info = get_post( $attendee_id );
					$date          = MP_Global_Function::get_post_info( $attendee_id, 'mpwpb_date' );
					?>
					<h4><?php esc_html_e( 'Order details', 'service-booking-manager' ); ?></h4>
					<div class="divider"></div>
					<ul class="mp_list">
						<li><strong class="min_100"><?php esc_html_e( 'Order ID:', 'service-booking-manager' ); ?> :</strong>&nbsp;#<?php echo esc_html( $order_id ); ?></li>
						<li><strong class="min_100"><?php esc_html_e( 'Ticket No', 'service-booking-manager' ); ?> :</strong>&nbsp;<?php echo MP_Global_Function::get_post_info( $attendee_id, 'mpwpb_pin' ); ?></li>
						<li><strong class="min_100"><?php echo MPWPB_Function::get_service_text( $post_id ) . ' ' . esc_html__( ' Date : ', 'service-booking-manager' ); ?></strong>&nbsp;<?php echo MP_Global_Function::date_format( $date, 'full' ); ?></li>
						<li><strong class="min_100"><?php esc_attr_e( 'Booking Date : ', 'service-booking-manager' ); ?></strong>&nbsp;<?php echo MP_Global_Function::date_format( $attendee_info->post_date, 'full' ); ?></li>
						<li><strong class="min_100"><?php echo esc_html( MPWPB_Function::get_name() ); ?> :</strong>&nbsp;<?php echo get_the_title( $post_id ); ?></li>
					</ul>
					<?php
				}
			}
			public static function service_info( $attendee_id ) {
				if ( $attendee_id > 0 ) {
					$post_id      = MP_Global_Function::get_post_info( $attendee_id, 'mpwpb_id' );
					$category     = MP_Global_Function::get_post_info( $attendee_id, 'mpwpb_category' );
					$sub_category = MP_Global_Function::get_post_info( $attendee_id, 'mpwpb_sub_category' );
					$service      = MP_Global_Function::get_post_info( $attendee_id, 'mpwpb_service' );
					$price        = MP_Global_Function::get_post_info( $attendee_id, 'mpwpb_price' );
					?>
					<h4><?php echo MPWPB_Function::get_service_text( $post_id ) . ' ' . esc_html__( 'Information', 'service-booking-manager' ); ?></h4>
					<div class="divider"></div>
					<ul class="mp_list">
						<?php if ( $category ) { ?>
							<li><strong class="min_100"><?php echo esc_html( MPWPB_Function::get_category_text( $post_id ) ); ?> :</strong>&nbsp;<?php echo esc_html( $category ); ?></li>
						<?php } ?>
						<?php if ( $sub_category ) { ?>
							<li><strong class="min_100"><?php echo esc_html( MPWPB_Function::get_sub_category_text( $post_id ) ); ?> :</strong>&nbsp;<?php echo esc_html( $sub_category ); ?></li>
						<?php } ?>
						<li><strong class="min_100"><?php echo esc_html( MPWPB_Function::get_service_text( $post_id ) ); ?> :</strong>&nbsp;<?php echo esc_html( $service ); ?></li>
						<li><strong class="min_100"><?php esc_html_e( 'Price', 'service-booking-manager' ); ?> :</strong>&nbsp;<?php echo wc_price( $price ); ?></li>
						<?php do_action( 'mpwpb_after_order_info', $attendee_id ); ?>
					</ul>
					<?php
				}
			}
			public static function ex_service_info( $item_id ) {
				$post_id          = MPWPB_Query::get_order_meta( $item_id, '_mpwpb_id' );
				$ex_service       = MPWPB_Woocommerce::get_order_item_meta( $item_id, '_mpwpb_extra_service_info' );
				$ex_service_infos = $ex_service ? MP_Global_Function::data_sanitize( $ex_service ) : [];
				if ( sizeof( $ex_service_infos ) > 0 ) {
					?>
					<h4><?php echo esc_html__( 'Extra', 'service-booking-manager' ) . ' ' . MPWPB_Function::get_service_text( $post_id ); ?></h4>
					<div class="divider"></div>
					<ul class="mp_list">
						<?php
							foreach ( $ex_service_infos as $ex_service_info ) {
								$group_name = array_key_exists( 'ex_group_name', $ex_service_info ) ? $ex_service_info['ex_group_name'] : '';
								$name       = $ex_service_info['ex_name'];
								$price      = $ex_service_info['ex_price'];
								$qty        = $ex_service_info['ex_qty'];
								?>
								<li class="justifyBetween">
									<strong>
										<?php echo esc_html( $name ); ?>
										<?php if ( $group_name ) { ?>
											(<span class="textTheme"><?php echo esc_html( $group_name ) ?></span>)
										<?php } ?>
									</strong>
									<h6><span class="ex_service_qty">x<?php echo esc_html( $qty ); ?></span>&nbsp;|&nbsp;<?php echo wc_price( $price ); ?>=<?php echo wc_price( $price * $qty ); ?></h6>
								</li>
								<?php
							}
						?>
					</ul>
					<?php
				}
			}
			public static function billing_info( $attendee_id ) {
				$billing_name = MP_Global_Function::get_post_info( $attendee_id, 'mpwpb_billing_name' );
				$email        = MP_Global_Function::get_post_info( $attendee_id, 'mpwpb_billing_email' );
				$phone        = MP_Global_Function::get_post_info( $attendee_id, 'mpwpb_billing_phone' );
				$address      = MP_Global_Function::get_post_info( $attendee_id, 'mpwpb_billing_address' );
				?>
				<h4><?php esc_html_e( 'Billing information', 'service-booking-manager' ); ?></h4>
				<div class="divider"></div>
				<ul class="mp_list">
					<?php if ( $billing_name ) { ?>
						<li><strong class="min_100"><?php esc_html_e( 'Name', 'service-booking-manager' ); ?> : &nbsp;</strong><?php echo esc_html( $billing_name ); ?></li>
					<?php } ?>
					<?php if ( $email ) { ?>
						<li><strong class="min_100"><?php esc_html_e( 'E-mail', 'service-booking-manager' ); ?> : &nbsp;</strong><?php echo esc_html( $email ); ?></li>
					<?php } ?>
					<?php if ( $phone ) { ?>
						<li><strong class="min_100"><?php esc_html_e( 'Phone', 'service-booking-manager' ); ?> : &nbsp;</strong><?php echo esc_html( $phone ); ?></li>
					<?php } ?>
					<?php if ( $address ) { ?>
						<li><strong class="min_100"><?php esc_html_e( 'Address', 'service-booking-manager' ); ?> : &nbsp;</strong><?php echo esc_html( $address ); ?></li>
					<?php } ?>
				</ul>
				<?php
			}
		}
		new MPWPB_Order_layout();
	}