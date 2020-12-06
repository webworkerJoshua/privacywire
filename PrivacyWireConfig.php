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
            'content_banner_details_show' => false,
            'content_banner_details_title' => $this->_("This is how and why we use cookies"),
            'content_banner_details_text' => $this->_("Here you can store more detailed information on the cookies used or describe individual cookies in depth."),
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
            'trigger_custom_js_function' => "",
            'messageTimeout' => 1500,
            'add_basic_css_styling' => true,
            'ask_consent_message' => $this->_("To load this element, it is required to consent to the following cookie category: {category}."),
            'ask_content_button_label' => $this->_("Load {category} cookies"),
            'banner_header_tag' => 'header',
            'alternate_banner_template' => '',
            'render_manually' => false,
            'detect_consents_by_class' => false,
            'use_es6' => false,
            'output_mode' => 'regular'
        ];
    }

    public function getInputfields()
    {
        $inputfields = parent::getInputfields();

        // version integer
        $f = $this->modules->get('InputfieldInteger');
        $f->attr('name', 'version');
        $f->description = $this->_("When you increase the version number, all users have to opt-in again. This version number is saved with the users consent in the cookie.");
        $f->label = $this->_('Versioning');
        $f->attr('min', 1);
        $f->columnWidth = 33;
        $inputfields->add($f);

        // respect "do not track"
        $f = $this->modules->get('InputfieldCheckbox');
        $f->attr('name', 'respectDNT');
        $f->description = $this->_("If enabled, PrivacyWire checks if the users browser sends the DNT-Header. If so, no cookie banner will be shown and the user will be handled like 'Only Necessary Cookies' would be chosen.");
        $f->label = $this->_('DNT: Do Not Track');
        $f->checkboxLabel = $this->_('Respect "Do Not Track" Settings from the browser');
        $f->columnWidth = 33;
        $inputfields->add($f);

        // Output mode
        $f = $this->modules->get('InputfieldSelect');
        $f->attr('name', 'output_mode');
        $f->label = $this->_('Output mode of PrivacyWire JS Core');
        $f->description = $this->_("Choose if you want to render the PrivacyWire JS Core as regular script tag, ProCache script tag or inline js.");
        $f->options = [
            "regular" => $this->_("Regular script tag"),
            "procache" => $this->_("ProCache script tag"),
            "inline" => $this->_("Inline script"),
        ];
        $f->columnWidth = 34;
        $inputfields->add($f);

        // opt-in type
        $f = $this->modules->get('InputfieldAsmSelect');
        $f->attr('name', 'cookie_groups');
        $f->description = $this->_("Choose, which groups of cookies the user is allowed to choose. If more than the two default groups (all & necessary) are allowed, the option window will be shown to the user.");
        $f->label = $this->_('Cookie Groups');
        $f->options = [
            "all" => $this->_("All Cookies"),
            "necessary" => $this->_("Necessary Cookies"),
            "functional" => $this->_("Functional Cookies"),
            "statistics" => $this->_("Statistics"),
            'marketing' => $this->_("Marketing"),
            'external_media' => $this->_("External Media")
        ];
        $inputfields->add($f);

        // fieldset for cookie groups
        $fs = $this->modules->get('InputfieldFieldset');
        $fs->label = $this->_("Cookie Group Labels");
        $fs->description = $this->_("Label of the cookie groups in 'Choose Cookies' window");
        $inputfields->add($fs);

        // label for cookie group: necessary
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'cookies_necessary_label');
        $f->label = $this->_('Necessary Cookies: Label');
        $f->showIf("cookie_groups=necessary");
        $f->useLanguages = true;
        $f->columnWidth = 20;
        $fs->add($f);

        // label for cookie group: functional
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'cookies_functional_label');
        $f->label = $this->_('Functional Cookies: Label');
        $f->showIf("cookie_groups=functional");
        $f->useLanguages = true;
        $f->columnWidth = 20;
        $fs->add($f);

        // label for cookie group: statistics
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'cookies_statistics_label');
        $f->label = $this->_('Statistics Cookies: Label');
        $f->showIf("cookie_groups=statistics");
        $f->useLanguages = true;
        $f->columnWidth = 20;
        $fs->add($f);

        // label for cookie group: marketing
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'cookies_marketing_label');
        $f->label = $this->_('Marketing Cookies: Label');
        $f->showIf("cookie_groups=marketing");
        $f->useLanguages = true;
        $f->columnWidth = 20;
        $fs->add($f);

        // label for cookie group: external media
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'cookies_external_media_label');
        $f->label = $this->_('External Media Cookies: Label');
        $f->showIf("cookie_groups=external_media");
        $f->useLanguages = true;
        $f->columnWidth = 20;
        $fs->add($f);

        // fieldset for banner options
        $fs = $this->modules->get('InputfieldFieldset');
        $fs->label = $this->_("Banner");
        $inputfields->add($fs);

        // banner headline (optional)
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'content_banner_title');
        $f->description = $this->_("Optional: If empty, no headline will be shown in the banner.");
        $f->label = $this->_('Title');
        $f->useLanguages = true;
        $f->columnWidth = 100;
        $fs->add($f);

        // banner body copy
        $f = $this->modules->get('InputfieldCKEditor');
        $f->attr('name', 'content_banner_text');
        $f->attr('toolbar', 'Bold, Italic, NumberedList, BulletedList, PWLink, Unlink, PWImage, Table');
        $f->label = $this->_('Text');
        $f->useLanguages = true;
        $f->columnWidth = 100;
        $fs->add($f);

        // banner show details
        $f = $this->modules->get('InputfieldCheckbox');
        $f->attr('name', 'content_banner_details_show');
        $f->description = $this->_("If enabled, you will have the possibility to display alternative headline and text elements within the options banner where the user can select the cookies allowed.");
        $f->label = $this->_('Use alternative text and headline for options banner');
        $f->columnWidth = 100;
        $fs->add($f);

        // banner details headline (optional)
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'content_banner_details_title');
        $f->description = $this->_("Optional: If empty, no headline will be shown in the banner.");
        $f->label = $this->_('Options Banner - Title Details');
        $f->showIf = "content_banner_details_show=1";
        $f->useLanguages = true;
        $f->columnWidth = 100;
        $fs->add($f);

        // banner details text
        $f = $this->modules->get('InputfieldCKEditor');
        $f->attr('name', 'content_banner_details_text');
        $f->attr('toolbar', 'Bold, Italic, NumberedList, BulletedList, PWLink, Unlink, PWImage, Table');
        $f->showIf = "content_banner_details_show=1";
        $f->label = $this->_('Options Banner - Text Details');
        $f->useLanguages = true;
        $f->columnWidth = 100;
        $fs->add($f);

        // banner header tag
        $f = $this->modules->get('InputfieldSelect');
        $f->attr('name', 'banner_header_tag');
        $f->description = $this->_("Choose between <header> and <div>.");
        $f->label = $this->_('Banner Header Tag');
        $f->options = [
            "header" => $this->_("<header>"),
            "div" => $this->_("<div>"),
        ];
        $f->columnWidth = 33;
        $fs->add($f);

        // alternate banner template
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'alternate_banner_template');
        $f->label = $this->_('Alternate Banner Template');
        $f->description = $this->_("If you want to replace the original banner template (located in site/modules/PrivacyWire/PrivacyWireBanner.php ) insert the alternative file path here (starting from webroot without leading slash )");
        $f->columnWidth = 33;
        $fs->add($f);

        // render manually
        $f = $this->modules->get('InputfieldCheckbox');
        $f->attr('name', 'render_manually');
        $f->label = $this->_('Render Banner and Header Content Manually');
        $f->description = $this->_("If you want to render PrivacyWire header and banner content manually instead of letting the module render them for you, check this option.");
        $f->notes = $this->_("Use `\$modules->get('PrivacyWire')->renderHeadContent()` to render header tags and `\$modules->get('PrivacyWire')->renderBodyContent()` to render body content.");
        $f->columnWidth = 34;
        $fs->add($f);

       // fieldset for links
        $fs = $this->modules->get('InputfieldFieldset');
        $fs->label = $this->_("Links");
        $inputfields->add($fs);

        // privacy policy url
        $f = $this->modules->get('InputfieldURL');
        $f->attr('name', 'content_banner_privacy_link');
        $f->description = $this->_("If you want to output a link to your privacy policy page, add the URL to this page here");
        $f->label = $this->_('Privacy Policy URL');
        $f->useLanguages = true;
        $f->columnWidth = 50;
        $fs->add($f);

        // privacy policy link title
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'content_banner_privacy_title');
        $f->label = $this->_('Privacy Policy link title');
        //$f->showIf = "content_banner_privacy_link!=''";
        $f->useLanguages = true;
        $f->columnWidth = 50;
        $fs->add($f);

        // imprint url
        $f = $this->modules->get('InputfieldURL');
        $f->attr('name', 'content_banner_imprint_link');
        $f->description = $this->_("If you want to output a link to your imprint page, add the URL to this page here");
        $f->label = $this->_('Imprint URL');
        $f->useLanguages = true;
        $f->columnWidth = 50;
        $fs->add($f);

        // imprint link title
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'content_banner_imprint_title');
        $f->label = $this->_('Imprint link title');
        //$f->showIf = "content_banner_imprint_link!=''";
        $f->useLanguages = true;
        $f->columnWidth = 50;
        $fs->add($f);

        // fieldset for buttons
        $fs = $this->modules->get('InputfieldFieldset');
        $fs->label = $this->_("Buttons");
        $inputfields->add($fs);

        // Button Label: Allow All
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'content_banner_button_allow_all');
        $f->label = $this->_('Button Label: Allow All Cookies');
        $f->useLanguages = true;
        $f->columnWidth = 33;
        $fs->add($f);

        // Button Label: Allow Necessary
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'content_banner_button_allow_necessary');
        $f->label = $this->_('Button Label: Allow Necessary Cookies');
        $f->useLanguages = true;
        $f->columnWidth = 33;
        $fs->add($f);

        // Button Label: Choose Cookies
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'content_banner_button_choose');
        $f->label = $this->_('Button Label: Choose Cookies');
        $f->useLanguages = true;
        $f->columnWidth = 34;
        $fs->add($f);

        // Button Label: Toggle Cookies Options
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'content_banner_button_toggle');
        $f->label = $this->_('Button Label: Toggle Cookie Options');
        $f->useLanguages = true;
        $f->columnWidth = 33;
        $fs->add($f);

        // Show another "Accept all" instead of the "Toggle" Button
        $f = $this->modules->get('InputfieldCheckbox');
        $f->attr('name', 'content_banner_button_all_instead_toggle');
        $f->label = $this->_('Choose Window: "Accept all" instead of "Toggle"');
        $f->checkboxLabel = $this->_('Show "Accept all" Button instead of "Toggle" Button');
        $f->columnWidth = 33;
        $fs->add($f);

        // Button Label: Save Preferences
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'content_banner_button_save');
        $f->label = $this->_('Button Label: Save Preferences');
        $f->useLanguages = true;
        $f->columnWidth = 34;
        $f->value = "";
        $fs->add($f);

         // Saved Message Text
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'content_banner_save_message');
        $f->label = $this->_('Message: Save Confirmation');
        $f->useLanguages = true;
        $f->columnWidth = 33;
        $fs->add($f);

        // Textformatter Button Label
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'textformatter_choose_label');
        $f->label = $this->_('Textformatter Button label');
        $f->useLanguages = true;
        $f->columnWidth = 33;
        $fs->add($f);

        // Ask for consent Button label
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'ask_content_button_label');
        $f->label = $this->_('Button Label: Ask for consent');
        $f->description = $this->_("You can insert the current cookie category name by using the placeholder {category}.");
        $f->useLanguages = true;
        $f->columnWidth = 34;
        $fs->add($f);

        // ask for consent text field
        $f = $this->modules->get('InputfieldCKEditor');
        $f->attr('name', 'ask_consent_message');
        $f->attr('toolbar', 'Bold, Italic, NumberedList, BulletedList, PWLink, Unlink, PWImage, Table');
        $f->label = $this->_('Text above button: Ask for consent');
        $f->description = $this->_("You can insert the current cookie category name by using the placeholder {category}.");
        $f->useLanguages = true;
        $f->columnWidth = 100;
        $fs->add($f);

        // fieldset for modifications - have fun ;-)
        $fs = $this->modules->get('InputfieldFieldset');
        $fs->label = $this->_("Modifications");
        $inputfields->add($fs);

        // Message Timeout
        $f = $this->modules->get('InputfieldInteger');
        $f->attr('name', 'messageTimeout');
        $f->label = $this->_('Timeout of showing the success message');
        $f->description = $this->_("Time in ms for how long the success message should be visible");
        $f->columnWidth = 33;
        $fs->add($f);

        // add basic css styles or not
        $f = $this->modules->get('InputfieldCheckbox');
        $f->attr('name', 'add_basic_css_styling');
        $f->description = $this->_("If enabled, PrivacyWire will automatically include some very basic css styles to the output.");
        $f->label = $this->_('CSS: Add basic CSS Styling');
        $f->checkboxLabel = $this->_('Add basic CSS Styling');
        $f->columnWidth = 33;
        $fs->add($f);

        // Trigger a custom js function
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'trigger_custom_js_function');
        $f->label = $this->_('Trigger a custom js function');
        $f->description = $this->_("If you want to trigger a custom js function after saving the cookie banner, insert the name of the function here");
        $f->columnWidth = 34;
        $fs->add($f);

        // use consent detection by class?
        $f = $this->modules->get('InputfieldCheckbox');
        $f->attr('name', 'detect_consents_by_class');
        $f->label = $this->_('Detect consent windows by class `require-consent` instead of data-attribute.');
        $f->description = $this->_("If enabled, PrivacyWire will use a class selector instead of data-attribute selector to detect elements which require consent. This is more performant.");
        $f->checkboxLabel = $this->_('Use consent detection by class instead of data-attribute');
        $f->columnWidth = 33;
        $fs->add($f);

        // use ES6 (No support for Internet Explorer!)
        $f = $this->modules->get('InputfieldCheckbox');
        $f->attr('name', 'use_es6');
        $f->label = $this->_('Use ES6 (No support for Internet Explorer at all!)');
        $f->description = $this->_("If enabled, the ES6 version of PrivacyWire will be used. **WARNING**: No support for Internet Explorer!");
        $f->checkboxLabel = $this->_('Yes, I want to use the fancy new ES6 version!');
        $f->columnWidth = 33;
        $fs->add($f);

        return $inputfields;
    }
}
