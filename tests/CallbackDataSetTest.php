<?php
/**
 * CallbackDataSetTest
 *
 * Copyright (c) 2014 ISHIDA Akio
 *
 * This software is released under the MIT License.
 *
 * http://opensource.org/licenses/mit-license.php
 */

use iakio\dataset\CallbackDataSet;

class CallbackClass
{
    private $empty;

    function __construct($empty = FALSE)
    {
        $this->empty = $empty;
    }

    function table1()
    {
        if ($this->empty) {
            return array();
        }
        return array(array(
            'table1_id' => 1,
            'column1' => 'tgfahgasdf',
            'column2' => 200,
            'column3' => 34.64,
            'column4' => 'yghkf;a  hahfg8ja h;'
        ), array(
            'table1_id' => 2,
            'column1' => 'hk;afg',
            'column2' => 654,
            'column3' => 46.54,
            'column4' => '24rwehhads'
        ), array(
            'table1_id' => 3,
            'column1' => 'ha;gyt',
            'column2' => 462,
            'column3' => 1654.4,
            'column4' => 'asfgklg'
        ));
    }

    function table2()
    {
        if ($this->empty) {
            return array();
        }
        return new ArrayIterator(array(array(
            'table2_id' => 1,
            'column5' => 'fhah',
            'column6' => 456,
            'column7' => 46.5,
            'column8' => 'fsdb, ghfdas'
        ), array(
            'table2_id' => 2,
            'column5' => 'asdhfoih',
            'column6' => 654,
            'column7' => 'blah',
            'column8' => '43asd "fhgj" sfadh'
        ), array(
            'table2_id' => 3,
            'column5' => 'ajsdlkfguitah',
            'column6' => 654,
            'column7' => 'blah',
            'column8' => 'thesethasdl
asdflkjsadf asdfsadfhl "adsf, halsdf" sadfhlasdf'
        )));
    }
}

class CallbackDataSetTest extends \PHPUnit_Framework_TestCase
{
    function expectedDataSet()
    {
        $table1MetaData = new \PHPUnit_Extensions_Database_DataSet_DefaultTableMetaData(
            'table1', array('table1_id', 'column1', 'column2', 'column3', 'column4')
        );
        $table2MetaData = new \PHPUnit_Extensions_Database_DataSet_DefaultTableMetaData(
            'table2', array('table2_id', 'column5', 'column6', 'column7', 'column8')
        );
        $table1 = new \PHPUnit_Extensions_Database_DataSet_DefaultTable($table1MetaData);
        $table2 = new \PHPUnit_Extensions_Database_DataSet_DefaultTable($table2MetaData);
        $table1->addRow(array(
            'table1_id' => 1,
            'column1' => 'tgfahgasdf',
            'column2' => 200,
            'column3' => 34.64,
            'column4' => 'yghkf;a  hahfg8ja h;'
        ));
        $table1->addRow(array(
            'table1_id' => 2,
            'column1' => 'hk;afg',
            'column2' => 654,
            'column3' => 46.54,
            'column4' => '24rwehhads'
        ));
        $table1->addRow(array(
            'table1_id' => 3,
            'column1' => 'ha;gyt',
            'column2' => 462,
            'column3' => 1654.4,
            'column4' => 'asfgklg'
        ));

        $table2->addRow(array(
            'table2_id' => 1,
            'column5' => 'fhah',
            'column6' => 456,
            'column7' => 46.5,
            'column8' => 'fsdb, ghfdas'
        ));
        $table2->addRow(array(
            'table2_id' => 2,
            'column5' => 'asdhfoih',
            'column6' => 654,
            'column7' => 'blah',
            'column8' => '43asd "fhgj" sfadh'
        ));
        $table2->addRow(array(
            'table2_id' => 3,
            'column5' => 'ajsdlkfguitah',
            'column6' => 654,
            'column7' => 'blah',
            'column8' => 'thesethasdl
asdflkjsadf asdfsadfhl "adsf, halsdf" sadfhlasdf'
        ));

        $expectedDataSet = new \PHPUnit_Extensions_Database_DataSet_DefaultDataSet(array($table1, $table2));
        return $expectedDataSet;
    }

    function emptyDataSet()
    {
        $table1MetaData = new \PHPUnit_Extensions_Database_DataSet_DefaultTableMetaData('table1', array());
        $table2MetaData = new \PHPUnit_Extensions_Database_DataSet_DefaultTableMetaData('table2', array());
        $table1 = new \PHPUnit_Extensions_Database_DataSet_DefaultTable($table1MetaData);
        $table2 = new \PHPUnit_Extensions_Database_DataSet_DefaultTable($table2MetaData);
        $expectedDataSet = new \PHPUnit_Extensions_Database_DataSet_DefaultDataSet(array($table1, $table2));
        return $expectedDataSet;
    }

    function testCallbackDataSetByClassName()
    {
        $factoryDataSet = new CallbackDataSet("CallbackClass");
        $expectedDataSet = $this->expectedDataSet();
        \PHPUnit_Extensions_Database_TestCase::assertDataSetsEqual($expectedDataSet, $factoryDataSet);
    }

    function testCallbackDataSetByInstance()
    {
        $factoryDataSet = new CallbackDataSet(new CallbackClass(true));
        $expectedDataSet = $this->emptyDataSet();
        \PHPUnit_Extensions_Database_TestCase::assertDataSetsEqual($expectedDataSet, $factoryDataSet);
    }
}
