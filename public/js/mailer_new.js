var template;
var email;
var header_img, footer_img, templates, footer_color, btn_img, subHeaderText;

var empty_space_15 = `<table border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td height="15" valign="top">
      </td>
    </tr>
</table>`;

function empty_space(pixels){
    return `<table border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td height="`+pixels+`" valign="top">
      </td>
    </tr>
</table>`
}

$( document ).ready(function() {
    //initTemplates();
    changeTemplate($("#digestSelect").val());
    console.log( "ready!" );
    template = $('.card').clone();
    template.hide();

    $( "#add-new" ).click(function() {

        $(template).clone().appendTo('#news').show('slow');

        var el = document.getElementById('news');
        var sortable = new Sortable(el, {
            handle: '.fa-arrows', // handle's class
            animation: 250,
            onUpdate: function (/**Event*/evt) {
                contentChanged();
            },
        });
        bindEvents();
    });

    $( "#send" ).click(function() {
        console.log('start sending');
        $( "#send" ).prop( "disabled", true );
        $("#spinner").show();
        let body = $('#mail').html();
        //body = body.replace('/tbody/g','table');
        body = body.split('tbody').join('table');
        //console.log(body);
/*        digest = $("#digestSelect").val();
        if (digest = 'retail-weekly')
            sendEmailWeekly(body);
        else
            sendEmail(body);*/
        sendEmail(body);
    });

    $("#digestSelect").change(function () {
        let val = $( this ).val();
        console.log(val);
        changeTemplate(val);
        contentChanged();
    });

    $("#save-digest").click(function () {
        console.log(this);
        saveDigest(this.getAttribute('data-id'));
    });

    contentChanged();

    loadDigest();
});

function loadDigest() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let jqxhr = $.ajax({
        url: "/digest/" + currentId + '/json',
        type: "GET",
    })
        .done(function(data) {
            console.log(data);
            if (data.template) {
                $("#digestSelect").val(data.template);
                changeTemplate( $("#digestSelect").val() );
            }
            //let response = jQuery.parseJSON(data);
            let news = data.news;
            news.forEach(function (article) {
                let temp = $(template).clone();
                temp.find('input.article-header').val(article.headline);
                temp.find('textarea').val(article.excert);
                temp.find('input.article-link').val(article.href);
                temp.find('.section-select').val(article.section);

                if (article.img) {
                    let el = temp.find('.fileupload');
                    $(el).parent().siblings('img').attr('src', article.img);
                    $(el).parent().siblings('button').removeClass('hide');
                    $(el).parent().closest('.custom-file').addClass('hide');
                }
                temp.appendTo('#news').show();
                console.log(article);
/*                'headline' : card.find('input.article-header').val(),
                    'excert' : card.find('textarea').val(),
                    'href' : card.find('input.article-link').val(),
                    'section' : card.find('.section-select').val(),  */
            })

            let el = document.getElementById('news');
            let sortable = new Sortable(el, {
                handle: '.fa-arrows', // handle's class
                animation: 250,
                onUpdate: function (/**Event*/evt) {
                    contentChanged();
                },
            });

            bindEvents();
            contentChanged();
        })
        .fail(function() {
            alert( "Ошибка загрузки" );
        })
        .always(function() {
        });
}

function saveDigest(id) {
    console.log('save ', id);
    let news = [];
    $("#news .card").each(function () {
        let card = $(this);
        let img = card.find('img').attr('src');
        console.log(img);
        news.push({
            'headline' : card.find('input.article-header').val(),
            'excert' : card.find('textarea').val(),
            'href' : card.find('input.article-link').val(),
            'section' : card.find('.section-select').val(),
            'img' : img || "",
        });
    });
    let name = $('#mailSubject').val().trim() || 'Дайджест';

    let data = {
        'id' : id,
        'name' : name,
        'template' : $("#digestSelect").val(),
        'news': news,
    };

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    console.log(data);

    let jqxhr = $.ajax({
        url: "/digest/" + id,
        type: "PATCH",
        dataType: "json",
        //data: JSON.stringify(data),
        data: data,
        })
        .done(function(data) {

        })
        .fail(function() {
            alert( "Ошибка сохранения" );
        })
        .always(function() {
        });
}

