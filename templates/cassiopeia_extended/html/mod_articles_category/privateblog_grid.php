<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_category
 *
 * Custom layout for private blog grid
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

if (!$list) {
    return;
}
?>

<div class="category-module privateblog-grid-override <?php echo $moduleclass_sfx; ?>">
    <div class="pb-grid-container">
        <?php foreach ($list as $item) : ?>
            <?php
            // Extract image safely
            $images = json_decode($item->images);
            $imageUrl = isset($images->image_intro) && !empty($images->image_intro) ? htmlspecialchars($images->image_intro, ENT_COMPAT, 'UTF-8') : '';
            
            // Generate clean metadata
            $date = HTMLHelper::_('date', $item->created, 'd M Y');
            $wordCount = str_word_count(strip_tags($item->introtext . $item->fulltext));
            $readingTime = ceil($wordCount / 200 > 0 ? $wordCount / 200 : 1) . ' MIN LECTURA';
            ?>
            
            <article class="pb-grid-item">
                <?php if ($imageUrl) : ?>
                <div class="pb-grid-image-wrapper">
                    <a href="<?php echo $item->link; ?>">
                        <img src="<?php echo $imageUrl; ?>" alt="<?php echo htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8'); ?>" class="pb-grid-img">
                    </a>
                </div>
                <?php endif; ?>

                <div class="pb-grid-content">
                    <div class="pb-meta-minimal">
                        <span><?php echo strtoupper($date); ?></span>
                        <span class="pb-meta-dot">&middot;</span>
                        <span><?php echo $readingTime; ?></span>
                    </div>

                    <h3 class="pb-grid-title">
                        <a href="<?php echo $item->link; ?>">
                            <?php echo $item->title; ?>
                        </a>
                    </h3>

                    <?php if ($params->get('show_introtext', 0)) : ?>
                    <div class="pb-grid-excerpt">
                        <?php echo HTMLHelper::_('string.truncate', strip_tags($item->introtext), 150, true, false); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</div>
