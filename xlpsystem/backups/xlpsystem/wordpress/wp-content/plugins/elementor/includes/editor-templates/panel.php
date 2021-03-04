<?php
namespace Elementor;

use Elementor\Core\Responsive\Responsive;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * @var Editor $this
 */
$document = Plugin::$instance->documents->get( $this->get_post_id() );

?>
<script type="text/template" id="tmpl-elementor-panel">
	<div id="elementor-mode-switcher"></div>
	<header id="elementor-panel-header-wrapper"></header>
	<main id="elementor-panel-content-wrapper"></main>
	<footer id="elementor-panel-footer">
		<div class="elementor-panel-container">
		</div>
	</footer>
</script>

<script type="text/template" id="tmpl-elementor-panel-menu">
	<div id="elementor-panel-page-menu-content"></div>
	<div id="elementor-panel-page-menu-footer">
		<a href="<?php echo esc_url( $document->get_exit_to_dashboard_url() ); ?>" id="elementor-panel-exit-to-dashboard" class="elementor-button elementor-button-default">
			<i class="fa fa-wordpress"></i>
			<?php echo __( 'Exit To Dashboard', 'elementor' ); ?>
		</a>
	</div>
</script>

<script type="text/template" id="tmpl-elementor-panel-menu-group">
	<div class="elementor-panel-menu-group-title">{{{ title }}}</div>
	<div class="elementor-panel-menu-items"></div>
</script>

<script type="text/template" id="tmpl-elementor-panel-menu-item">
	<div class="elementor-panel-menu-item-icon">
		<i class="{{ icon }}"></i>
	</div>
	<div class="elementor-panel-menu-item-title">{{{ title }}}</div>
</script>

<script type="text/template" id="tmpl-elementor-panel-header">
	<div id="elementor-panel-header-menu-button" class="elementor-header-button">
		<i class="elementor-icon eicon-menu-bar tooltip-target" aria-hidden="true" data-tooltip="<?php esc_attr_e( 'Menu', 'elementor' ); ?>"></i>
		<span class="elementor-screen-only"><?php echo __( 'Menu', 'elementor' ); ?></span>
	</div>
	<div id="elementor-panel-header-title"></div>
	<div id="elementor-panel-header-add-button" class="elementor-header-button">
		<i class="elementor-icon eicon-apps tooltip-target" aria-hidden="true" data-tooltip="<?php esc_attr_e( 'Widgets Panel', 'elementor' ); ?>"></i>
		<span class="elementor-screen-only"><?php echo __( 'Widgets Panel', 'elementor' ); ?></span>
	</div>
</script>

