<?php
/**
 * @author  wpWax
 * @since   1.0
 * @version 1.0
 */
use \Directorist\Helper;

if ( ! defined( 'ABSPATH' ) ) exit;

?>

<div class="<?php Helper::directorist_row(); ?>">
    <div class="<?php Helper::directorist_column('lg-8'); ?>">
        <form action="#" id="directorist_helgent_config">
            <div class="">
                <div class="directorist-user-profile-edit">

                    <div class="directorist-card directorist-user-profile-box">

                        <div class="directorist-card__header">

                            <h4 class="directorist-card__header--title"><?php esc_html_e( 'Settings', 'directorist' ); ?></h4>

                        </div>

                        <div class="directorist-card__body">

                            <div class="directorist-user-info-wrap">
                                <div class="directorist-form-section">

                                    <div class="directorist-form-group">
                                        <label for="title"><?php esc_html_e( 'Email Form name', 'directorist' ); ?></label>
                                        <input class="directorist-form-element" value="<?php echo isset( $config['email_from_name'] ) ? esc_attr( $config['email_from_name']) : ''; ?>" type="text" name="email_from_name" placeholder="<?php esc_html_e( 'Dr. Jhone', 'directorist' ); ?>">
                                    </div>

                                    <div class="directorist-form-group">
                                        <label for="title"><?php esc_html_e( 'Email Form email', 'directorist' ); ?></label>
                                        <input class="directorist-form-element" value="<?php echo isset ($config['email_from_email']) ? esc_attr( $config['email_from_email']) : ''; ?>" type="text" name="email_from_email" placeholder="<?php esc_html_e( 'jhone@mail.com', 'directorist' ); ?>">
                                    </div>
                                </div>

                                <div class="directorist-form-section">

                                    <div class="directorist-form-group">
                                        <label for="title"><?php esc_html_e( 'Subject', 'directorist' ); ?></label>
                                        <input class="directorist-form-element" value="<?php echo isset($config['email_subject']) ? esc_attr( $config['email_subject']) : ''; ?>" type="text" name="email_subject" placeholder="<?php esc_html_e( 'A new message', 'directorist' ); ?>">
                                    </div>

                                    <div class="directorist-form-group">
                                        <label for="body"><?php esc_html_e( 'Body', 'directorist' ); ?></label>
                                        <?php
                                        wp_editor(
                                                isset($config['email_body']) ? wp_kses_post( $config['email_body'] ) : '',
                                                'email_body',
                                                array(
                                                'media_buttons' => false,
                                                'quicktags'     => true,
                                                'editor_height' => 200,	
                                            )
                                        );
                                        ?>
                                    </div>

                                </div>

                                <div class="directorist-form-section">

                                    <div class="directorist-form-group">
                                        <label for="title"><?php esc_html_e( 'Greeting Subject', 'directorist' ); ?></label>
                                        <input class="directorist-form-element" value="<?php echo isset($config['greeting_subject']) ? esc_attr( $config['greeting_subject']) : ''; ?>" type="text" name="greeting_subject" placeholder="<?php esc_html_e( 'Welcome to my channel', 'directorist' ); ?>">
                                    </div>

                                    <div class="directorist-form-group">
                                        <label for="body"><?php esc_html_e( 'Greeting Body', 'directorist' ); ?></label>
                                        <?php
                                        wp_editor(
                                            isset($config['greeting_body']) ? wp_kses_post( $config['greeting_body'] ) : '',
                                            'greeting_body',
                                            array(
                                                'media_buttons' => false,
                                                'quicktags'     => true,
                                                'editor_height' => 200,	
                                            )
                                        );
                                        ?>
                                    </div>

                                    <div class="directorist-form-group">
                                        <label for="body"><?php esc_html_e( 'Greeting Body (Guest)', 'directorist' ); ?></label>
                                        <?php
                                        wp_editor(
                                            isset($config['guest_greeting_body']) ? wp_kses_post( $config['guest_greeting_body'] ) : '',
                                            'guest_greeting_body',
                                            array(
                                                'media_buttons' => false,
                                                'quicktags'     => true,
                                                'editor_height' => 200,	
                                            )
                                        );
                                        ?>
                                    </div>

                                </div>

                                <input type="hidden" name="action" value="helpgent_user_config">
                                <input type="hidden" name="nonce" value="<?php echo directorist_get_nonce_key() ? wp_create_nonce( directorist_get_nonce_key() ): ''; ?>">

                                <button type="submit" class="directorist-btn directorist-btn-lg directorist-btn-dark directorist-btn-profile-save"><?php esc_html_e( 'Save', 'directorist' ); ?></button>

                                <div id="directorist-user-config-notice"></div>


                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </form>
    </div>

    <div class="<?php Helper::directorist_column('lg-4'); ?>">

        <div class="directorist-user-profile-edit">

            <div class="directorist-card directorist-user-profile-box directorist-allowed-placeholder">

                <div class="directorist-card__header">

                    <h4 class="directorist-card__header--title"><?php esc_html_e( 'Allowed Placeholders', 'directorist' ); ?></h4>

                </div>

                <div class="directorist-card__body">

                    <div class="directorist-user-info-wrap">
                        <div class="exlac-vm-note__content"><div class="exlac-vm-note__single"><span class="exlac-vm-note__single--label">{{NAME}}:</span><span class="exlac-vm-note__single--text">Name of the person who sent the first message.</span></div><div class="exlac-vm-note__single"><span class="exlac-vm-note__single--label">{{MESSAGE}}:</span><span class="exlac-vm-note__single--text">It outputs messege details.</span></div><div class="exlac-vm-note__single"><span class="exlac-vm-note__single--label">{{REPLIER_NAME}}:</span><span class="exlac-vm-note__single--text">Name of the message replier.</span></div><div class="exlac-vm-note__single"><span class="exlac-vm-note__single--label">{{TODAY}}:</span><span class="exlac-vm-note__single--text">It outputs the current date.</span></div><div class="exlac-vm-note__single"><span class="exlac-vm-note__single--label">{{NOW}}:</span><span class="exlac-vm-note__single--text">It outputs the current time.</span></div><div class="exlac-vm-note__single"><span class="exlac-vm-note__single--label">{{CONVERSATION_LINK}}:</span><span class="exlac-vm-note__single--text">It outputs the user dashboard page link.</span></div><div class="exlac-vm-note__single"><span class="exlac-vm-note__single--label">{{SITE_NAME}}:</span><span class="exlac-vm-note__single--text">It outputs your site name.</span></div><div class="exlac-vm-note__single"><span class="exlac-vm-note__single--label">{{SITE_LINK}}:</span><span class="exlac-vm-note__single--text">It outputs your site url with link.</span></div><div class="exlac-vm-note__single"><span class="exlac-vm-note__single--label">{{SITE_URL}}:</span><span class="exlac-vm-note__single--text">It outputs your site url with link.</span></div></div>
                    </div>

                </div>

            </div>

        </div>

	</div>
</div>