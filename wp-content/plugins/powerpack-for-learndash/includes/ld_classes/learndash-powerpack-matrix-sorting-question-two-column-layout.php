<?php
/**
 * Load class
 *
 * @version 1.0.0
 * @package LearnDash PowerPack
 */

defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'LearnDash_PowerPack_Matrix_Sorting_Question_Two_Column_Layout', false ) ) {
	/**
	 * LearnDash_PowerPack_Matrix_Sorting_Question_Two_Column_Layout Class.
	 */
	class LearnDash_PowerPack_Matrix_Sorting_Question_Two_Column_Layout {
		public $current_class = '';

		/**
		 * Hook.
		 */
		public function __construct() {
			$this->current_class = get_class( $this );

			if ( if_current_class_is_active( $this->current_class ) === 'active' ) {
				add_action( 'wp_footer', [ $this, 'learndash_wp_footer_func_matrix' ] );
			}
		}

		/**
		 * Returns the CSS style for Sorting Questions in 2 columns.
		 */
		public function learndash_wp_footer_func_matrix() {
			$option_active_status = if_current_class_is_active( $this->current_class );

			if ( 'active' !== $option_active_status ) {
				return;
			}
			?>
			<style>
				/* Quiz Matrix Sorting Question 2 Column */
				.ldx-plugin .learndash .wpProQuiz_content .wpProQuiz_matrixSortString {
					display: inline-block;
					max-width: 30%;
					margin-right: 10%;
				}

				.learndash-wrapper .wpProQuiz_content .wpProQuiz_listItem .wpProQuiz_question ul.wpProQuiz_questionList {
					max-width: 50%;
					display: inline-block;
					width: 100%;
				}
			</style>
			<?php
		}

		/**
		 * Add class details.
		 *
		 * @return array The class details.
		 */
		public function learndash_powerpack_class_details() {
			$ld_type           = esc_html__( 'question', 'learndash-powerpack' );
			$class_title       = esc_html__( 'Matrix Sorting Question', 'learndash-powerpack' );
			$class_description = esc_html__( 'Display Matrix Sorting Question 2 Column Layout', 'learndash-powerpack' );
			$deprecated        = esc_html__( 'Setting Deprecated due the functionality is already on LearnDash Core', 'learndash-powerpack' );
			$deprecated_date   = gmdate( 'Y-m-d', strtotime( '2021-07-29' ) );

			return [
				'title'           => $class_title,
				'ld_type'         => $ld_type,
				'description'     => $class_description,
				'settings'        => false,
				'deprecated'      => $deprecated,
				'deprecated_date' => $deprecated_date,
			];
		}
	}

	new LearnDash_PowerPack_Matrix_Sorting_Question_Two_Column_Layout();
}