<script type="text/template" id="tmpl-elementor-panel-footer-content">
	<div id="elementor-panel-footer-settings" class="elementor-panel-footer-tool elementor-leave-open tooltip-target" data-tooltip="<?php esc_attr_e( 'Settings', 'elementor' ); ?>">
		<i class="fa fa-cog" aria-hidden="true"></i>
		<span class="elementor-screen-only"><?php printf( esc_html__( '%s Settings', 'elementor' ), $document::get_title() ); ?></span>
	</div>
	<div id="elementor-panel-footer-responsive" class="elementor-panel-footer-tool">
		<i class="eicon-device-desktop tooltip-target" aria-hidden="true" data-tooltip="<?php esc_attr_e( 'Responsive Mode', 'elementor' ); ?>"></i>
		<span class="elementor-screen-only">
			<?php echo __( 'Responsive Mode', 'elementor' ); ?>
		</span>
		<div class="elementor-panel-footer-sub-menu-wrapper">
			<div class="elementor-panel-footer-sub-menu">
				<div class="elementor-panel-footer-sub-menu-item" data-device-mode="desktop">
					<i class="elementor-icon eicon-device-desktop" aria-hidden="true"></i>
					<span class="elementor-title"><?php echo __( 'Desktop', 'elementor' ); ?></span>
					<span class="elementor-description"><?php echo __( 'Default Preview', 'elementor' ); ?></span>
				</div>
				<div class="elementor-panel-footer-sub-menu-item" data-device-mode="tablet">
					<i class="elementor-icon eicon-device-tablet" aria-hidden="true"></i>
					<span class="elementor-title"><?php echo __( 'Tablet', 'elementor' ); ?></span>
					<?php $breakpoints = Responsive::get_breakpoints(); ?>
					<span class="elementor-description"><?php echo sprintf( __( 'Preview for %s', 'elementor' ), $breakpoints['md'] . 'px' ); ?></span>
				</div>
				<div class="elementor-panel-footer-sub-menu-item" data-device-mode="mobile">
					<i class="elementor-icon eicon-device-mobile" aria-hidden="true"></i>
					<span class="elementor-title"><?php echo __( 'Mobile', 'elementor' ); ?></span>
					<span class="elementor-description"><?php echo __( 'Preview for 360px', 'elementor' ); ?></span>
				</div>
			</div>
		</div>
	</div>
	<div id="elementor-panel-footer-history" class="elementor-panel-footer-tool elementor-leave-open tooltip-target" data-tooltip="<?php esc_attr_e( 'History', 'elementor' ); ?>">
		<i class="fa fa-history" aria-hidden="true"></i>
		<span class="elementor-screen-only"><?php echo __( 'History', 'elementor' ); ?></span>
	</div>
	<div id="elementor-panel-saver-button-preview" class="elementor-panel-footer-tool tooltip-target" data-tooltip="<?php esc_attr_e( 'Preview Changes', 'elementor' ); ?>">
		<span id="elementor-panel-saver-button-preview-label">
			<i class="fa fa-eye" aria-hidden="true"></i>
			<span class="elementor-screen-only"><?php echo __( 'Preview Changes', 'elementor' ); ?></span>
		</span>
	</div>
	<div id="elementor-panel-saver-publish" class="elementor-panel-footer-tool">
		<button id="elementor-panel-saver-button-publish" class="elementor-button elementor-button-success elementor-saver-disabled">
			<span class="elementor-state-icon">
				<i class="fa fa-spin fa-circle-o-notch" aria-hidden="true"></i>
			</span>
			<span id="elementor-panel-saver-button-publish-label">
				<?php echo __( 'Publish', 'elementor' ); ?>
			</span>
		</button>
	</div>
	<div id="elementor-panel-saver-save-options" class="elementor-panel-footer-tool" >
		<button id="elementor-panel-saver-button-save-options" class="elementor-button elementor-button-success tooltip-target elementor-saver-disabled" data-tooltip="<?php esc_attr_e( 'Save Options', 'elementor' ); ?>">
			<i class="fa fa-caret-up" aria-hidden="true"></i>
			<span class="elementor-screen-only"><?php echo __( 'Save Options', 'elementor' ); ?></span>
		</button>
		<div class="elementor-panel-footer-sub-menu-wrapper">
			<p class="elementor-last-edited-wrapper">
				<span class="elementor-state-icon">
					<i class="fa fa-spin fa-circle-o-notch" aria-hidden="true"></i>
				</span>
				<span class="elementor-last-edited">
					{{{ elementor.config.document.last_edited }}}
				</span>
			</p>
			<div class="elementor-panel-footer-sub-menu">
				<div id="elementor-panel-saver-menu-save-draft" class="elementor-panel-footer-sub-menu-item elementor-saver-disabled">
					<i class="elementor-icon fa fa-save" aria-hidden="true"></i>
					<span class="elementor-title"><?php echo __( 'Save Draft', 'elementor' ); ?></span>
				</div>
				<div id="elementor-panel-saver-menu-save-template" class="elementor-panel-footer-sub-menu-item">
					<i class="elementor-icon fa fa-folder" aria-hidden="true"></i>
					<span class="elementor-title"><?php echo __( 'Save as Template', 'elementor' ); ?></span>
				</div>
			</div>
		</div>
	</div>
</script>

<script type="text/template" id="tmpl-elementor-mode-switcher-content">
	<input id="elementor-mode-switcher-preview-input" type="checkbox">
	<label for="elementor-mode-switcher-preview-input" id="elementor-mode-switcher-preview">
		<i class="fa" aria-hidden="true" title="<?php esc_attr_e( 'Hide Panel', 'elementor' ); ?>"></i>
		<span class="elementor-screen-only"><?php echo __( 'Hide Panel', 'elementor' ); ?></span>
	</label>
</script>

<script type="text/template" id="tmpl-editor-content">
	<div class="elementor-panel-navigation">
		<# _.each( elementData.tabs_controls, function( tabTitle, tabSlug ) {
			if ( 'content' !== tabSlug && ! elementor.userCan( 'design' ) ) {
			return;
		}
			#>
			<div class="elementor-panel-navigation-tab elementor-tab-control-{{ tabSlug }}" data-tab="{{ tabSlug }}">
				<a href="#">{{{ tabTitle }}}</a>
			</div>
		<# } ); #>
	</div>
	<# if ( elementData.reload_preview ) { #>
		<div class="elementor-update-preview">
			<div class="elementor-update-preview-title"><?php echo __( 'Update changes to page', 'elementor' ); ?></div>
			<div class="elementor-update-preview-button-wrapper">
				<button class="elementor-update-preview-button elementor-button elementor-button-success"><?php echo __( 'Apply', 'elementor' ); ?></button>
			</div>
		</div>
	<# } #>
	<div id="elementor-controls"></div>
</script>

<script type="text/template" id="tmpl-elementor-panel-schemes-disabled">
	<i class="elementor-panel-nerd-box-icon eicon-nerd" aria-hidden="true"></i>
	<div class="elementor-panel-nerd-box-title">{{{ '<?php echo __( '%s are disabled', 'elementor' ); ?>'.replace( '%s', disabledTitle ) }}}</div>
	<div class="elementor-panel-nerd-box-message"><?php printf( __( 'You can enable it from the <a href="%s" target="_blank">Elementor settings page</a>.', 'elementor' ), Settings::get_url() ); ?></div>
