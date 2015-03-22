<?php  
/**
 * EOF Select Field Class
 *
 * All the logic for this field type
 *
 * @class       EOF_field_select
 * @extends     EOF_field
 * @package     EOF
 * @subpackages Fields
 */
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if( !class_exists('EOF_field_select') ) :

class EOF_field_select extends EOF_field {

	/**
	 * __construct
	 *
	 * This function will setup the field type data
	 * 
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct( $field, $value, $parent ) {
		//vars
		$this->parent = $parent;
		$this->option_name = $field['option_name'];
		$this->option_id   = parent::beautifyid($field['option_name']);

		$this->value = $value;
		$this->field = wp_parse_args( $field, array(
			'id'			=> '',
			'title'			=> '',
			'desc'			=> '',
			'default' 		=> '',
			'holder'		=> __('Select', 'eof'),
			'sizes'			=> 'regular',
			'readonly'		=> false,
			'options'		=> null
		) );

		// If value does not set, use the default
		if( is_null($this->value) ) {
			$this->value = $this->field['default'];
		}

		parent::__construct($this->field);
	}

	/**
	 * Render field
	 *
	 * Create the HTML interface for your field
	 *
	 * @param $field - an array holding all the field's data
	 *
	 * @since 1.0
	 * @return void
	 */
	public function render_field() {
		
		$options = (array) $this->field['options'];

		$class = '';
		switch ($this->field['sizes']) {
			case "small":
				$class .= ' seof-small-select';
				break;
			case "large":
				$class .= ' eof-large-select';
				break;
			default:
				$class .= ' eof-regular-select';
				break;
		}
	?>
		<select class="<?php echo $class; ?>" name="<?php echo $this->option_name; ?>" id="<?php echo $this->option_id; ?>">
		<?php  
			// Placeholder
			if( empty($this->value) && !empty($options) ) {
				echo '<option value="" disabled selected>'. $this->field['holder'] .'</option>';
			} elseif ( empty($options) ) {
				echo '<option value="" disabled selected>'. __('Nothing found.', 'eof') .'</option>';
			}

			foreach ($options as $val => $label) {
				printf('<option value="%1$s" %2$s>%3$s</option>',
					$val,
					selected($val, $this->value, false ),
					$label
				);
			}
		?>
		</select>
		<span class="description"><?php echo $this->field['desc']; ?></span>
	<?php
	}

	public function sanitize( $value ) {

		$sanitize_value = strip_tags($value);

		return $sanitize_value;
	}

}

endif;

?>