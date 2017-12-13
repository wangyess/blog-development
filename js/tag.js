;(function () {
    'use strict';
    var limit = 10;
    var number;
    var page = 1;
    var tag = new Model('tag');
    //选中表单增加事件
    var my_form = document.querySelector('#my_form');
    //选中渲染的div
    var first_tbody = document.querySelector('#first-tbody');
    //选中翻页按钮
    var top_page = document.querySelector('.top-page a');
    var next_page = document.querySelector('.next-page a');
    init();
    function init() {
        read();
        add();
    }
    //翻页 首先获取数据的个数在/limit
    tag.read_count()
        .then(function (r) {
            count(r);
        });
    //获取渲染翻页页面的数量
    function count(r) {
        number =Math.ceil(r/limit);
    }
    top_page.addEventListener('click', function (e) {
        e.preventDefault();
        if (page <= 1) {
            return;
        }
        page--;
        tag.read({'page': page, 'limit': limit})
            .then(function (r) {
                render(r.data);
            })
    });
    next_page.addEventListener('click', function (e) {
        e.preventDefault();
        console.log(1);
        console.log(page);
        console.log(number);
        if (page == number) {
            return;
        }
        page++;
        console.log(page);
        tag.read({'page': page, 'limit': limit})
            .then(function (r) {
                render(r.data);
            })
    });
    //获取数据
    function read(){
        tag.read({'page': page, 'limit': limit})
            .then(function (r) {
                render(r.data)
            });
    }
    //渲染数据
    function render(data){
        first_tbody.innerHTML = '';
        data.forEach(function (item) {
            var tr = document.createElement('tr');
            tr.innerHTML = `
              <td>${item.id}</td>  
              <td>${item.title}</td> 
              <td>
                 <button class="btn btn-danger" id="del_button_${item.id}"><i class="fa fa-trash"></i></button>
                 <button class="btn btn-success" id="up_button_${item.id}"><i class="fa fa-edit"></i></button>
              </td>  
            `;
            first_tbody.appendChild(tr);
            //绑定删除按钮
            var del_event = document.querySelector('#del_button_' + item.id);
            remove(del_event, item.id);
            //绑定更新按钮
            var update_event = document.querySelector('#up_button_' + item.id);
            update(update_event, item);
        })
    }
    //添加
    function add() {
        my_form.addEventListener('submit',function (e) {
            e.preventDefault();
            //获取页面数据
            var data = get_form_input();
            tag.add_or_update(data)
                .then(function (r) {
                    read();
                })
        });
    }
    //获取表单输入
    function get_form_input() {
        var data = {};
        var input_list = document.querySelectorAll('[name]');
        input_list.forEach(function (item) {
            var val = item.value;
            var key = item.name;
            data[key] = val;
            item.value = '';
        });
        return data;
    }
    //删除
    function remove(a,id) {
        a.addEventListener('click',function (e) {
            e.preventDefault();
            tag.remove({'id':id})
                .then(function () {
                    read();
                })
        })
    }
    //更新
    function update(a,item) {
        a.addEventListener('click',function (e) {
            e.preventDefault();
            //把数据推送到表单
            input_page_form(item);
        })
    }
    //数据推到表单
    function input_page_form(item) {
         for(var temp in item){
             var val = item[temp];
             var input = document.querySelector('[name='+temp+']');
             if(! input){
                 continue;
             }
             input.value=val;
         }
    }
})();