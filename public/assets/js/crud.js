$(".btn-save").click(function (event) {
    event.preventDefault();
    if ($(this).text() == "Edit") {
        $("form").find("input, select, textarea").prop("disabled", false);
        $("form").attr("action", "/customer/update");
        $(this).text("Save");
    } else {
        var idform = $(this).closest(".card").find("form").attr("id");
        var form = $("#" + idform);
        validateForm(event, form);
    }
});

$(".btn-spages").click(function (event) {
    var idform = $(this).closest(".modal").find("form").attr("id");
    var form = $("#" + idform);
    validateForm(event, form);
});

function validateForm(event, form) {
    if (form[0].checkValidity() === false) {
        event.preventDefault();
        event.stopPropagation();
    } else {
        event.preventDefault();
        save(form.attr("id"));
    }
    form.addClass("was-validated");
}
$(document).on("click", ".btn-update", function (event) {
    event.preventDefault();
    var dataParam = $(this).data("id");
    var pageAction = $(this).data("action");
    if (pageAction == "editCustomer") {
        var pageView =
            "/customer/show?action=" + pageAction + "&id=" + dataParam;
    }
    location.href = pageView;
});

function save(idform) {
    var getUrl = window.location;
    var urLoc = getUrl.pathname.split("/")[3];
    var action = $("#" + idform).attr("action");
    var dataParam = new FormData($("#" + idform)[0]);
    if (urLoc == "edit") {
        action = action + "/" + getUrl.pathname.split("/")[2];
        dataParam.append("_method", "PATCH");
    } else {
        dataParam.append("_method", "POST");
    }
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: action,
        data: dataParam,
        type: "post",
        dataType: "json",
        processData: false,
        contentType: false,
        success: function (response) {
            $("#" + idform)[0].reset();
            $(".modal").hide();
            if (confirm(response.success + " " + response.message)) {
                location.href = response.location;
            }
        },
        error: function (xhr, status, error) {
            if (xhr.status == 422) {
                var message =
                    "<strong>Whoops!</strong> There were some problems with your input.<br><br>" +
                    "<ul>";
                $.each(xhr.responseJSON.errors, function (key, option) {
                    message += "<li>" + option + "</li>";
                });
                message += "</ul>";
                message +=
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                $(".alert").removeClass("d-none");
                $(".alert").html(message);
                $(".alert").on("closed.bs.alert", function (event) {
                    location.reload();
                });
            } else {
                console.log(error);
                console.log(status);
                console.log(xhr);
            }
        },
    });
}

function load_edit(idPage, pageAction) {
    var url = "/customer/edit";
    var action = url;
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: action,
        data: { dataID: idPage },
        method: "post",
        dataType: "json",
        success: function (response) {
            var obj = response.data[0];
            if (pageAction == "editCustomer") {
                $("#inputIDCustomer").val(obj.id_customers);
                $("#inputEmail").val(obj.email_customer);
                $("#inputName").val(obj.nama_customer);
                $("#inputAddress").val(obj.alamat);
                $("#inputPhone").val(obj.phone_customer);
                $("#inputBOD").val(obj.bod_customer);
                $("#inputRekening").val(obj.nomor_rekening);
                $("#inputBank").val(obj.bank_rekening);
                $("#wizardPicturePreview")
                    .attr(
                        "src",
                        "../" + obj.file_location + "/" + obj.file_image
                    )
                    .fadeIn("slow");
                checkIfFileLoaded($("#wizardPicturePreview").attr("src"));
            }
            $("form input").prop("disabled", true);
            $(".btn-save").addClass("btn-edit");
            $(".btn-save").text("Edit");
        },
        error: function (xhr, status, error) {
            console.log(error);
            console.log(status);
            console.log(xhr);
        },
    });
}

$(document).on("click", ".btn-delete", function (event) {
    event.preventDefault();
    var dataParam = $(this).data("id");
    var url = "/customer/" + dataParam;
    var action = url;
    deldata(dataParam, action);
});

