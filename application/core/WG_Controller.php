<?php

class WG_Controller extends CI_Controller
{
    /**
        * Grupo $key tem autorização para acessar os controller [$value1, $value2]
    */
    public $autorized = [
        1 => ['home', 'excelparser', 'upload'],
        2 => ['adm', 'excelparser', 'upload'],
        3 => ['adm_izabela', 'excelparser']
    ];

    /**
        * Aqui são definidos os métodos que se pode acessar por qualquer usuário
        *@var array
    */
    public $allowedActions = [];

    /**
        * Aqui é mostrado para o framework onde é a ação do login
        *@var array
    */

    public $loginAction = ['controller' => 'home', 'method' => 'login'];

    public function __construct()
    {
        parent::__construct();
        $this->viewVars['user'] = (object) $this->session->all_userdata();
    }

    /**
        * Verifica se é autorizado
        * @param int $role_id = nível do usuário
    */
    protected function _isAutorized($role_id)
    {
        if (!isset($this->autorized[$role_id])) {
            return false;
        } else {
            $autorizedControllers = $this->autorized[$role_id];
            return in_array($this->_name(), $autorizedControllers, true);
        }
    }


    /**
        * Retorna o nome do Controller pedido pela URL
        * @return string
    */

    protected function _name()
    {
        return strtolower(get_class($this));
    }

    /**
        * Retorna a string da localização da ação de login
    */

    protected function _loginAction()
    {
        $action = $this->loginAction;

        $controller = array_shift($action);
        $method = !empty($action) ? array_shift($action) : 'login';

        return $controller . '/' . $method;
    }

    /**
        * A página atual é a página de login ?
        * @param string $method = O método atual passado como parâmetro em WG_Controller::beforeAction()
    */
    protected function _isLoginPage($method = '')
    {
        $currentAction = $this->_name() . '/' . $method;

        return $this->_loginAction() == $currentAction;
    }

    /**
        * Faz a verificação pra ver se o método é aceitável no controller atual
        * As definições são declaradas em Controller::$allowedActions
        *@param string $method
    */

    protected function _isAllowedMethod($method)
    {
        return in_array($method, $this->allowedActions, true);
    }

    /**
        * Retorna o local autorizado para o usuário, caso o mesmo saia fora da rota
        * @param int $role_id
    */

    protected function _autorizedLocation($role_id)
    {
        if (isset($this->autorized[$role_id])) {
            $location = current($this->autorized[$role_id]);

            redirect("/$location");
            exit;
        } else {
            redirect($this->_loginAction());
        }
    }

    public function beforeAction($method = '')
    {
        $role_id = $this->session->userdata('tbl_niveis_cod_nivel');

        $isLoginPage = $this->_isLoginPage($method);
        $isAllowedMethod = $this->_isAllowedMethod($method);
        $isAutorized = $this->_isAutorized($role_id);

        // Se não estiver logadd e for a página de login, ou é um método permitido //
        if(!$role_id && $isLoginPage or $isAllowedMethod) {
            return true;
        }

        if (!$isAutorized) {
            redirect($this->_autorizedLocation($role_id));
            exit;
        }
    }
}