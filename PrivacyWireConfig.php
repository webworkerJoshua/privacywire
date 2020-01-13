<?php namespace ProcessWire;

class PrivacyWireConfig extends ModuleConfig
{
    public function getDefaults()
    {
        return [
            'enable' => false,
            'version' => 1,
        ];
    }

    public function getInputfields()
    {
        $inputfields = parent::getInputfields();

        $f = $this->modules->get('InputfieldCheckbox');
        $f->attr('name', 'enable');
        $f->label = 'Enable PrivacyWire and Cookie Banner';
        $inputfields->add($f);

        $f = $this->modules->get('InputfieldInteger');
        $f->attr('name', 'version');
        $f->label = 'Version number';
        $f->attr('min', 1);
        $inputfields->add($f);

        return $inputfields;
    }
}
