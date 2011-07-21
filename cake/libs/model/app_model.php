<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Application model for Cake.
 *
 * This is a placeholder class.
 * Create the same file in app/app_model.php
 * Add your application-wide methods to the class, your models will inherit them.
 *
 * @package       cake
 * @subpackage    cake.cake.libs.model
 */
class AppModel extends Model {
	  
    /** 
     * Adds a join record between two records of a hasAndBelongsToMany association 
     * 
     * @param mixed $assoc The name of the HABTM association 
     * @param mixed $assoc_ids The associated id or an array of associated ids 
     * @param integer $id The id of the record in this model 
     * @return boolean Success 
     */ 
    function addAssoc($assoc, $assoc_ids, $id = null) 
    { 
        if ($id != null) { 
            $this->id = $id; 
        } 

        $id = $this->id; 

        if (is_array($this->id)) { 
            $id = $this->id[0]; 
        } 
         
        if ($this->id !== null && $this->id !== false) { 
            $db =& ConnectionManager::getDataSource($this->useDbConfig); 
             
            $joinTable = $this->hasAndBelongsToMany[$assoc]['joinTable']; 
            $table = $db->name($db->fullTableName($joinTable)); 
             
            $keys[] = $this->hasAndBelongsToMany[$assoc]['foreignKey']; 
            $keys[] = $this->hasAndBelongsToMany[$assoc]['associationForeignKey']; 
            $fields = join(',', $keys); 
             
            if(!is_array($assoc_ids)) { 
                $assoc_ids = array($assoc_ids); 
            } 
         
            // to prevent duplicates 
            $this->deleteAssoc($assoc,$assoc_ids,$id); 
             
            foreach ($assoc_ids as $assoc_id) { 
                $values[]  = $db->value($id, $this->getColumnType($this->primaryKey)); 
                $values[]  = $db->value($assoc_id); 
                $values    = join(',', $values); 
                 
                $db->execute("INSERT INTO {$table} ({$fields}) VALUES ({$values})"); 
                unset ($values); 
            } 
             
            return true; 
        } else { 
            return false; 
        } 
    } 

    /** 
     * Deletes any join records between two records of a hasAndBelongsToMany association 
     * 
     * @param integer $id The id of the record in this model 
     * @param mixed $assoc The name of the HABTM association 
     * @param mixed $assoc_ids The associated id or an array of associated ids 
     * @return boolean Success 
     */ 
    function deleteAssoc($assoc, $assoc_ids, $id = null) 
    { 
        if ($id != null) { 
            $this->id = $id; 
        } 

        $id = $this->id; 

        if (is_array($this->id)) { 
            $id = $this->id[0]; 
        } 
         
        if ($this->id !== null && $this->id !== false) { 
            $db =& ConnectionManager::getDataSource($this->useDbConfig); 
             
            $joinTable = $this->hasAndBelongsToMany[$assoc]['joinTable'];     
            $table = $db->name($db->fullTableName($joinTable)); 
             
            $mainKey = $this->hasAndBelongsToMany[$assoc]['foreignKey']; 
            $assocKey = $this->hasAndBelongsToMany[$assoc]['associationForeignKey']; 
             
            if(!is_array($assoc_ids)) { 
                $assoc_ids = array($assoc_ids); 
            } 
             
            foreach ($assoc_ids as $assoc_id) { 
                $db->execute("DELETE FROM {$table} WHERE {$mainKey} = '{$id}' AND {$assocKey} = '{$assoc_id}'"); 
            } 
             
            return true; 
        } else { 
            return false; 
        } 
    } 

}
