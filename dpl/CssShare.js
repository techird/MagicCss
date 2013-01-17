baidu(function(){
    function fixTab(str) {
        var arr, i, line, spaces, min_spaces;
        str = str.replace(/\t/g, '    ');
        arr = str.split('\n');
        for (i in arr) {
            line = arr[i];
            if(!/\S/.test(line)) continue;
            spaces = /^ +/.exec(line);
            if(!min_spaces || spaces && spaces[0].length < min_spaces.length) min_spaces = spaces[0];
        }
        if(!min_spaces) return str;
        for (i = 0; i < arr.length; i++) {
            arr[i] = arr[i].substr(min_spaces.length);
        }
        while(!/\S/.test(arr[0])) arr.shift();
        while(!/\S/.test(arr[arr.length-1])) arr.pop();
        return arr.join('\n');
    }
    var $nav = baidu('<ul>').appendTo(baidu('<div class="nav">').appendTo('body'));
    var section_pos = [];
    var padding_top = 130;
    function makeNavFor( $section ) {
        var section_top = $section.offset().top;
        var title = $section.children('h2').text();
        var $li = baidu('<li>').appendTo($nav);
        var $a = baidu('<a></a>')
            .text(title)
            .data('target', $section)
            .click(onNavClick)
            .appendTo($li);
        $section.data('nav', $a);
    }
    function onNavClick( e ) {
        var target = baidu(e.target).data('target');
        baidu('body').scrollTop(target.offset().top-padding_top);
        updateCurrentNav();
    }

    var $sections = baidu('div.section');
    $sections.each(function(index, section){
        var $section = baidu(section);
        var $link = $section.children('link');
        var $example = $section.children('div.example-html');
        baidu.ajax({
            url: $link.attr('href'),
            type: 'GET',
            dataType: 'text',
            success: function( cssContent ) {
                var $code = baidu('<pre>').text(cssContent).addClass('prettyprint').addClass('css');
                $link.after($code);
                prettyPrint();
            }
        });
        var html_code = fixTab($example.html());
        var $example_code = baidu('<pre>').text(html_code).addClass('prettyprint').addClass('html');
        $example.before($example_code);
        makeNavFor($section);
    });
    function updateCurrentNav (){
        var bt = baidu('body').scrollTop() + padding_top, range = 10;
        $sections.each(function(index, section) {
            var $section = baidu(section);
            var st = $section.offset().top,
                sh = $section.height();
            if( bt > st - range && bt < st + sh ) {
                baidu('.nav a.current').removeClass('current');
                $section.data('nav').addClass('current');
            }
        });
    }
    baidu(window).scroll(updateCurrentNav);
    updateCurrentNav();
    prettyPrint();
});