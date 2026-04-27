<!DOCTYPE html>
<html lang="ru">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>VDS Mailer</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script src="{{ asset('js/jquery.fileupload.js') }}"></script>
    <script src="{{ asset('js/Sortable.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="{{ asset('js/smtp.js') }}"></script>
    <script src="{{ asset('js/mailer.js?ver='.config('app.version')) }}"></script>

    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,800&display=swap&subset=cyrillic,cyrillic-ext" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('/logo.png') }}">
    <script>var currentId = {{$digest->id}};</script>
    <style>
        .types-wrapper{
            border: 1px #00000054 solid;
            margin: 10px 0px 30px 0px;
            padding: 4px 10px;
            border-radius: 9px;
        }
        .digest-type{
            font-size: 15px;
            font-weight: bold;
            display: inline;
        }
        .types-wrapper .form-check-input{
            margin-top: 1.3rem;
        }
        .types-wrapper .form-check-label{
            cursor: pointer;
        }
        .hide,.hide-section .section-group{
            display: none;
        }
        i.fa-arrows{
            font-size: 16px;
            cursor: grab;
        }
        body{
            font-family: Arial, Helvetica, Verdana, Trebuchet MS;
            font-size: 12px;
            word-break: break-word;
        }
        .table-padding{
            padding: 42px 77px 34px 55px;
        }
        .new-header{
            padding-bottom: 16px;
        }
        .column-fit{
            height: calc(100vh - 64px);
            overflow-y: scroll;
        }
        .header-img{
            max-height: 160px;
            --margin-top: 14px
        }
        .header{
            text-align: center;
        }
        .article-daily{
            color: black !important;
            margin-top: 0;
            margin-bottom:0;
            padding-bottom: 0;
            font-size: 16px;
            line-height: 1;
            text-decoration: none;
        }
        .mb-8px{
            margin-bottom:8px;
        }
        .article-weekly{
            color: black;
            margin-top: 0;
            margin-bottom:4px;
            padding-bottom: 0;
            text-decoration: none;
        }

        .article-td{
            margin-bottom:0;
        }
        .excert-header{
            text-transform: uppercase;
            font-weight: 800;
            padding-bottom: 0;
            margin-bottom: 0;
        }
        .excert-header-daily{
            text-transform: uppercase;
            font-weight: 600;
            padding-bottom: 0;
            margin-bottom: 0;
            font-size: 16px;
        }
        .excert{
            color: black;
            margin-bottom: 15px;
            padding-bottom: 0;
        }
        .excert-daily{
            color: black;
            margin-bottom: 15px;
            padding-bottom: 0;
            font-size: 16px;
            line-height: 125%;
        }
        .excert-link{
            margin-bottom: 15px;
            padding-bottom: 0px;
            margin-bottom: 15px;
        }
        .footer-link{
            color: white;
            --padding-top: 10px;
        }
        .templateColumnContainer{
            width: 287px;
        }
        .table-container{
            max-width: 595px;
            width: 595px;
            background-color: white !important;
        }
        .section-header{
            font-size: 14px;
            font-weight: bold;
            margin-top: 0px;
            margin-bottom:16px;
        }
        .section-header-daily{
            font-size: 24px;
            font-weight: bold;
            margin-top: 0px;
            margin-bottom:16px;
        }
        @media only screen and (max-width: 480px){
            .section-header{
                --font-size: 12px !important;
            }
            .article-weekly{
                margin-top: 0px;
                --font-size: 10px !important;
            }

            #template--Columns{
                width:100% !important;
            }

            .template--ColumnContainer{
                display:block !important;
                width:100% !important;
            }

            .left--ColumnContent{
                font-size:9px !important;
                line-height:100% !important;
            }

            .right--ColumnContent{
                font-size:9px !important;
                line-height:100% !important;
            }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm mb-2">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            Главная
        </a>
    </div>
