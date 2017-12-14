;(function () {
    'use strict';
    var cli_on_1 = document.getElementById('cli_on_1');
    if(cli_on_1){
        on_cli();
    }
    function on_cli() {
        cli_on_1.addEventListener('click', function (e) {
            e.preventDefault();
            $.post('/a/user/logout')
                .then(function (r) {
                    if (r.success) {
                        aa();
                    }
                })
        })
    }
    function aa() {
        alert('您已经成功的退出');
        window.location.href='/';
    }
})();