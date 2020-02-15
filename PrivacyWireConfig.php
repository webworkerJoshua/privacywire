<?php namespace ProcessWire;

class PrivacyWireConfig extends ModuleConfig
{
    public function getDefaults()
    {
        return [
            'version' => 1,
            'cookie_groups' => [ "all", "necessary" ],
            'respectDNT' => false,
            'cookies_necessary_label' => $this->_('Necessary'),
            'cookies_statistics_label' => $this->_('Statistics'),
            'cookies_marketing_label' => $this->_('Marketing'),
            'cookies_external_media_label' => $this->_('External Media'),
            'content_banner_title' => $this->_("This website is using cookies to provide a good browsing experience"),
            'content_banner_text' => $this->_("These include essential cookies that are necessary for the operation of the site, as well as others that are used only for anonymous statistical purposes, for comfort settings or to display personalized content. You can decide for yourself which categories you want to allow. Please note that based on your settings, not all functions of the website may be available."),
            'content_banner_privacy_link' => null,
            'content_banner_button_allow_all' => $this->_("Accept all"),
            'content_banner_button_allow_necessary' => $this->_("Accept necessary cookies only"),
            'content_banner_button_choose' => $this->_("Choose cookies"),
            'content_banner_button_save' => $this->_("Save preferences"),
            'content_banner_button_toggle' => $this->_("Toggle options"),
            'content_banner_save_message' => $this->_("Your cookie preferences have been saved."),
        ];
    }

    public function getInputfields()
    {
        $inputfields = parent::getInputfields();

        // version integer
        $f = $this->modules->get('InputfieldInteger');
        $f->attr('name', 'version');
        $f->description = $this->_("When you increase the version number, all users have to opt-in again. This version number is saved with the users consent in the cookie.");
        $f->label = $this->_('Version Number');
        $f->attr('min', 1);
        $f->columnWidth = 33;
        $inputfields->add($f);

        // opt-in type
        $f = $this->modules->get('InputfieldAsmSelect');
        $f->attr('name', 'cookie_groups');
        $f->description = $this->_("Choose, which groups of cookies the user is allowed to choose. When more than the two default groups (all & necessary) are allowed, the option window will be shown to the user.");
        $f->label = $this->_('Cookie Groups');
        $f->options = [
            "necessary" => $this->_("Necessary Cookies"),
            "all" => $this->_("All Cookies"),
            "statistics" => $this->_("Statistics"),
            'marketing' => $this->_("Marketing"),
            'external_media' => $this->_("External Media")
        ];
        $f->columnWidth = 33;
        $inputfields->add($f);

        // respect "do not track"
        $f = $this->modules->get('InputfieldCheckbox');
        $f->attr('name', 'respectDNT');
        $f->description = $this->_("When enabled, PrivacyWire checks if the users browser sends the DNT-Header. If so, no cookie banner will be shown and the user will be handled like 'Only Necessary Cookies' would be chosen.");
        $f->label = $this->_('DNT: Do Not Track');
        $f->checkboxLabel = $this->_('Respect "Do Not Track" Settings from the browser');
        $f->columnWidth = 33;
        $inputfields->add($f);

        // fieldset for cookie groups
        $cookieFieldset = $this->modules->get('InputfieldFieldset');
        $cookieFieldset->label = $this->_("Cookie Group Labels");
        $cookieFieldset->description = $this->_("Label of the cookie groups in 'Choose Cookies' window");
        $inputfields->add($cookieFieldset);

        // label for cookie group: necessary
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'cookies_necessary_label');
        $f->label = $this->_('Necessary Cookies: Label');
        $f->showIf("cookie_groups=necessary");
        $f->columnWidth = 25;
        $cookieFieldset->add($f);

        // label for cookie group: statistics
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'cookies_statistics_label');
        $f->label = $this->_('Statistics Cookies: Label');
        $f->showIf("cookie_groups=statistics");
        $f->columnWidth = 25;
        $cookieFieldset->add($f);

        // label for cookie group: marketing
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'cookies_marketing_label');
        $f->label = $this->_('Marketing Cookies: Label');
        $f->showIf("cookie_groups=marketing");
        $f->columnWidth = 25;
        $cookieFieldset->add($f);

        // label for cookie group: external media
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'cookies_external_media_label');
        $f->label = $this->_('External Media Cookies: Label');
        $f->showIf("cookie_groups=external_media");
        $f->columnWidth = 25;
        $cookieFieldset->add($f);

        // fieldset for contents of the module markup
        $content = $this->modules->get('InputfieldFieldset');
        $content->label = $this->_("Banner Content");
        $inputfields->add($content);

        // banner headline (optional)
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'content_banner_title');
        $f->description = $this->_("Optional: If empty, no headline will be shown in the banner.");
        $f->label = $this->_('Banner Title');
        $f->columnWidth = 50;
        $content->add($f);

        // banner body copy
        $f = $this->modules->get('InputfieldCKEditor');
        $f->attr('name', 'content_banner_text');
        $f->attr('toolbar', 'Bold, Italic, NumberedList, BulletedList, PWLink, Unlink, PWImage, Table');
        $f->label = $this->_('Banner Text');
        $f->useLanguage = true;
        $f->columnWidth = 50;
        $content->add($f);

        // privacy page
        $f = $this->modules->get('InputfieldPage');
        $f->attr('name', 'content_banner_privacy_link');
        $f->description = $this->_("If you want to output a link to your privacy policy page, choose the  corresponding page here");
        $f->inputfield = "InputfieldPageListSelect";
        $f->derefAsPage = 1;
        $f->label = $this->_('Privacy Link / Page');
        $f->columnWidth = 100;
        $content->add($f);

        // Button Label: Allow All
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'content_banner_button_allow_all');
        $f->label = $this->_('Button Label: Allow All Cookies');
        $f->columnWidth = 25;
        $content->add($f);

        // Button Label: Allow Necessary
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'content_banner_button_allow_necessary');
        $f->label = $this->_('Button Label: Allow Necessary Cookies');
        $f->columnWidth = 25;
        $content->add($f);

        // Button Label: Choose Cookies
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'content_banner_button_choose');
        $f->label = $this->_('Button Label: Choose Cookies');
        $f->columnWidth = 25;
        $content->add($f);

        // Button Label: Save Preferences
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'content_banner_button_save');
        $f->label = $this->_('Button Label: Save Preferences');
        $f->columnWidth = 25;
        $content->add($f);

        // Button Label: Saved Message
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'content_banner_save_message');
        $f->label = $this->_('Save Message');
        $f->columnWidth = 100;
        $content->add($f);

        return $inputfields;
    }
}
