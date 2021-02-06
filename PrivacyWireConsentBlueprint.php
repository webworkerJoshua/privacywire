<?php namespace ProcessWire;
/**
 * @var PrivacyWire $module Instance of the PrivacyWire
 */
?>
<div hidden class="privacywire-ask-consent-blueprint" id="privacywire-ask-consent-blueprint">
    <div class="privacywire-consent-message"><?php echo $module->get("ask_consent_message{$module->lang}|ask_consent_message"); ?></div>
    <button class="privacywire-consent-button"
            data-consent-category="{categoryname}"><?php echo $module->get("ask_content_button_label{$module->lang}|ask_content_button_label"); ?></button>
</div>
