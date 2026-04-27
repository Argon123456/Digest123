
jQuery( document ).ready(function() {
    console.log(navigator.language);
    DevExpress.localization.locale('ru-RU');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let datasource = new DevExpress.data.CustomStore({

        load: function(loadOptions) {
            return $.getJSON(window.location +"/json");
        },

    });

    $("#gridContainer").dxDataGrid({
        dataSource: datasource,
        allowColumnReordering: true,
        //columnAutoWidth: true,
        grouping: {
            autoExpandAll: true,
        },
        groupPanel: {
            visible: true
        },
        scrolling: {
            mode: "virtual"
        },
        hoverStateEnabled: true,
        filterRow: {
            visible: true,
            applyFilter: "auto"
        },
        searchPanel: {
            visible: true,
            width: 240,
            placeholder: "Поиск..."
        },
        headerFilter: {
            visible: true
        },
        columns: [{
            type: "buttons",
            width: 50,
            buttons: [{
                name: "info",
                icon: "info",
                onClick: function (e) {
                    let id = e.row.data.id;
                    console.log(e.row.data.id);
                    $('.modal').modal('show');
                    $('#mailBody').empty().append('<iframe width="700" height="1000" src="'+window.location +"/" +e.row.data.id+ "/iframe" + '" frameborder="0" allowfullscreen=""></iframe>');;
                }
            }]
        },{
            caption : "Дата",
            dataField: "created_at",
            dataType: "datetime",
            width: 150,
        },{
            caption : "email",
            dataField: "email",
        }, {
            caption : "Заголовок",
            dataField: "subject",
        }, {
            caption : "Статус",
            dataField: "status",
            width: 80,
        }, {
            caption : "Просмотрено",
            dataField: "opened",
            dataType: "boolean",
            width: 80,
        }, {
            caption : "Открыто",
            dataField: "updated_at",
            dataType: "datetime",
            width: 150,
        }, {
            caption : "Ошибка",
            dataField: "error",
        }],
        showBorders: true,
        summary: {
            totalItems: [{
                column: "name",
                summaryType: "count"
            }],
            groupItems: [{
                column: "id",
                summaryType: "count",
                //displayFormat: "{0} orders",
            }]
        },
    });

/*
    $('.modal').on('shown.bs.modal', function () {
        if ($("#gridContacts").data('dxDataGrid')) {
            $("#gridContacts").dxDataGrid("instance").refresh();
            return;
        }
        $("#gridContacts").dxDataGrid({
            dataSource: window.location + "/contacts",
            selection: {
                mode: "multiple"
            },
            scrolling: {
                mode: "virtual"
            },
            hoverStateEnabled: true,
            filterRow: {
                visible: true,
                applyFilter: "auto"
            },
            searchPanel: {
                visible: true,
                width: 240,
                placeholder: "Поиск..."
            },
            headerFilter: {
                visible: true
            },
            columns: [{
                caption: "Имя",
                dataField: "name",
            }, {
                caption: "Должность",
                dataField: "position",
            }, {
                caption: "Компания",
                dataField: "company.name",
            }, {
                caption: "email",
                dataField: "email",
            }],
            showBorders: true,

        });
    })
*/


});

