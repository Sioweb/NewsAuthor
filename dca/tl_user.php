<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Add palettes to tl_module
 */

foreach($GLOBALS['TL_DCA']['tl_user']['palettes'] as $type => $palette) {
  if(is_array($palette)) continue;

  $semi = substr($GLOBALS['TL_DCA']['tl_user']['palettes'][$type],-1);
  $GLOBALS['TL_DCA']['tl_user']['palettes'][$type] .= ($semi===';'?'':';').'{NewsLegend},singleSRC,text';
}

$this->loadLanguageFile('tl_content');
$this->loadDataContainer('tl_content');
if(!isset($GLOBALS['TL_DCA']['tl_user']['fields']['singleSRC'])) {
  $GLOBALS['TL_DCA']['tl_user']['fields']['singleSRC'] = $GLOBALS['TL_DCA']['tl_content']['fields']['singleSRC'];
}
if(!isset($GLOBALS['TL_DCA']['tl_user']['fields']['text'])) {
  $GLOBALS['TL_DCA']['tl_user']['fields']['text'] = $GLOBALS['TL_DCA']['tl_content']['fields']['text'];
}
if(!isset($GLOBALS['TL_DCA']['tl_user']['fields']['jumpTo'])) {
  $this->loadLanguageFile('tl_page');
  $this->loadDataContainer('tl_page');
  $GLOBALS['TL_DCA']['tl_user']['fields']['jumpTo'] = $GLOBALS['TL_DCA']['tl_page']['fields']['jumpTo'];
}