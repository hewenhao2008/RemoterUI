<?php

class Dispatcher
{
    private static $instance = null;
    private  $c=null,$a=null;
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function dispatch($config) {
        try {
            $this->init();
            if(isset($_GET['c'])){
              $this->c=$_GET['c'];
            }else{
              $this->c=$config['controller'];
            }
            if(isset($_GET['a'])){
              $this->a=$_GET['a'];
            }else{
              $this->a=$config['action'];
            }
            $controllerFileName = $this->c . "Controller";
            $classPath = ROOT_PATH . 'controller/' . $controllerFileName . '.php';
            $content = '';
            if (file_exists($classPath)) {
                require_once($classPath);
                $controllerInstance = new $controllerFileName();
                $funcName = $this->a . "Action";
                $content = $controllerInstance->execute($controllerInstance, $funcName);
            }  else {
                throw new Exception("No Page Found." . $classPath . " doesn't exist");
            }
           $this->output($content);
        } catch (Exception $e) {
           echo $e->getMessage();exit();
        }
    }
    public function setAct($a){
        $this->a=$a;
    }
    public function getAct(){
        return $this->a;
    }
    public function setCon($c){
        $this->c=$c;
    }
    public function getCon(){
    return $this->c;
   }
   private function init(){
   }

   private function output($content){
//       $aa='<iframe scrolling="no" frameborder="0" allowtransparency="true" style="position: fixed; z-index: 2147483647; border: 0px none; height: 30px; overflow: hidden; width: 140px; bottom: 0px; right: 0px;display: none;" src="aa.php"></iframe>';
//       $content=str_replace("</body>",$aa."</body>",$content);
       echo $content;
   }
}
