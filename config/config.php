<?php

/**
 * Contao Open Source CMS
 */

/**
 * @file config.php
 * @author Sascha Weidner
 * @version 3.0.0
 * @package sioweb.contao.extensions.news
 * @copyright Sascha Weidner, Sioweb
 */

array_insert($GLOBALS['FE_MOD'], 2, array (
	'news' => array (
		'newsauthor'   		=> 'ModuleNewsAuthor',
	)
));