function changeTemplate(template) {
    switch (template) {
        case 'enviroment':
            header_img = 'https://digest.vds.group/img/env-grey.png';
            footer_color = '#8e8e8c';
            header_color = '#ffffff';
            btn_img = 'https://digest.vds.group/img/detail-env.png';
            subHeaderText = "Актуальные новости городской среды";
            break;
        case 'retail-daily':
            header_img = 'https://digest.vds.group/img/retail-daily.png';
            footer_color = '#93272c';
            header_color = '#ffffff';
            btn_img = 'https://digest.vds.group/img/detail.png';
            subHeaderText = "Актуальные новости топливного ритейла";
            break;
            case 'retail-weekly':
            header_img = 'https://digest.vds.group/img/tek-weekly-white.png';
            footer_color = '#93272c';
            header_color = '#93272c';
            btn_img = 'https://digest.vds.group/img/detail.png';
            subHeaderText = "Актуальные новости топливного ритейла";
            break;
        case 'india':
            header_img = 'https://digest.vds.group/img/india.png';
            footer_color = '#0e601f';
            header_color = '#ffffff';
            btn_img = 'https://digest.vds.group/img/detail-india.png';
            subHeaderText = "Актуальные новости топливного ритейла в Индии";
            break;
    };
    $('.header img').attr("src",header_img);
    $('.excert-link img').attr("src",btn_img);
    $('#footer').attr("bgcolor",footer_color);
    $('.header td').attr("bgcolor",header_color);

/*    if (template == 'retail-weekly' || template == 'india') {
        $('body').removeClass('hide-section')
    } else {
        $('body').addClass('hide-section');
    }*/
}

function bindEvents() {
    $(".btn-close").click(function () {
        var form = $(this).closest('.card');
        console.log(this,form);
        form.hide("slow", function() {
            $(this).remove();
            contentChanged();
        });
    });

    $("input, textarea, select").on('input',function () {
        contentChanged();
    });

    $('.btn-img-delete').click(function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        console.log(this);
        let el = $(this);
        el.siblings('.custom-file').removeClass('hide');
        el.siblings('img').removeAttr('src');
        el.addClass('hide');

        contentChanged();
    });

    $('.fileupload').fileupload({
        dataType: 'json',
        sequentialUploads: true,
        add: function (e, data) {
            console.log('add', e, data);
            console.log(data.files, data.files[0].name);
            data.submit();
        },
        send: function (e, data) {
            console.log('send', this, e, data);
            console.log(data.files, data.files[0].name);
            $(this).siblings('.loading').html('<div style="margin-top: 16px;" class="spinner-grow text-primary" role="status">\n' +
                '  <span class="sr-only">Загрузка...</span>\n' +
                '</div>');
        },
        done: function (e, data) {
            console.log('done', e, data);
            let el = $(this);
            $.each(data.result.files, function (index, file) {
                console.log(file);

                $(el).parent().siblings('img').attr('src', file.url);
                $(el).parent().siblings('button').removeClass('hide');
                $(el).parent().closest('.custom-file').addClass('hide');

                bindEvents();
                contentChanged();
            });

        },
        fail: function (e, data) {
            console.log('fail', e, data);
        },
        always: function (e, data) {
            console.log('always', this, e, data);
            $(this).siblings('.loading').text('');
        },
    });
}

