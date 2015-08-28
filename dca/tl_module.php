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
$GLOBALS['TL_DCA']['tl_module']['palettes']['newsauthor']    = '{title_legend},name,headline,type;{config_legend},author,editableAuthor';

$GLOBALS['TL_DCA']['tl_module']['fields']['editableAuthor'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_module']['editable'],
  'exclude'                 => true,
  'inputType'               => 'checkboxWizard',
  'options_callback'        => array('tl_sw_news_module', 'getEditableUserProperties'),
  'eval'                    => array('multiple'=>true,'tl_class'=>'clr'),
  'sql'                     => "blob NULL"
);

if(!isset($GLOBALS['TL_DCA']['tl_module']['fields']['author'])) {
  $this->loadDataContainer('tl_news');
  $GLOBALS['TL_DCA']['tl_module']['fields']['author'] = $GLOBALS['TL_DCA']['tl_news']['fields']['author'];
}

class tl_sw_news_module extends tl_module {


  public function getEditableUserProperties() {

    $return = array();

    System::loadLanguageFile('tl_user');
    $this->loadDataContainer('tl_user');

    foreach ($GLOBALS['TL_DCA']['tl_user']['fields'] as $k=>$v) {
      if(!empty($GLOBALS['TL_DCA']['tl_user']['fields'][$k]['label'][0]))
        $return[$k] = $GLOBALS['TL_DCA']['tl_user']['fields'][$k]['label'][0];
    }

    return $return;
  }
}