<?php
/**
 * jUpgrade
 *
 * @version		$Id$
 * @package		MatWare
 * @subpackage	com_jupgrade
 * @copyright	Copyright 2006 - 2011 Matias Aguire. All rights reserved.
 * @license		GNU General Public License version 2 or later.
 * @author		Matias Aguirre <maguirre@matware.com.ar>
 * @link		http://www.matware.com.ar
 */

/**
 * Upgrade class for Banners
 *
 * This class takes the banners from the existing site and inserts them into the new site.
 *
 * @since	0.4.5
 */
class jUpgradeBanners extends jUpgrade
{
	/**
	 * @var		string	The name of the source database table.
	 * @since	0.4.5
	 */
	protected $source = '#__banner';

	/**
	 * @var		string	The name of the destination database table.
	 * @since	0.4.5
	 */
	protected $destination = '#__banners';


	/**
	 * Get the raw data for this part of the upgrade.
	 *
	 * @return	array	Returns a reference to the source data array.
	 * @since	0.4.5
	 * @throws	Exception
	 */
	protected function &getSourceData()
	{
		$rows = parent::getSourceData(
			'`bid` AS id, `cid`, `type`,`name`,`alias`, `imptotal` ,`impmade`, `clicks`, '
		 .'`catid`, `clickurl`, `checked_out`, `checked_out_time`, `showBanner` AS state, '
		 .'`custombannercode`, `description`, `sticky`, `ordering`, `publish_up`, '
		 .'`publish_down`, `params`',
			null,
			'bid'
		);

		// Getting the categories id's
		$categories = $this->getMapList('categories', 'com_banner');

		// Do some custom post processing on the list.
		foreach ($rows as &$row)
		{
			$row['params'] = $this->convertParams($row['params']);

			$cid = $row['catid'];
			$row['catid'] = &$categories[$cid]->new;

			$row['language'] = '*';
		}

		return $rows;
	}
}
