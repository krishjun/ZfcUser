<?php

namespace ZfcUser\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;
use ZfcUser\Entity\UserInterface as UserEntityInterface;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Where;

class User extends AbstractDbMapper implements UserInterface
{
    protected $tableName  = 'user';

    public function findByEmail($email)
    {
        $select = $this->getSelect()
                       ->where(array('email' => $email));

        $entity = $this->select($select)->current();
        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));
        return $entity;
    }

    public function findByUsername($username)
    {
        $select = $this->getSelect()
                       ->where(array('username' => $username));

        $entity = $this->select($select)->current();
        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));
        return $entity;
    }

    public function findById($id)
    {
        $select = $this->getSelect()
                       ->where(array('user_id' => $id));

        $entity = $this->select($select)->current();
        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));
        return $entity;
    }

    public function getTableName(){
        return $this->tableName;
    }
    
    public function setTableName($tableName){
        $this->tableName=$tableName;
    }    
    
    public function insert($entity, $tableName = null, HydratorInterface $hydrator = null)
    {
        $result = parent::insert($entity, $tableName, $hydrator);
        $entity->setId($result->getGeneratedValue());
        return $result;
    }

    public function update($entity, $where = null, $tableName = null, HydratorInterface $hydrator = null)
    {
        if (!$where) {
            $where = 'user_id = ' . $entity->getId();
        }

        return parent::update($entity, $where, $tableName, $hydrator);
    }
    
    public function delete($entity, $where = null, $tableName = null, HydratorInterface $hydrator = null)
    {
        if (!$where) {
            $where = 'user_id = ' . $entity->getId();
        }
    
        return parent::delete($where,$tableName);
    }
    
    
    public function getSelectAll() {
    
        $tb = new TableGateway($this->getTableName(), $this->getDbAdapter());
        $select = $tb->getSql()->select();
       // $select->join('brands','brands.brand_id = products.brand_id',array('brand_name'=>'name'));
        return $select;
    }
    

    
    public function getPaginator($hydrator,$role,$search) {
    
        $select = $this->getSelectAll();
        
        if($role && $role != 'all') {
            $select->where(array('role_id'=>$role));
        }
        
        if($search) {
            $spec = function (Where $where) use($search) {
                $where->like('username', "$search%");
            };
            
            $select->where($spec);
        }
        
        
        
        $adapter = new DbSelect($select, $this->getDbAdapter(),new HydratingResultSet(new UserHydrator(),$this->getEntityPrototype()));
        $paginator = new Paginator($adapter);
    
        return $paginator;
    
    }
    
}
