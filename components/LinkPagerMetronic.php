<?php

namespace webvimark\modules\UserManagement\components;

use yii\widgets\LinkPager;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


class LinkPagerMetronic extends LinkPager
{

    public $options = ['class' => 'kt-datatable__pager-nav'];

    /**
     * @var bool If we must render the linkpager inside metroni div>dataTable container.
     * If this property is false, no div is rendered.
     */
    public $dataTableContainer =false;

    /**
     * @var string|bool the label for the "next" page button. Note that this will NOT be HTML-encoded.
     * If this property is false, the "next" page button will not be displayed.
     */
    public $nextPageLabel = '<i class="flaticon2-next"></i>';
    /**
     * @var string|bool the text label for the previous page button. Note that this will NOT be HTML-encoded.
     * If this property is false, the "previous" page button will not be displayed.
     */
    public $prevPageLabel = '<i class="flaticon2-back"></i>';


    /**
     * @var string|bool the text label for the "first" page button. Note that this will NOT be HTML-encoded.
     * If it's specified as true, page number will be used as label.
     * Default is false that means the "first" page button will not be displayed.
     */
    public $firstPageLabel = '<i class="flaticon2-fast-back"></i>';
    /**
     * @var string|bool the text label for the "last" page button. Note that this will NOT be HTML-encoded.
     * If it's specified as true, page number will be used as label.
     * Default is false that means the "last" page button will not be displayed.
     */
    public $lastPageLabel = '<i class="flaticon2-fast-next"></i>';


    public $pageCssClass='kt-datatable__pager-link';
    /**
     * @var string the CSS class for the "first" page button.
     */
    public $firstPageCssClass = 'kt-datatable__pager-link--first';
    /**
     * @var string the CSS class for the "last" page button.
     */
    public $lastPageCssClass = 'kt-datatable__pager-link--last';
    /**
     * @var string the CSS class for the "previous" page button.
     */
    public $prevPageCssClass = 'kt-datatable__pager-link--previous';
    /**
     * @var string the CSS class for the "next" page button.
     */
    public $nextPageCssClass = 'kt-datatable__pager-link--next';
    /**
     * @var string the CSS class for the active (currently selected) page button.
     */
    public $activePageCssClass = 'kt-datatable__pager-link--active';
    /**
     * @var string the CSS class for the disabled page buttons.
     */
    public $disabledPageCssClass = 'kt-datatable__pager-link--disabled';




    /**
     * Executes the widget.
     * This overrides the parent implementation by displaying the generated page buttons.
     */
    public function run()
    {
        if ($this->registerLinkTags) {
            $this->registerLinkTags();
        }
        $buttons =  $this->renderPageButtons();
        $linkPager = Html::tag('div',$buttons,['class'=>'kt-datatable__pager kt-datatable--paging-loaded']);
        if($this->dataTableContainer) {
            $linkPager = Html::tag('div',$linkPager,['class'=>'dataTables_pager']);
        }
        echo $linkPager;
    }

    protected function renderPageButton($label, $page, $class, $disabled, $active)
    {
        $options = $this->linkContainerOptions;
        $linkOptions = $this->linkOptions;
        $linkOptions['data-page'] = $page;
        $linkWrapTag = ArrayHelper::remove($options, 'tag', 'li');
        Html::addCssClass($linkOptions, empty($class) ? $this->pageCssClass : $class);

        if ($active) {
            Html::addCssClass($linkOptions, $this->activePageCssClass);
        }
        if ($disabled) {
            Html::addCssClass($linkOptions, $this->disabledPageCssClass);
            $tag = ArrayHelper::remove($this->disabledListItemSubTagOptions, 'tag', 'a');

            return Html::tag($linkWrapTag, Html::tag($tag, $label, $linkOptions), $options);
        }

        return Html::tag($linkWrapTag, Html::a($label, $this->pagination->createUrl($page), $linkOptions), $options);
    }

}