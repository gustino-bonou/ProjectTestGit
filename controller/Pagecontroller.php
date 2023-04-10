<?php

class PageController   extends Controller{

    private $model ;

    function view($id){
      $this->model =  $this->loadModel('Post');

       $post = $this->model->findFirst(array(
        'condition' => 'id='.$id
       ));

       if(empty($post)){
        die('error');
       }

       $this->set('post', $post);


    }
    
}