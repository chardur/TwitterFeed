<?php
/**
 * Unit-test for Part 1
 *
 * PHP Version 7
 *
 * @category UnitTests
 * @package  Tests
 * @author   Don Stringham <donstringham@weber.edu>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://weber.edu
 */
declare(strict_types=1);
namespace App\Tests;

use PHPUnit\Framework\TestCase;

/**
 * PartOneTest tests database validation
 *
 * @property string _host
 * @property string _port
 * @property string _username
 * @property string _password
 * @property \MySQLi _connection
 * @property string _database
 * @category UnitTests
 * @package  App\Tests
 * @author   Don Stringham <donstringham@weber.edu>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://weber.edu
 */
class PartOneTest extends TestCase
{
    /**
     * Set up data needed for every unit-test
     *
     * @category UnitTests
     * @package  App\Tests
     * @author   Don Stringham <donstringham@weber.edu>
     * @license  MIT https://opensource.org/licenses/MIT
     * @link     https://weber.edu
     * @return   void
     */
    public function setUp(): void
    {
        $this->_host = '67.205.183.11';
        $this->_port = '3306';
        $this->_username = 'chardur';
        $this->_password = 'changeme';
        $this->_connection = null;
        $this->_database = 'feed_chardur';
        $this->_connection = mysqli_connect(
            $this->_host,
            $this->_username,
            $this->_password
        );
        $this->_connection->select_db($this->_database);
    }

    /**
     * Tests if unit-test can be run
     *
     * @category UnitTests
     * @package  App\Tests
     * @author   Don Stringham <donstringham@weber.edu>
     * @license  MIT https://opensource.org/licenses/MIT
     * @link     https://weber.edu
     * @return   void
     */
    public function testCanary(): void
    {
        // arrange & act & assert
        $this->assertTrue(true);
    }

    /**
     * Tests prime numbers
     *
     * @category UnitTests
     * @package  App\Tests
     * @author   Don Stringham <donstringham@weber.edu>
     * @license  MIT https://opensource.org/licenses/MIT
     * @link     https://weber.edu
     * @return   void
     */
    public function testSelectAll(): void
    {
        // arrange
        $query = "SELECT * FROM feed_chardur.Users";
        // act
        $result = $this->_connection->query($query);
        $row = $result->fetch_row();
        // assert
        $this->assertEquals('2', $row[0]);
    }

    public function testPost(): void
    {

        $sql = "INSERT INTO feed_chardur.Users (name) values ('unitTest')";
        if ($this->_connection->query($sql) === TRUE) {
            $result = TRUE;
        } else {
            $result = FALSE;
        }
        $this->assertEquals(TRUE, $result);

    }

    public function testGet(): void
    {
        $sql = "SELECT LAST_INSERT_ID()";
        $result = $this->_connection->query($sql);
        if($result->num_rows > 0){
            $test = TRUE;
        }else{
            $test = FALSE;
        }
        $this->assertEquals(TRUE, $test);
    }

}
