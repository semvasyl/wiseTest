<?php
include_once '/var/www/html/wise/includes/MeekroDB.php';
include_once '/var/www/html/wise/includes/configs.php';
include_once '/var/www/html/wise/includes/Task.php';
include_once '/var/www/html/wise/includes/Todo.php';

$todoList = new Todo();

/**
 * function for prepare value (escape dangerous symbols) to sql query
 * @param $value
 * @return string
 */
function clearValue($value)
{
    if (!is_numeric($value)){
        return addslashes($value);
    }
    return $value;
}


function setPostParametr($value)
{
    if (!empty($value)) {
        return clearValue($value);
    }

    return '';
}

$action = setPostParametr($_POST['action'] ?? '');
$name = setPostParametr($_POST['name'] ?? '');
$taskID = setPostParametr($_POST['taskID'] ?? 0);
$taskListID = setPostParametr($_POST['blockID'] ?? 0);
$taskState = setPostParametr($_POST['taskState'] ?? 0);

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'addTodoItem':
            if (!empty($name)) {
                $id = $todoList->add($name);
                echo json_encode(
                    [
                        'message' => 'success',
                        'data' => [
                            'listID' => $id,
                            'name' => $name
                        ],
                    ]
                );
            }
            break;
        case 'addTodoTaskItem':
            if (!empty($name) && !empty($taskListID)) {
                $id = $todoList->get($taskListID)->addTask($name);
                echo json_encode(
                    [
                        'message' => 'success',
                        'data' => [
                            'listID' => $taskListID,
                            'id' => $id,
                        ],
                    ]
                );
            }
            break;
        case 'setTodoTaskItemDone':
            if (!empty($taskID) && !empty($taskListID)) {
                $result = $todoList->get($taskListID)->setTaskDoneState($taskID);
                echo json_encode(
                    [
                        'message' => ($result === true) ? 'success' : 'fail',
                        'data' => [
                            'listID' => $taskListID,
                            'id' => $taskID,
                        ],
                    ]
                );
            }
            break;
        case 'setTodoTaskItemUnDone':
            if (!empty($taskID) && !empty($taskListID)) {
                $result = $todoList->get($taskListID)->setTaskUnDoneState($taskID);
                echo json_encode(
                    [
                        'message' => ($result === true) ? 'success' : 'fail',
                        'data' => [
                            'listID' => $taskListID,
                            'id' => $taskID,
                        ],
                    ]
                );
            }
            break;
        case 'deleteTodoItem':
            if (!empty($taskListID)) {
                $result = $todoList->delete($taskListID);
                echo json_encode(
                    [
                        'message' => ($result === true) ? 'success' : 'fail',
                        'data' => [],
                    ]
                );
            }
            break;
        case 'deleteTodoTaskItem':
            if (!empty($taskListID) && !empty($taskID)) {
                $result = $todoList->get($taskListID)->deleteTask($taskID);
                echo json_encode(
                    [
                        'message' => ($result === true) ? 'success' : 'fail',
                        'data' => [],
                    ]
                );
            }
            break;
        case 'getTodoItemList':
            $response = $todoList->getTodoLists();
            echo json_encode(
                [
                    'message' => 'success',
                    'data' => $response,
                ]
            );
            break;
        case 'getTodoItemTaskList':
            if (!empty($taskListID)) {
                $response = $todoList->get($taskListID)->getTaskLists();
                echo json_encode(
                    [
                        'message' => 'success',
                        'data' => $response,
                    ]
                );
            }
            break;
        case 'getTodoItemList1':
            $todoList->get('43')->getTaskLists();
            break;
    }
}