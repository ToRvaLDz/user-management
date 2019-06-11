<?php

namespace webvimark\modules\UserManagement\components;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class GridView extends \kartik\grid\GridView
{

    const FILTER_SELECT2 =Select2::class;

    public $responsive=true;
    public $perfectScrollbar=true;
    public $hover=true;
    public $condensed=false;
    public $floatHeader=false;
    public $bordered=true;
    public $striped=false;
    public $persistResize=false;
    public $pjax=true;
    public $tableOptions= ['class'=>'kt-datatable__table'];
    public $headerRowOptions=['class'=>'kt-datatable__row'];
    public $rowOptions=['class'=>'kt-datatable__row'];
    public $summaryOptions=['tag'=>'small','class'=>''];

    public $toolbar=[];
    public $showExport=false;

    public $showReset=true;
    public $resetRight=true;

    public $pager= ['class'=> LinkPagerMetronic::class];

    public $headTools='';

    public $resetUrl='?';

    public $panelFooterTemplate=<<<HTML
        {footer}
        <div class="clearfix"></div>
HTML;

    private $exportTemplate=<<<HTML
        <li class="kt-portlet__nav-item">{export}</li>
HTML;

    public $panelHeadingTemplate=<<<HTML
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="{headIcon}"></i>
            </span>
            <h3 class="kt-portlet__head-title kt-font-primary">
                {headTitle}{summary}  
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-group">
                {resetButton}
                {headTools}
            </div>
        </div>
    </div>
HTML;

    public $panelTemplate=<<<HTML
        <div class="kt-portlet kt-portlet--{type} kt-portlet--full-height">
            {panelHeading}
            <div class="kt-portlet__body m--padding-top-10">
                {panelBefore}
                {items}
                {panelFooter}
                {panelAfter}
             </div>
        </div>
HTML;

    public $resetButton=<<<'HTML'
        <a href="{resetUrl}" data-ktportlet-tool="reload" class="btn btn-sm btn-icon btn-{panelType} btn-icon-md" data-toggle="kt-tooltip" data-placement="left" title="Reset filtri"><i class="la la-refresh"></i></a>
HTML;

    public $panelBeforeTemplate=<<<'HTML'
        {pager}
        {toolbarContainer}
        {before}
        <div class="clearfix kt-padding-b-10"></div>
HTML;

    public $panelAfterTemplate=<<<'HTML'
        {pager}
        <div class="btn-toolbar kv-grid-toolbar toolbar-container pull-right">
        </div>
        <div class="clearfix"></div>        
        {after}
HTML;

    protected function initPanel()
    {
        if (!$this->bootstrap || !is_array($this->panel) || empty($this->panel)) {
            return;
        }
        $options = ArrayHelper::getValue($this->panel, 'options', []);
        $type = ArrayHelper::getValue($this->panel, 'type', 'default');
        $heading = ArrayHelper::getValue($this->panel, 'heading', '');
        $footer = ArrayHelper::getValue($this->panel, 'footer', '');
        $before = ArrayHelper::getValue($this->panel, 'before', '');
        $after = ArrayHelper::getValue($this->panel, 'after', '');
        $headingOptions = ArrayHelper::getValue($this->panel, 'headingOptions', []);
        $titleOptions = ArrayHelper::getValue($this->panel, 'titleOptions', []);
        $footerOptions = ArrayHelper::getValue($this->panel, 'footerOptions', []);
        $beforeOptions = ArrayHelper::getValue($this->panel, 'beforeOptions', []);
        $afterOptions = ArrayHelper::getValue($this->panel, 'afterOptions', []);
        $summaryOptions = ArrayHelper::getValue($this->panel, 'summaryOptions', []);
        $panelHeading = '';
        $panelBefore = '';
        $panelAfter = '';
        $panelFooter = '';
        $this->panelPrefix=false;
        $isBs4 = $this->isBs4();
        if (isset($this->panelPrefix)) {
            static::initCss($options, $this->panelPrefix . $type);
        } else {
            $this->addCssClass($options, self::BS_PANEL);
            Html::addCssClass($options, $isBs4 ? "border-{$type}" : "panel-{$type}");
        }

        static::initCss($titleOptions, $isBs4 ? 'kt-0' : $this->getCssClass(self::BS_PANEL_TITLE));
        if ($heading !== false) {
            $color = $isBs4 ? ($type === 'default' ? ' bg-light' : " text-white bg-{$type}") : '';
            static::initCss($headingOptions, $this->getCssClass(self::BS_PANEL_HEADING) . $color);
            $panelHeading =$this->panelHeadingTemplate;
        }
        if ($footer !== false) {
            static::initCss($footerOptions, $this->getCssClass(self::BS_PANEL_FOOTER));
            $content = strtr($this->panelFooterTemplate, ['{footer}' => $footer]);
            $panelFooter = Html::tag('div', $content, $footerOptions);
        }
        if ($before !== false) {
            static::initCss($beforeOptions, 'kv-panel-before kt-datatable kt-datatable--default kt-datatable--loaded');
            $content = strtr($this->panelBeforeTemplate, ['{before}' => $before]);
            $panelBefore = Html::tag('div', $content, $beforeOptions);
        }
        if ($after !== false) {
            static::initCss($afterOptions, 'kv-panel-after kt-datatable kt-datatable--default kt-datatable--loaded');
            $content = strtr($this->panelAfterTemplate, ['{after}' => $after]);
            $panelAfter = Html::tag('div', $content, $afterOptions);
        }

         $out= strtr($this->panelTemplate, [
            '{panelHeading}' => $panelHeading,
            '{type}' => $type,
            '{panelFooter}' => $panelFooter,
            '{panelBefore}' => $panelBefore,
            '{panelAfter}' => $panelAfter,
        ]);

        $this->resetButton=strtr($this->resetButton,
            [
                '{panelType}' => ArrayHelper::getValue($this->panel, 'type', 'brand'),
                '{resetUrl}'=>$this->resetUrl,
            ]);
        $this->layout = Html::tag('div', strtr($out, [
            '{resetButton}'=>$this->showReset ? $this->resetButton : '',
/*            '{title}' => Html::tag($titleTag, $heading, $titleOptions),*/
            '{summary}' => Html::tag('small', '{summary}'),
            '{panelType}' => ArrayHelper::getValue($this->panel, 'type', 'brand'),
            '{headIcon}' =>  ArrayHelper::getValue($this->panel, 'icon', ''),
            '{headTitle}'=>Html::encode(ArrayHelper::getValue($this->panel, 'headTitle', 'Elenco')),
            '{headTools}'=>ArrayHelper::getValue($this->panel, 'headTools', ''),

        ]), $options);


    }

