//Quill Crirle Program Bar

//DOM
function quillCircleBarDom( _element ){

    var _container = '<div class="progress_circle"></div>';

    var _pie = '<div class="pie"></div>',
        _shadow = '<div class="shadow"></div>'

    var _left = '<div class="left_circle half_circle"></div>',
        _right = '<div class="right_circle half_circle"></div>';

    //adding DOM
    _element.addClass('active').append( _container );
    _element.find('.progress_circle').append( _pie ).append( _shadow );
    _element.find('.pie').append( _left ).append( _right );
}

//基本款
function normal_circle_progress( name, value ){
    //EX: normal_circle_progress('.cola_1',20);
    //這裡的value就是目前跑到幾%的數值
    var _this = name;
        _pie = _this.find('.pie');

    var L_circle = name.find('.left_circle'),
        R_circle = name.find('.right_circle');

    var a = _this.outerWidth(),
        b = _this.outerWidth() / 2

    _this.find('.progress_circle').attr('data-value',value);

    if ( value <= 50 ) 
    {
        var deg = value * 3.6;
        _pie.css('clip', 'rect(0, '+ a +'px, '+ a +'px, '+ b +'px)');

        L_circle.css({
            transform: 'inherit',
            clip: 'rect(0, '+ b +'px, '+ a +'px, 0)',
        });
        R_circle.css({
            transform: 'rotate(' + deg + 'deg)',
            clip: 'rect(0, '+ b +'px, '+ a +'px, 0)',
        });
        
    }
    else 
    {
        var deg = value * 3.6;
        _pie.css('clip', 'rect(auto, auto, auto, auto)');

        L_circle.css({
            transform: 'rotate(' + deg + 'deg)',
            clip: 'rect(0, '+ b +'px, '+ a +'px, 0)',
        });

        R_circle.css({
            transform: 'rotate(180deg)',
            clip: 'rect(0, '+ b +'px, '+ a +'px, 0)',
        });
    }
}

//總數款
function total_circle_progress( name, total, goal ){
    //EX: total_circle_progress('.cola_9999',20,10);
    //這裡的total 就是 總數
    //這裡的goal  就是 完成數
    var _this = name,
        step = 360 / total,
        goal_step = step * goal,
        _pie = _this.find('.pie');

    var L_circle = name.find('.left_circle'),
        R_circle = name.find('.right_circle');

    var a = _this.outerWidth(),
        b = _this.outerWidth() / 2

    _this.find('.progress_circle').attr('data-value', goal + '/' + total);

    var walk_step = step / 3.6;

    if ( goal != 0 ) {
        for (var index = 1; index <= walk_step; index++) {
            var time = index * 100;    
            let deg = ( 3.6 * index ) + ( step * ( goal - 1 ) );    
    
            if ( deg <= 180 ) 
            {    
                _pie.css('clip', 'rect(0, '+ a +'px, '+ a +'px, '+ b +'px)');

                L_circle.css({
                    transform: 'inherit',
                    clip: 'rect(0, '+ b +'px, '+ a +'px, 0)',
                });    
                R_circle.css({
                    transform: 'rotate(' + deg + 'deg)',
                    clip: 'rect(0, '+ b +'px, '+ a +'px, 0)',
                });                    
            }
            else 
            {    
                _pie.css('clip', 'rect(auto, auto, auto, auto)');

                L_circle.css({
                    transform: 'rotate(' + deg + 'deg)',
                    clip: 'rect(0, '+ b +'px, '+ a +'px, 0)',
                });    
                R_circle.css({
                    transform: 'rotate(180deg)',
                    clip: 'rect(0, '+ b +'px, '+ a +'px, 0)',
                });    
            }            
        }            
    }
}

//quillCircleBar 主體
(function ( $ ) {

    //預設值屬性   
    var setting = {
        type: 'normal',
        number: 0,
        baseNumber: 0,
    };

    $.fn.quillCircleBar = function( options ) {

        //支援JQuery選擇器   
        //支援鏈式呼叫
        return this.each(function () {

             //將 option s的內容合併到 chOptions 中。
            var chOptions = $.extend( setting, options );
            var _this = $(this);

            if ( _this.hasClass( 'active' ) == false ) 
            {    
                quillCircleBarDom( _this );

                switch( chOptions.type ) {
                    case 'normal':
                        _this.attr('circle-type','normal');
                        normal_circle_progress( _this, 0 );
                        break;

                    case 'total':
                        _this.attr('circle-type','total');
                        total_circle_progress( _this, 0, 0 );
                        break;

                    default:
                        console.log('請輸入正確的樣式');
                }    
            }
            else
            {
                var circle_type = _this.attr('circle-type');

                switch( circle_type ) {
                    case 'normal':
                        normal_circle_progress( _this, chOptions.number );
                        break;

                    case 'total':
                        total_circle_progress( _this, chOptions.baseNumber, chOptions.number );
                        break;

                    default:
                        console.log('請輸入正確，好嗎??');
                }
            }
        });  

    };
}( jQuery ));