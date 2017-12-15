;(function () {
    'use strict';
    var user = new Model('user');
    //获取地址栏传的ID
    var str = location.search;
    //str  就是标签的ID
    str = str.split('?').join('');
    var article_page = document.querySelector('.article_page');
    //找到所有有这个标签的文章
    $.post('/a/tag/join_one', {'id': str})
        .then(function (r) {
            render(r);
        });

    function render(data) {
        article_page.innerHTML = '';
        data.forEach(function (item) {
            var one_div = document.createElement('div');
            var two_div = document.createElement('div');
            var thr_div = document.createElement('div');
            var foe_div = document.createElement('div');
            var tag_div = document.createElement('div');
            one_div.classList.add('one_t');
            two_div.classList.add('two_t');
            thr_div.classList.add('thr_t');
            foe_div.classList.add('foe_t');
            tag_div.classList.add('tag_t', 'btn-group', 'btn-group-xs');
            two_div.innerHTML = `<h4><a href="/detail?id=${item.article_id}">${item.title}</a></h4>`;
            thr_div.innerHTML = `<p>${item.content}</p>`;
            foe_div.innerHTML = `作者: <span class="author_name">${item.author_id}</span>&nbsp;&nbsp;&nbsp;&nbsp;
                                       <span>创建于 : ${item.create_time}</span>`;
            one_div.appendChild(two_div);
            one_div.appendChild(tag_div);
            one_div.appendChild(thr_div);
            one_div.appendChild(foe_div);
            article_page.appendChild(one_div);
            var author_name = foe_div.querySelector('.author_name');
            render_author(item.author_id, author_name);
        })
    }

    function render_author(id, aa) {
        user.read({'id': id})
            .then(function (r) {
                var data = r.data;
                var author_name = data[0]['username'];
                aa.innerText = author_name;
            })
    }

})();