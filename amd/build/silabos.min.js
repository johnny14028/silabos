define(['jquery'], function ($) {
    return {
        init: function () {
            loadDataTableInidate('tableSilabosCourses');
        }
    };
});

function loadDataTableInidate(elementdiv) {
    require(['local_silabos/jquery.datatable'], function ($) {
        $(function () {
            $('#' + elementdiv).DataTable({
                "language": {
                    "sProcessing": local_silabos.lcl_inidate_datatable_processing,
                    "sLengthMenu": local_silabos.lcl_inidate_datatable_LengthMenu,
                    "sZeroRecords": local_silabos.lcl_inidate_datatable_ZeroRecords,
                    "sEmptyTable": local_silabos.lcl_inidate_datatable_EmptyTable,
                    "sInfo": local_silabos.lcl_inidate_datatable_Info,
                    "sInfoEmpty": local_silabos.lcl_inidate_datatable_InfoEmpty,
                    "sInfoFiltered": local_silabos.lcl_inidate_datatable_InfoFiltered,
                    "sInfoPostFix": "",
                    "sSearch": local_silabos.lcl_inidate_datatable_search,
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": local_silabos.lcl_inidate_datatable_LoadingRecords,
                    "oPaginate": {
                        "sFirst": local_silabos.lcl_inidate_datatable_first,
                        "sLast": local_silabos.lcl_inidate_datatable_last,
                        "sNext": local_silabos.lcl_inidate_datatable_next,
                        "sPrevious": local_silabos.lcl_inidate_datatable_previous
                    },
                    "oAria": {
                        "sSortAscending": local_silabos.lcl_inidate_datatable_SortAscending,
                        "sSortDescending": local_silabos.lcl_inidate_datatable_SortDescending
                    }
                },
                "pageLength": 10
            });
        });
    });
}