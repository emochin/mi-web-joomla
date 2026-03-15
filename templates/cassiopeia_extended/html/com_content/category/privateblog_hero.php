<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Content\Site\Helper\RouteHelper;

// Variables shortcuts
$item = $this->item;
$params = $item->params;

// Clean text extraction for metadata
$date = HTMLHelper::_('date', $item->created, 'd M Y');
$readingTime = ceil(str_word_count(strip_tags($item->introtext . $item->fulltext)) / 200) . ' MIN LECTURA';

// Link logic
if ($params->get('access-view')) {
    $link = Route::_(RouteHelper::getArticleRoute($item->slug, $item->catid, $item->language));
} else {
    $menu = Factory::getApplication()->getMenu();
    $active = $menu->getActive();
    $itemId = $active->id;
    $link = new Uri(Route::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false));
    $link->setVar('return', base64_encode(RouteHelper::getArticleRoute($item->slug, $item->catid, $item->language)));
}

// Intro Image extraction
$images = json_decode($item->images);
$imageUrl = '';
if (isset($images->image_intro) && !empty($images->image_intro)) {
    $imageUrl = htmlspecialchars($images->image_intro, ENT_COMPAT, 'UTF-8');
}
?>

<div class="pb-hero-article">
    <?php if ($imageUrl) : ?>
    <div class="pb-hero-image-wrapper">
        <a href="<?php echo $link; ?>">
            <img src="<?php echo $imageUrl; ?>" alt="<?php echo htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8'); ?>" class="pb-hero-img">
        </a>
    </div>
    <?php endif; ?>

    <div class="pb-hero-content">
        <div class="pb-meta-minimal">
            <span><?php echo strtoupper($date); ?></span>
            <span class="pb-meta-dot">&middot;</span>
            <span><?php echo $readingTime; ?></span>
        </div>

        <h2 class="pb-hero-title">
            <a href="<?php echo $link; ?>">
                <?php echo $this->escape($item->title); ?>
            </a>
        </h2>

        <div class="pb-hero-excerpt">
            <?php echo HTMLHelper::_('string.truncate', strip_tags($item->introtext), 250, true, false); ?>
        </div>

        <a href="<?php echo $link; ?>" class="pb-read-link">LEER HISTORIA <span aria-hidden="true">&rarr;</span></a>
    </div>
</div>
