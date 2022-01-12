<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'Learndash_PowerPack_Setting_Page', false ) ) {
	class Learndash_PowerPack_Setting_Page {
		public function __construct() {
			add_action( 'admin_menu', [ $this, 'ld_learndash_powerpack_admin_menu' ] );
		}

		public function ld_learndash_powerpack_admin_menu() {
			add_submenu_page(
				'learndash-lms',
				__( 'PowerPack', 'learndash-powerpack' ),
				__( 'PowerPack', 'learndash-powerpack' ),
				'manage_options',
				'learndash-powerpack',
				[ $this, 'settings' ]
			);
		}

		public function settings() {
			$get_all_powerpack_classes = Learndash_PowerPack_All_Classes::get_all_powerpack_classes();
			?>
			<div class="ld-head-panel">
				<h1>
					<?php esc_html_e( 'LearnDash PowerPack', 'learndash-powerpack' ); ?>
				</h1>
				<div id="ld-powerpack-tabs" class="ld-tab-buttons">
					<a href="#" class="button active" data-target-content="ld-powerpack-tab-standard">
						<?php _e( 'Standard', 'learndash-powerpack' ); ?>
					</a>
					<a href="#" class="button" data-target-content="ld-powerpack-tab-premium">
						<?php _e( 'Premium', 'learndash-powerpack' ); ?>
					</a>
				</div>
			</div>

			<div class="wrap">
				<h1 class="wp-heading-inline"></h1>

				<div id="ld-powerpack-tab-standard" class="ld-powerpack-tab">
					<?php echo Learndash_PowerPack_Build_Setting_Page_Html::settings_select_option(); ?>

					<div id="learndash_snippet_list"
						class="imm-grid imm-grid-cols-1 lg:imm-grid-cols-2 xl:imm-grid-cols-3 imm-gap-5">
						<?php if ( is_array( $get_all_powerpack_classes ) ) : ?>
							<?php foreach ( $get_all_powerpack_classes as $key ) : ?>
								<?php echo Learndash_PowerPack_Build_Setting_Page_Html::settings_page_html( $key ); ?>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>

				<div id="ld-powerpack-tab-premium" class="ld-powerpack-tab" style="display: none">
					<?php
					global $wp_filter;

					if ( isset( $wp_filter['ld_powerpack_premium_settings'] ) ) {
						if ( ! defined( 'LEARNDASH_POWERPACK_PREMIUM_VERSION' ) ) {
							$wp_filter['ld_powerpack_premium_settings'] = null;
						} else {
							$wp_filter['ld_powerpack_premium_settings']->callbacks = array_filter(
								$wp_filter['ld_powerpack_premium_settings']->callbacks,
								function ( $callback ) {
									$callback_data = end( $callback );

									return is_a( $callback_data['function'][0], Learndash_Powerpack_Premium_Admin::class );
								}
							);
						}
					}
					?>
					<?php esc_html_e( apply_filters( 'ld_powerpack_premium_settings', 'Coming Soon..' ) ); ?>
				</div>
			</div>
			<?php
		}
	}

	new Learndash_PowerPack_Setting_Page();
}
