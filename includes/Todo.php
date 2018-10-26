<?php
/**
 * Created by PhpStorm.
 * User: vasyl
 * Date: 24.10.18
 * Time: 20:17
 */

class Todo
{
    const TODO_TABLE = 'todo_list';
    const TODO_TABLE_ITEMS = 'todo_items';

    public function add($name)
    {
        $maxPos = DB::queryFirstRow('SELECT MAX(position) as count FROM ' . self::TODO_TABLE);
        DB::insert(
            self::TODO_TABLE,
            [
                'name' => $name,
                'position' => $maxPos['count'] === null ? 1 : $maxPos['count'] + 1,
                'create_at' => date('Y-m-d H:i:s'),
                'modified_at' => date('Y-m-d H:i:s'),
            ]
        );

        return DB::insertId();
    }

    public function getTodoLists()
    {
        return DB::query('SELECT * FROM ' . self::TODO_TABLE);
    }

    public function get($id)
    {
        return new Task($id);
    }

    public function delete($id)
    {
        DB::startTransaction();
        $findedChildTask = DB::queryFirstRow('SELECT COUNT(id) as count FROM ' . self::TODO_TABLE_ITEMS . ' WHERE listID=%d', $id);
        DB::query("DELETE FROM " . self::TODO_TABLE_ITEMS . " WHERE listID=%d", $id);
        $affectedRecordCount = DB::affectedRows();
        if ($affectedRecordCount === (int)$findedChildTask['count']) {
            DB::query("DELETE FROM " . self::TODO_TABLE . " WHERE id=%d", $id);
            DB::commit();
            return true;

        } else {
            DB::rollback();
            return false;
        }
//        return DB::query("DELETE FROM " . self::TODO_TABLE . " WHERE id=%d", $id);
    }
}