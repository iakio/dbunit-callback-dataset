<?php
/**
 * CallbackDataSet
 *
 * Copyright (c) 2014 ISHIDA Akio
 *
 * This software is released under the MIT License.
 *
 * http://opensource.org/licenses/mit-license.php
 */

namespace iakio\dataset;

use PHPUnit_Extensions_Database_DataSet_AbstractDataSet;

class CallbackDataSet extends PHPUnit_Extensions_Database_DataSet_AbstractDataSet
{
    /**
     * @var array
     */
    protected $tables = array();


    /**
     * @param $classname_or_instance mixed
     */
    public function __construct($classname_or_instance)
    {
        $reflection_class = new \ReflectionClass($classname_or_instance);
        if (is_object($classname_or_instance)) {
            $instance = $classname_or_instance;
        } else {
            $instance = $reflection_class->newInstance();
        }
        $methods = $reflection_class->getMethods(\ReflectionMethod::IS_PUBLIC);

        foreach ($methods as $method) {
            if ($method->isConstructor()) {
                continue;
            }
            $tableName = $method->name;
            $columns = array();
            foreach ($method->invoke($instance) as $row) {
                $columns = array_merge($columns, array_keys($row));
            }
            $columns = array_values(array_unique($columns));
            $tableMetaData = new \PHPUnit_Extensions_Database_DataSet_DefaultTableMetaData($tableName, $columns);
            $this->tables[$tableName] = new \PHPUnit_Extensions_Database_DataSet_DefaultTable($tableMetaData);
            foreach ($method->invoke($instance) as $row) {
                $this->tables[$tableName]->addRow($row);
            }
        }
    }


    /**
     * @return PHPUnit_Extensions_Database_DataSet_ITableIterator
     */
    protected function createIterator($reserved = FALSE)
    {
        return new \PHPUnit_Extensions_Database_DataSet_DefaultTableIterator(
            $this->tables, $reserved
        );
    }
}
