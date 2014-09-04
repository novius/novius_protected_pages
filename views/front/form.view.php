<?php
/**
 * Protected Pages is an application for Novius OS for protecting pages (and theirs tree) by login / password.
 *
 * @copyright 2014 Novius
 * @license GNU Affero General Public License v3 or (at your option) any later version
 * http://www.gnu.org/licenses/agpl-3.0.html
 * @link https://github.com/novius/novius_protected_pages
 */
?>
<div class="protected_pages">
    <form method="POST" action="<?= $url ?>">
        <p><input type="text" name="login" value="<?= e(\Input::post('login', '')); ?>" placeholder="<?= e(__('Login')) ?>" /></p>
        <p><input type="password" name="password" placeholder="<?= e(__('password')) ?>" /></p>
        <p><input type="submit" value="<?= e(__('Connect')) ?>" /></p>
    </form>
</div>
