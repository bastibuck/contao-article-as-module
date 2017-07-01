<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'Bastibuck',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Modules
	'Bastibuck\ModuleArticleAsModule' => 'system/modules/article_as_module/modules/ModuleArticleAsModule.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_article_module' => 'system/modules/article_as_module/templates',
));
