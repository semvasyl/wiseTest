taskBlockObject = $('div.todo-block-list');

function request(rawData) {
    var responseResult = null;
    $.ajax({
        url: 'ajax.php',
        dataType: 'json',
        type: 'post',
        async: false, //very ne dobre. Need to find alternative
        contentType: 'application/x-www-form-urlencoded',
        data: rawData,
        success: function (data, textStatus, jQxhr) {
            responseResult = data;
            return data;

        },
        error: function (jqXhr, textStatus, errorThrown) {
            console.log(jqXhr);
            console.log(textStatus.toString());
            console.log(errorThrown.toString());
        }
    });

    return responseResult;
};

function removeTask(blockID, id) {
    rawTaskItems = {'action': 'deleteTodoTaskItem', 'blockID': blockID, 'taskID': id};
    responseTask = request(rawTaskItems);
    if (responseTask.message === 'success') {
        return true;
    }
    return false;
}

function createTask(blockID, name) {
    rawTaskItems = {'action': 'addTodoTaskItem', 'blockID': blockID, 'name': name};
    responseTask = request(rawTaskItems);
    if (responseTask.message === 'success') {
        addTaskToBlock(responseTask.data.listID, responseTask.data.id, name)
    }
}

function setTaskState(blockID, id, state) {
    actionName = 'setTodoTaskItemUnDone';
    if (state === 'checked') {
        actionName = 'setTodoTaskItemDone';
    }
    rawTaskItems = {'action': actionName, 'blockID': blockID, 'taskID': id};
    responseTask = request(rawTaskItems);
    if (responseTask.message === 'success') {
        return true;
    }

    return false;
}

function addTaskToBlock(blockID, id, name) {
    $item = '                    <li class="ui-state-default todo-li">\n' +
        '                        <div class="checkbox">\n' +
        '                            <input type="checkbox" class="todo-li-state-' + blockID + '-' + id + '" value=""/> <span class="todo-li-item todo-li-name-' + blockID + '-' + id + '" data-block-id="' + blockID + '" data-id="' + id + '">' + name + '</span> <i class="fas-item fas fa-trash-alt" data-block-id="' + blockID + '" data-id="' + id + '"></i></i>\n' +
        '                        </div>\n' +
        '                    </li>';
    $('.todo-ul-list-' + blockID)
        .append($item)

}

function createTaskBlock(name) {
    rawTaskItems = {'action': 'addTodoItem', 'name': name};
    responseTask = request(rawTaskItems);
    if (responseTask.message === 'success') {
        addBlock(responseTask.data.listID, responseTask.data.name);
    }
}

function removeTaskBlock(blockID) {
    rawTaskItems = {'action': 'deleteTodoItem', 'blockID': blockID};
    responseTask = request(rawTaskItems);
    if (responseTask.message === 'success') {
        $('div.todo-block-' + blockID).remove();
    }else{
        console.log('error');
        console.log(responseTask);
    }
}

function addBlock(blockID, name) {
    item = '            <div class="card todo-block-group todo-block-' + blockID + '">\n' +
        '                <div class="card-header">\n' +
        '                    ' + name + '\n' +
        '                    <div class="btn-group float-right btn-group-sm" role="group" aria-label="Basic example">\n' +
        '                        <button type="button" class="btn btn-secondary todo-block-delete-' + blockID + '" data-blockID="' + blockID + '"><i class="fas fa-minus-circle"></i></i></button>\n' +
        '                    </div>\n' +
        '                </div>\n' +
        '                <div class="card-body">\n' +
        '                    <p class="card-text">\n' +
        '                    <ul class="list-unstyled todo-ul-list-' + blockID + '">\n' +
        '                    </ul>\n' +
        '                    </p>\n' +
        '                    <form action="#">\n' +
        '                        <div class="form-row align-items-center">\n' +
        '                            <div class="col-8">\n' +
        '                                <label class="sr-only" for="todo-ul-' + blockID + '-input">Task</label>\n' +
        '                                <input type="text" class="form-control mb-6 todo-ul-' + blockID + '-input"\n' +
        '                                       placeholder="Enter new task here...">\n' +
        '                            </div>\n' +
        '                            <div class="col-2">\n' +
        '                                <button type="button" class="btn btn-primary mb-2 todo-ul-' + blockID + '-button">add Task</button>\n' +
        '                            </div>\n' +
        '                        </div>\n' +
        '                    </form>\n' +
        '                </div>\n' +
        '            </div>';
    taskBlockObject
        .append(item)
        .on('click', '.todo-ul-' + blockID + '-button', function (e) {
            inputText = $('input.todo-ul-' + blockID + '-input');
            createTask(blockID, inputText.val());
            inputText.val('');
        })
        .on('dblclick', '.todo-block-delete-' + blockID, function (e) {
            if (confirm('Delete block and all Tasks?')){
                removeTaskBlock(blockID);
            }
        });


    return true;
}

$(document).ready(function () {

    rawTaskLists = {'action': 'getTodoItemList'};
    response = request(rawTaskLists);
    $.each(response.data, function (key, value) {
        addBlock(value.id, value.name);
        rawTaskItems = {'action': 'getTodoItemTaskList', 'blockID': value.id};
        responseTask = request(rawTaskItems);
        if (responseTask.data !== null) {
            $.each(responseTask.data, function (key, value) {
                addTaskToBlock(value.listID, value.id, value.name);
                taskBlockObject
                    .on('click', 'span.todo-li-name-' + value.listID + '-' + value.id, function (e) {
                        state = $('input.todo-li-state-' + value.listID + '-' + value.id);
                        if (state.is(':checked') === false) {
                            setResult = setTaskState($(this).data('blockId'), $(this).data('id'), 'checked');
                            if (setResult === true) {
                                state.prop("checked", true);
                                $(this).addClass('deleted-item');
                            }
                        }
                    })
                    .on('dblclick', 'span.todo-li-name-' + value.listID + '-' + value.id, function (e) {
                        state = $('input.todo-li-state-' + value.listID + '-' + value.id);
                        if (state.is(':checked') === true) {
                            setResult = setTaskState($(this).data('blockId'), $(this).data('id'), 'unchecked');
                            if (setResult === true) {
                                state.prop("checked", false);
                                $(this).removeClass('deleted-item');
                            }
                        }
                    });
            });
        }


    });


    $('a.todo-add-list').click(function (e) {
        todoListName = $('input.todo-add-list-input');
        createTaskBlock(todoListName.val())
        todoListName.val('');
    });


    $('i.fas-item').dblclick(function (e) {
        if (confirm('Delete this tasks?')){
            removeTaskResult=removeTask($(this).data('blockId'),$(this).data('id'));
            if (removeTaskResult===true){
                $(this).parent().parent().remove();
            }
        }
    });

});