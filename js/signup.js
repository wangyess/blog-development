;(function () {
    'use strict';
    var signup_form = document.querySelector('#signup-form');
    init();

    function init() {
        signup_submit();
    }

    //给表单添加提交时间
    function signup_submit() {
        signup_form.addEventListener('submit', function (e) {
            e.preventDefault();
            //获取页面输入
            var data = get_page_input(signup_form);
            $.post('/a/user/signup', data)
                .then(function (r) {
                    if (r.success) {
                        alert('您已经成功注册');
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
            data[key] = val;
            input.value = "";
        }
        return data;
    }
})();