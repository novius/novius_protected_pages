<?php
/**
 * Protected Pages is an application for Novius OS for protecting pages (and theirs tree) by login / password.
 *
 * @copyright 2014 Novius
 * @license GNU Affero General Public License v3 or (at your option) any later version
 * http://www.gnu.org/licenses/agpl-3.0.html
 * @link https://github.com/novius/novius_protected_pages
 */

namespace Novius\ProtectedPages;

use Fuel\Core\View;
use Nos\Controller_Front_Application;
use Nos\FrontCache;
use Nos\I18n;
use Nos\NotFoundException;

class Controller_Front_Protectedpages extends Controller_Front_Application
{
    public function before()
    {
        parent::before();

        I18n::current_dictionary(array('novius_protected_pages::front'));
    }

    public function action_main($args = array())
    {
        $this->main_controller->disableCaching();

        $page = $this->main_controller->getPage();
        $enhancer_url = $this->main_controller->getEnhancerUrl();

        $protected_pages = \Session::get('protected_pages', array());
        if (empty($protected_pages[$page->page_id]) || $protected_pages[$page->page_id] !== true || $enhancer_url == 'login') {
            if ($enhancer_url == 'connect') {
                $login = \Arr::get($args, 'login', false);
                $password = \Arr::get($args, 'password', false);
                if (\Input::post('login', '') === $login && \Input::post('password', '') === $password) {
                    $redirect = \Arr::get($protected_pages, $page->page_id, false);
                    if (!is_string($redirect)) {
                        $redirect = $this->main_controller->getContextUrl().$this->main_controller->getPageUrl();
                    }
                    $protected_pages[$page->page_id] = true;
                    \Session::set('protected_pages', $protected_pages);
                    \Session::write();
                    \Response::redirect($redirect);
                } else {
                    \Session::set_flash('protected_pages_error', __('Bad login or password.'));
                    \Session::set_flash('protected_pages_login', \Input::post('login', ''));
                }
            } elseif ($enhancer_url == 'login') {
                if ($protected_pages[$page->page_id] === true) {
                    unset($protected_pages[$page->page_id]);
                    \Session::set('protected_pages', $protected_pages);
                    \Session::write();
                };

                $wysiwyg_name = $this->main_controller->getWysiwygName();
                \Event::register_function('front.parse_wysiwyg', function (&$content) use ($wysiwyg_name) {
                    if ($wysiwyg_name === $this->main_controller->getWysiwygName()) {
                        $content = (string) View::forge('novius_protected_pages::front/form', array(
                            'error' => \Session::get_flash('protected_pages_error', '', true),
                            'login' => \Session::get_flash('protected_pages_login', \Input::post('login', ''), true),
                            'url' => $this->main_controller->getContextUrl().$this->main_controller->getEnhancedUrlPath().'connect.html'
                        ), false);
                    }
                });

                // Keep one space at least, without have a notice in DEV
                return ' ';
            } else {
                $protected_pages[$page->page_id] = $this->main_controller->getUrl();
                \Session::set('protected_pages', $protected_pages);
                \Session::write();
            }

            \Response::redirect($this->main_controller->getContextUrl().$this->main_controller->getEnhancedUrlPath().'login.html');
        } else if (!empty($enhancer_url)) {
            throw new NotFoundException();
        }

        // Keep one space at least, without have a notice in DEV
        return ' ';
    }
}
