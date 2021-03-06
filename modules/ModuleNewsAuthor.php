<?php

/**
* Contao Open Source CMS
*/

namespace sioweb\contao\extensions\news;
use Contao;

/**
* @file ModuleNewsAuthor.php
* @class ModuleNewsAuthor
* @author Sascha Weidner
* @version 3.0.0
* @package sioweb.contao.extensions.news
* @copyright Sascha Weidner, Sioweb
*/
class ModuleNewsAuthor extends \Module {
  
  public function generate() {
    $this->strTemplate = 'news_author';

    if (TL_MODE == 'BE')
    {
      /** @var \BackendTemplate|object $objTemplate */
      $objTemplate = new \BackendTemplate('be_wildcard');

      $objTemplate->wildcard = '### News author ###';
      $objTemplate->title = $this->headline;
      $objTemplate->id = $this->id;
      $objTemplate->link = $this->name;
      $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

      return $objTemplate->parse();
    }

    if (!isset($_GET['items']) && \Config::get('useAutoItem') && isset($_GET['auto_item']))
      \Input::setGet('items', \Input::get('auto_item'));

    return parent::generate();
  }

  /**
   * Generate module
   */
  protected function compile() {
    if(!empty(($objAuthor = $this->objModel->getRelated('author')))) 
      $arrAuthor = $objAuthor->row();
    if(\Input::get('items') != '') {
      $objArticle = \NewsModel::findByAlias(\Input::get('items'));
      $arrAuthor = $objArticle->getRelated('author')->row();
    } 

    if(empty($arrAuthor))
      return '';

    $_author = array();
    if($this->editableAuthor) {
      $this->editableAuthor = deserialize($this->editableAuthor);
      foreach($this->editableAuthor as $key => $field)
        $_author[$field] = $arrAuthor[$field];
    }

    if (isset($GLOBALS['TL_HOOKS']['newsAuthor']) && is_array($GLOBALS['TL_HOOKS']['newsAuthor'])) {
      foreach ($GLOBALS['TL_HOOKS']['newsAuthor'] as $key => $callback) {
        $this->import($callback[0]);
        $_author = $this->$callback[0]->$callback[1]($_author);
      }
    }

    if(!empty($arrAuthor['singleSRC'])) {
      $__author = array_merge(array('addImage'=>1,'floating'=>0,'caption'=>0,'fullsize'=>0,'imageUrl'=>0,'imagemargin'=>serialize(array()),'size'=>serialize(array()),'title'=>$arrAuthor['name'],'alt'=>$arrAuthor['name']),$_author);

      $objFile = \FilesModel::findByUuid($_author['singleSRC']);
      $_obj = $this->Template;
      $__author['singleSRC'] = $objFile->path;
      $this->addImageToTemplate((object)$_obj,$__author);
      $_author['singleSRC'] = $_obj;
    }

    if(!empty($objAuthor)) {
      $about = null;
      if($this->jumpTo) {
        $jt = $this->objModel->getRelated('jumpTo');
        if(!empty($jt))
          $about = $jt->row();
      }
      if(!empty($about)) {
        $jt = $objAuthor->getRelated('jumpTo');
        if(!empty($jt))
          $about = $jt->row();
      }
    }

    if(!empty($about)) {
      $this->Template->about_title = $about['description']?$about['description']:$about['title'];
      $this->Template->about = $this->generateFrontendUrl($about);
    }

    $this->Template->author = $_author;
  }
}