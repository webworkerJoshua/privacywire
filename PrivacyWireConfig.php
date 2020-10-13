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
            'cookies_functional_label' => $this->_('Functional'),
            'cookies_statistics_label' => $this->_('Statistics'),
            'cookies_marketing_label' => $this->_('Marketing'),
            'cookies_external_media_label' => $this->_('External Media'),
            'content_banner_title' => $this->_("This website is using cookies to provide a good browsing experience"),
            'content_banner_text' => $this->_("These include essential cookies that are necessary for the operation of the site, as well as others that are used only for anonymous statistical purposes, for comfort settings or to display personalized content. You can decide for yourself which categories you want to allow. Please note that based on your settings, not all functions of the website may be available."),
            'content_banner_privacy_link' => null,
            'content_banner_privacy_title' => $this->_("Privacy Policy"),
            'content_banner_imprint_link' => null,
            'content_banner_imprint_title' => $this->_("Imprint"),
            'content_banner_button_allow_all' => $this->_("Accept all"),
            'content_banner_button_allow_necessary' => $this->_("Accept necessary cookies only"),
            'content_banner_button_choose' => $this->_("Choose cookies"),
            'content_banner_button_save' => $this->_("Save preferences"),
            'content_banner_button_toggle' => $this->_("Toggle options"),
            'content_banner_save_message' => $this->_("Your cookie preferences have been saved."),
            'content_banner_button_all_instead_toggle' => false,
            'textformatter_choose_label' => $this->_("Show or edit my Cookie Consent"),
            'use_procache_minification' => true,
            'trigger_custom_js_function' => "",
            'messageTimeout' => 1500,
            'add_basic_css_styling' => true
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
            "functional" => $this->_("Functional Cookies"),
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
        $f->useLanguages = true;
        $f->columnWidth = 25;
        $cookieFieldset->add($f);

        // label for cookie group: functional
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'cookies_functional_label');
        $f->label = $this->_('Functional Cookies: Label');
        $f->showIf("cookie_groups=functional");
        $f->useLanguages = true;
        $f->columnWidth = 25;
        $cookieFieldset->add($f);

        // label for cookie group: statistics
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'cookies_statistics_label');
        $f->label = $this->_('Statistics Cookies: Label');
        $f->showIf("cookie_groups=statistics");
        $f->useLanguages = true;
        $f->columnWidth = 25;
        $cookieFieldset->add($f);

        // label for cookie group: marketing
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'cookies_marketing_label');
        $f->label = $this->_('Marketing Cookies: Label');
        $f->showIf("cookie_groups=marketing");
        $f->useLanguages = true;
        $f->columnWidth = 25;
        $cookieFieldset->add($f);

        // label for cookie group: external media
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'cookies_external_media_label');
        $f->label = $this->_('External Media Cookies: Label');
        $f->showIf("cookie_groups=external_media");
        $f->useLanguages = true;
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
        $f->useLanguages = true;
        $f->columnWidth = 50;
        $content->add($f);

        // banner body copy
        $f = $this->modules->get('InputfieldCKEditor');
        $f->attr('name', 'content_banner_text');
        $f->attr('toolbar', 'Bold, Italic, NumberedList, BulletedList, PWLink, Unlink, PWImage, Table');
        $f->label = $this->_('Banner Text');
        $f->useLanguages = true;
        $f->columnWidth = 50;
        $content->add($f);

        // privacy policy url
        $f = $this->modules->get('InputfieldURL');
        $f->attr('name', 'content_banner_privacy_link');
        $f->description = $this->_("If you want to output a link to your privacy policy page, add the URL to this page here");
        $f->label = $this->_('Privacy Policy URL');
        $f->useLanguages = true;
        $f->columnWidth = 50;
        $content->add($f);

        // privacy policy link title
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'content_banner_privacy_title');
        $f->label = $this->_('Privacy Policy link title');
        $f->showIf = "content_banner_privacy_link!=''";
        $f->useLanguages = true;
        $f->columnWidth = 50;
        $content->add($f);

        // imprint url
        $f = $this->modules->get('InputfieldURL');
        $f->attr('name', 'content_banner_imprint_link');
        $f->description = $this->_("If you want to output a link to your imprint page, add the URL to this page here");
        $f->label = $this->_('Imprint URL');
        $f->useLanguages = true;
        $f->columnWidth = 50;
        $content->add($f);

        // imprint link title
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'content_banner_imprint_title');
        $f->label = $this->_('Imprint link title');
        $f->showIf = "content_banner_imprint_link!=''";
        $f->useLanguages = true;
        $f->columnWidth = 50;
        $content->add($f);

        // Button Label: Allow All
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'content_banner_button_allow_all');
        $f->label = $this->_('Button Label: Allow All Cookies');
        $f->useLanguages = true;
        $f->columnWidth = 33;
        $content->add($f);

        // Button Label: Allow Necessary
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'content_banner_button_allow_necessary');
        $f->label = $this->_('Button Label: Allow Necessary Cookies');
        $f->useLanguages = true;
        $f->columnWidth = 33;
        $content->add($f);

        // Button Label: Choose Cookies
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'content_banner_button_choose');
        $f->label = $this->_('Button Label: Choose Cookies');
        $f->useLanguages = true;
        $f->columnWidth = 34;
        $content->add($f);

        // Button Label: Toggle Cookies Options
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'content_banner_button_toggle');
        $f->label = $this->_('Button Label: Toggle Cookie Options');
        $f->useLanguages = true;
        $f->columnWidth = 33;
        $content->add($f);

        // Button Label: Save Preferences
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'content_banner_button_save');
        $f->label = $this->_('Button Label: Save Preferences');
        $f->useLanguages = true;
        $f->columnWidth = 33;
        $f->value = "";
        $content->add($f);

        // Textformatter Button Label
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'textformatter_choose_label');
        $f->label = $this->_('Textformatter Button label');
        $f->useLanguages = true;
        $f->columnWidth = 34;
        $content->add($f);

        // add basic css styles or not
        $f = $this->modules->get('InputfieldCheckbox');
        $f->attr('name', 'content_banner_button_all_instead_toggle');
        $f->label = $this->_('Choose Window: Show "Accept All" Button instead of "Toggle" Button');
        $f->checkboxLabel = $this->_('Show "Accept All" Button instead of "Toggle" Button');
        $f->columnWidth = 50;
        $content->add($f);

        // Button Label: Saved Message
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'content_banner_save_message');
        $f->label = $this->_('Save Message');
        $f->useLanguages = true;
        $f->columnWidth = 50;
        $content->add($f);

        // ProCache JS Minification
        $f = $this->modules->get('InputfieldCheckbox');
        $f->attr('name', 'use_procache_minification');
        $f->description = $this->_("When enabled, PrivacyWire checks if [ProCache](https://processwire.com/store/pro-cache/#procache-css-js-minification-api) is installed and activated. If so, the javascript files will be minified automatically via ProCache.");
        $f->label = $this->_('Use ProCache JS Minification (if available)');
        $f->checkboxLabel = $this->_('Use ProCache JS Minification (if available)');
        $f->columnWidth = 50;
        $inputfields->add($f);

        // Trigger a custom js function
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'trigger_custom_js_function');
        $f->label = $this->_('Trigger a custom js function');
        $f->description = $this->_("When you want to trigger a custom js function after saving the cookie banner, insert the name of the function here");
        $f->columnWidth = 50;
        $inputfields->add($f);

        // Message Timeout
        $f = $this->modules->get('InputfieldInteger');
        $f->attr('name', 'messageTimeout');
        $f->label = $this->_('Timeout of showing the success message');
        $f->columnWidth = 50;
        $inputfields->add($f);

        // add basic css styles or not
        $f = $this->modules->get('InputfieldCheckbox');
        $f->attr('name', 'add_basic_css_styling');
        $f->description = $this->_("When enabled, PrivacyWire will automatically include some very basic css styles to the output.");
        $f->label = $this->_('CSS: Add basic CSS Styling');
        $f->checkboxLabel = $this->_('Add basic CSS Styling');
        $f->columnWidth = 50;
        $inputfields->add($f);

        return $inputfields;
    }
}