function contentChanged() {
    let news = [];
    let counter = 0;
    $("#news .card").each(function () {
        let card = $(this);
        let img = card.find('img').attr('src');
        console.log(img);
        news.push({
            'headline' : card.find('input.article-header').val(),
            'excert' : card.find('textarea').val(),
            'href' : card.find('input.article-link').val(),
            'section' : card.find('.section-select').val(),
            'id' : 'new-' + counter,
            'img' : img,
            //'img' : 'https://digest.vds.group/photos/21xtVBWb74OO6vzLbLIYLk83jEvWYDriO7azNNe0.jpeg',
        });
        counter++;
    });

    console.log(news);

    let articles = $('#articles').empty();
    news.forEach(function (el) {
        //console.log(el.headline);

        //$('<div class="article">' + el.headline + '</div>').appendTo(articles);
        $(`<tr>
<td width="40px" ><img style="margin-bottom:0;" width="11px" src="https://vds.group/mail-template/arrow-big.png"></td>
<td><p class="article" style="margin-bottom:0;">`+ el.headline +`</p></td>
</tr>`).appendTo(articles);
    })

    let excerts = $('#excerts').empty();
    news.forEach(function (el) {
        //console.log(el.headline);
        $('<div class="excert-header">' + el.headline + '</div>').appendTo(excerts);
        $('<div class="excert">' + el.excert + '</div>').appendTo(excerts);
        if(el.href != "")
            $('<p class="excert-link"><a href="'+el.href+'"><img height="25" width="92" src="'+btn_img+'" alt="Подробнее"></a></p>').appendTo(excerts);
    })

    digest = $("#digestSelect").val();
    console.log(digest);
/*    if (digest == 'retail-weekly' || digest == 'india')
        makeWeekly(news);
    else
        makeEmail(news);*/
    makeEmail(news);
}

