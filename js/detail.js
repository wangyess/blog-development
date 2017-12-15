;(function () {
    'use strict';
    var article_page = document.querySelector('.article_page');
    var article = new Model('article');
    var tag = new Model('tag');
    var user = new Model('user');
    var str = location.search;
    //str  就是被点击这条数据的ID;
    str = str.split('?id=').join('');
    //获取article表单数据
    article.read({'id': str})
        .then(function (r) {
            render(r.data)
        });

    //渲染数据到页面上
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
            two_div.innerHTML = `<h4><a href="/detail">${item.title}</a></h4>`;
            thr_div.innerHTML = `<p>${item.content}</p>`;
            foe_div.innerHTML = `作者: <span class="author_name">${item.author_id}</span>&nbsp;&nbsp;&nbsp;&nbsp;
                                     <span>创建于 : ${item.create_time}</span>`;
            one_div.appendChild(two_div);
            one_div.appendChild(tag_div);
            one_div.appendChild(thr_div);
            one_div.appendChild(foe_div);
            article_page.appendChild(one_div);
            var author_name = foe_div.querySelector('.author_name');
            tag_article(item.id, tag_div);
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

    function tag_article(id, tag_div) {
        $.post('/a/tag/join_two', {'id': id})
            .then(function (r) {
                render_tag(r, tag_div);
            })
    }

    function render_tag(data, el) {
        data.forEach(function (item) {
            var k_div = document.createElement('span');
            k_div.classList.add('tag_item', 'btn', 'btn-info');
            k_div.innerText = item.title;
            el.appendChild(k_div);
        })
    }
})();