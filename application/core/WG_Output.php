<?php

class WG_Output extends CI_Output
{
    
    private $_layoutScripts;
    private $_layoutStyles;
    private $_layoutView;
    private $_isCalledLayout = false;
    
    
    public function render($view, $vars = array())
    {
        extract((array) $vars);
        
        ob_start();
        
        include $this->_view($view);
        
        $this->final_output = ob_get_clean();
        
        
        $CI =& get_instance();
        
        $layout = isset($CI->layout) ? $CI->layout : 'layout';
        
        unset($CI);
        
        include $this->_layoutFile($layout);
        
        $this->_isCalledLayout = true;
    }
    
    /**
        * Sobrecarga do método Output::_display().
        * Se esse WG_Output::render() já foi invocado, Output::_display() não retorna a view
        * @return (void|string)
    */
    public function _display()
    {
        if ($this->_isCalledLayout == false) {
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
            throw new Exception('As opções para o método ' . __METHOD__ . 'são "scripts", "styles" e "content"');
        }
    }
    
    private function _layoutFile($layout)
    {
        return FCPATH . APPPATH . "/views/layouts/{$layout}.php";
    }
    
    private function _view($view)
    {
        return FCPATH . APPPATH . "/views/$view.php";
    }
    
    public function script(array $scripts, $inline = true)
    {
        $base = base_url();
        
        foreach ($scripts as &$js) {
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
        
        foreach ($styles as &$css) {
            $css = "<link rel='stylesheet' href='{$base}static/css/{$css}.css' />\n";
        }
        
        if (!$inline) {
            $this->_layoutStyles .= implode('', $styles);
        } else {
            return implode('', $styles);
        }
    }
    
    
}
    