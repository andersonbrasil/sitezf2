<?php
namespace Site\Model;

 use Zend\Db\TableGateway\TableGateway;

 class SiteTable
 {
     protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

     public function fetchAll()
     {
         $resultSet = $this->tableGateway->select();
         return $resultSet;
     }

     public function getSite($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }

     public function saveSite(Site $site)
     {
         $data = array(
             'artist' => $site->artist,
             'title'  => $site->title,
         );

         $id = (int) $site->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getSite($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Site id does not exist');
             }
         }
     }

     public function deleteSite($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }
