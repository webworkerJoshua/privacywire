<?php namespace ProcessWire;

class TextformatterPrivacyWireConfig extends ModuleConfig
{
    public function getDefaults()
    {
        return [
            'open_tag' => '[[',
            'close_tag' => ']]',
            'video_category' => null,
        ];
    }

    public function getInputfields()
    {
        $inputfields = parent::getInputfields();

        // open tag
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'open_tag');
        $f->label = $this->_('Open Tag');
        $f->columnWidth = 50;
        $inputfields->add($f);

        // close tag
        $f = $this->modules->get('InputfieldText');
        $f->attr('name', 'close_tag');
        $f->label = $this->_('Close Tag');
        $f->columnWidth = 50;
        $inputfields->add($f);

        // embedded media
        $fs = $this->modules->get('InputfieldFieldset');
        $fs->attr('name', 'embedded_media');
        $fs->label = $this->_('Embedded media');
        $inputfields->add($fs);

        // category for embedded videos (optional)
        $f = $this->modules->get('InputfieldSelect');
        $f->attr('name', 'video_category');
        $f->label = $this->_('Category for embedded videos');
        $f->description = $this->_('If you select a category here, users will need to accept said cookie category before embedded video elements are displayed. Leave empty to disable this feature.');
        $f->notes = $this->_('Recommended if you\'re using [TextformatterVideoEmbed](https://processwire.com/modules/textformatter-video-embed/). Note that TextformatterPrivacyWire need to run after TextformatterVideoEmbed for this to work.');
        $f->columnWidth = 50;
        $f->options = [
            "statistics" => $this->_("Statistics"),
            'marketing' => $this->_("Marketing"),
            'external_media' => $this->_("External Media")
        ];
        $fs->add($f);

        return $inputfields;
    }
}
