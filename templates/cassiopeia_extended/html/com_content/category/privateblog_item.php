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
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Content\Administrator\Extension\ContentComponent;
use Joomla\Component\Content\Site\Helper\RouteHelper;

/** @var \Joomla\Component\Content\Site\View\Category\HtmlView $this */
// Create a shortcut for params.
$params = $this->item->params;
$canEdit = $this->item->params->get('access-edit');
$info    = $params->get('info_block_position', 0);

// Check if associations are implemented. If they are, define the parameter.
$assocParam = (Associations::isEnabled() && $params->get('show_associations'));

$currentDate   = Factory::getDate()->format('Y-m-d H:i:s');
$isUnpublished = ($this->item->state == ContentComponent::CONDITION_UNPUBLISHED || $this->item->publish_up > $currentDate)
    || ($this->item->publish_down < $currentDate && $this->item->publish_down !== null);

?>

<article class="private-blog-post">
    <div class="private-blog-post-image">
        <?php echo LayoutHelper::render('joomla.content.intro_image', $this->item); ?>
    </div>

    <div class="private-blog-post-content">
        <?php if ($isUnpublished) : ?>
            <div class="system-unpublished">
        <?php endif; ?>

        <header class="private-blog-post-header">
            <?php echo LayoutHelper::render('joomla.content.blog_style_default_item_title', $this->item); ?>

            <?php if ($canEdit) : ?>
                <?php echo LayoutHelper::render('joomla.content.icons', ['params' => $params, 'item' => $this->item]); ?>
            <?php endif; ?>
        </header>

        <?php $useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
            || $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author') || $assocParam); ?>

        <?php if ($useDefList && ($info == 0 || $info == 2)) : ?>
            <div class="private-blog-post-meta">
                <?php echo LayoutHelper::render('joomla.content.info_block', ['item' => $this->item, 'params' => $params, 'position' => 'above']); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($info == 0 && $params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
            <div class="private-blog-post-tags">
                <?php echo LayoutHelper::render('joomla.content.tags', $this->item->tags->itemTags); ?>
            </div>
        <?php endif; ?>

        <?php if (!$params->get('show_intro')) : ?>
            <?php echo $this->item->event->afterDisplayTitle; ?>
        <?php endif; ?>

        <?php echo $this->item->event->beforeDisplayContent; ?>

        <div class="private-blog-post-text">
            <?php echo $this->item->introtext; ?>
        </div>

        <?php if ($info == 1 || $info == 2) : ?>
            <?php if ($useDefList) : ?>
                <div class="private-blog-post-meta private-blog-post-meta-below">
                    <?php echo LayoutHelper::render('joomla.content.info_block', ['item' => $this->item, 'params' => $params, 'position' => 'below']); ?>
                </div>
            <?php endif; ?>
            <?php if ($params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
                <div class="private-blog-post-tags">
                    <?php echo LayoutHelper::render('joomla.content.tags', $this->item->tags->itemTags); ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <footer class="private-blog-post-footer">
            <?php if ($params->get('show_readmore') && $this->item->readmore) :
                if ($params->get('access-view')) :
                    $link = Route::_(RouteHelper::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language));
                else :
                    $menu = Factory::getApplication()->getMenu();
                    $active = $menu->getActive();
                    $itemId = $active->id;
                    $link = new Uri(Route::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false));
                    $link->setVar('return', base64_encode(RouteHelper::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language)));
                endif; ?>

                <div class="private-blog-readmore">
                    <?php echo LayoutHelper::render('joomla.content.readmore', ['item' => $this->item, 'params' => $params, 'link' => $link]); ?>
                </div>
            <?php endif; ?>
        </footer>

        <?php if ($isUnpublished) : ?>
            </div>
        <?php endif; ?>

        <?php echo $this->item->event->afterDisplayContent; ?>
    </div>
</article>
