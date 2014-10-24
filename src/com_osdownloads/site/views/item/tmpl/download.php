<?php
/**
 * @package   OSDownloads
 * @contact   www.alledia.com, hello@alledia.com
 * @copyright 2014 Alledia.com, All rights reserved
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

$mainframe 			= JFactory::getApplication();
$params 			= clone($mainframe->getParams('com_osdownloads'));
$thankyoupage 	= $params->get("thankyoupage", "Thank you");

$email = trim(JRequest::getVar("email"));
if ($this->item->require_email && !preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email)) {
?>
<div class="error"><?php echo(JText::_("Wrong email"));?></div>
<?php
} else {?>
<div class="contentopen">
    <h1 class="thank"><?php echo($thankyoupage);?></h1>
    <p class="download_link"><?php echo JText::sprintf("CLICK TO DOWNLOAD FILE", $this->download_url);?>
        <meta http-equiv="refresh" content="0;url=<?php echo $this->download_url;?>">
    </p>
</div>
<?php
}
