<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_login
 *
 * Custom Premium Dropdown Layout
 */

defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Router\Route;

$app->getDocument()->getWebAssetManager()
    ->useScript('core')
    ->useScript('keepalive')
    ->useScript('field.passwordview')
    ->useScript('bootstrap.dropdown');

Text::script('JSHOWPASSWORD');
Text::script('JHIDEPASSWORD');
?>

<div class="mod-login dropdown">
    <button class="btn dropdown-toggle" type="button" id="loginDropdown-<?php echo $module->id; ?>" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="icon-user icon-fw" aria-hidden="true"></span> 
        <?php echo Text::_('JLOGIN'); ?>
    </button>
    
    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="loginDropdown-<?php echo $module->id; ?>">
        <form id="login-form-<?php echo $module->id; ?>" action="<?php echo Route::_('index.php', true); ?>" method="post">
            
            <?php if ($params->get('pretext')) : ?>
                <div class="mod-login__pretext pretext">
                    <p><?php echo $params->get('pretext'); ?></p>
                </div>
            <?php endif; ?>

            <div class="mod-login__userdata userdata">
                <!-- Username -->
                <div class="mod-login__username form-group">
                    <label for="modlgn-username-<?php echo $module->id; ?>"><?php echo Text::_('MOD_LOGIN_VALUE_USERNAME'); ?></label>
                    <input id="modlgn-username-<?php echo $module->id; ?>" type="text" name="username" class="form-control" autocomplete="username" placeholder="<?php echo Text::_('MOD_LOGIN_VALUE_USERNAME'); ?>">
                </div>

                <!-- Password -->
                <div class="mod-login__password form-group mt-3">
                    <label for="modlgn-passwd-<?php echo $module->id; ?>"><?php echo Text::_('JGLOBAL_PASSWORD'); ?></label>
                    <input id="modlgn-passwd-<?php echo $module->id; ?>" type="password" name="password" autocomplete="current-password" class="form-control" placeholder="<?php echo Text::_('JGLOBAL_PASSWORD'); ?>">
                </div>

                <!-- Remember Me -->
                <?php if (PluginHelper::isEnabled('system', 'remember')) : ?>
                    <div class="mod-login__remember form-group mt-2">
                        <div id="form-login-remember-<?php echo $module->id; ?>" class="form-check">
                            <input type="checkbox" name="remember" class="form-check-input" value="yes" id="form-login-input-remember-<?php echo $module->id; ?>">
                            <label class="form-check-label" for="form-login-input-remember-<?php echo $module->id; ?>">
                                <?php echo Text::_('MOD_LOGIN_REMEMBER_ME'); ?>
                            </label>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Submit Button -->
                <div class="mod-login__submit form-group mt-4">
                    <button type="submit" name="Submit" class="btn btn-primary w-100"><?php echo Text::_('JLOGIN'); ?></button>
                </div>

                <!-- Links -->
                <?php $usersConfig = ComponentHelper::getParams('com_users'); ?>
                <ul class="mod-login__options list-unstyled">
                    <li>
                        <a href="<?php echo Route::_('index.php?option=com_users&view=reset'); ?>">
                        <?php echo Text::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?></a>
                    </li>
                    <li>
                        <a href="<?php echo Route::_('index.php?option=com_users&view=remind'); ?>">
                        <?php echo Text::_('MOD_LOGIN_FORGOT_YOUR_USERNAME'); ?></a>
                    </li>
                    <?php if ($usersConfig->get('allowUserRegistration')) : ?>
                    <li>
                        <a href="<?php echo Route::_($registerLink); ?>">
                        <?php echo Text::_('MOD_LOGIN_REGISTER'); ?></a>
                    </li>
                    <?php endif; ?>
                </ul>
                
                <input type="hidden" name="option" value="com_users">
                <input type="hidden" name="task" value="user.login">
                <input type="hidden" name="return" value="<?php echo $return; ?>">
                <?php echo HTMLHelper::_('form.token'); ?>
            </div>
            
            <?php if ($params->get('posttext')) : ?>
                <div class="mod-login__posttext posttext mt-3">
                    <p><?php echo $params->get('posttext'); ?></p>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>