   /* protected function initExport()
    {
        parent::initExport();
        $cssStyles = [
            '.kv-group-even' => ['background-color' => '#f0f1ff'],
            '.kv-group-odd' => ['background-color' => '#f9fcff'],
            '.kv-grouped-row' => ['background-color' => '#fff0f5', 'font-size' => '1.3em', 'padding' => '10px'],
            '.kv-table-caption' => [
                'border' => '1px solid #ddd',
                'border-bottom' => 'none',
                'font-size' => '1.5em',
                'padding' => '8px',
            ],
            '.kv-table-footer' => ['border-top' => '40px double #ddd', 'font-weight' => 'bold'],
            '.kv-page-summary td' => [
                'background-color' => '#ffeeba',
                'border-top' => '4px double #ddd',
                'font-weight' => 'bold',
            ],
            '.kv-align-center' => ['text-align' => 'center'],
            '.kv-align-left' => ['text-align' => 'left'],
            '.kv-align-right' => ['text-align' => 'right'],
            '.kv-align-top' => ['vertical-align' => 'top'],
            '.kv-align-bottom' => ['vertical-align' => 'bottom'],
            '.kv-align-middle' => ['vertical-align' => 'middle'],
            '.kv-editable-link' => [
                'color' => '#428bca',
                'text-decoration' => 'none',
                'background' => 'none',
                'border' => 'none',
                'border-bottom' => '1px dashed',
                'margin' => '0',
                'padding' => '2px 1px',
            ],
        ];

        $pdfHeader = [
            'L' => [
                'content' => yii::$app->id,
                'font-size' => 8,
                'font-style' => 'B',
                'color' => '#999999',
            ],
            'C' => [
                'content' => ArrayHelper::getValue($this->panel,'headTitle',''),
                'font-size' => 10,
                'font-style' => 'B',
                'font-family' => 'arial',
                'color' => '#333333'
            ],
            'R' => [
                'content' => yii::$app->formatter->asDate(time()),
                 'font-size' => 8,
                 'font-style' => 'B',
                 'color' => '#999999'
            ],
            'line' => true,
        ];

        $pdfFooter = [
            'L' => [
                'content' => yii::$app->id,
                'font-size' => 8,
                'font-style' => 'B',
                'color' => '#999999',
            ],
            'C' => [
                'content' => ArrayHelper::getValue($this->panel,'headTitle',''),
                'font-size' => 10,
                'font-style' => 'B',
                'font-family' => 'arial',
                'color' => '#333333'
            ],
            'R' => [
                'content' => '[ {PAGENO} ]',
                'font-size' => 8,
                'font-style' => 'B',
                'color' => '#999999'
            ],
            'line' => true,
        ];

        $newexportConfig=[
            GridView::EXCEL=>[],
            GridView::CSV=>[],
            GridView::PDF => [
                'cssStyles' => $cssStyles,
                'config' => [
                    'methods' => [
                        'SetHeader' => [
                            ['odd' => $pdfHeader, 'even' => $pdfHeader]
                        ],
                        'SetFooter' => [
                            ['odd' => $pdfFooter, 'even' => $pdfFooter]
                        ],
                    ],
                    'options' => [
                        'title' => yii::$app->id,
                        'subject' => ArrayHelper::getValue($this->panel,'headTitle',''),
                        'keywords' => ''
                    ],
                ]
            ],
        ];

        $this->exportConfig = self::parseExportConfig($newexportConfig,$this->exportConfig);



    }*/

    public function init() {
        parent::init();
        $isBs4 = $this->isBs4();
        if ($isBs4) {
           $this->pager['linkContainerOptions']=['class'=>''];
           $this->pager['linkOptions']=['class'=>'kt-datatable__pager-link'];
           $this->pager['disabledListItemSubTagOptions']=['class'=>'kt-datatable__pager-link'];
        }

        $this->pjaxSettings=[
            'neverTimeout'=>true,
            'options'=>[
                'id'=>$this->id . '-pjax',
            ]
        ];

        $this->export=[
            'showConfirmAlert'=>false,
            'target'=>GridView::TARGET_BLANK
        ];

        $this->panelHeadingTemplate=strtr($this->panelHeadingTemplate,['{export}'=>$this->showExport ? $this->exportTemplate : '']);
    }

}
