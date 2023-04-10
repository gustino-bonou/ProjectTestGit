<?php 
class Model{

    static $connection = array();
    public $conf = 'default';
    public $table = false;

    public $db;
    public  function __construct() {

        //je me connecte à la base

        
        $conf  = Conf::$database[$this->conf];

        if(!isset(Model::$connection[$this->conf])){
            try {
                $pdo = new PDO(
                    'mysql:host='.$conf['host'].';
            dbname='.$conf['database'].';
            ', $conf['login'], 
            $conf['password'],
            array((PDO::MYSQL_ATTR_COMPRESS)=>'SET NAMES utf8')
        );
    
            Model::$connection[$this->conf] = $pdo;    
            
            $this->db = $pdo;
            
            }catch(PDOException $e){
                if(Conf::$debug >=   1){
                    die($e->getMessage());
                }else{
                    die("Impossible de se connecter à la base de données");
                }
                
            }
            //j'initialise quesques variables

            if($this->table === false){
                $this->table = strtolower(get_class($this));
            }
            
        }else {
            $this->db = Model::$connection[$this->conf];
        }

    }
        
    
    public function find($request){

        $sql = 'SELECT * FROM '.$this->table;
        if(isset($request['condition'])){
        $sql .= ' WHERE '. $request['condition'];
        }

 
        $pre = $this->db->prepare($sql);
        $pre->execute();
        return $pre->fetchAll(PDO::FETCH_OBJ);
    }

    public function findFirst($request){
        return current($this->find($request));
    }
    
    
}

    
    

?>