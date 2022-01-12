<?php
/**
 * Created by PhpStorm.
 * User: michaeldajewski
 * Date: 11/03/20
 * Time: 16:38
 */

?>

<div class="sfwd sfwd_options">

	<div id="elc_ldquiz_embed_section">

		<!--		enable, checkbox field-->
		<div id=elc_qrcode_options_enable_field" class="sfwd_input sfwd_input_type_checkbox">
			<span class="sfwd_option_label" style="text-align:right;vertical-align:top;">
				<a class="sfwd_help_text_link" style="cursor:pointer;" title="Click for Help!"
				   onclick="toggleVisibility('elc_qrcode_options_enable_tip');">
					<img src="<?php echo LEARNDASH_LMS_PLUGIN_URL . 'assets/images/question.png' ?>">
					<label class="sfwd_label textinput"><?php _e( 'Insert as a part of background', 'text-domain' ); ?></label>
				</a>
				<div id="elc_qrcode_options_enable_tip" class="sfwd_help_text_div"
				     style="display: none;">
					<label class="sfwd_help_text">
						<?php _e( 'If enabled the QR-Code will be inserted as a part of background. It will not alter/affect the text inserted in textarea above. <br><strong>DO NOT FORGET</strong> to remove any QR-Code shortcode(s) in certificate content (textarea above).', 'elc-ctid-tracker' ); ?>
					</label>
				</div>
			</span>
			<span class="sfwd_option_input">
				<div class="sfwd_option_div">
					<p class="learndash-section-field-checkbox-p">
						<input
							type="checkbox"
							autocomplete="off"
							id="elc_qrcode_options_enable"
							name="elc_qrcode_options[enable]"
							class="learndash-section-field learndash-section-field-checkbox ld-checkbox-input"
							value="1"
							data-dependent="elc_ld_quiz_embed"
							<?php checked( '1', $enable ); ?>
						>
						<label class="ld-checkbox-input__label" for="elc_qrcode_options_enable">
							<span><?php esc_html_e( 'Enable', 'elc-ctid-tracker' ); ?></span>
						</label>
					</p>
				</div>
			</span>

			<p style="clear:left"></p>
		</div>

		<div id="elc-ctid-qrcode" <?php echo empty( $enable ) ? ' style="position: absolute; left: -100%"' : '' ?>>

			<!--		data, url field URL-->
			<div id=elc_qrcode_options_data" class="sfwd_input sfwd_input_type_text">
				<span class="sfwd_option_label">
					<a class="sfwd_help_text_link" style="cursor:pointer;" title="Click for Help!"
					   onclick="toggleVisibility('elc_qrcode_options_data_tip');">
						<img alt="" src="<?php echo LEARNDASH_LMS_PLUGIN_URL . 'assets/images/question.png' ?>">
						<label for="elc_qrcode_options_data" class="sfwd_label">QR-Code data</label>
					</a>
					<div id="elc_qrcode_options_data_tip" class="sfwd_help_text_div" style="display: none;">
						<label class="sfwd_help_text">
							<?php _e( 'Enter valid URL to the certificate ID verification page.', 'elc-ctid-tracker' ); ?>
						</label>
					</div>
				</span>
				<span class="sfwd_option_input">
					<div class="sfwd_option_div">
						<input
							type="url"
							size="30"
							autocomplete="off"
							id="elc_qrcode_options_data"
							name="elc_qrcode_options[data]"
							class="learndash-section-field learndash-section-field-text regular-text"
							value="<?php echo esc_url_raw( $elc_qrcode_options_meta[ 'data' ] ); ?>">
					</div>
				</span>
			</div>

			<!--		link, checkbox field-->
			<div id="elc_qrcode_options_link_field" class="sfwd_input sfwd_input_type_checkbox ">
				<span class="sfwd_option_label">
					<a class="sfwd_help_text_link" style="cursor:pointer;" title="Click for Help!"
					   onclick="toggleVisibility('elc_qrcode_options_link_tip');">
						<img alt="" src="<?php echo LEARNDASH_LMS_PLUGIN_URL . 'assets/images/question.png' ?>">
						<label for="elc_qrcode_options_link" class="sfwd_label">Make QR-Code clickable</label>
					</a>
					<div id="elc_qrcode_options_link_tip" class="sfwd_help_text_div" style="display: none;">
						<label class="sfwd_help_text">
							<?php _e( 'If checked the Qr-Code will be clickable, when viewed on desktop and/or mobile devices.', 'elc-ctid-tracker' ); ?>
						</label>
					</div>
				</span>
				<span class="sfwd_option_input">
					<div class="sfwd_option_div">
						<fieldset>
							<legend class="screen-reader-text"><span>Link</span></legend>
							<p class="learndash-section-field-checkbox-p">
								<input
									autocomplete="off"
									type="checkbox"
									id="elc_qrcode_options_link"
									name="elc_qrcode_options[link]"
									class="learndash-section-field learndash-section-field-checkbox  ld-checkbox-input"
									value="1" <?php checked( '1', $link ); ?>
								>
								<label class="ld-checkbox-input__label" for="elc_qrcode_options_link">
									<span>Enable</span>
								</label>
							</p>
						</fieldset>
					</div>
				</span>

				<p class="ld-clear"></p>
			</div>

			<!--		size, (float) text field-->
			<div id="elc_qrcode_options_size_field" class="sfwd_input sfwd_input_type_number ">
				<span class="sfwd_option_label">
					<a class="sfwd_help_text_link" style="cursor:pointer;" title="Click for Help!"
					   onclick="toggleVisibility('elc_qrcode_options_size_tip');">
						<img alt="" src="<?php echo LEARNDASH_LMS_PLUGIN_URL . 'assets/images/question.png' ?>">
						<label for="elc_qrcode_options_size" class="sfwd_label">Size</label>
					</a>
					<div id="elc_qrcode_options_size_tip" class="sfwd_help_text_div" style="display: none;">
						<label class="sfwd_help_text">
							<?php _e( 'Width and height of QR-Code in user units. <br>By default the TCPDF is set to millimeters (mm).', 'elc-ctid-tracker' ); ?>
						</label>
					</div>
				</span>

				<span class="sfwd_option_input">
					<div class="sfwd_option_div">
						<input
							autocomplete="off"
							type="number"
							name="elc_qrcode_options[size]"
							id="elc_qrcode_options_size"
							class="learndash-section-field learndash-section-field-number small-text"
							can_decimal="3"
							min="7.125"
							step="any"
							size="12"
							value="<?php echo $elc_qrcode_options_meta[ 'size' ]; ?>"
						>
						( user units )
					</div>
				</span>

				<p class="ld-clear"></p>
			</div>

			<!--		padding, (int) number field-->
			<div id="elc_qrcode_options_padding_field" class="sfwd_input sfwd_input_type_number ">
				<span class="sfwd_option_label">
					<a class="sfwd_help_text_link" style="cursor:pointer;" title="Click for Help!"
					   onclick="toggleVisibility('elc_qrcode_options_padding_tip');">
						<img alt="" src="<?php echo LEARNDASH_LMS_PLUGIN_URL . 'assets/images/question.png' ?>">
						<label for="elc_qrcode_options_padding" class="sfwd_label">Padding</label>
					</a>
					<div id="elc_qrcode_options_padding_tip" class="sfwd_help_text_div" style="display: none;">
						<label class="sfwd_help_text">
							<?php _e( 'Uniform (all sides), measured in QR-Code modules. <br>If QR-Code is placed over graphics it requires background (plain color) and clear space \'quiet zone\' around it.', 'elc-ctid-tracker' ); ?>
						<br>Default: 0
						</label>
					</div>
				</span>

				<span class="sfwd_option_input">
					<div class="sfwd_option_div">
						<input
							autocomplete="off"
							type="number"
							name="elc_qrcode_options[padding]"
							id="elc_qrcode_options_padding"
							class="learndash-section-field learndash-section-field-number small-text"
							min="0"
							step="any"
							size="12"
							value="<?php echo $elc_qrcode_options_meta[ 'padding' ]; ?>"
						>
						( qr-code modules )
					</div>
				</span>

				<p class="ld-clear"></p>
			</div>

			<!--		align, select field-->
			<div id="elc_qrcode_options_align_field" class="sfwd_input sfwd_input_type_select-edit-delete ">
				<span class="sfwd_option_label">
					<a class="sfwd_help_text_link" style="cursor:pointer;" title="Click for Help!"
					   onclick="toggleVisibility('elc_qrcode_options_align_tip');">
						<img alt="" src="<?php echo LEARNDASH_LMS_PLUGIN_URL . 'assets/images/question.png' ?>">
						<label for="elc_qrcode_options_align" class="sfwd_label"><?php esc_html_e( 'Horizontal align', 'elc-ctid-tracker' ); ?></label>
					</a>
					<div id="elc_qrcode_options_align_tip" class="sfwd_help_text_div" style="display: none;">
						<label class="sfwd_help_text">
							<?php _e( 'Horizontal alignment left or right. <br>Indicates insertion point relative to the qr-code.', 'elc-ctid-tracker' ); ?>
						</label>
					</div>
				</span>

				<span class="sfwd_option_input">
					<div class="sfwd_option_div">
						<select
							type="select"
							name="elc_qrcode_options[align]"
							id="elc_qrcode_options_align"
							class="learndash-section-field learndash-section-field-select">
							<?php
							foreach( $elc_qrcode_options[ 'align' ] as $key => $label ) {
								?>
								<option <?php selected( $key, $elc_qrcode_options_meta[ 'align' ] ); ?>
									value="<?php echo esc_attr( $key ); ?>"><?php echo esc_attr( $label ); ?></option>
								<?php
							}
							?>
						</select>
					</div>
				</span>

				<p class="ld-clear"></p>
			</div>

			<!--		position, select field-->
			<div id="elc_qrcode_options_position_field" class="sfwd_input sfwd_input_type_select-edit-delete ">
				<span class="sfwd_option_label">
					<a class="sfwd_help_text_link" style="cursor:pointer;" title="Click for Help!"
					   onclick="toggleVisibility('elc_qrcode_options_position_tip');">
						<img alt="" src="<?php echo LEARNDASH_LMS_PLUGIN_URL . 'assets/images/question.png' ?>">
						<label for="elc_qrcode_options_position"
						       class="sfwd_label"><?php esc_html_e( 'Vertical align', 'elc-ctid-tracker' ); ?></label>
					</a>
					<div id="elc_qrcode_options_position_tip" class="sfwd_help_text_div" style="display: none;">
						<label class="sfwd_help_text">
							<?php _e( 'Vertical alignment top or bottom. <br>Indicates insertion point relative to the qr-code.', 'elc-ctid-tracker' ); ?>
						</label>
					</div>
				</span>

				<span class="sfwd_option_input">
					<div class="sfwd_option_div">
						<select
							type="select"
							name="elc_qrcode_options[position]"
							id="elc_qrcode_options_position"
							class="learndash-section-field learndash-section-field-select">
							<?php
							foreach( $elc_qrcode_options[ 'position' ] as $key => $label ) {
								?>
								<option <?php selected( $key, $elc_qrcode_options_meta[ 'position' ] ); ?>
									value="<?php echo esc_attr( $key ); ?>"><?php echo esc_attr( $label ); ?></option>
								<?php
							}
							?>
						</select>
					</div>
				</span>

				<p class="ld-clear"></p>
			</div>

			<!--		x, (float) number field-->
			<div id="elc_qrcode_options_x_field" class="sfwd_input sfwd_input_type_number ">
				<span class="sfwd_option_label">
					<a class="sfwd_help_text_link" style="cursor:pointer;" title="Click for Help!"
					   onclick="toggleVisibility('elc_qrcode_options_x_tip');">
						<img alt="" src="<?php echo LEARNDASH_LMS_PLUGIN_URL . 'assets/images/question.png' ?>">
						<label for="elc_qrcode_options_x" class="sfwd_label"><?php esc_html_e( 'X position', 'elc-ctid-tracker' ); ?></label>
					</a>
					<div id="elc_qrcode_options_x_tip" class="sfwd_help_text_div" style="display: none;">
						<label class="sfwd_help_text">
							<?php _e( 'Horizontal position in user units. By default the TCPDF is set to millimeters (mm).<br> The position is measured from left or right side of document depending on \'Horizontal align\' setting.', 'elc-ctid-tracker' ); ?>
						</label>
					</div>
				</span>

				<span class="sfwd_option_input">
					<div class="sfwd_option_div">
						<input
							autocomplete="off"
							type="number"
							name="elc_qrcode_options[x]"
							id="elc_qrcode_options_x"
							class="learndash-section-field learndash-section-field-number small-text"
							can_decimal="3"
							min="0"
							step="any"
							size="12"
							value="<?php echo $elc_qrcode_options_meta[ 'x' ]; ?>"
						>
						( user units )
					</div>
				</span>

				<p class="ld-clear"></p>
			</div>

			<!--		y, (float) number field-->
			<div id="elc_qrcode_options_y_field" class="sfwd_input sfwd_input_type_number ">
				<span class="sfwd_option_label">
					<a class="sfwd_help_text_link" style="cursor:pointer;" title="Click for Help!"
					   onclick="toggleVisibility('elc_qrcode_options_y_tip');">
						<img alt="" src="<?php echo LEARNDASH_LMS_PLUGIN_URL . 'assets/images/question.png' ?>">
						<label for="elc_qrcode_options_y" class="sfwd_label"><?php esc_html_e( 'Y position', 'elc-ctid-tracker' ); ?></label>
					</a>
					<div id="elc_qrcode_options_y_tip" class="sfwd_help_text_div" style="display: none;">
						<label class="sfwd_help_text">
							<?php _e( 'Vertical position in user units. By default the TCPDF is set to mm (millimeters).<br> The position is measured from top or bottom side of document depending on \'Vertical align\' setting.', 'elc-ctid-tracker' ); ?>
						</label>
					</div>
				</span>

				<span class="sfwd_option_input">
					<div class="sfwd_option_div">
						<input
							autocomplete="off"
							type="number"
							name="elc_qrcode_options[y]"
							id="elc_qrcode_options_y"
							class="learndash-section-field learndash-section-field-number small-text"
							can_decimal="3"
							min="0"
							step="any"
							size="12"
							step="any"
							value="<?php echo $elc_qrcode_options_meta[ 'y' ]; ?>"
						>
						( user units )
					</div>
				</span>

				<p class="ld-clear"></p>
			</div>

			<div class="sfwd_input">
				<span class="sfwd_option_label" style="font-weight: inherit;"><?php _e( 'Example', 'elc-ctid-tracker' ); ?></span>
				<span class="sfwd_option_input">
					<object id="svg-object" width="266" data="<?php echo $obj_data_attribute; ?>" type="image/svg+xml"></object>
				</span>
			</div>

			<!--		fgcolor, (color format) text field-->
			<div id=elc_qrcode_options_fgcolor" class="sfwd_input sfwd_input_type_text">
				<span class="sfwd_option_label">
					<a class="sfwd_help_text_link" style="cursor:pointer;" title="Click for Help!"
					   onclick="toggleVisibility('elc_qrcode_options_fgcolor_tip');">
						<img alt="" src="<?php echo LEARNDASH_LMS_PLUGIN_URL . 'assets/images/question.png' ?>">
						<label for="elc_qrcode_options_fgcolor" class="sfwd_label">Foreground color</label>
					</a>
					<div id="elc_qrcode_options_fgcolor_tip" class="sfwd_help_text_div" style="display: none;">
						<label class="sfwd_help_text">
							<?php _e( 'Color in valid format:', 'elc-ctid-tracker' ); ?>
							<ul style="list-style: inherit; margin-top: 0.125em;">
								<li>
									<?php _e( 'Hexadecimal (3 or 6 digits) e.g.: ', 'elc-ctid-tracker' ); ?>
									#F00 or #FF0000,
								</li>
								<li>
									<?php _e( 'RGB e.g.: ', 'elc-ctid-tracker' ); ?>
									rgb(255,0,0),
								</li>
								<li>
									<?php _e( 'CMYK e.g.: ', 'elc-ctid-tracker' ); ?>
									cmyk(0,100,100,0),
								</li>
								<li>
									<?php _e( 'WEB color name e.g.: red.', 'elc-ctid-tracker' ); ?>
								</li>
							</ul>
							<?php _e( 'Default: #FFF (black)', 'elc-ctid-tracker' ); ?>
						</label>
					</div>
				</span>
				<span class="sfwd_option_input">
					<div class="sfwd_option_div">
						<input
							type="text"
							size="11"
							autocomplete="off"
							id="elc_qrcode_options_fgcolor"
							name="elc_qrcode_options[fgcolor]"
							class="learndash-section-field learndash-section-field-text regular-text"
							style="max-width: 130px;"
							value="<?php echo $elc_qrcode_options_meta[ 'fgcolor' ]; ?>"
						>
					</div>
				</span>
			</div>

			<!--		bg_color, (color format) text field-->
			<div id=elc_qrcode_options_bgcolor" class="sfwd_input sfwd_input_type_text">
				<span class="sfwd_option_label">
					<a class="sfwd_help_text_link" style="cursor:pointer;" title="Click for Help!"
					   onclick="toggleVisibility('elc_qrcode_options_bgcolor_tip');">
						<img alt="" src="<?php echo LEARNDASH_LMS_PLUGIN_URL . 'assets/images/question.png' ?>">
						<label for="elc_qrcode_options_bgcolor" class="sfwd_label">Background color</label>
					</a>
					<div id="elc_qrcode_options_bgcolor_tip" class="sfwd_help_text_div" style="display: none;">
						<label class="sfwd_help_text">
							<?php _e( 'Color in valid format:', 'elc-ctid-tracker' ); ?>
							<ul style="list-style: inherit; margin-top: 0.125em;">
								<li>
									<?php _e( 'Hexadecimal (3 or 6 digits) e.g.: ', 'elc-ctid-tracker' ); ?>
									#FF0 or #FFFF00,
								</li>
								<li>
									<?php _e( 'RGB e.g.: ', 'elc-ctid-tracker' ); ?>
									rgb(255,255,0),
								</li>
								<li>
									<?php _e( 'CMYK e.g.: ', 'elc-ctid-tracker' ); ?>
									CMYK e.g.: cmyk(0,0,100,0),
								</li>
								<li>
									<?php _e( 'WEB color name e.g.: yellow.', 'elc-ctid-tracker' ); ?>
								</li>
							</ul>
							<?php _e( 'Default: none (transparent)', 'elc-ctid-tracker' ); ?>
						</label>
					</div>
				</span>
				<span class="sfwd_option_input">
					<div class="sfwd_option_div">
						<input
							type="text"
							size="11"
							autocomplete="off"
							id="elc_qrcode_options_bgcolor"
							name="elc_qrcode_options[bgcolor]"
							class="learndash-section-field learndash-section-field-text regular-text"
							style="max-width: 130px;"
							value="<?php echo $elc_qrcode_options_meta[ 'bgcolor' ]; ?>"
						>
					</div>
				</span>
			</div>

			<!--		border, (float) text field-->
			<div id="elc_qrcode_options_border_field" class="sfwd_input sfwd_input_type_checkbox ">
				<span class="sfwd_option_label">
					<a class="sfwd_help_text_link" style="cursor:pointer;" title="Click for Help!"
					   onclick="toggleVisibility('elc_qrcode_options_border_tip');">
						<img alt="" src="<?php echo LEARNDASH_LMS_PLUGIN_URL . 'assets/images/question.png' ?>">
						<label for="elc_qrcode_options_border" class="sfwd_label">Border</label>
					</a>
					<div id="elc_qrcode_options_border_tip" class="sfwd_help_text_div" style="display: none;">
						<label class="sfwd_help_text">
							<?php _e( 'Black border (all sides), 1pt line-weight.', 'elc-ctid-tracker' ); ?>
						</label>
					</div>
				</span>
				<span class="sfwd_option_input">
					<div class="sfwd_option_div">
						<fieldset>
							<legend class="screen-reader-text"><span>Link</span></legend>
							<p class="learndash-section-field-checkbox-p">
								<input
									autocomplete="off"
									type="checkbox"
									id="elc_qrcode_options_border"
									name="elc_qrcode_options[border]"
									class="learndash-section-field learndash-section-field-checkbox  ld-checkbox-input"
									value="1" <?php checked( '1', $border ); ?>
								>
								<label class="ld-checkbox-input__label" for="elc_qrcode_options_border">
									<span>Enable</span>
								</label>
							</p>
						</fieldset>
					</div>
				</span>

				<p class="ld-clear"></p>
			</div>

			<!--		ecl, select field-->
			<div id="elc_qrcode_options_ecl_field" class="sfwd_input sfwd_input_type_select-edit-delete ">
				<span class="sfwd_option_label">
					<a class="sfwd_help_text_link" style="cursor:pointer;" title="Click for Help!"
					   onclick="toggleVisibility('elc_qrcode_options_ecl_tip');">
						<img alt="" src="<?php echo LEARNDASH_LMS_PLUGIN_URL . 'assets/images/question.png' ?>">
						<label for="elc_qrcode_options_ecl" class="sfwd_label">Error Correction Level</label>
					</a>
					<div id="elc_qrcode_options_ecl_tip" class="sfwd_help_text_div" style="display: none;">
						<label class="sfwd_help_text">
							<?php _e( 'Advanced use only! <br>Error correction capability to restore data if the code is physically dirty or damaged. <br> For explanation see: <a href="https://www.qrcode.com/en/about/error_correction.html" target="_blank">QR Code.com, Error correction feature</a> <br>Default: L (low)', 'elc-ctid-tracker' ); ?>
						</label>
					</div>
				</span>

				<span class="sfwd_option_input">
					<div class="sfwd_option_div">
						<select
								type="select"
								name="elc_qrcode_options[ecl]"
								id="elc_qrcode_options_ecl"
								class="learndash-section-field learndash-section-field-select">
							<?php
							foreach( $elc_qrcode_options[ 'ecl' ] as $key => $label ) {
								?>
								<option <?php selected( $key, $elc_qrcode_options_meta[ 'ecl' ] ); ?>
										value="<?php echo esc_attr( $key ); ?>"><?php echo esc_attr( $label ); ?></option>
								<?php
							}
							?>
						</select>
					</div>
				</span>

				<p class="ld-clear"></p>
			</div>

		</div>

	</div>
</div>