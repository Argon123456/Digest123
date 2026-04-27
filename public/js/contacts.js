jQuery( document ).ready(function() {
    DevExpress.localization.locale('ru-RU');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let companies = new DevExpress.data.CustomStore({
        //key: "id",
        load: function (loadOptions) {
            return $.getJSON("companies/all");
        },
        byKey: function (key) {
            return $.get('companies/'+ key.toString()+'/json/');
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
/*            return sendRequest(URL + "/InsertOrder", "POST", {
                values: JSON.stringify(values)
            });*/
        },
        update: function(key, values) {
            console.log(key,values);
            return $.ajax({
                url: window.location + "/update",
                method: "POST",
                data: {key: key, values : values},
            });
/*            return sendRequest(URL + "/contacts/update", "POST", {
                key: key,
                values: JSON.stringify(values)
            });*/
        },
        remove: function(key) {
            console.log(key);
            return $.ajax({
                url: window.location + "/" + key.id,
                method: "DELETE",
            });
        }

    });

    $("#gridContacts").dxDataGrid({
        dataSource: datasource,
        allowColumnResizing: true,
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
            width: 60,
            buttons: ["edit",{
                name: "delete",
                /*                onClick: function(e) {
                                    console.log(e.row.key)
                                    console.log(this)
                                }*/
            }]
        },{
            caption: "Имя",
            dataField: "name",
            validationRules: [{ type: "required" }],
        }, {
            caption: "Должность",
            dataField: "position",
        }, {
            dataField: "company.id",
            displayExpr: "name",
            caption: "Компания",
            validationRules: [{ type: "required" }],
            lookup: {
                dataSource:  companies,
                displayExpr: "name",
                valueExpr: "id"
            }
        }, {
            caption: "email",
            dataField: "email",
            validationRules: [{ type: "required" }, {
                type: "email"
            }],
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

    let gridInstance = $("#gridContacts").dxDataGrid("instance");
    let cols = gridInstance.option("columns");
    for (const col of columns) {
        cols.push(col);
    };

    gridInstance.option("columns", cols);
});
