<?php
/**
 * @version 1.0.0
 * @author Open Source Training (www.ostraining.com)
 * @copyright (C) 2014 Open Source Training
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.view');

class OSDownloadsViewItem extends JViewLegacy
{

    public function display($tpl = null)
    {
        JTable::addIncludePath(JPATH_COMPONENT.'/tables');

        $mainframe = JFactory::getApplication();
        $params    = clone($mainframe->getParams('com_osdownloads'));
        $id        = $params->get("document_id");

        $db 	= JFactory::getDBO();

        if (JRequest::getVar("id")) {
            $id = JRequest::getVar("id");
        }

        $query	= "SELECT documents.*, cate.access
                    FROM `#__osdownloads_documents` documents
                    LEFT JOIN `#__categories` cate ON (documents.cate_id = cate.id AND cate.extension='com_osdownloads')
                    WHERE cate.published = 1 AND documents.id = {$id}";

        $db->setQuery($query);
        $item = $db->loadObject();
        $user = JFactory::getUser();
        $groups = $user->getAuthorisedViewLevels();
        if (!$item || !in_array($item->access, $groups)) {
            JError::raiseWarning(404, JText::_("This download isn't available"));

            return;
        }

        $this->buildPath($paths, $item->cate_id);
        $this->assignRef("item", $item);
        $this->assignRef("paths", $paths);
        $this->assignRef("params", $params);

        // Check if the file should come from an external URL
        if (!empty($item->file_url)) {

            // Triggers the onGetExternalDownloadLink event
            JPluginHelper::importPlugin('osdownloads');
            $dispatcher = JEventDispatcher::getInstance();
            $dispatcher->trigger('onGetExternalDownloadLink', array(&$item));

            $downloadUrl = $item->file_url;
        } else {
            $downloadUrl = "index.php?option=com_osdownloads&task=download&tmpl=component&id={$item->id}";
        }
        $downloadUrl = JRoute::_($downloadUrl);
        $this->assignRef('download_url', $downloadUrl);

        parent::display($tpl);
    }

    public function buildPath(& $paths, $id)
    {
        $db 	= JFactory::getDBO();
        $db->setQuery("SELECT * FROM `#__categories` WHERE extension='com_osdownloads' AND id = " . $id);
        $cate = $db->loadObject();
        if ($cate) {
            $paths[] = $cate;
        }

        if ($cate && $cate->parent_id) {
            $this->buildPath($paths, $cate->parent_id);
        }
    }
}