function makeEmail(news) {
    let articles = "";
    let artAnalytics = artReformat = artDev = artInn  = [];
    artAnalytics = news.filter( n => n.section == 'analytics');
    artDev = news.filter( n => n.section == 'development');
    artReformat = news.filter( n => n.section == 'reformat');
    artRetail = news.filter( n => n.section == 'retail');
    artInn = news.filter( n => n.section == 'innovation');
    artBrand = news.filter( n => n.section == 'branding');
    artBigArch = news.filter( n => n.section == 'bigarch');
    artSmallArch = news.filter( n => n.section == 'smallarch');
    artVisual = news.filter( n => n.section == 'visualcom');

    newsGrouped = [artAnalytics, artDev, artReformat, artRetail,artInn, artBrand,artBigArch,artSmallArch,artVisual];
    newsGrouped = newsGrouped.filter( n => n.length > 0);

    console.log(newsGrouped);

    newsGrouped.forEach( function (el,index){

        let section = el[0].section;
        let headerText = '';//section == 1 ? 'АНАЛИТИКА' : section == 2  ? 'ПЕРЕФОРМАТИРОВАНИЕ АЗС' : section == 3 ? 'РАЗВИТИЕ' : section == 4 ? 'РАЗВИТИЕ' : 'РИТЕЙЛ';
        switch (section) {
            case 'analytics' :
                headerText = 'АНАЛИТИКА';
                break;
            case 'development' :
                headerText = 'РАЗВИТИЕ';
                break;
            case 'reformat' :
                headerText = 'ПЕРЕФОРМАТИРОВАНИЕ';
                break;
            case 'retail' :
                headerText = 'РИТЕЙЛ';
                break;
            case 'innovation' :
                headerText = 'ИННОВАЦИИ';
                break;
            case 'branding' :
                headerText = 'БРЕНДИНГ';
                break;
            case 'bigarch' :
                headerText = 'БОЛЬШАЯ АРХИТЕКТУРА';
                break;
            case 'smallarch' :
                headerText = 'МАЛАЯ АРХИТЕКТУРА';
                break;
            case 'visualcom' :
                headerText = 'ВИЗУАЛЬНАЯ КОММУНИКАЦИЯ';
                break;
            default :
                headerText = 'НОВОСТИ';
                break;
        }
        //console.log(el,leftHeader,'!!');
        /*        leftHeader = `<table border="0" cellpadding="0" cellspacing="0"><tr>
        <td width="20" valign="top"><p style="color:#93272c;font-weight:600;margin-bottom:0;margin-top:0;">\`+letter+\`</p></td>
        <td>`*/

        let content = `<table border="0" cellpadding="0" cellspacing="0"><tr>
<td width="5%" valign="top"><img height="24" style="margin-bottom:0;" src="https://digest.vds.group/img/arrow-big2.png"></td>
<td valign="top"><p style="font-size:24px !important;font-weight: bold;margin-top: 0px;margin-bottom:16px;margin-top:0;font-weight:600;line-height:1;color: black !important;">`+headerText+`</p></td></tr>`;

        el.forEach(function (el,index) {
            content = content + `<tr>
<td width="5%" valign="top"><img height="17"  style="margin-bottom:0;" src="https://digest.vds.group/img/bullet3.png"></td>
            <td valign="top"><a style="color:black;margin-top: 0;margin-bottom:0;padding-bottom: 0;font-size: 16px;line-height: 1;text-decoration: none;" href="#`+el.id+`">`+ el.headline +`</a>
            `+empty_space(16)+`
            </td>
        </tr>`;
        });

        articles = articles + content +  '</table>' +empty_space_15;
    });
/*    news.forEach(function (el, index) {
        articles = articles + `<tr >
<td width="40" valign="top"><img class="" width="18" src="https://vds.group/mail-template/arrow-padding.png"></td>
<td valign="top"><a class="article-daily" style="text-decoration: none; color:black;" href="#new`+index+`">`+ el.headline +`</a></td>
</tr>`;
    });*/

    let excerts = "";
    news.forEach(function (el, index) {
        console.log(el.headline);
        excerts = excerts.concat('<a name="'+el.id+'" style="text-transform: uppercase;font-weight: 600;padding-bottom: 0;margin-bottom: 0;font-size: 16px;display:block;text-decoration: none; color:black;">' + el.headline + '</a>');
        excerts = excerts.concat(empty_space_15);
        if (el.img != undefined) {
            excerts = excerts.concat('<img border="0" width="600" style="display:block;margin:0 auto;max-width:595px;width:100%;height:auto;" src="'+ el.img +'">');
            excerts = excerts.concat(empty_space_15);
        }

        excerts = excerts.concat('<div style="color: black;margin-bottom: 15px;padding-bottom: 0;font-size: 16px;line-height:1;" >' + el.excert + '</div>');
        if(el.href != "")
            excerts = excerts.concat('<p style="margin-bottom: 15px;padding-bottom: 0;margin-bottom: 15px;"><a href="'+el.href+'"><img height="30" src="'+btn_img+'" alt="Подробнее"></a></p>');
    })

    let body = `<table  id="mail" class="table-container" style="max-width: 595px;width: 595px;background-color: white !important;" align="center" border="0" cellpadding="0" cellspacing="0">
<tr><td><div style="color:white !important;FONT-SIZE: 1px; OVERFLOW: hidden; MAX-WIDTH: 0px; DISPLAY: none !important; LINE-HEIGHT: 1px; MAX-HEIGHT: 0px; VISIBILITY: hidden; mso-hide: all; opacity: 0">`+ subHeaderText+`</div></td></tr>
                        <!-- Header -->
                        <tr style="text-align: center;" align="center">
                            <td bgcolor="`+header_color+`">
                                <img height="64" style="max-height: 160px;" src="` + header_img + `" alt="Дайджест VDS">
                            </td>
                        </tr>
                        <tr>
                            <!-- Content -->
                            <td bg--color="#ffffff" style="padding: 42px 9% 34px 9%">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <!-- Articles -->
                                    <tr>
                                        <td>
                                            `
                                                + articles +
                                            `
                                        </td>
                                    </tr>
                                    <!-- Excerts -->
                                    <tr>
                                        <td id="excerts" style="padding-top: 30px">
                                            <table border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td width="5%" valign="top"><img style="margin-bottom:0;" src="https://digest.vds.group/img/arrow-empty.png"></td>
                                                    <td valign="top">`+excerts+`</td>
                                                </tr>                                        
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>

                        </tr>
                        <!-- Footer -->

                    </table>`;
/*
    body = body +
`<table  id="footer" class="" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;width:100% ! important;border: none !important;">
                        <tr width="100%" style="min-width: 100%;width:100% ! important;border: none !important;">
                            <td width="100%" bgcolor="` + footer_color + `" align="right" style="height: 50px;min-width: 100%;width:100% ! important;border: none !important;">
                                <table  bgcolor="` + footer_color + `" align="center" border="0" cellpadding="0" cellspacing="0" width="595" >
                                    <tr><td>
                                        <table bordercolor="`+footer_color+`" bgcolor="` + footer_color + `" class="footer-table" border="0" cellpadding="0" cellspacing="0"  align="right" width="160" style="min-width: 160px!important;" >
                                            <tr bordercolor="`+footer_color+`">
                                                <td bordercolor="`+footer_color+`" style="min-width:80px;">
                                                    <a class="footer-link" style="height: 48px;color: white;text-decoration: none;" href="https://vds.group">vds.group</a>
                                                </td>
                                                <td>
                                                    <a class="footer-link" style="height: 48px;color: white;text-decoration: none;" href="https://www.linkedin.com/company/vds_2/">linkedin</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td></tr>
                                </table>
                            </td>
                        </tr>
</table>`;
*/
    body +=
        `<table  id="footer"  bgcolor="`+footer_color+`" class="" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;width:100% ! important;border: none !important;">
            <tr><td>`+empty_space(18)+`</td></tr>
            <tr><td>
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="595">
                <tr>
                    <td align="right" >
                        <a style="color: white;padding-right: 0;padding-bottom: 0;margin-bottom: 0;margin-right: 16px;height: 14px;text-decoration: none;" href="https://vds.group">vds.group</a>                                       
                        <a style="color: white;padding-right: 0;padding-bottom: 0;margin-bottom: 0;margin-right: 16px;height: 14px;text-decoration: none;" href="https://www.linkedin.com/company/vds_2/">linkedin</a>
                    </td>
                </tr>
                </table>
            </td></tr>
            <tr><td>`+empty_space(18)+`</td></tr>
</table>`;

    email = body;

    $('.col-8.column-fit').html(email);
    return email;
}

