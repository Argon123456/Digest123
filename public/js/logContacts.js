
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
            let begin = getFirstDay();
            let end = new Date();
            begin = parseInt((begin.getTime() / 1000).toFixed(0));
            end = parseInt((end.getTime() / 1000).toFixed(0));
            return $.get(window.location + `/json`, { firstDate: begin, lastDate: end } );
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
            caption : "Контакт",
            dataField: "contact_name",
        }, {
            caption : "Компания",
            dataField: "company_name",
        }, {
            caption : "Дата отправки",
            dataField: "sended_at",
            dataType: "date",
            //width: 150,
        }, {
            caption : "Дайджест",
            dataField: "digest_name",
        }, {
            caption : "Отправлено",
            dataField: "total_count",
            dataType: "string",
        }, {
            caption : "Открыто",
            dataField: "opened_count",
            dataType: "string",
            //alignment: "right"
        },],
        onContentReady: function(e) {
            e.element.find(".dx-datagrid-text-content").removeClass("dx-text-content-alignment-left");
        },
        showBorders: true,
        summary: {
            totalItems: [{
                column: "name",
                summaryType: "count"
            }, {
                column: "opened_count",
                summaryType: "sum"
            }, {
                column: "total_count",
                summaryType: "sum"
            }],
            groupItems: [{
                column: "id",
                summaryType: "count",
                //displayFormat: "{0} orders",
            }, {
                column: "total_count",
                summaryType: "sum"
            }, {
                column: "opened_count",
                summaryType: "sum"
            }]
        },
        export: {
            enabled: true
        },
        onToolbarPreparing: function (e) {
            var dataGrid = e.component;
            var startDate, endDate;
            e.toolbarOptions.items.unshift({
                location: "after",
                widget: "dxDateBox",
                options: {
                    type: "date",
                    onInitialized: function (e) {
                        startDate = e.component;
                        startDate.option("max", new Date());
                    },
                    onValueChanged: function (e) {
                        endDate.option("min", e.value);
                    },
                    value: getFirstDay()
                }
            }, {
                location: "after",
                widget: "dxDateBox",
                options: {
                    type: "date",
                    onInitialized: function (e) {
                        endDate = e.component;
                        endDate.option("min", new Date());
                    },
                    onValueChanged: function (e) {
                        startDate.option("max", e.value);
                    },
                    value: new Date()
                }
            }, {
                location: "after",
                widget: "dxButton",
                options: {
                    icon: "refresh",
                    onClick: function () {
                        let begin = new Date(startDate.option('value'));
                        let end = new Date(endDate.option('value'));
                        begin = parseInt((begin.getTime() / 1000).toFixed(0));
                        end = parseInt((end.getTime() / 1000).toFixed(0));
                        dataGrid.option("dataSource", window.location + `/json?firstDate=${begin}&lastDate=${end}` );
                        dataGrid.refresh();
                    }
                }
            });
        },
        onExporting: function(e) {
            var workbook = new ExcelJS.Workbook();
            var worksheet = workbook.addWorksheet('Отчет');
            DevExpress.excelExporter.exportDataGrid({
                worksheet: worksheet,
                component: e.component,
                customizeCell: function(options) {
                    var excelCell = options;
                    excelCell.font = { name: 'Arial', size: 12 };
                    excelCell.alignment = { horizontal: 'left' };
                }
            }).then(function() {
                workbook.xlsx.writeBuffer().then(function(buffer) {
                    saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'Отчет.xlsx');
                });
            });
            e.cancel = true;
        }
    });

    $("#autoExpand").dxCheckBox({
        value: true,
        text: "Раскрыть все группы",
        onValueChanged: function(data) {
            let dataGridInstance = $("#gridContainer").dxDataGrid("instance");
            dataGridInstance.option("grouping.autoExpandAll", data.value);
        }
    });

});

function getFirstDay()
{
    let date = new Date();
    return new Date(date.getFullYear(), date.getMonth(), 1);
}

