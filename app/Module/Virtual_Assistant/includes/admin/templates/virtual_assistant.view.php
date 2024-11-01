<?php $this->sortform(); ?>
<?php 
	$activity = array(
		'speak' => esc_html__( 'Speak', 'virtual-assistant' ),
		'read' => esc_html__( 'Read', 'virtual-assistant' ),
		'go_to_link' => esc_html__( 'Go to link', 'virtual-assistant' ),
		'scroll' => esc_html__( 'Scroll', 'virtual-assistant' ),
		'add_to_cart' => esc_html__( 'Add To Cart (Woocommerce)', 'virtual-assistant' ),
		'time' => esc_html__( 'Time', 'virtual-assistant' ),
		'custom' => esc_html__( 'Custom', 'virtual-assistant' ),
	);
 ?>
<table class="wp-list-table widefat" id="rc-shortcode-table">
	<thead>
		<tr>
			<th width="30px" align="center"></th>
			<th width="100px"><?php esc_html_e('ID', 'virtual-assistant') ?></th>
			<th><?php esc_html_e('Voice Command', 'virtual-assistant') ?></th>
			<th width="150px"><?php esc_html_e('Ativity', 'virtual-assistant') ?></th>
			<th width="100px" style="text-align: center"><?php esc_html_e('Action', 'virtual-assistant') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($this->shortcodes as $id => $shortcode) {
				$act = get_post_meta($shortcode->ID, EXLAC_VA_PREFIX . 'activity', true);
		?>
			<tr>
				<td width="30px" align="center">
					<input type="checkbox" id="checked_remove-<?php echo esc_html($shortcode->ID) ?>" class="checked_remove" data-id="<?php echo esc_html($shortcode->ID) ?>" value="" style="margin-right:10px;">
				</td>
				<td><strong><?php echo esc_html($shortcode->ID) ?></strong></td>
				<td><?php echo esc_html($shortcode->post_title) ?></td>
				<td><?php if(isset($activity[$act])) echo esc_html($activity[$act]) ?>
				<td style="text-align:right">
                    <a class="button success bbhelp--top" bbhelp-label="<?php esc_html_e('Edit', 'virtual-assistant'); ?>" href="<?php echo admin_url('admin.php?page='.EXLAC_VA_ADD_VIRTUAL_ASSISTANT_SLUG.'&ID=' . $shortcode->ID) ?>">
						<span class="dashicons dashicons-edit"></span>
                    </a>
					<button class="bb-button-delete button danger bbhelp--top" bbhelp-label="<?php esc_html_e('Delete', 'virtual-assistant'); ?>" data-id="<?php echo esc_html($shortcode->ID) ?>">
						<span class="dashicons dashicons-trash"></span></button>

				</td>
			</tr>
		<?php
			}
		?>
	</tbody>
</table>

<?php $this->sortform(); ?>
