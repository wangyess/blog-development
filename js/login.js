;(function () {
    'use strict';
    var login_form = document.querySelector('#login-form');
    init();

    function init() {
        login_submit();
    }

    //给表单添加提交时间
    function login_submit() {
        login_form.addEventListener('submit', function (e) {
            e.preventDefault();
            //获取页面输入
            var data = get_page_input(login_form);
            $.post('/a/user/login', data)
                .then(function (r) {
                    if (r.success) {
                        alert('您已经登陆成功');
                        window.location.href = '/';
                    }
                })
        })
    }

    //获取页面输入
    function get_page_input(el) {
        var data = {};
        var input_list = el.querySelectorAll('[name]');
        for (var i = 0; i < input_list.length; i++) {
            var input = input_list[i];
            var val = input.value;
            var key = input.name;
            console.log(val);
            data[key] = val;
            input.value = "";
        }
        return data;
    }
})();
