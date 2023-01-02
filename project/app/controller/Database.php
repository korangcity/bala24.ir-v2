<?php

namespace App\controller;

class Database
{ 
    public $debug = true;
    private static $instance;

    private $server = "";
    private $user = "";
    private $pass = "";
    private $database = "";
    private $error = "";
    public $affected_rows = 0;
    public $link_id = 0;
    private $query_id = 0;


    public function __construct($server = null, $user = null, $pass = null, $database = null)
    {
        if ($server == null || $user == null || $database == null) {
            $this->oops("Database information must be passed in when the object is first created.");
        }

        $this->server = $server;
        $this->user = $user;
        $this->pass = $pass;
        $this->database = $database;
    }


    public function set_db($server = null, $user = null, $pass = null, $database = null)
    {
        $this->server = $server;
        $this->user = $user;
        $this->pass = $pass;
        $this->database = $database;
    }

    public static function obtain($server = null, $user = null, $pass = null, $database = null)
    {
        if (!self::$instance) {
            self::$instance = new Database($server, $user, $pass, $database);
        }

        return self::$instance;
    }

    public function connect($new_link = false)
    {
        $this->link_id = mysqli_connect($this->server, $this->user, $this->pass, $this->database);
        mysqli_set_charset($this->link_id, "utf8mb4");

        if (mysqli_connect_errno()) {
            $this->oops("Could not connect to server: <b>$this->server</b>.");
        }


        if (!mysqli_select_db($this->link_id, $this->database)) {
            $this->oops("Could not open database: <b>$this->database</b>.");
        }

        $this->server = '';
        $this->user = '';
        $this->pass = '';
        $this->database = '';
    }

    public function close()
    {
        if (!@mysqli_close($this->link_id)) {
            $this->oops("Connection close failed.");
        }
    }

    public function escape($string)
    {

        return @mysqli_real_escape_string($this->link_id, $string);
    }

    public function query($sql)
    {
        $this->query_id = mysqli_query($this->link_id, $sql);


        if (!$this->query_id) {
            $this->oops("<b>MySQL Query fail:</b> $sql");
            return 0;
        }

        $this->affected_rows = mysqli_affected_rows($this->link_id);

        return $this->query_id;
    }

    public function select_q($table, $data, $order = "")
    {
        $q = "select * from $table where 1=1 AND ";

        if ($data[0] != "0") {

            foreach ($data as $key => $val) {
                if ($key != "0")
                    $n .= "`$key`='" . $this->escape($val) . "' AND ";
            }
        }
        $q .= " $n 2=2 $order";

        return $this->fetch_array($q);
    }

    public function rawQuery($query)
    {
        return $this->fetch_array($query);

    }

    public function query_first($query_string)
    {
        $query_id = $this->query($query_string);
        $out = $this->fetch($query_id);
        $this->free_result($query_id);
        return $out;
    }

    public function fetch($query_id = -1)
    {
        if ($query_id != -1) {
            $this->query_id = $query_id;
        }

        if (isset($this->query_id)) {
            $record = @mysqli_fetch_assoc($this->query_id);
        } else {
            $this->oops("Invalid query_id: <b>$this->query_id</b>. Records could not be fetched.");
        }

        return $record;

    }

    public function fetch_array($sql)
    {
        $query_id = $this->query($sql);
        $out = array();

        while ($row = $this->fetch($query_id)) {
            $out[] = $row;
        }


        $this->free_result($query_id);
        return $out;
    }

    public function select_old($query)
    {
        $res = mysqli_query($this->link_id, $query);
        return $res;
    }

    public function update($table, $data, $where = '1')
    {
        $q = "UPDATE `$table` SET ";

        foreach ($data as $key => $val) {
            if (strtolower($val) == 'null') $q .= "`$key` = NULL, ";
            elseif (strtolower($val) == 'now()') $q .= "`$key` = NOW(), ";
            elseif (preg_match("/^increment\((\-?\d+)\)$/i", $val, $m)) $q .= "`$key` = `$key` + $m[1], ";
            else $q .= "`$key`='" . $this->escape($val) . "', ";
        }

        $q = rtrim($q, ', ') . ' WHERE ' . $where . ';';

        return $this->query($q);
    }

