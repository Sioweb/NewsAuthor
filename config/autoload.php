<?php

/**
 * Contao Open Source CMS
 */

/**
 * @file autoload.php
 * @author Sascha Weidner
 * @version 3.0.0
 * @package sioweb.contao.extensions.news
 * @copyright Sascha Weidner, Sioweb
 */

ClassLoader::addNamespaces(array(
    'sioweb\contao\extensions\news'
));

ClassLoader::addClasses(array(
    // classes
    'sioweb\contao\extensions\news\ModuleNewsAuthor'   => 'system/modules/NewsAuthor/modules/ModuleNewsAuthor.php',
));

TemplateLoader::addFiles(array(
    'news_author'     => 'system/modules/NewsAuthor/templates',
));