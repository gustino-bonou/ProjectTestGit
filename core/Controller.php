<?php

class Controller   {

    public $request;
    private $vars= array();

    public $layout = 'default';

    private $rendered = false;

    function __construct($request) {
        $this->request = $request;
    }

    /* 
    *Permet de  rendre une vue
    *@param ^view Fichier à rendre (chemin dpuis view ou nom de la vue)
    */
    public function render($view) {
        if($this->rendered){ return false; }
        extract($this->vars);
        if(strpos($view, '/') === 0){

            $view = ROOT.DS.'views'.$view.'.php';

        }else{
            $view = ROOT.DS.'views'.DS.$this->request->controller.DS.$view.'.php';

        }
        
        ob_start();
        require($view);
        $content_for_layout = ob_get_clean();

        require ROOT.DS.'views'.DS.'layout'.DS.$this->layout.'.php';


        $this->rendered = true;
    
    }

    /* 
    *Permet de passer une ou plusieurs variables à la vue
    *@param key nom de la varaible ou tableau de variables 
    @parm $value Vlauer de la variable
    */

    public function set($key, $value=null){
        if(is_array($key)){
            $this->vars += $key;
        }else{
            $this->vars[$key] = $value;
        }
        
    }

    /* 
    *permet de charger un model
     */

     function loadModel($name){
        $file = ROOT.DS.'model'.DS.$name.'.php'; 
        require_once($file);
        if(!isset($this->$name)){
            $this->$name = new $name();
        }else{
            echo "pas cgargé";
        }

        return $this->$name;
     }

}