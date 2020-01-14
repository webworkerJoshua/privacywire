<?php namespace ProcessWire;

class PrivacyWireConfig extends ModuleConfig
{
    public function getDefaults()
    {
        return [
            'enable' => false,
            'version' => 1,
            'respectDNT' => false,
            'allowOptions' => true,
            'content_banner_title' => $this->_("This website is using cookies to provide a good browsing experience"),
            'content_banner_text' => $this->_("These include essential cookies that are necessary for the operation of the site, as well as others that are used only for anonymous statistical purposes, for comfort settings or to display personalized content. You can decide for yourself which categories you want to allow. Please note that based on your settings, not all functionalities of the website may be available."),
            'content_banner_privacy_link' => null,
            'content_banner_button_allow_all' => $this->_("Accept all"),
            'content_banner_button_allow_necessary' => $this->_("Accept necessary cookies only"),
            'content_banner_button_choose' => $this->_("Choose cookies"),
            'content_banner_button_save' => $this->_("Save preferences"),
            'content_banner_save_message' => $this->_("Your cookie preferences have been saved."),
            'cookies_necessary' => $this->_("wire|domain.tld|This cookie is required for secure login and to detect spam or abuse of this website.|Session \nprivacywire|domain.tld|This cookie saves the consent status for cookies.|1 Year"),
            'cookies_statistics' => $this->_(""),
            'cookies_external_media' => $this->_(""),
            'cookies_marketing' => $this->_(""),
        ];
    }

    public function getInputfields()
    {
        $inputfields = parent::getInputfields();

        // 1. Checkbox for enabling or disabling the whole module
        $f = $this->modules->get('InputfieldCheckbox');
        $f->attr('name', 'enable');
        $f->label = $this->_('Enable PrivacyWire and Cookie Banner');
        $inputfields->add($f);

        // 2. Fieldset for module config
        $fieldset = $this->modules->get('InputfieldFieldset');
        $fieldset->label = $this->_("PrivacyWire Settings");
        $fieldset->showIf = "enable=1";
        $inputfields->add($fieldset);

        // version integer
        $f = $this->modules->get('InputfieldInteger');
        $f->attr('name', 'version');
        $f->label = $this->_('Version Number');
        $f->attr('min', 1);
        $f->columnWidth = 50;
        $fieldset->add($f);

        // respect "do not track"
        $f = $this->modules->get('InputfieldCheckbox');
        $f->attr('name', 'respectDNT');
        $f->label = $this->_('DNT: Do Not Track');
        $f->checkboxLabel = $this->_('Respect "Do Not Track" Settings from the browser');
        $f->columnWidth = 50;
        $fieldset->add($f);


        // fieldset for contents of the module markup
        $content = $this->modules->get('InputfieldFieldset');
        $content->label = $this->_("Banner Content");
        $fieldset->add($content);

        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'content_banner_title');
        $f->label = $this->_('Banner Title');
        $f->columnWidth = 50;
        $content->add($f);

        $f = $this->modules->get('InputfieldCKEditor');
        $f->attr('name', 'content_banner_text');
        $f->attr('toolbar', 'Bold, Italic, NumberedList, BulletedList, PWLink, Unlink, PWImage, Table');
        $f->label = $this->_('Banner Text');
        $f->useLanguage = true;
        $f->columnWidth = 50;
        $content->add($f);

        $f = $this->modules->get('InputfieldPage');
        $f->attr('name', 'content_banner_privacy_link');
        $f->inputfield = "InputfieldPageListSelect";
        $f->derefAsPage = 1;
        $f->label = $this->_('Privacy Link / Page');
        $f->columnWidth = 100;
        $content->add($f);

        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'content_banner_button_allow_all');
        $f->label = $this->_('Button Label: Allow All Cookies');
        $f->columnWidth = 25;
        $content->add($f);

        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'content_banner_button_allow_necessary');
        $f->label = $this->_('Button Label: Allow Necessary Cookies');
        $f->columnWidth = 25;
        $content->add($f);

        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'content_banner_button_choose');
        $f->label = $this->_('Button Label: Choose Cookies');
        $f->columnWidth = 25;
        $content->add($f);

        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'content_banner_button_save');
        $f->label = $this->_('Button Label: Save Preferences');
        $f->columnWidth = 25;
        $content->add($f);

        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'content_banner_save_message');
        $f->label = $this->_('Save Message');
        $f->columnWidth = 100;
        $content->add($f);

        // fieldset for cookie groups and settings
        $cookieFieldset = $this->modules->get('InputfieldFieldset');
        $cookieFieldset->label = $this->_("Cookie Settings");
        $fieldset->add($cookieFieldset);

        $f = $this->modules->get('InputfieldTextarea');
        $f->attr('name', 'cookies_necessary');
        $f->label = $this->_('Cookies: Necessary');
        $f->description = $this->_("Cookie name | Domain | Description | Duration");
        $f->columnWidth = 100;
        $cookieFieldset->add($f);

        $f = $this->modules->get('InputfieldTextarea');
        $f->attr('name', 'cookies_statistics');
        $f->label = $this->_('Cookies: Statistics');
        $f->description = $this->_("Cookie name | Domain | Description | Duration");
        $f->columnWidth = 100;
        $cookieFieldset->add($f);

        $f = $this->modules->get('InputfieldTextarea');
        $f->attr('name', 'cookies_external_media');
        $f->label = $this->_('Cookies: External Media');
        $f->description = $this->_("Cookie name | Domain | Description | Duration");
        $f->columnWidth = 100;
        $cookieFieldset->add($f);

        $f = $this->modules->get('InputfieldTextarea');
        $f->attr('name', 'cookies_marketing');
        $f->label = $this->_('Cookies: Marketing');
        $f->description = $this->_("Cookie name | Domain | Description | Duration");
        $f->columnWidth = 100;
        $cookieFieldset->add($f);

        return $inputfields;
    }
}
