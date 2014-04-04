<?php
/**
 * Copyright (c) 2014 ISHIDA Akio
 *
 * This software is released under the MIT License.
 *
 * http://opensource.org/licenses/mit-license.php
 */

use iakio\dataset\CallbackDataSet;

/**
 * @requires extension pdo_sqlite
 */
class GuestbookTest extends \PHPUnit_Extensions_Database_TestCase
{
    static $pdo;

    function guestbook()
    {
        return array(
            array('id' => 1, 'content' => 'Hello buddy!', 'user' => 'joe', 'created' => '2010-04-24 17:15:23'),
            array('id' => 2, 'content' => 'I like it!',   'user' => null,  'created' => '2010-04-26 12:14:20'),
        );
    }

    function getConnection()
    {
        if (!self::$pdo) {
            self::$pdo = new PDO('sqlite::memory:');
            self::$pdo->exec('CREATE TABLE guestbook(id integer primary key, content varchar(50), user varchar(50), created datetime)');
        }
        return $this->createDefaultDBConnection(self::$pdo, ':memory:');
    }

    function getDataSet()
    {
        return new CallbackDataSet($this, array('guestbook'));
    }

    function testGuestBook()
    {
        $this->assertEquals(2, $this->getConnection()->getRowCount('guestbook'));
        $queryTable = $this->getConnection()->createQueryTable(
            'guestbook', 'SELECT * FROM guestbook WHERE user IS NULL'
        );
        $this->assertEquals(1, $queryTable->getRowCount('guestbook'));
    }

}
