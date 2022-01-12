<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       immerseus.com
 * @since      1.0.0
 *
 * @package    Learndash_Private_Message
 * @subpackage Learndash_Private_Message/public/partials
 */
?>

<?php
$hamburger_icon = '<svg xmlns="http://www.w3.org/2000/svg" class="imm-h-8 imm-w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>';
$search_icon    = '<svg xmlns="http://www.w3.org/2000/svg" class="imm-h-4 imm-w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>';
$add_icon       = '<svg xmlns="http://www.w3.org/2000/svg" class="imm-h-8 imm-w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>';
$close_icon     = '<svg xmlns="http://www.w3.org/2000/svg" class="imm-h-8 imm-w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>';
$settings_icon  = '<svg xmlns="http://www.w3.org/2000/svg" class="imm-h-8 imm-w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>';
?>

<?php if ( ! is_user_logged_in() ) : ?>

	<div
		class="imm-bg-yellow-50 imm-border-l-8 imm-border-yellow-400 imm-p-5 imm-font-semibold imm-rounded-3xl imm-text-yellow-500">
		<?php _e( 'Please log in to join the chat', 'learndash-private-message' ); ?>
	</div>

<?php else : ?>

	<div id="ldpm-chat-container" class="imm-chat-container">
		<div id="ldpm-chat-sidebar" class="imm-chat-aside imm-chat-aside--is-hidden">
			<div class="imm-chat-aside__search__container imm-chat-container--main-color">
				<div class="imm-chat-aside__search">
					<span><?php echo $search_icon; ?></span>
					<input id="imm-search-input" type="text" class="imm-chat-aside__search__input" placeholder="Search"/>
				</div>
				<?php if ( ( current_user_can( 'administrator' ) && ! get_option( 'ldpm_enable_anonymous_users', 0 ) ) || get_option( 'ldpm_allow_create_private_chat_groups', 0 ) ) : ?>
					<div class="imm-pg-dialog-button__container">
						<button id="ldpm-pg-show-dialog-button" type="button">
						<span><?php echo $add_icon; ?></span>
						<?php esc_html_e( 'Create Private Group', 'learndash-private-message' ); ?>
						</button>
					</div>
				<?php endif; ?>
			</div>
			<div class="imm-chat-aside__conversations__container imm-chat-container--main-color">
				<div id="conversations" data-course-id="<?php echo isset( $shortcode_args['course_id'] ) ? esc_attr( $shortcode_args['course_id'] ) : ''; ?>" class="imm-chat-aside__conversations"></div>
			</div>
		</div>
		<div id="ldpm-chat-settings" class="imm-chat-settings imm-chat-settings--is-hidden">
			<div class="imm-chat-settings__header">
				<span class="imm-chat-settings__title"><?php esc_html_e( 'Settings', 'learndash-private-message' ); ?></span>
				<button id="imm-chat-settings__close-button"><span><?php echo $close_icon; ?></span></button>
			</div>
			<div class="imm-chat-settings__container">
				<div class="imm-chat-settings__items">
					<?php foreach ( $user_settings_options as $key => $option_value ) { ?>
						<label class="imm-chat-settings__label">
							<input type="checkbox" name="<?php echo esc_attr( $key ); ?>" <?php checked( $option_value ); ?>>
							<span><?php echo esc_html( Learndash_Private_Message_User_Settings::get_label_for_setting( $key ) ); ?></span>
						</label>
					<?php } ?>
				</div>
			</div>
		</div>
		<div id="ldpm-pg-details" class="imm-pg-details imm-pg-details--is-hidden">
			<div class="imm-pg-details__header">
				<span class="imm-pg-details__title"><?php esc_html_e( 'Group Information', 'learndash-private-message' ); ?></span>
				<button id="imm-pg-details__close-button"><span><?php echo $close_icon; ?></span></button>
			</div>
			<div class="imm-pg-details__container">
				<span class="imm-pg-details__container__title"><?php esc_html_e( 'Members', 'learndash-private-message' ); ?></span>
				<div class="imm-pg-details__members">
				</div>
			</div>
			<div class="imm-pg-details__action-buttons">
				<button id="ldpm-pg-leave-group" class="imm-pg-details__action-button imm-pg-details__action-button--is-cancel"><?php esc_html_e( 'Leave the Group', 'learndash-private-message' ); ?></button>
				<button id="ldpm-pg-delete-group" class="imm-pg-details__action-button imm-pg-details__action-button--is-cancel" style="display:none;"><?php esc_html_e( 'Delete the Group', 'learndash-private-message' ); ?></button>
			</div>
		</div>
		<div id="ldpm-chat-content" class="imm-chat-content imm-chat-container--main-color">
			<div class="imm-chat-content__header">
				<button id="imm-chat-menu__button"><span><?php echo $hamburger_icon; ?></span></button>
				<div class="imm-chat-menu__title__container">
					<span id="imm-chat-menu__title"></span>
				</div>
				<button id="imm-chat-settings__button"><span><?php echo $settings_icon; ?></span></button>
			</div>
			<div class="imm-chat-paper imm-chat__window">
				<div class="imm-chat__conversation">
					<div
						class="ldpm-chat-syncing-indicator imm-hidden imm-absolute imm-left-1/2 imm-transform imm--translate-x-1/2 imm-top-3 imm-z-10 imm-rounded-md imm-bg-gray-300 imm-px-2 imm-py-1">
						<span class="imm-flex imm-space-x-2 imm-text-xs imm-font-medium imm-text-gray-800 imm-capitalize">
							<svg class="imm-animate-spin imm-h-3 imm-w-3 imm-mt-0.5" viewBox="0 0 24 24">
								<path class="imm-opacity-75" fill="currentColor"
									d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
							</svg>

							<span>
								<?php _e( 'Syncing', 'learndash-private-message' ); ?>...
							</span>
						</span>
					</div>

					<div id="ldpm-chat-conversation" class="imm-chat__conversation__container">

						<div class="imm-pg-show-details__container" style="display:none;">
							<button type="button" id="imm-pg-show-details__button"><?php _e( 'Show Group', 'learndash-private-message' ); ?></button>
						</div>

						<div id="chat-history" class="imm-chat__history">
							<!-- Content goes here -->
							<span
								class="imm-capitalize imm-text-center imm-text-xl imm-leading-6 imm-text-gray-200 imm-font-medium imm-absolute imm-top-1/2 imm-left-1/2 imm-transform imm--translate-x-1/2 imm--translate-y-1/2">
								<?php _e( 'Select your chat room', 'learndash-private-message' ); ?>
							</span>
						</div>
						<div id="ldpm-chat-private-invitation" class="imm-chat__invitation" style="display:none;">
							<div class="imm-chat__invitation__content">
								<span class="imm-chat__invitation__content__text"><?php esc_html_e( "You've been invited to this private group.", 'learndash-private-message' ); ?></span>
								<span class="imm-chat__invitation__content__text"><?php esc_html_e( 'Do you accept the invitation?', 'learndash-private-message' ); ?></span>
								<form id="ldpm-chat-private-invitation-form" class="imm-chat__invitation__buttons">
									<button id="ldpm-chat-private-invitation-accept" class="imm-chat__invitation__button imm-chat__invitation__button--is-success" type="button"><?php esc_html_e( 'Yes', 'learndash-private-message' ); ?></button>
									<button id="ldpm-chat-private-invitation-decline" class="imm-chat__invitation__button imm-chat__invitation__button--is-cancel" type="button"><?php esc_html_e( 'No', 'learndash-private-message' ); ?></button>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div id="ldpm-chat__message-box__container" class="imm-chat__message-box__container" style="display: none;">
					<form id="ldpm-chat-form" method="POST" enctype="multipart/form-data">
						<div class="imm-chat__message-box">

							<input type="hidden" id="conversation_id" value="">

							<input type="file" class="imm-hidden" id="ldpm-file-to-send">

							<textarea rows="1" id="ldpm-message-to-send"
								placeholder="Type something here..."></textarea>

							<svg id="ldpm-chat-add-file"
								class="imm-chat__message-box__file"
								xmlns="http://www.w3.org/2000/svg" viewBox="0 0 950 950">
								<g>
									<path d="M857.7,141.3c-30.1-30.1-65.1-53.5-104.3-69.4c-37.8-15.3-77.7-23.2-118.7-23.2c-40.9,0-80.9,7.7-118.7,22.9
										c-39.1,15.8-74.2,38.9-104.3,68.8L73.1,478.3C49.3,501.9,30.9,529.4,18.3,560.2C6.2,589.9,0,621.3,0,653.6
										C0,685.7,6.1,717,18.1,746.7c12.4,30.7,30.7,58.2,54.3,81.899c23.6,23.7,51.2,42,81.9,54.5c29.7,12.101,61.1,18.2,93.3,18.2
										c32.2,0,63.6-6.1,93.3-18.1c30.8-12.5,58.399-30.8,82.1-54.4l269.101-268c17.3-17.2,30.6-37.3,39.699-59.7
										c8.801-21.6,13.2-44.5,13.2-67.899c0-48.2-18.8-93.2-52.899-127c-34-34.2-79.2-53.1-127.301-53.3c-48.199-0.1-93.5,18.6-127.6,52.7
										L269.6,473.3c-8.5,8.5-13.1,19.7-13.1,31.601c0,11.899,4.6,23.199,13.1,31.6l0.7,0.7c17.4,17.5,45.8,17.5,63.3,0.1l168-167.5
										c35.1-34.8,92.1-35,127.199-0.399c16.9,16.8,26.101,39.3,26.101,63.399c0,24.3-9.4,47.101-26.5,64.101l-269,268
										c-0.5,0.5-0.9,0.899-1.2,1.5c-29.7,28.899-68.9,44.699-110.5,44.5c-41.9-0.2-81.2-16.5-110.6-46c-14.7-15-26.1-32.5-34-52
										C95.5,694,91.7,674,91.7,653.6c0-41.8,16.1-80.899,45.4-110.3c0.4-0.3,0.7-0.6,1.1-0.899l337.9-337.8c0.3-0.3,0.6-0.7,0.899-1.1
										c21.4-21,46.3-37.4,74-48.5c27-10.8,55.4-16.2,84.601-16.2c29.199,0,57.699,5.6,84.6,16.4c27.9,11.3,52.9,27.8,74.3,49.1
										c21.4,21.4,37.9,46.4,49.2,74.3c10.9,26.9,16.4,55.4,16.4,84.6c0,29.3-5.5,57.9-16.5,85c-11.301,28-28,53.2-49.5,74.8l-233.5,232.8
										c-8.5,8.5-13.2,19.7-13.2,31.7s4.7,23.2,13.1,31.6l0.5,0.5c17.4,17.4,45.8,17.4,63.2,0L857.5,586.9
										C887.601,556.8,911,521.7,926.9,482.6C942.3,444.8,950,404.9,950,363.9c0-40.9-7.8-80.8-23.1-118.5
										C911.101,206.3,887.8,171.3,857.7,141.3z" />
								</g>
							</svg>

							<div id="ldpm-chat-attached-file-indicator" class="imm-chat__message-box__file__notification">1</div>
						</div>
						<button id="ldpm-send-message">
							<svg enable-background="new 0 0 24 24"
								viewBox="0 0 24 24"
								xmlns="http://www.w3.org/2000/svg"><path
									d="m8.75 17.612v4.638c0 .324.208.611.516.713.077.025.156.037.234.037.234 0 .46-.11.604-.306l2.713-3.692z" /><path
									d="m23.685.139c-.23-.163-.532-.185-.782-.054l-22.5 11.75c-.266.139-.423.423-.401.722.023.3.222.556.505.653l6.255 2.138 13.321-11.39-10.308 12.419 10.483 3.583c.078.026.16.04.242.04.136 0 .271-.037.39-.109.19-.116.319-.311.352-.53l2.75-18.5c.041-.28-.077-.558-.307-.722z" /></svg>
						</button>
					</form>
				</div>
			</div>
		</div>

		<div id="ldpm-pg-dialog" class="imm-pg-dialog imm-pg-dialog--is-hidden">
			<div class="imm-pg-dialog__container">
				<div>
					<label class="imm-pg-label">
						<span class="imm-pg-label__text">Name of the Group</span>
						<input id="ldpm-pg-name-input" class="imm-pg-input" name="name" type="text">
					</label>
				</div>
				<div class="imm-pg-participants__container">
					<label class="imm-pg-label">
						<span class="imm-pg-label__text">Add Participants</span>
					<input list="ldpm-pg-invited-ids-datalist" id="ldpm-pg-invited-id-select" name="invited_ids" class="imm-pg-input">
					</label>
					<datalist id="ldpm-pg-invited-ids-datalist" >
					</datalist>
					<div>
						<button id="ldpm-pg-invite-button" class="imm-pg-button imm-pg-button--is-success">Invite</button>
					</div>
				</div>
				<div id="ldpm-pg-invited-ids-content" class="imm-pg-list">
				</div>
				<div class="imm-pg-action-buttons">
					<button id="ldpm-pg-cancel" type="button" class="imm-pg-button imm-pg-button--is-cancel">Cancel</button>
					<button id="ldpm-pg-create" type="button" class="imm-pg-button imm-pg-button--is-success">Create</button>
				</div>
			</div>
		</div>
	</div>

<?php endif; ?>
