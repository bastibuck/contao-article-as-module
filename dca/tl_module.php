<?php

/**
 * @package     ArticleAsModule
 * @author      Basti Buck (http://www.bastibuck.de)
 * @license     LGPL
 * @copyright   Basti Buck, 2017
 */

namespace Bastibuck;

// Palettes
$GLOBALS['TL_DCA']['tl_module']['palettes']['article_as_module'] = '
  {title_legend},name,type;
  {include_legend},pick_article;
  {protected_legend:hide},protected;
  {expert_legend:hide},guests,cssID,space';

// Fields
$GLOBALS['TL_DCA']['tl_module']['fields']['pick_article'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_module']['pick_article'],
  'exclude'                 => true,
  'inputType'               => 'select',
  'foreignKey'              => 'tl_article.title',
  'options_callback'        => array('Bastibuck\tl_module', 'getArticlesPerPage'),
  'eval'                    => array
  (
    'chosen'                      => true,
    'tl_class'                    => '',
    'mandatory'                   => true,
    'includeBlankOption'          => true
  ),
  'sql'                     => "int(10) unsigned NOT NULL default '0'",
  'relation'                => array
  (
    'type'=>'hasOne',
    'load'=>'lazy'
  )
);


/**
 * Class provides small functions for tl_module
 */
class tl_module extends \Backend {

  /**
   * returns Array of articles ordered by their parent page
   */
  public function getArticlesPerPage() {

    // get all articles
    $objArticles = \ArticleModel::findAll(array('order' => 'pid, sorting'));

    while ($objArticles->next())
		{
      $arrArticles[$objArticles->pid][] = array(
        'id' => $objArticles->id,
        'title' => $objArticles->title,
        'alias' => $objArticles->alias
      );
		}

    // get all regular pages
    $objPages = \PageModel::findByType('regular', array('order' => 'pid, sorting'));

    // build array with pages as group headlines
		while ($objPages->next())
		{
      foreach($arrArticles[$objPages->id] as $arrArticle) {
        $arrArticleSet[$objPages->title][$arrArticle['id']] = $arrArticle['title'].' ['.$arrArticle['alias'].']';
      }
		}

    // return array to field options
		return $arrArticleSet;
  }
}
