<?php
/**
 * Created by PhpStorm.
 * User: vasyl
 * Date: 24.10.18
 * Time: 20:16
 */

class Task
{
    const TODO_TABLE_ITEMS = 'todo_items';

    private $todoListID;

    public function __construct($todoListID)
    {
        $this->todoListID = $todoListID;
    }

    public function addTask($name)
    {
        $maxPos = DB::queryFirstRow('SELECT MAX(position) as count FROM ' . self::TODO_TABLE_ITEMS);
        DB::insert(
            self::TODO_TABLE_ITEMS,
            [
                'listID' => $this->todoListID,
                'name' => $name,
                'isdone' => false,
                'position' => $maxPos['count'] === null ? 1 : $maxPos['count']+1,
                'create_at' => date('Y-m-d H:i:s'),
                'modified_at' => date('Y-m-d H:i:s'),
            ]
        );

        return DB::insertId();
    }

    public function getTask($id)
    {
        return DB::query('SELECT * FROM ' . self::TODO_TABLE_ITEMS . ' WHERE id=%d', $id);
    }

    public function getTaskLists()
    {
        return DB::query('SELECT * FROM ' . self::TODO_TABLE_ITEMS . ' WHERE listID=%d', $this->todoListID);
    }

    public function deleteTask($id)
    {
        return DB::query("DELETE FROM " . self::TODO_TABLE_ITEMS . " WHERE id=%d", $id);
    }

    public function setTaskDoneState($id)
    {
        return DB::update(
            self::TODO_TABLE_ITEMS,
            [
                'isdone' => true,
                'modified_at' => date('Y-m-d H:i:s'),
            ],
            "id=%d",
            $id
        );
    }

    public function setTaskUnDoneState($id)
    {
        return DB::update(
            self::TODO_TABLE_ITEMS,
            [
                'isdone' => false,
                'modified_at' => date('Y-m-d H:i:s'),
            ],
            "id=%d",
            $id
        );
    }
}