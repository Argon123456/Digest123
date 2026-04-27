
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

        remove: function(key) {
            console.log(key);
            return $.ajax({
                url: window.location + "/unsubscribe/" + key.id,
                method: "GET",
            });
        }

    });

    $("#gridContainer").dxDataGrid({
        dataSource: datasource,
        deleteUrl: window.location + '/unsubscribe',
        /*selection: {
            mode: "single"
        },*/
        allowColumnReordering: true,
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
        editing: {
            mode: "row",
            //allowUpdating: true,
            allowDeleting: function(e) {
                return true;
            },
            useIcons: true,
        },

        columns: [{
            type: "buttons",
            width: 50,
            buttons: [/*"edit",*/ {
                name: "delete",
/*                onClick: function(e) {
                    console.log(e.row.key)
                    console.log(this)
                }*/
            }, /*{
                hint: "Clone",
                icon: "repeat",
                visible: function(e) {
                    return !e.row.isEditing;
                },
                onClick: function(e) {

                }
            }*/]
        },{
            caption : "Имя",
            dataField: "name",
        }, {
            caption : "Должность",
            dataField: "position",
        }, {
            caption : "Компания",
            dataField: "company.name",
        }, {
            caption : "email",
            dataField: "email",
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
        onRowRemoving: function (e) {
            console.log(e);
/*            var dxDialogPromise = DevExpress.ui.dialog.confirm("Are you sure you want to remove " + 'e.data.Email' + "?", "Delete row");

            e.cancel = $.Deferred(function (deferred) {
                dxDialogPromise.done(function (result) {
                    deferred.resolve(!result);
                });
            }).promise();*/
        },
        onRowRemoved: function(e) {
            console.log("RowRemoved");
        }

    });

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

    $('#addContacts').click(function() {
        let grid = $("#gridContacts").dxDataGrid("instance");
        let keys = grid.getSelectedRowKeys();
        keys = keys.map(a => a.id);
        console.log(keys);

        var jqxhr = $.post( window.location +"/subscribe", {keys : keys} )
            .done(function(data) {
                let grid = $("#gridContainer").dxDataGrid("instance");
                grid.refresh();
            })
            .fail(function() {
                alert( "error" );
            })
            .always(function() {
                $('.modal').modal('hide');
            });
    });

});

