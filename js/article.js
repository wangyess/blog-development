;(function () {
    "use strict";
    var limit = 5;
    var number;
    var page = 1;
    var article = new Model('article');
    var tag = new Model('tag');
    var user = new Model('user');
    //选中表单增加事件
    var my_form = document.querySelector('#my_form');
    //选中渲染的div
    var first_tbody = document.querySelector('#first-tbody');
    //选中翻页按钮
    var top_page = document.querySelector('.top-page a');
    var next_page = document.querySelector('.next-page a');
    //选中select
    var select_form = document.querySelector('[name=tag_id]');
    init();

    function init() {
        //获取数据
        read();
        //监听表单提交
        add_submit();
        //获取tag标签中的数据
        get_tag_data();
    }

    //获取所有数据个数
    article.read_count()
        .then(function (r) {
            fenye(r);
        });

    //获取页数
    function fenye(r) {
        number = Math.ceil(r / limit);
    }

    //翻页
    top_page.addEventListener('click', function (e) {
        e.preventDefault();
        if (page <= 1) {
            return;
        }
        page--;
        article.read({'page': page, 'limit': limit})
            .then(function (r) {
                render(r.data);
            })
    });
    next_page.addEventListener('click', function (e) {
        e.preventDefault();
        if (page == number) {
            return;
        }
        page++;
        article.read({'page': page, 'limit': limit})
            .then(function (r) {
                render(r.data);
            })
    });

    //读取数据
    function read() {
        article.read({'page': page, 'limit': limit})
            .then(function (r) {
                render(r.data);
            })
    }

    //渲染数据
    function render(data) {
        first_tbody.innerHTML = '';
        data.forEach(function (item) {
            var tr = document.createElement('tr');
            tr.innerHTML = `
              <td>${item.id}</td>  
              <td>${item.title}</td>  
              <td id="ren_${item.id}">${item.author_id}</td>  
              <td>${item.create_time}</td>  
              <td>${item.update_time}</td>  
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
            //选中作者所在的td  再把id 传出来
            var kk = document.querySelector('#ren_' + item.id);
            render_author(kk,item.author_id);
        })
    }

    //渲染作者
    function render_author(kk,id) {
        user.read({'id': id})
            .then(function (r) {
                var data = r.data;
                var author_name = data[0]['username'];
                kk.innerText=author_name;
            })
    }

    //更新
    function update(a, data) {
        a.addEventListener('click', function (e) {
            e.preventDefault();
            //首先把数据放到表单中
            input_page_form(data);
        })
    }

    //把数据推到表单中
    function input_page_form(data) {
        for (var temp in data) {
            var val = data[temp];
            var input = document.querySelector('[name=' + temp + ']');
            if (!input) {
                continue;
            }
            input.value = val;
        }
    }

    //删除
    function remove(a, id) {
        a.addEventListener('click', function (e) {
            e.preventDefault();
            article.remove({'id': id})
                .then(function (r) {
                    read();
                });
        })
    }

    //添加数据
    function add_submit() {
        my_form.addEventListener('submit', function (e) {
            e.preventDefault();
            //当提交的时候获取表单内容
            var data = get_form_input();
            article.add_or_update(data)
                .then(function (r) {
                    if (r.success) {
                        tag_chuan(r.data);
                        read();
                        get_tag_data();
                    }
                });
        })
    }

    //获取表单输入
    function get_form_input() {
        var data = {};
        var input_list = document.querySelectorAll('[name]');
        input_list.forEach(function (item) {
            if (item.name === 'tag_id') {
                return;
            }
            var val = item.value;
            var key = item.name;
            data[key] = val;
            item.value = '';
        });
        return data;
    }

    //传到article中
    //获取tag标签中的数据
    function get_tag_data() {
        tag.read({'page': page, 'limit': 100})
            .then(function (r) {
                render_tag(r.data);
            })
    }

    //渲染tag表中的数据
    function render_tag(data) {
        select_form.innerHTML = '';
        data.forEach(function (item) {
            var option = document.createElement('option');
            option.innerHTML = item.title;
            option.value = item.id;
            select_form.appendChild(option);
        })
    }

    //获取select 中的数据
    function get_select_data() {
        var select = document.getElementById("one");
        var str = [];
        for (var i = 0; i < select.length; i++) {
            if (select.options[i].selected) {
                str.push(select[i].value);
            }
        }
        return str;
    }

    //传
    function tag_chuan(id) {
        var str = get_select_data();
        var row = {'id': id, 'data': str};
        $.post('/a/article/tag_article_biao', row)
    }
})();