</nav>
<div class="container-fluid">

    <div class="row">
        <div class="col-4 column-fit">
            <div class="form-group pt-2">
                <button type="button" class="btn btn-primary btn-sm m-2" id="save-digest" data-id="{{$digest->id}}"></i>Сохранить дайджест</button>
                <button type="button" class="btn btn-primary btn-sm m-2" data-toggle="modal" data-target="#modal"><i class="fa fa-envelope"></i></button>
            </div>
            <div class="form-group">
                <label>Заголовок письма</label>
                <input type="text" value="{{$digest->name}}" class="form-control form-control-sm" id="mailSubject" placeholder="Обозрение от Компании VDS. Выпуск №1857 от 13.03.2020">
            </div>
            <div class="form-group">
                <label for="digestSelect">Шаблон дайджеста</label>
                <select class="form-control" id="digestSelect">
                    @foreach($digestTypes as $type)
                        <option value="{{$type->id}}">{{$type->name}}</option>
                    @endforeach
                </select>
            </div>

            <div id="news">

            </div>
            <button type="button" class="btn btn-primary btn-sm m-2" id="add-new"><i class="fa fa-plus"></i>Добавить новость</button>
        </div>
        <div class="col-8 column-fit">
            <table id="mail" class="table-container" align="center" border="0" cellpadding="0" cellspacing="0" width="595">
                <!-- Header -->
                <tr class="header">
                    <td bgcolor="#ffffff">
                        <img height="57" class="header-img" src="https://digest.vds.group/img/env-grey.png" alt="ТЭК еженедельный дайджест VDS">
                    </td>
                </tr>
                <tr>
                    <!-- Content -->
                    <td bgcolor="#ffffff" style="padding: 42px 77px 34px 55px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <!-- Articles -->
                            <tr>
                                <td>
                                    <table id="articles" border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td width="40px"><img width="11px" src="https://digest.vds.group/img/arrow.png"></td>
                                            <td><p class="article">Lorem Ipsum</p></td>
                                        </tr>
                                    </table>

                                </td>
                            </tr>
                            <!-- Excerts -->
                            <tr>
                                <td id="excerts" style="padding-top: 30px">
                                    <p class="excert-header">Lorem Ipsum</p>
                                    <p class="excert">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at bibendum nibh. Vestibulum in lorem mollis, aliquet velit id, semper ante. Nunc ultrices lacus sed lectus ullamcorper facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus vulputate justo nulla, a finibus augue auctor a. Integer consectetur aliquet diam, ut facilisis diam viverra in.</p>
                                    <p class="excert-link"><a href=""><img height="25px" src="https://digest.vds.group/img/detail-env.png" alt="Подробнее"></a></p>
                                </td>
                            </tr>
                        </table>
                    </td>

                </tr>
                <!-- Footer -->
                <tr>
                    <td id="footer" bgcolor="#8e8e8c" align="right" style="height: 48px;">
                        <table align="right" height="48"  width="160" valign="center">
                            <tr valign="center" height="48">
                                <td valign="center" height="48">
                                    <a class="footer-link" style="color: white;padding-top: 10px;text-decoration: none;" href="https://vds.group">vds.group</a>
                                </td>
                                <td valign="center" height="48">
                                    <a class="footer-link" style="color: white;padding-top: 10px;text-decoration: none;" href="https://ru.linkedin.com/company/vds-group">linkedin</a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table align="right" height="48"  width="160" valign="center">
                            <tr valign="center" height="48">
                                <td valign="center" height="48">
                                    <a class="footer-link" style="color: white;padding-top: 10px;text-decoration: none;" href="https://vds.group">vds.group</a>
                                </td>
                                <td valign="center" height="48">
                                    <a class="footer-link" style="color: white;padding-top: 10px;text-decoration: none;" href="https://www.linkedin.com/company/vds_2/">linkedin</a>
                                </td>
                                <td valign="center" height="48">
                                    <a class="footer-link" style="color: white;padding-top: 10px;text-decoration: none;" href="">vk.com/vdsgroup</a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

        </div>
    </div>
</div>

<div class="card m-2 new-template" style="display: none;">
    <div class="card-body">
        <form>
            <i class="fa fa-arrows"></i>
            <button type="button" class="close btn-close" data-dismiss="card" aria-label="Close">
                <span>×</span>
            </button>
            <div class="form-group mt-2 section-group">
                <label>Раздел</label>
                <select class="form-control form-control-sm section-select" >
                    <option value="analytics">Аналитика</option>
                    <option value="development">Развитие</option>
                    <option value="reformat">Переформатирование</option>
                    <option value="retail">Ритейл</option>
                    <option value="innovation">Инновации</option>
                    <option value="branding">Брендинг</option>
                    <option value="bigarch">Большая Архитектура</option>
                    <option value="smallarch">Малая Архитектура</option>
                    <option value="visualcom">Визуальная коммуникация</option>
                </select>
            </div>
            <div class="form-group">
                <label>Заголовок</label>
                <input type="text" class="form-control form-control-sm article-header">
            </div>
            <div class="form-group">
                <label >Изображение(опционально)</label>
                <form action="" method="post">
                    {{ csrf_field() }}
                    <div class="custom-file"  lang="ru">
                        <input type="file" class="custom-file-input fileupload" name="photos[]" data-url="/upload" aria-describedby="fileHelp">
                        <label class="custom-file-label" for="fileupload">
                            Выберите файлы...
                        </label>
                        <p class="loading"></p>
                    </div>
                    <img alt="" class="py-2" style="max-width: 100%;max-height: 100%;display: block;">
                    <button type="button" class="btn btn-primary btn-sm py-2 btn-img-delete hide" >Удалить изображение</button>
                </form>
            </div>
            <div class="form-group">
                <label>Краткое содержание новости</label>
                <textarea class="form-control form-control-sm"  rows="3"></textarea>
            </div>
            <div class="form-group">
                <label>Ссылка на статью</label>
                <input type="text" class="form-control form-control-sm article-link">
            </div>
        </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Список получателей</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @foreach($subscriptions as $s)
                    <div class="custom-control custom-radio pb-2">
                        <input class="custom-control-input" type="radio" name="list" id="sub-{{$s->id}}" value="{{$s->id}}" @if($s->id==1)checked @endif>
                        <label class="custom-control-label h5" for="sub-{{$s->id}}">
                            {{$s->name}}
                        </label>
                    </div>
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" id="send">Отправить</button>
                <div id="spinner" class="spinner-grow text-primary" style="width: 1.3rem; height: 1.3rem; display: none;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Template Modal -->
<div class="modal fade" id="modal-template" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle2">Выбор шаблона дайджеста</h5>
{{--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>--}}
            </div>
            <div class="modal-body">
                <div>
                @foreach($digestTypes as $type)
                    <div class="types-wrapper">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="templateRadios" id="radio-{{$type->id}}" value="{{$type->id}}" >
                            <label class="form-check-label" for="radio-{{$type->id}}">
                                <div class="digest-type">{{$type->name}}</div>
                                <img src="{{ URL::asset('/img/'.$type->image) }}" alt="">
                            </label>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
            <div class="modal-footer">
                {{--<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>--}}
                <button type="button" class="btn btn-primary" id="pick">Выбрать</button>
            </div>
        </div>
    </div>
</div>

</body>
</html>