</script>

<script type="text/template" id="tmpl-elementor-panel-scheme-color-item">
	<div class="elementor-panel-scheme-color-input-wrapper">
		<input type="text" class="elementor-panel-scheme-color-value" value="{{ value }}" data-alpha="true" />
	</div>
	<div class="elementor-panel-scheme-color-title">{{{ title }}}</div>
</script>

<script type="text/template" id="tmpl-elementor-panel-scheme-typography-item">
	<div class="elementor-panel-heading">
		<div class="elementor-panel-heading-toggle">
			<i class="fa" aria-hidden="true"></i>
		</div>
		<div class="elementor-panel-heading-title">{{{ title }}}</div>
	</div>
	<div class="elementor-panel-scheme-typography-items elementor-panel-box-content">
		<?php
		$scheme_fields_keys = Group_Control_Typography::get_scheme_fields_keys();

		$typography_group = Plugin::$instance->controls_manager->get_control_groups( 'typography' );
		$typography_fields = $typography_group->get_fields();

		$scheme_fields = array_intersect_key( $typography_fields, array_flip( $scheme_fields_keys ) );

		foreach ( $scheme_fields as $option_name => $option ) :
		?>
			<div class="elementor-panel-scheme-typography-item">
				<div class="elementor-panel-scheme-item-title elementor-control-title"><?php echo $option['label']; ?></div>
				<div class="elementor-panel-scheme-typography-item-value">
					<?php if ( 'select' === $option['type'] ) : ?>
						<select name="<?php echo esc_attr( $option_name ); ?>" class="elementor-panel-scheme-typography-item-field">
							<?php foreach ( $option['options'] as $field_key => $field_value ) : ?>
								<option value="<?php echo esc_attr( $field_key ); ?>"><?php echo $field_value; ?></option>
							<?php endforeach; ?>
						</select>
					<?php elseif ( 'font' === $option['type'] ) : ?>
						<select name="<?php echo esc_attr( $option_name ); ?>" class="elementor-panel-scheme-typography-item-field">
							<option value=""><?php echo __( 'Default', 'elementor' ); ?></option>
							<?php foreach ( Fonts::get_font_groups() as $group_type => $group_label ) : ?>
								<optgroup label="<?php echo esc_attr( $group_label ); ?>">
									<?php foreach ( Fonts::get_fonts_by_groups( [ $group_type ] ) as $font_title => $font_type ) : ?>
										<option value="<?php echo esc_attr( $font_title ); ?>"><?php echo $font_title; ?></option>
									<?php endforeach; ?>
								</optgroup>
							<?php endforeach; ?>
						</select>
					<?php elseif ( 'text' === $option['type'] ) : ?>
						<input name="<?php echo esc_attr( $option_name ); ?>" class="elementor-panel-scheme-typography-item-field" />
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</script>

<script type="text/template" id="tmpl-elementor-control-responsive-switchers">
	<div class="elementor-control-responsive-switchers">
		<#
			var devices = responsive.devices || [ 'desktop', 'tablet', 'mobile' ];

			_.each( devices, function( device ) { #>
				<a class="elementor-responsive-switcher elementor-responsive-switcher-{{ device }}" data-device="{{ device }}">
					<i class="eicon-device-{{ device }}"></i>
				</a>
			<# } );
		#>
	</div>
</script>

<script type="text/template" id="tmpl-elementor-control-dynamic-switcher">
	<div class="elementor-control-dynamic-switcher-wrapper">
		<div class="elementor-control-dynamic-switcher">
			<?php echo __( 'Dynamic', 'elementor' ); ?>
			<i class="fa fa-database"></i>
		</div>
	</div>
</script>

<script type="text/template" id="tmpl-elementor-control-dynamic-cover">
    <div class="elementor-dynamic-cover__settings">
        <i class="fa fa-{{ hasSettings ? 'wrench' : 'database' }}"></i>
    </div>
	<div class="elementor-dynamic-cover__title" title="{{{ title + ' ' + content }}}">{{{ title + ' ' + content }}}</div>
	<# if ( isRemovable ) { #>
		<div class="elementor-dynamic-cover__remove">
			<i class="fa fa-times-circle"></i>
		</div>
	<# } #>
</script>

<script type="text/template" id="tmpl-elementor-panel-page-settings">
	<div class="elementor-panel-navigation">
		<# _.each( elementor.config.page_settings.tabs, function( tabTitle, tabSlug ) { #>
			<div class="elementor-panel-navigation-tab elementor-tab-control-{{ tabSlug }}" data-tab="{{ tabSlug }}">
				<a href="#">{{{ tabTitle }}}</a>
			</div>
			<# } ); #>
	</div>
	<div id="elementor-panel-page-settings-controls"></div>
</script>
