<?php

use Contao\CoreBundle\DataContainer\PaletteManipulator;

$pm = PaletteManipulator::create()
    ->addField('enableCustomBackendStyle', 'backendTheme', PaletteManipulator::POSITION_AFTER);

foreach (['login', 'admin', 'default', 'group', 'extend', 'custom'] as $palette) {
    $pm->applyToPalette($palette, 'tl_user');
}

$GLOBALS['TL_DCA']['tl_user']['fields']['enableCustomBackendStyle'] = [
    'inputType' => 'checkbox',
    'eval'      => ['tl_class' => 'w50 m12'],
    'sql'       => "char(1) NOT NULL default '1'",
];
