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
use Joomla\CMS\Language\Text;

$app = Factory::getApplication();

/** @var \Joomla\Component\Content\Site\View\Category\HtmlView $this */
$this->category->text = $this->category->description;
$app->triggerEvent('onContentPrepare', [$this->category->extension . '.categories', &$this->category, &$this->params, 0]);
$this->category->description = $this->category->text;

// We will skip displaying Joomla's default event outputs for a cleaner look
$htag = $this->params->get('show_page_heading') ? 'h2' : 'h1';

?>

<div class="pb-canvas">
    <div class="pb-wrapper">
        
        <header class="pb-site-header">
            <?php if ($this->params->get('show_page_heading')) : ?>
                <h1 class="pb-main-title"> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
            <?php elseif ($this->params->get('show_category_title', 1)) : ?>
                <h1 class="pb-main-title"> <?php echo $this->category->title; ?> </h1>
            <?php endif; ?>

            <?php if ($this->params->get('show_description') && $this->category->description) : ?>
                <div class="pb-main-desc">
                    <?php echo HTMLHelper::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
                </div>
            <?php endif; ?>
        </header>

        <?php if (empty($this->lead_items) && empty($this->link_items) && empty($this->intro_items)) : ?>
            <div class="pb-empty-state">
                Aún no hay historias publicadas aquí.
            </div>
        <?php endif; ?>

        <?php if (!empty($this->lead_items)) : ?>
            <section class="pb-hero-section">
                <?php 
                // Display the VERY FIRST lead item as the Hero
                $this->item = &$this->lead_items[0];
                echo $this->loadTemplate('hero'); 
                ?>
            </section>
        <?php endif; ?>

        <?php 
        // Collect remaining items (rest of leads + intros)
        $remainingItems = [];
        if (!empty($this->lead_items) && count($this->lead_items) > 1) {
            for ($i = 1; $i < count($this->lead_items); $i++) {
                $remainingItems[] = $this->lead_items[$i];
            }
        }
        if (!empty($this->intro_items)) {
            foreach ($this->intro_items as $item) {
                $remainingItems[] = $item;
            }
        }
        ?>

        <?php if (!empty($remainingItems)) : ?>
            <section class="pb-grid-section">
                <div class="pb-grid-container">
                    <?php foreach ($remainingItems as &$item) : ?>
                        <?php
                        $this->item = &$item;
                        echo $this->loadTemplate('item');
                        ?>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <?php if (($this->params->def('show_pagination', 1) == 1 || ($this->params->get('show_pagination') == 2)) && ($this->pagination->pagesTotal > 1)) : ?>
            <div class="pb-pagination-wrapper">
                <?php echo $this->pagination->getPagesLinks(); ?>
            </div>
        <?php endif; ?>

    </div>
</div>
