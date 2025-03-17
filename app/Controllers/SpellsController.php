<?php

namespace app\Controllers;

use app\Models\ConfigModel;
use app\Models\SpellModel;

class SpellsController
{
    private SpellModel $spellModel;
    private $spellColumns = [];
    public function __construct()
    {
        $this->spellModel = new SpellModel();
        $configModel = new ConfigModel();
        $columns = $configModel->getConfigSpellColumns();
        $this->spellColumns = explode(',', $columns);
    }

    public function getSpellsByLevel($spells): array
    {
        $spellsNotes = array_key_exists('spell_notes', $_SESSION['character']->getCharModifiers())?
            $_SESSION['character']->getCharModifiers()['spell_notes'] : [];
        $spellsByLevel = [];
        foreach ($spells as $spellId) {
            $thisSpell = $this->getSpell((int) $spellId);
        $thisSpell['notes'] = array_key_exists($spellId, $spellsNotes) ? $spellsNotes[$spellId] : null;
            $thisSpell['modal'] = $this->getSpellModalTemplate($thisSpell);
            $level = ($thisSpell['level'] === 0) ? 'Cantrips' : 'Level '.$thisSpell['level'];
            $spellsByLevel[$level][] = $thisSpell;
        }
        ksort($spellsByLevel);
        return $spellsByLevel;
    }

    public function getSpell(int $id)
    {
        return $this->spellModel->getSpellById($id);
    }

    private function getSpellModalTemplate($spell)
    {
        // Options:level,school,casting_time,duration,sp_range,sp_area,attack,save,damage_effect,ritual,concentration,vsm,source,details
        $spellName = $spell['name'];
        $levelList = ['Cantrip', '1st level', '2nd level', '3rd level'];
        $spellLvl = false;
        if (in_array('level', $this->spellColumns)) {
            $spellLvl = (array_key_exists($spell['level'], $levelList)) ? $levelList[$spell['level']] : $spell['level'].'th level';
        }
        $castingTime = in_array('casting_time', $this->spellColumns)? $spell['casting_time'] : false;
        $range = in_array('sp_range', $this->spellColumns)? $spell['sp_range'] : false;
        $target = false;
        $vsm = false;
        if (in_array('vsm', $this->spellColumns)) {
            $vsm = [];
            $vsm['verbal'] = (array_key_exists('verbal',$spell) && $spell['verbal'] == 'Y') ? 'V' : '';
            $vsm['somatic'] = (array_key_exists('somatic',$spell) && $spell['somatic'] == 'Y') ? 'S' : '';
            $vsm['material'] = (array_key_exists('material',$spell) && $spell['material'] === 'Y') ? 'M' : '';
            $vsm['material_list'] = !empty($spell['material_list'])? ' '.$spell['material_list'] : '';
        }
        $duration = in_array('duration', $this->spellColumns)? $spell['duration'] : false;
        $ritual = false;
        if (in_array('ritual', $this->spellColumns)) {
            $ritual = !is_null($spell['ritual'])? 'Yes' : 'No';
        }
        $details = in_array('details', $this->spellColumns)? $spell['details'] : false;
        $source = in_array('source', $this->spellColumns)? $spell['source'] : false;
        $url = $spell['url'];
        $notes = array_key_exists('notes', $spell)? $spell['notes'] : false;

        ob_start();
        include './app/Views/Templates/partials/spell-modal-template_tpl.php';
        return ob_get_clean();
    }

}