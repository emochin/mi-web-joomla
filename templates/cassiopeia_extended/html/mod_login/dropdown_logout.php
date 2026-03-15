<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_login
 *
 * Custom Premium Dropdown Layout (Logout state)
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = \Joomla\CMS\Factory::getApplication()->getDocument()->getWebAssetManager();
$wa->useScript('keepalive');
$wa->useScript('bootstrap.dropdown');

?>

<div class="mod-login dropdown">
    <button class="btn dropdown-toggle" type="button" id="logoutDropdown-<?php echo $module->id; ?>" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="icon-user icon-fw" aria-hidden="true"></span> 
        <?php echo (!$params->get('name', 0)) ? htmlspecialchars($user->name, ENT_COMPAT, 'UTF-8') : htmlspecialchars($user->username, ENT_COMPAT, 'UTF-8'); ?>
    </button>
    
    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="logoutDropdown-<?php echo $module->id; ?>">
        <form class="mod-login-logout form-vertical" action="<?php echo Route::_('index.php', true); ?>" method="post" id="login-form-<?php echo $module->id; ?>">
            
            <?php if ($params->get('greeting', 1)) : ?>
                <div class="mod-login-logout__login-greeting login-greeting text-center">
                <?php if (!$params->get('name', 0)) : ?>
                    <?php echo Text::sprintf('MOD_LOGIN_HINAME', htmlspecialchars($user->name, ENT_COMPAT, 'UTF-8')); ?>
                <?php else : ?>
                    <?php echo Text::sprintf('MOD_LOGIN_HINAME', htmlspecialchars($user->username, ENT_COMPAT, 'UTF-8')); ?>
                <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($params->get('profilelink', 0)) : ?>
                <ul class="mod-login-logout__options list-unstyled text-center mb-3">
                    <li>
                        <a href="<?php echo Route::_('index.php?option=com_users&view=profile'); ?>">
                        <?php echo Text::_('MOD_LOGIN_PROFILE'); ?></a>
                    </li>
                </ul>
            <?php endif; ?>
            
            <div class="mod-login-logout__button logout-button mt-3">
                <button type="submit" name="Submit" class="btn btn-primary w-100"><?php echo Text::_('JLOGOUT'); ?></button>
                <input type="hidden" name="option" value="com_users">
                <input type="hidden" name="task" value="user.logout">
                <input type="hidden" name="return" value="<?php echo $return; ?>">
                <?php echo HTMLHelper::_('form.token'); ?>
            </div>
        </form>
    </div>
</div>
