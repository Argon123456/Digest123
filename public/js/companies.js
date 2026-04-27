jQuery( document ).ready(function() {
    DevExpress.localization.locale('ru-RU');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    let datasource = new DevExpress.data.CustomStore({
        load: function(loadOptions) {
            return $.getJSON(window.location +"/all");
        },
        insert: function(values) {
            console.log(values);
            return $.ajax({
                url: window.location + "/create",
                method: "POST",
                data: {values : values},
            });
        },
        update: function(key,values) {
            console.log(key,values);
            return $.ajax({
                url: window.location + "/update",
                method: "POST",
                data: {key: key, values : values},
            });
        },
        remove: function(key) {
            console.log(key);
            return $.ajax({
                url: window.location + "/" + key.id,
                method: "DELETE",
            });
        }
    });

    $("#gridCompanies").dxDataGrid({
        dataSource: datasource,
        editing: {
            mode: "row",
            allowUpdating: true,
            allowAdding: true,
            allowDeleting: function(e) {
                return true;
            },
            useIcons: true,
        },
        scrolling: {
            mode: "virtual"
        },
        groupPanel: {
            visible: true
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
            width: 110,
            buttons: ["edit",{
                name: "delete",
                visible: function(e) {
                    return e.row.data.id !== 1;
                },
                /*                onClick: function(e) {
                                    console.log(e.row.key)
                                    console.log(this)
                                }*/
            }]
        },{
            caption: "Имя",
            dataField: "name",
            validationRules: [{ type: "required" }],
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
        onRowInserting: function(e) {
            console.log("RowInserting");
        },
        onRowInserted: function(e) {
            console.log("RowInserted");
        },
        onRowUpdating: function(e) {
            console.log("RowUpdating");
        },
    });
});
