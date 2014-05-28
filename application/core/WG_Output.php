<?php
    
    /** 
        * Output alterado para o Codeigniter
        * @author Wallacemaxters
        * @version 1.0
        * @copyright Wallace de Souza Vizerra
    */

    class WG_Output extends CI_Output {
    
        private $_layoutScripts;
        private $_layoutStyles;
        private $_layoutView;
        private $_isCalledLayout = false;



        /**
            * Renderiza a view juntamente com o layout
            * @param (string) $view = o endereço da view dentro da pasta "views"
            * @param (array|object) $vars = a variável que vai ser extraída para a view
        */


        public function render($view, $vars = array())
        {
            $CI =& get_instance();

            if (isset($CI->viewVars))
                $vars = array_merge((array) $vars, (array) $CI->viewVars);


            if(is_array($vars)) extract($vars);

            ob_start();
            
            include $this->_view($view);

            $this->final_output = ob_get_clean();

            $layout = isset($CI->layout) ? $CI->layout : 'layout';

            unset($CI);

            include $this->_layoutFile($layout);
            
            $this->_isCalledLayout = true;
        }

        public function _display()
        {
            // Se foi chamado o layout, renderiza a view normalmente //
            if($this->_isCalledLayout == false) {
                parent::_display();
            }
        }


        public function fetch($option = '')
        {
            if ($option == 'scripts') {
                return $this->_layoutScripts;
            } elseif ($option == 'styles') {
                return $this->_layoutStyles;
            } elseif ($option == 'content') {
                return $this->final_output;
            } else {
                throw new Exception('Opção deve ser "styles", "content" ou "scripts"');
            }
        }
        
        private function _layoutFile($layout)
        {

            $DS = DIRECTORY_SEPARATOR;
            $filename = FCPATH . APPPATH . "{$DS}views{$DS}layouts{$DS}{$layout}.php";

            if (file_exists($filename)) {
                return $filename;
            } else {
                throw new Exception("O layout '{$filename}' não existe");
            }
        }
        
        private function _view($view)
        {
            $DS = DIRECTORY_SEPARATOR;
            $filename = FCPATH . APPPATH . "{$DS}views{$DS}$view.php";

            if (file_exists($filename)) {
                return $filename;
            } else {
                throw new Exception("O layout '{$filename}' não existe");
            }
        }
        
        public function script(array $scripts, $inline = true)
        { 

            $base = base_url();

            foreach($scripts as &$js) {
                $js = "<script type='text/javascript' src='{$base}static/js/{$js}.js'></script>\n";
            }

            if (!$inline) {
                $this->_layoutScripts .= implode('', $scripts);
            } else {
                return implode('', $scripts);
            }
            
        }

        public function style(array $styles, $inline = true)
        { 
            $base = base_url();

            foreach($styles as &$css) {
                $css = "<link rel='stylesheet' type='text/css' href='{$base}static/css/{$css}.css' />\n";
            }
            
            if (!$inline) {
                $this->_layoutStyles .= implode('', $styles);
            } else {
                return implode('', $styles);
            }
        }


        public function element($element, $vars = array())
        {
            ob_start();

            if(is_array($vars) || is_object($vars)) {
                extract((array) $vars);
            } else {
                throw new Exception('O segundo argumento deve ser um objeto stdClass ou um array.');
            }


            $DS = DIRECTORY_SEPARATOR;
            $filename = FCPATH . APPPATH . "{$DS}element{$DS}{$element}.php";

            if(file_exists($filename)) {
                include_once $filename;
                return ob_get_clean();
            } else {
                throw new Exception("Não existe o arquivo {$filename} .");
            }
        }   
    
    }
         
