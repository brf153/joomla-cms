<?php
/**
 * @package     Joomla.Tests
 * @subpackage  AcceptanceTester.Step
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
namespace Step\Acceptance\Administrator;

use Exception;
use Page\Acceptance\Administrator\ContentListPage;

/**
 * Acceptance Step object class contains suits for Content Manager.
 *
 * @package  Step\Acceptance\Administrator
 *
 * @since    4.0.0
 */
class Content extends Admin
{
	/**
	 * Method to feature a article.
	 *
	 * @param   string  $title  Title
	 *
	 * @return void
	 *
	 * @since   4.0.0
	 *
	 * @throws Exception
	 */
	public function featureArticle($title)
	{
		$I = $this;
		$I->amOnPage(ContentListPage::$url);
		$I->waitForElement(ContentListPage::$filterSearch, $I->getConfig('timeout'));
		$I->searchForItem($title);
		$I->checkAllResults();
		$I->clickToolbarButton('feature');
		$I->seeNumberOfElements(ContentListPage::$seeFeatured, 1);
	}

	/**
	 * Method to set an article accesslevel.
	 *
	 * @param   string  $title        Title
	 * @param   string  $accessLevel  AccessLevel
	 *
	 * @return void
	 *
	 * @since   4.0.0
	 *
	 * @throws Exception
	 */
	public function setArticleAccessLevel($title, $accessLevel)
	{
		$I = $this;
		$I->amOnPage(ContentListPage::$url);
		$I->waitForElement(ContentListPage::$filterSearch, $I->getConfig('timeout'));
		$I->searchForItem($title);
		$I->checkAllResults();
		$I->click($title);
		$I->waitForElement(['id' => "jform_access"], $I->getConfig('timeout'));
		$I->selectOption(['id' => "jform_access"], $accessLevel);
		$I->click(ContentListPage::$dropDownToggle);
		$I->clickToolbarButton('Save & Close');
		$I->waitForElement(ContentListPage::$filterSearch, $I->getConfig('timeout'));
		$I->see($accessLevel, ContentListPage::$seeAccessLevel);
	}

	/**
	 * Method to unpublish an article.
	 *
	 * @param   string  $title  Title
	 *
	 * @return void
	 *
	 * @since   4.0.0
	 * @throws Exception
	 */
	public function unPublishArticle($title)
	{
		$I = $this;
		$I->amOnPage(ContentListPage::$url);
		$I->waitForElement(ContentListPage::$filterSearch, $I->getConfig('timeout'));
		$I->searchForItem($title);
		$I->checkAllResults();
		$I->clickToolbarButton('unpublish');
		$I->seeNumberOfElements(ContentListPage::$seeUnpublished, 1);
	}

	/**
	 * Method to trash an article.
	 *
	 * @param   string  $title  Title
	 *
	 * @return void
	 *
	 * @since   4.0.0
	 *
	 * @throws Exception
	 */
	public function trashArticle($title)
	{
		$I = $this;
		$I->amOnPage(ContentListPage::$url);
		$I->waitForElement(ContentListPage::$filterSearch, $I->getConfig('timeout'));
		$this->articleManagerPage->haveItemUsingSearch($title);
		$I->clickToolbarButton('trash');
		$I->searchForItem($title);
		$I->dontSee($title);
	}
}
