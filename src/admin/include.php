<?php
/**
 * @package   OSDownloads
 * @contact   www.joomlashack.com, help@joomlashack.com
 * @copyright 2005-2019 Joomlashack.com. All rights reserved
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 * This file is part of OSDownloads.
 *
 * OSDownloads is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * OSDownloads is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OSDownloads.  If not, see <http://www.gnu.org/licenses/>.
 */

use Alledia\Framework\Joomla\Extension;
use Alledia\OSDownloads\Free\Factory;

defined('_JEXEC') or die();

// Alledia Framework
if (!defined('ALLEDIA_FRAMEWORK_LOADED')) {
    $allediaFrameworkPath = JPATH_SITE . '/libraries/allediaframework/include.php';

    if (file_exists($allediaFrameworkPath)) {
        require_once $allediaFrameworkPath;
    } else {
        $app = JFactory::getApplication();

        if ($app->isClient('administrator')) {
            $app->enqueueMessage('[OSDownloads] Alledia framework not found', 'error');
        }
    }
}

if (defined('ALLEDIA_FRAMEWORK_LOADED') && !defined('OSDOWNLOADS_LOADED')) {
    // Define the constant that say OSDownloads is ok to run
    define('OSDOWNLOADS_LOADED', 1);

    define('OSDOWNLOADS_MEDIA_PATH', JPATH_SITE . 'media/com_osdownloads');
    define('OSDOWNLOADS_MEDIA_URI', JUri::root() . 'media/com_osdownloads');

    Extension\Helper::loadLibrary('com_osdownloads');

    require_once JPATH_ADMINISTRATOR . '/components/com_osdownloads/vendor/autoload.php';

    $lang = JFactory::getLanguage();

    switch (JFactory::getApplication()->getName()) {
        case 'site':
            $lang->load('com_osdownloads', JPATH_SITE . '/components/com_osdownloads');
            break;

        case 'administrator':
            $lang->load('com_osdownloads', JPATH_ADMINISTRATOR . '/components/com_osdownloads');
            break;
    }
}
