<?php
    $allCommands =  get_posts(array(
        'numberposts' => -1,
        'post_type' => EXLAC_VA_POSTTYPE,
    ));
    $textIntro = trim(bb_option(EXLAC_VA_PREFIX . 'text_instruction'));
    $textIntro = ($textIntro!='')?$textIntro:esc_html("Virtual Assistant", "bestbug");
?>

<div class="bb_va_popup">
    <div class="popup-header"><?php echo esc_html($textIntro) ?></div>
    <div class="popup-body">
        <?php
            foreach ($allCommands as $command){
                $data_meta = get_post_meta($command->ID);

                if(strlen($data_meta['virtual_assistant_description_popup'][0])>210) {
                    $sttr = substr($data_meta['virtual_assistant_description_popup'][0], 0, 210).' ...';
                }else{
                    $sttr = $data_meta['virtual_assistant_description_popup'][0];
                }
                if($data_meta['virtual_assistant_show_on_popup'][0]=='yes'):

                ?>
                <div class="popup-body-command" data-command="<?php ! empty( $data_meta['virtual_assistant_sample_command'] ) ? esc_attr_e( $data_meta['virtual_assistant_sample_command'][0] ) : ''; ?>">
                    <div class="popup-body-command-title">
                        <span><?php esc_attr_e( $data_meta['virtual_assistant_title_popup'][0] ); ?></span>
                    </div>
                    <div class="popup-body-command-description">
                        <span><?php esc_attr_e(  $sttr  ); ?></span>
                    </div>
                </div>
                <?php

                endif;
            }
        ?>
        
    </div>
    <div class="popup-footer">
        <input id="wpva_text_command" disabled="disabled" type="text" placeholder="<?php esc_html_e("Say something...", "bestbug") ?>">
        <a class="wpva-button-micro">
            <i class="fa fa-microphone " aria-hidden="true"></i>
        </a>
    </div>
</div>
<div class="bb_va_button_popup">
    <div class="bb_vs_popup_icon"></div>
</div>