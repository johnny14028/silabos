define(['jquery'], function ($) {
    return {
        init: function () {
            loadDataTableInidate('tableSilabosCourses');
            loadFormFiles();
        }
    };
});

function loadDataTableInidate(elementdiv) {
    require(['local_silabos/jquery.datatable'], function ($) {
        $(function () {
            $('#' + elementdiv).DataTable({
                "language": {
                    "sProcessing": local_silabos.local_silabos_datatable_processing,
                    "sLengthMenu": local_silabos.local_silabos_datatable_LengthMenu,
                    "sZeroRecords": local_silabos.local_silabos_datatable_ZeroRecords,
                    "sEmptyTable": local_silabos.local_silabos_datatable_EmptyTable,
                    "sInfo": local_silabos.local_silabos_datatable_Info,
                    "sInfoEmpty": local_silabos.local_silabos_datatable_InfoEmpty,
                    "sInfoFiltered": local_silabos.local_silabos_datatable_InfoFiltered,
                    "sInfoPostFix": "",
                    "sSearch": local_silabos.local_silabos_datatable_search,
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": local_silabos.local_silabos_datatable_LoadingRecords,
                    "oPaginate": {
                        "sFirst": local_silabos.local_silabos_datatable_first,
                        "sLast": local_silabos.local_silabos_datatable_last,
                        "sNext": local_silabos.local_silabos_datatable_next,
                        "sPrevious": local_silabos.local_silabos_datatable_previous
                    },
                    "oAria": {
                        "sSortAscending": local_silabos.local_silabos_datatable_SortAscending,
                        "sSortDescending": local_silabos.local_silabos_datatable_SortDescending
                    }
                },
                "pageLength": 10
            });
        });
    });
}
function loadFormFiles() {
    require(['local_silabos/jquery.validate'], function ($) {
        $("#formFile").validate({
            rules: {
                inputName: {
                    required: true
                }
            },
            messages: {
                inputName: {
                    required: local_silabos.local_silabos_formvalidation_missing,
                }
            }
        });
    });
}

function activeCourse(eSelect, itemid) {
    require(['jquery'], function ($) {
        var url_ajax = $("#url_ajax").val();
        $.post(url_ajax, {subject: "activeCourse", active: $(eSelect).val(), itemid: itemid}, function (response) {
            if (response.success) {
            }
        });
    });
}
function deleteFile(itemid) {
    require(['jquery'], function ($) {
        var r = confirm(local_silabos.local_silabos_comfirm_action);
        if (r == true) {
            var url_ajax = $("#url_ajax").val();
            $.post(url_ajax, {subject: "deleteFile", itemid: itemid}, function (response) {
                if (response.success) {
                    //redireccionamos a la página inicial
                    window.location.href = response.url
                }
            });
        }
    });
}