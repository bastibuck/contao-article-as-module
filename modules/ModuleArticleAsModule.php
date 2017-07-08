<?php

/**
 * @package     ArticleAsModule
 * @author      Basti Buck (http://www.bastibuck.de)
 * @license     LGPL
 * @copyright   Basti Buck, 2017
 */

namespace Bastibuck;


/**
 * Class for new Module ArticleAsModule
 */
class ModuleArticleAsModule extends \Module {

  protected $strTemplate = 'mod_article_module';


  /**
   * Display a wildcard in the back end
   */
  public function generate()
  {
    if (TL_MODE == 'BE')
    {
      /** @var \BackendTemplate|object $objTemplate */
      $objTemplate = new \BackendTemplate('be_wildcard');

      $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['article_as_module'][0]). ' ###';
      $objTemplate->id = $this->id;
      $objTemplate->link = $this->name;
      $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

      return $objTemplate->parse();
    }

    return parent::generate();
  }


  /**
   * Generate the module
   */
  protected function compile() {

    // get published article by saved ID
    $objArticle = \ArticleModel::findPublishedById($this->pick_article);

    // Print in Template
    if($objArticle->id) {
      $this->Template->insertArticle = '{{insert_article::'.$objArticle->id.'}}';
    }
    // return error msg if no article was found e.g. not published
    else {
      $this->Template->insertArticle = '<p class="error">'.
        $GLOBALS['TL_LANG']['MSC']['article_as_module']['not_found'].
      '</p>';
    }
  }
}
