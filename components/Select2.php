<?php

    namespace webvimark\modules\UserManagement\components;

    use Yii;
    use yii\helpers\Html;
    use yii\helpers\Json;
    use yii\web\View;


    class Select2 extends \kartik\select2\Select2
    {
        protected function renderInput()
        {
            if ($this->pluginLoading) {
                $this->_loadIndicator = '<div class="kv-plugin-loading loading-' . $this->options['id'] . '">&nbsp;</div>';
                Html::addCssStyle($this->options, 'display:none');
            }
            Html::addCssClass($this->options, 'kt-select2');
            $input = $this->getInput('dropDownList', true);
            echo $this->_loadIndicator . $this->embedAddon($input);
        }

        /**
         * Registers the client assets for [[Select2]] widget.
         */
        public function registerAssets()
        {
            $id = $this->options['id'];
            $this->registerAssetBundle();
            $isMultiple = isset($this->options['multiple']) && $this->options['multiple'];
            $options = Json::encode([
            /*    'themeCss' => ".select2-container--{$this->theme}",*/
            /*    'sizeCss' => empty($this->addon) && $this->size !== self::MEDIUM ? ' input-' . $this->size : '',*/
                'doReset' => static::parseBool($this->changeOnReset),
                'doToggle' => static::parseBool($isMultiple && $this->showToggleAll),
                'doOrder' => static::parseBool($isMultiple && $this->maintainOrder),
            ]);
            $pluginOption=$this->pluginOptions;
            $pluginOption['placeholder']=$this->options['prompt'];
            unset($pluginOption['theme']);
            $pluginOption=Json::encode($pluginOption);

            $this->_s2OptionsVar = 's2options_' . hash('crc32', $options);
            $this->options['data-s2-options'] = $this->_s2OptionsVar;

            $view = $this->getView();
            $view->registerJs("var {$this->_s2OptionsVar} = {$options};", View::POS_HEAD);
            if ($this->maintainOrder) {
                $val = Json::encode(is_array($this->value) ? $this->value : [$this->value]);
                $view->registerJs("initS2Order('{$id}',{$val});");
            }
            $this->registerPlugin($this->pluginName, "jQuery('#{$id}')", "initS2Loading('{$id}','{$this->_s2OptionsVar}')");
            $view->registerJs("jQuery('#{$id}').select2({$pluginOption})");

        }

    }
