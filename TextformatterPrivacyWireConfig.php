<?php namespace ProcessWire;

class TextformatterPrivacyWireConfig extends ModuleConfig
{
    public function getDefaults()
    {
        return [
            'open_tag' => '[[',
            'close_tag' => ']]',
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

        return $inputfields;
    }
}
