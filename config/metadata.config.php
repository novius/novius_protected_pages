<?php
/**
 * Protected Pages is an application for Novius OS for protecting pages (and theirs tree) by login / password.
 *
 * @copyright 2014 Novius
 * @license GNU Affero General Public License v3 or (at your option) any later version
 * http://www.gnu.org/licenses/agpl-3.0.html
 * @link https://github.com/novius/novius_protected_pages
 */

return array(
    'name'    => 'Protected pages',
    'version' => '1.0',
    'provider' => array(
        'name' => 'Novius',
    ),
    'namespace' => "Novius\ProtectedPages",
    'permission' => array(
    ),
    'i18n_file' => 'novius_protected_pages::metadata',
    'icons' => array(
        64 => 'static/apps/novius_protected_pages/img/64/icon.png',
        32 => 'static/apps/novius_protected_pages/img/32/icon.png',
        16 => 'static/apps/novius_protected_pages/img/16/icon.png',
    ),
    'enhancers' => array(
        'novius_protected_pages' => array(
            'title' => 'Protected pages',
            'desc'  => '',
            'urlEnhancer' => 'novius_protected_pages/front/protectedpages/main',
            'dialog' => array(
                'contentUrl' => 'admin/novius_protected_pages/enhancer/popup',
                'ajax' => true,
            ),
        ),
    ),
);
