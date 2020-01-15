<?php namespace ProcessWire;
    /**
     * @var PrivacyWire $module Instance of the PrivacyWire module;
     */
    $cookieOptions = [
        'necessary'
    ];

    if(!empty($module->cookies_statistics)) {
        $cookieOptions[] = 'statistics';
    }

    if(!empty($module->cookies_external_media)) {
        $cookieOptions[] = 'external_media';
    }
    if(!empty($module->cookies_marketing)) {
        $cookieOptions[] = 'marketing';
    }
?>

<div class="privacywire-wrapper">
    <div class="privacywire privacywire-banner">
        <header class="privacywire-header"> <?php echo $module->content_banner_title;?></header>
        <div class="privacywire-body">
            <div class="privacywire-text"><?php echo $module->content_banner_text;?></div>
            <div class="privacywire-buttons">
                <button class="allow-all"><?php echo $module->content_banner_button_allow_all;?></button>
                <button class="allow-necessary"><?php echo $module->content_banner_button_allow_necessary;?></button>
                <button class="choose"><?php echo $module->content_banner_button_choose;?></button>
            </div>
        </div>

    </div>
    <div class="privacywire privacywire-options">
        <header class="privacywire-header"></header>
        <div class="privacywire-body">
            <div class="privacywire-text">
                    <ul>
                        <li><label for="necessary"><input class="required" type="checkbox" name="necessary" id="necessary" value="1" checked disabled>Necessary</label></li>
                        <li><label for="statistics"><input class="optional" type="checkbox" name="statistics" id="statistics" value="0">Statistics</label></li>
                        <li><label for="external_media"><input class="optional" type="checkbox" name="external_media" id="external_media" value="0">External Media</label></li>
                        <li><label for="marketing"><input class="optional" type="checkbox" name="marketing" id="marketing" value="0" >Marketing</label></li>
                    </ul>
            </div>
            <div class="privacywire-buttons">
                <button class="toggle"><?php echo $module->content_banner_button_toggle;?></button>
                <button class="save"><?php echo $module->content_banner_button_save;?></button>
            </div>
        </div>
    </div>
    <div class="privacywire privacywire-message">
        <div class="priavywire-body"><?php echo $module->content_banner_save_message;?></div>
    </div>
</div>