function sendEmail(body) {
    let subject = $('#mailSubject').val().trim();
    if (subject === ""){
        subject = 'Дайджест';
        //alert("Необходимо заполнить заголов письма!");
        //unlockUI();
        //return;
    }

console.log(email); //return;
    Email.send({
/*        Username : "cb920b59739917",
        Password : "17c89e4d103c72",
        Host : "smtp.mailtrap.io",*/
        Host : "smtp.yandex.ru",
        Password : "KJkjgfnf123",
        Username : "alexlisp@tut.by",
        To : ['aliaksandraua@gmail.com','aliaksandrau@live.com','aliaksei.aliaksandrau@mail.ru'],
        //To : ['aliaksandraua@gmail.com','aliaksandrau@live.com','a.sevkovich@vds.by'],
        //To : ['aliaksandraua@gmail.com','aliaksandrau@live.com','a.vasiliev@vds.by'],
        //To : ['aliaksandraua@gmail.com','aliaksandrau@live.com','viktoribat66@gmail.com','aea@vds.by','a.vasiliev@vds.by'],
        //To : ['a.gladkiy@vds.by','aliaksandraua@gmail.com','aliaksandrau@live.com'],
        //To : ['viktoribat66@gmail.com','aea@vds.by','a.vasiliev@vds.by','iav@vds.by','o.konoplyanik@vds.by','aliaksandrau@live.com','aliaksandraua@gmail.com','a.gladkiy@vds.by'],
        From : "alexlisp@tut.by",
        Subject : subject,
        Body : `<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">   
 <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Email Design VDS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">  
  
<!--[if gte mso 9]>
    <style type="text/css">
         .footer-table{   
            margin-top: 13px;
         }        
    </style>
<![endif]-->

     
    </head>
<body style="font-family: Arial, Helvetica, Verdana, Trebuchet MS;font-size: 12px;word-break: break-word;color: black;">
`
+ email + '</body></html>'
    }).then(
        function (message) {
            unlockUI();
            alert('Статус отправки письма: ' + message);
        }
    );
}
function unlockUI() {
    $( "#send" ).prop( "disabled", false );
    $("#spinner").hide();
}