function deldata(dataParam, action) {
    if (confirm("Data Akan Dihapus")) {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: action,
            data: { dataID: dataParam, _method: "DELETE" },
            type: "post",
            dataType: "json",
            success: function (response) {
                location.href = response.location;
            },
            error: function (xhr, status, error) {
                console.log(error);
                console.log(status);
                console.log(xhr);
            },
        });
    }
}

function trashed(dataParam, action, text) {
    if (confirm("Data Will Be " + text)) {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: action,
            data: { dataID: dataParam },
            method: "post",
            dataType: "json",
            success: function (response) {
                location.href = response.location;
            },
            error: function (xhr, status, error) {
                console.log(error);
                console.log(status);
                console.log(xhr);
            },
        });
    }
}

function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split("&"),
        sParameterName,
        i;
    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split("=");
        if (sParameterName[0] === sParam) {
            return typeof sParameterName[1] === undefined
                ? true
                : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
}

function viewTables(table) {
    if (table.length > 0) {
        table.each(function () {
            loadTable($(this).attr("id"), $(this).data("action"));
        });
    }
}

function loadTable(idTables, action) {
    var dataParam = { table: idTables };
    var tableName = "#" + idTables,
        data,
        str,
        jqxhr = $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: action,
            data: dataParam,
            type: "post",
            dataType: "json",
        })
            .done(function () {
                data = JSON.parse(jqxhr.responseText);
                if (data.response.recordsTotal > 0) {
                    $.each(data.response.columns, function (k, colObj) {
                        str = "<th>" + colObj.name + "</th>";
                        $(str).appendTo(tableName + ">thead>tr");
                    });
                    data.response.columns[0].render = function (data) {
                        return data;
                    };
                    $(tableName).dataTable({
                        data: data.response.data,
                        columns: data.response.columns,
                        searching: true,
                        paging: true,
                        pagingType: "simple",
                        ordering: true,
                        info: true,
                        responsive: true,
                        lengthChange: false,
                        language: {
                            info: "Showing page _PAGE_  of _PAGES_",
                            search: "_INPUT_",
                            searchPlaceholder: "Cari...",
                            paginate: {
                                previous: "Prev",
                                next: "Next",
                            },
                        },
                        fnDrawCallback: function () {
                            $("input[type='search']")
                                .css("width", "250px")
                                .focus();
                        },
                        order: [[0, "asc"]],
                        iDisplayLength: 10,
                    });
                } else {
                    $(".table-responsive").html(
                        '<h1 class="text-center">No data available in table</h1>'
                    );
                }
            })
            .fail(function (jqXHR, exception) {
                console.log(jqXHR);
                console.log(exception);
            });
}

$(document).ready(function () {
    var getUrl = window.location;
    var urLoc = getUrl.pathname.split("/")[3];
    if (urLoc == "edit") {
        $("form input").prop("disabled", true);
        $(".btn-save").addClass("btn-edit");
        $(".btn-save").text("Edit");
    }
    // if (urLoc==='' || urLoc===undefined || urLoc=='undefined') {
    //     var extensions  = { "sFilter": "dataTables_filter text-right" };
    //     $.extend($.fn.dataTableExt.oStdClasses, extensions);
    //     var table       =   $('.table-responsive').find('.table');
    //     viewTables(table);
    // }
});

$("a").click(function (event) {
    event.preventDefault();
    if ($(this).text() == "Edit") {
        if ($(this).data("type") == "editCustomer") {
            //location.href    =   $(this).data('action')+'?action='+$(this).data('type')+'&id='+$(this).data('id');
            location.href = $(this).data("id") + "/" + $(this).data("action");
        }
    } else if ($(this).text() == "Delete") {
        if ($(this).data("type") == "deleteCustomer") {
            deldata($(this).data("id"), $(this).data("action"));
        }
    } else {
        if (
            $(this).text() == "Restore" ||
            $(this).text() == "Permanent Delete"
        ) {
            trashed($(this).data("id"), $(this).data("action"), $(this).text());
        } else {
            location.href = $(this).data("action");
        }
    }
});

$(".checkall").click(function () {
    var idRole = $(this).attr("id");
    var row = $("#" + idRole).closest("tr");
    $("td input:checkbox", row).prop("checked", this.checked);
});
