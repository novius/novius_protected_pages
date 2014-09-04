<?php
/**
 * Protected Pages is an application for Novius OS for protecting pages (and theirs tree) by login / password.
 *
 * @copyright 2014 Novius
 * @license GNU Affero General Public License v3 or (at your option) any later version
 * http://www.gnu.org/licenses/agpl-3.0.html
 * @link https://github.com/novius/novius_protected_pages
 */

\Nos\I18n::current_dictionary(array('novius_protected_pages::common'));

return array(
    'fields' => array(
        'login' => array(
            'label' => __('Login:'),
            'form' => array(
                'type' => 'text',
            ),
            'validation' => array(
                'required',
            ),
        ),
        'password' => array(
            'label' => __('Password:'),
            'form' => array(
                'type' => 'text',
            ),
            'validation' => array(
                'required',
            ),
        ),
    ),
);
