;(function () {
    'use strict';
    window.Model = Model;

    function Model(model_name) {
        if (!model_name) {
            throw 'invalid_model_name';
        }
        this.list = [];
        this.model_name = model_name;
        this.read = read;
        this.add_or_update = add_or_update;
        this.remove = remove;
        this.read_count = read_count;
    }

    function read(rows) {
        return $.post('/a/' + this.model_name +'/read', rows)
    }

    function add_or_update(rows) {
        if (rows.id) {
            return $.post('/a/' + this.model_name + '/update', rows)
        } else {
            return $.post('/a/' + this.model_name + '/add', rows)
        }
    }

    function remove(rows) {
        var ok = confirm('确定要删除吗?');
        if (!ok) {
            return;
        } else {
           return $.post('/a/' + this.model_name + '/remove', rows)
        }
    }

    function read_count() {
        return $.get('/a/' + this.model_name + '/count')
    }
})();