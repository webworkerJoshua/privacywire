<?php namespace ProcessWire;
    /**
     * @var PrivacyWire $module Instance of the PrivacyWire module;
     */

    $showAllButton = (in_array("all", $module->cookie_groups));
    $showNecessaryButton = (in_array("necessary", $module->cookie_groups));

    $showStatisticsButton = (in_array("statistics", $module->cookie_groups));
    $showMarketingButton = (in_array("marketing", $module->cookie_groups));
    $showExternalMediaButton = (in_array("external_media", $module->cookie_groups));

    $showChooseButton = (
        $showStatisticsButton ||
        $showMarketingButton ||
        $showExternalMediaButton
    );
?>

<div class="privacywire-wrapper">
    <div class="privacywire privacywire-banner">
        <?php if (!empty($module->content_banner_title)): ?>
            <header class="privacywire-header"> <?php echo $module->content_banner_title; ?></header>
        <?php endif; ?>
        <div class="privacywire-body">
            <div class="privacywire-text"><?php echo $module->content_banner_text; ?></div>
            <div class="privacywire-buttons">
                <button class="allow-all" <?php echo (!$showAllButton) ? "hidden" : ""; ?>><?php echo $module->content_banner_button_allow_all; ?></button>
                <button class="allow-necessary" <?php echo (!$showNecessaryButton) ? "hidden" : ""; ?>><?php echo $module->content_banner_button_allow_necessary; ?></button>

                <button class="choose" <?php echo (!$showChooseButton) ? "hidden" : ""; ?>><?php echo $module->content_banner_button_choose; ?></button>
            </div>
        </div>

    </div>
    <div class="privacywire privacywire-options">
        <header class="privacywire-header"></header>
        <div class="privacywire-body">
            <div class="privacywire-text">
                <ul>
                    <li <?php echo (!$showNecessaryButton) ? "hidden" : ""; ?>>
                        <label for="necessary">
                            <input class="required"
                                   type="checkbox"
                                   name="necessary"
                                   id="necessary"
                                   value="1"
                                   checked
                                   disabled>
                            <?php echo $module->cookies_necessary_label; ?>
                        </label>
                    </li>

                    <li <?php echo (!$showStatisticsButton) ? "hidden" : ""; ?>>
                        <label for="statistics">
                            <input class="optional"
                                   type="checkbox"
                                   name="statistics"
                                   id="statistics"
                                   value="0">
                            <?php echo $module->cookies_statistics_label; ?>
                        </label>
                    </li>

                    <li <?php echo (!$showMarketingButton) ? "hidden" : ""; ?>>
                        <label for="marketing">
                            <input class="optional"
                                   type="checkbox"
                                   name="marketing"
                                   id="marketing"
                                   value="0">
                            <?php echo $module->cookies_marketing_label; ?>
                        </label>
                    </li>

                    <li <?php echo (!$showExternalMediaButton) ? "hidden" : ""; ?>>
                        <label for="external_media">
                            <input class="optional"
                                   type="checkbox"
                                   name="external_media"
                                   id="external_media"
                                   value="0">
                            <?php echo $module->cookies_external_media_label; ?>
                        </label>
                    </li>
                </ul>
            </div>
            <div class="privacywire-buttons">
                <button class="toggle"><?php echo $module->content_banner_button_toggle; ?></button>
                <button class="save"><?php echo $module->content_banner_button_save; ?></button>
            </div>
        </div>
    </div>
    <div class="privacywire privacywire-message">
        <div class="priavywire-body"><?php echo $module->content_banner_save_message; ?></div>
    </div>
</div>
