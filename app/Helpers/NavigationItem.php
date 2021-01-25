<?php
namespace App\Helpers;

use Route;
use Illuminate\Support\Str;

class NavigationItem
{
    public $name;
    public $badgeCount;
    public $route;
    public $icon_class;
    public $type;
    public $route_name;
    public $children;

    public $id;

    public function __construct($name, $route, $icon_class = null, $type = 'main', $id = null)
    {
        $this->setName($name)->setRoute($route)->setIconClass($icon_class)->setType($type);

        $this->children = collect();
        $this->id = $id ?? Str::kebab($name);
    }

    public function hasChildren()
    {
        return $this->children && $this->children->isNotEmpty();
    }

    public function addChild($childName, $childRoute, $childClass = null)
    {
        if (!$childClass) {
            $childClass = static::getChildIconClass();
        }
        $child = new self($childName, $childRoute, $childClass, 'child');

        return $this->appendChild($child);
    }

    public function appendChild($child)
    {
        if ($child instanceof NavigationItem) {
            $this->children->push($child);
        }

        return $this->children;
    }

    public function isAParent()
    {
        $parents = ['main', 'section'];

        return in_array($this->type, $parents);
    }

    public function hasActiveChild()
    {
        if ($this->hasChildren()) {
            return $this->children->filter(function ($child, $key) {
                return ($child instanceof NavigationItem) && $child->isActive();
            })->isNotEmpty();
        }

        return false;
    }

    public function hasActivePath()
    {
        return Str::startsWith(url()->current(), $this->getRoute());
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getLinkClass()
    {
        if ($this->isCurrent()) {
            return ($this->isAParent()) ? static::getActiveParentClass() : static::getActiveLinkClass();
        }

        if ($this->hasActiveChild()) {
            return static::getActiveParentClass();
        }

        return '';
    }

    public function getIconClass()
    {
        return $this->icon_class;
    }

    public function setIconClass($iconClass)
    {
        $this->icon_class = $iconClass;

        return $this;
    }

    public function getBadgeCount()
    {
        return $this->badgeCount;
    }

    public function setBadgeCount($count)
    {
        $this->badgeCount = intval($count);

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type = 'main')
    {
        if (!in_array($type, ['section', 'main', 'child'])) {
            $type = 'main';
        }

        $this->type = $type;

        return $this;
    }

    public function getRouteName()
    {
        return $this->route_name;
    }

    public function getRoute()
    {
        if ($this->hasChildren()) {
            return '#' . $this->getId();
        }

        return $this->route;
    }

    public function setRoute($routeData)
    {
        if (is_array($routeData)) {
            $route = data_get($routeData, 'link', '#');
            $type = data_get($routeData, 'type', 'direct');
            $params = data_get($routeData, 'params', null);
        } else {
            $route = $routeData;
            $type = 'direct';
        }

        $this->route_name = null;
        switch ($type) {
            case 'laravel':
                $this->route_name = $route;
                if ($params) {
                    $route = route($route, $params);
                } else {
                    $route = route($route);
                }
                break;

            case 'relative':
                $route = url($route);
                break;

            case 'direct':
            default:
                // do-nothing;
                break;
        }
        $this->route = $route;

        return $this;
    }

    public function hasBadge()
    {
        return !empty($this->badgeCount);
    }

    public function isCurrent()
    {
        return request()->url() === $this->getRoute();
    }

    public function isActive()
    {
        return $this->isCurrent() || ($this->hasActiveChild()) || ($this->hasActivePath());
    }


    public static function getActiveLinkClass()
    {
        return 'active';
    }

    public static function getActiveParentClass()
    {
        return 'show text-primary';
    }

    public static function getChildIconClass()
    {
        return 'ni ni-pin-3 text-orange';
    }

    public static function toHome()
    {
        return new self('Home', ['type' => 'laravel', 'link' => 'home']);
    }


    public static function getPartName($partName)
    {
        $p = partToCollection($partName)->map(function ($partItem) {
            return Str::singular($partItem);
        })->implode(' ');

        $pluralized = [];

        $p = trim(str_replace(['admin', 'index'], '', strtolower($p)));
        if (Str::contains($p, $pluralized)) {
            $p = Str::plural($p);
        }

        return Str::title($p);
    }
}