    public function insert($table, $data)
    {
        $q = "INSERT INTO `$table` ";
        $v = '';
        $n = '';
        foreach ($data as $key => $val) {
            $n .= "`$key`, ";
            if (strtolower($val) == 'null') $v .= "NULL, ";
            elseif (strtolower($val) == 'now()') $v .= "NOW(), ";
            else $v .= "'" . $this->escape($val) . "', ";
        }
        $q .= "(" . rtrim($n, ', ') . ") VALUES (" . rtrim($v, ', ') . ");";

        if ($this->query($q)) {
            return mysqli_insert_id($this->link_id);
        } else return false;

    }

    public function insertGroup($table, $data)
    {
        $q = "INSERT INTO `$table` ";
        $v = '';
        $n = '';


        foreach ($data[0] as $key => $val) {
            $n .= "`$key`, ";
            if (strtolower($val) == 'null') $v .= "NULL, ";
            elseif (strtolower($val) == 'now()') $v .= "NOW(), ";
            else $v .= "'" . $this->escape($val) . "', ";
        }


        $q .= "(" . rtrim($n, ', ') . ") VALUES ";

        for ($zz = 0; $zz < count($data); $zz++) {
            $v = "";
            foreach ($data[$zz] as $key => $val) {
                $n .= "`$key`, ";
                if (strtolower($val) == 'null') $v .= "NULL, ";
                elseif (strtolower($val) == 'now()') $v .= "NOW(), ";
                else $v .= "'" . $this->escape($val) . "', ";
            }
            $v = rtrim($v, ', ');
            $ValuesGroup .= "($v) ,";

        }
        $ValuesGroup = rtrim($ValuesGroup, ', ');

        $q .= " " . $ValuesGroup;
        //echo $q."<hr>";

        if ($this->query($q)) {
            return mysqli_insert_id($this->link_id);
        } else return false;

    }

    private function free_result($query_id)
    {
        if ($query_id) {
            $this->query_id = $query_id;
        }
        mysqli_free_result($this->query_id);

    }

    private function oops($msg = '')
    {
        if (!empty($this->link_id)) {
            $this->error = mysqli_error($this->link_id);
        } else {
            $this->error = mysqli_error();
            $msg = "<b>WARNING:</b> No link_id found. Likely not be connected to database.<br />$msg";
        }

        // if no debug, done here
        if (!$this->debug) return;
        ?>
        <table align="center" border="1" cellspacing="0" style="background:white;color:black;width:80%;">
            <tr>
                <th colspan=2>Database Error</th>
            </tr>
            <tr>
                <td align="right" valign="top">Message:</td>
                <td><?php echo $msg; ?></td>
            </tr>
            <?php if (!empty($this->error)) echo '<tr><td align="right" valign="top" nowrap>MySQL Error:</td><td>' . $this->error . '</td></tr>'; ?>
            <tr>
                <td align="right">Date:</td>
                <td><?php echo date("l, F j, Y \a\\t g:i:s A"); ?></td>
            </tr>
            <?php if (!empty($_SERVER['REQUEST_URI'])) echo '<tr><td align="right">Script:</td><td><a href="' . $_SERVER['REQUEST_URI'] . '">' . $_SERVER['REQUEST_URI'] . '</a></td></tr>'; ?>
            <?php if (!empty($_SERVER['HTTP_REFERER'])) echo '<tr><td align="right">Referer:</td><td><a href="' . $_SERVER['HTTP_REFERER'] . '">' . $_SERVER['HTTP_REFERER'] . '</a></td></tr>'; ?>
        </table>
        <?php
    }




}