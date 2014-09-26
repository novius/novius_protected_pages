<?php
/**
 * Protected Pages is an application for Novius OS for protecting pages (and theirs tree) by login / password.
 *
 * @copyright 2014 Novius
 * @license GNU Affero General Public License v3 or (at your option) any later version
 * http://www.gnu.org/licenses/agpl-3.0.html
 * @link https://github.com/novius/novius_protected_pages
 */

\Nos\I18n::current_dictionary(array('novius_protected_pages::front'));
?>
<div class="protected_pages">
    <form method="POST" action="<?= $url ?>">
<?php
if (!empty($error)) {
    ?>
        <p class="protected_pages_error"><?= e($error) ?></p>
    <?php
}
?>
        <p class="protected_pages_title"><?= __('Please sign in to access this page') ?></p>
        <p class="protected_pages_login"><?= __('Login:') ?> <input type="text" name="login" value="<?= e(\Input::post('login', '')); ?>" /></p>
        <p class="protected_pages_password"><?= __('Password:') ?> <input type="password" name="password" /></p>
        <p class="protected_pages_submit"><input type="submit" value="<?= __('Connection') ?>" /></p>
    </form>
</div>
