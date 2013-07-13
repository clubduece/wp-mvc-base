<?php
/**
 * The base options page view.
 *
 * @package WP Models\Views
 * @author Daryl Lozupone <daryl@actionhook.com>
 * @version 0.1
 * @since WP Base 0.1
 */
?>

<div class="wrap">
	<h2><?php echo $page['page_title'] ?></h2>			
	<form action="options.php" method="post">
			<?php
			if( isset( $options ) && count( $options ) > 0 ):
				foreach( $options as $key => $option):
					settings_fields( $option['option_group'] );
				endforeach;
			endif;
			?>
		<fieldset>
			<?php do_settings_sections( $page['menu_slug'] ); ?>
			<input name='Submit' type='submit' value='<?php echo _x( 'Save Changes', 'text for the options page submit button', $this->txtdomain ); ?>' />
		</fieldset>
	</form>
</div>