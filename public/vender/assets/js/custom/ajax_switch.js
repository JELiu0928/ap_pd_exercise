/* ============================================================

 * cms.js

 * ============================================================ */





$(document).ready(function () {



    active_lbox();



});









/*lightbox啟動按鈕綁定*/

var lbox_checked = false;



function active_lbox() {



    var lbox_switch = $('.ajax-open');





    lbox_switch.on('click', function () {



        if (lbox_checked == false) {



            var a = $(this).attr('ajax-page');

            var b = $(this).attr('ajax-id');



            lbox(a, b);



            lbox_checked = true;



        }



    });



}







/*啟動lightbox*/

function lbox(lbox_page, lbox_name) {



    $.ajax({

        url: lbox_page,

    })

        .done(function (data) {



            //每次ajax都會先把 body下的除了 .page-sidebar 這個標籤以外的dom刪除

            $('body > *').each(function () {



                if ($(this).hasClass('extract-block') == true) {



                    $(this).remove();



                }



            });





            //把結構塞入 body 的 .page-sidebar 的後面

            $('body .page-sidebar').after(data);





            //ajax後對被呼叫進來的dom做所需功能的綁定

            setTimeout(function () {



                bind_dom();



                //

                $('[data-init-plugin="select2"]').select2();



            }, 500);





            //ajax結束 把lbox_checked改回false

            lbox_checked = false;



        })



}

