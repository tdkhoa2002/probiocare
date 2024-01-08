<?php

namespace Modules\Menu\Presenters;

use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Menu\MenuItem;
use Modules\Menu\Presenters\Presenter;

class FooterMenuPresenter extends Presenter
{
    public function setLocale($item)
    {
        if (Str::startsWith($item->url, 'http')) {
            return;
        }
        if (LaravelLocalization::hideDefaultLocaleInURL() === false) {
            $item->url = locale() . '/' . preg_replace('%^/?' . locale() . '/%', '$1', $item->url);
        }
    }
    /**
     * {@inheritdoc }.
     */
    public function getOpenTagWrapper()
    {
        return PHP_EOL . '<ul class="menu-list">' . PHP_EOL;
    }

    /**
     * {@inheritdoc }.
     */
    public function getCloseTagWrapper()
    {
        return PHP_EOL . '</ul>' . PHP_EOL;
    }

    /**
     * {@inheritdoc }.
     */
    public function getMenuWithoutDropdownWrapper($item)
    {
        $this->setLocale($item);

        return '<li><a href="' . $item->getUrl() . '" >' . $item->getIcon() . ' ' . $item->title . '</a></li>' . PHP_EOL;
    }

    /**
     * {@inheritdoc }.
     */
    public function getActiveState($item, $state = 'active')
    {
        return $item->isActive() ? $state : null;
    }

    /**
     * Get active state on child items.
     *
     * @param $item
     * @param string $state
     *
     * @return null|string
     */
    public function getActiveStateOnChild($item, $state = 'active')
    {
        return $item->hasActiveOnChild() ? $state : null;
    }

    /**
     * {@inheritdoc }.
     */
    public function getMenuWithDropDownWrapper($item)
    {
        return '<li><a href="' . $item->getUrl() . '" >' . $item->getIcon() . ' ' . $item->title . '</a></li>' . PHP_EOL;

        // return '<li class="nav-item dropdown' . $this->getActiveStateOnChild($item, ' active') . '">
        //         <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        //         ' . $item->title . ' <img src="/assets/images/down-outline.png" alt="" />
        //         </a>
                  
        //           <ul class="dropdown-menu" style="padding: 5px">
        //             ' . $this->getChildMenuItems($item) . '
        //           </ul>
        //         </li>'
        //     . PHP_EOL;
    }

    /**
     * Get multilevel menu wrapper.
     *
     * @param MenuItem $item
     *
     * @return string`
     */
    public function getMultiLevelDropdownWrapper($item)
    {
        return '<li class="dropdown' . $this->getActiveStateOnChild($item, ' active') . '">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    ' . $item->getIcon() . ' ' . $item->title . '
                    <b class="caret pull-right caret-right"></b>
                  </a>
                  <ul class="dropdown-menu">
                    ' . $this->getChildMenuItems($item) . '
                  </ul>
                </li>'
            . PHP_EOL;
    }
}
