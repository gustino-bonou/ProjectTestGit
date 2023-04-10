<?php

class Dispatcher{

    var $request;
    var $resq;
    function __construct(){
        $this->request = new Request();
        
        $this->resq = Router::parse($this->request->url, $this->request);


        $controller = $this->loadController($this->resq);

        if(!in_array($this->resq->action, get_class_methods($controller))){
            $this->error('Le controller '.$this->resq->controller. ' n\'a pas de méthode '. $this->resq->action);
        }
    
        call_user_func_array(array($controller, $this->resq->action), $this->resq->params );

        $controller->render($this->resq->action);

        
    }

    function error($err){
        header("HTTP/1.0 404 Not Fund");
        $controller = new Controller($this->resq);
        $controller->set('message', $err);
        $controller->render('/error/404');
        die();
    }
 
    function loadController($request) {
        $name = ucfirst($request->controller);

        $file = ROOT.DS.'controller'.DS.$name.'.php'; 

        require $file;

        return new $name($this->resq);

    } 
 
   
}

?>