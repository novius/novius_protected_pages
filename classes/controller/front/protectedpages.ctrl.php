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

use Nos\Controller_Front_Application;
use Nos\FrontCache;
use Nos\NotFoundException;

class Controller_Front_Protectedpages extends Controller_Front_Application
{

    public function action_main($args = array()) {

        $page = $this->main_controller->getPage();
        $enhancer_url = $this->main_controller->getEnhancerUrl();

        $protected_pages = \Session::get('protected_pages', array());
        if (empty($protected_pages[$page->page_id]) || $protected_pages[$page->page_id] !== true) {
            if ($enhancer_url == 'connect') {
                $login = \Arr::get($args, 'login', false);
                $password = \Arr::get($args, 'password', false);
                if (\Input::post('login', '') === $login && \Input::post('password', '') === $password) {
                    $redirect = \Arr::get($protected_pages, $page->page_id, $this->main_controller->getContextUrl().$this->main_controller->getEnhancedUrlPath());
                    $protected_pages[$page->page_id] = true;
                    \Session::set('protected_pages', $protected_pages);
                    \Session::write();
                    \Response::redirect($redirect);
                }
            } elseif ($enhancer_url == 'login') {
                $wysiwyg_name = $this->main_controller->getWysiwygName();
                \Event::register_function('front.parse_wysiwyg', function (&$content) use ($wysiwyg_name)
                {
                    if ($wysiwyg_name === $this->main_controller->getWysiwygName()) {
                        ob_start();
                        FrontCache::viewForgeUncached('novius_protected_pages::front/form', array(
                            'url' => $this->main_controller->getContextUrl().$this->main_controller->getEnhancedUrlPath().'connect.html'
                        ), false);

                        $content = ob_get_clean();
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