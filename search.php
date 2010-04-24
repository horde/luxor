<?php
/**
 * Copyright 2003-2010 The Horde Project (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (GPL). If you
 * did not receive this file, see http://www.horde.org/licenses/gpl.php.
 *
 * @author Jan Schneider <jan@horde.org>
 * @author Mike Cochrane <mike@graftonhall.co.nz>
 */

require_once dirname(__FILE__) . '/lib/Application.php';
Horde_Registry::appInit('luxor');

$symbol = Horde_Util::getFormData('s');
if (!$symbol) {
    header('Location: ' . Horde::applicationUrl('source.php', true));
    exit;
}

$ids = $index->searchSymbols($symbol);
if (count($ids) == 1) {
    $id = current($ids);
    header('Location: ' . Horde::applicationUrl('symbol.php?i=' . $id, true));
    exit;
}

// If there are multiple search results, display some info for all of them.

$title = sprintf(_("Symbol Search for \"%s\""), $symbol);
require LUXOR_TEMPLATES . '/common-header.inc';
require LUXOR_TEMPLATES . '/menu.inc';

echo '<h1 class="header">' . htmlspecialchars($title) . '</h1>';

foreach ($ids as $ident) {
    // Change source if the symbol isn't from the current source.
    $symbolSource = $index->getSourceBySymbol($ident);
    if ($symbolSource != $sourceid) {
        $source = $sources[$symbolSource];
        $index = Luxor_Driver::factory($symbolSource);
    }

    $name = $index->symname($ident);
    echo '<br /><span class="header">' . Horde::link(Horde::applicationUrl('symbol.php?i=' . $ident), $name, 'header') . $name . '</a></span><br />';

    $references = $index->getIndex($ident);
    $sorted = array();
    foreach ($references as $ref) {
        $sorted[$ref['declaration']][] = array('filename' => $ref['filename'],
                                               'line' => $ref['line']);
    }

    foreach ($sorted as $type => $locations) {
        echo _("Declared as ") . $type . "\n";
        foreach ($locations as $loc) {
            $href = Luxor::url($loc['filename'], array(), 'l' . $loc['line']);
            echo '    <a href="' . $href . '">' . $loc['filename'] . ' Line: ' . $loc['line'] . '</a><br />';
        }
        echo '<br />';
    }
}

require $registry->get('templates', 'horde') . '/common-footer.inc';
