<?php
namespace webvimark\modules\UserManagement\components;

use webvimark\modules\UserManagement\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Menu;

/**
 * Class GhostNav
 *
 * Show only those items in navigation menu which user can see
 * If item has no "visible" key, than "visible"=>User::canRoute($item['url') will be added
 *
 * @package webvimark\modules\UserManagement\components
 */
class GhostMenu extends Menu
{
    public $encodeLabels=false;
    public $activateParents=true;
    public $options=['class'=>'kt-menu__nav'];
    public $openedCssClass='kt-menu__item--open kt-menu__item--here';
    public $activeCssClass='kt-menu__item--active';
    public $linkTemplate='<a href="{url}" class="kt-menu__link"><span class="kt-menu__link-text">{label}</span></a>';
    public $labelTemplate='<a href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">{label}</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>';
    public $submenuTemplate='<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left"><ul class="kt-menu__subnav">{items}</ul></div>';
    public $itemOptions=[
        'class'=>['kt-menu__item kt-menu__item--submenu kt-menu__item--rel'],
        'data'=>['ktmenu-submenu-toggle'=>'click'],
    ];

    public function init()
	{
		parent::init();

		$this->ensureVisibility($this->items);
	}

	/**
	 * @param array $items
	 *
	 * @return bool
	 */
	protected function ensureVisibility(&$items)
	{
		$allVisible = false;

		foreach ($items as &$item)
		{
			if ( isset( $item['url'] ) AND !in_array($item['url'], ['', '#']) AND !isset( $item['visible'] ) )
			{
				$item['visible'] = User::canRoute($item['url']);
			}

			if ( isset( $item['items'] ) )
			{
				// If not children are visible - make invisible this node
				if ( !$this->ensureVisibility($item['items']) AND !isset( $item['visible'] ) )
				{
					$item['visible'] = false;
				}
			}

			if ( isset( $item['label'] ) AND ( !isset( $item['visible'] ) OR $item['visible'] === true ) )
			{
				$allVisible = true;
			}
		}

		return $allVisible;
	}

    /**
     * Recursively renders the menu items (without the container tag).
     * @param array $items the menu items to be rendered recursively
     * @return string the rendering result
     */
    protected function renderItems($items)
    {
        $n = count($items);
        $lines = [];
        foreach ($items as $i => $item) {
            $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
            $tag = ArrayHelper::remove($options, 'tag', 'li');
            $class = [];
            if ($item['active']) {
                if (!empty($item['items'])) {
                    $class[] = $this->openedCssClass;
                }else {
                    $class[] = $this->activeCssClass;
                }
            }
            if ($i === 0 && $this->firstItemCssClass !== null) {
                $class[] = $this->firstItemCssClass;
            }
            if ($i === $n - 1 && $this->lastItemCssClass !== null) {
                $class[] = $this->lastItemCssClass;
            }
            Html::addCssClass($options, $class);

            $menu = $this->renderItem($item);
            if (!empty($item['items'])) {
                $submenuTemplate = ArrayHelper::getValue($item, 'submenuTemplate', $this->submenuTemplate);
                $menu .= strtr($submenuTemplate, [
                    '{items}' => $this->renderItems($item['items']),
                ]);
            }
            $lines[] = Html::tag($tag, $menu, $options);
        }

        return implode("\n", $lines);
    }
} 