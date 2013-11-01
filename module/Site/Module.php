<?php
namespace Site;
 use Site\Model\Site;
 use Site\Model\SiteTable;
 use Zend\Db\ResultSet\ResultSet;
 use Zend\Db\TableGateway\TableGateway;


class Module
{
    public function getAutoloaderConfig()
     {
         return array(
             'Zend\Loader\ClassMapAutoloader' => array(
                 __DIR__ . '/autoload_classmap.php',
             ),
             'Zend\Loader\StandardAutoloader' => array(
                 'namespaces' => array(
                     __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                 ),
             ),
         );
     }

     public function getConfig()
     {
         return include __DIR__ . '/config/module.config.php';
     }
     
     public function getServiceConfig()
     {
         return array(
             'factories' => array(
                 'Site\Model\SiteTable' =>  function($sm) {
                     $tableGateway = $sm->get('SiteTableGateway');
                     $table = new SiteTable($tableGateway);
                     return $table;
                 },
                 'SiteTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Site());
                     return new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }

}
