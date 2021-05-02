// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
var firebaseConfig = {
    apiKey: "AIzaSyDz2XnmikLRO8-OtKDtyamKtXw9siYoX4g",
    authDomain: "learnapi-2f9e0.firebaseapp.com",
    projectId: "learnapi-2f9e0",
    storageBucket: "learnapi-2f9e0.appspot.com",
    messagingSenderId: "43647748479",
    appId: "1:43647748479:web:65b36ef89d8d5b80a7724a",
    measurementId: "G-194896LJQN",
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);
firebase.analytics();
const messaging = firebase.messaging();

$(".btn-save").click(function (event) {
    event.preventDefault();
    if ($(this).text() == "Edit") {
        $("form").find("input, select, textarea").prop("disabled", false);
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
        if (window.location.pathname.split("/")[1] == "user") {
            if ($(".btn-check:checked", form).val() == "active") {
                initFirebaseMessagingRegistration(form.attr("id"));
            } else {
                save(form.attr("id"));
            }
        } else {
            save(form.attr("id"));
        }
    }
    form.addClass("was-validated");
}

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
    $("#" + idform)
        .find("input, select, textarea")
        .attr("readonly", "readonly");
    $(".btn-save").html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true">&nbsp;</span> Loading...'
    );
    $(".btn").prop("disabled", true);
    $("form input").prop("disabled", true);
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
            $(".modal").modal("hide");
            $(".btn-save").removeClass("btn-primary");
            $(".btn-save").addClass("btn-success");
            $(".btn-save").html('<i class="fa fa-check"></i> success!');
            if (response.success == "Error") {
                $(".alert").addClass("alert-warning");
            } else {
                $(".alert").addClass("alert-success");
            }
            var message =
                "<strong>" +
                response.success +
                "!</strong> " +
                response.message +
                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            $(".alert").html(message);
            $(".alert").on("closed.bs.alert", function (event) {
                location.href = response.location;
            });
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
                $(".alert").addClass("alert-warning");
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

$(document).ready(function () {
    var getUrl = window.location;
    var urLoc = getUrl.pathname.split("/")[3];
    if (urLoc == "edit") {
        if (getUrl.pathname.split("/")[1] != "user") {
            $("form input").prop("disabled", true);
            $(".btn-save").addClass("btn-edit");
            $(".btn-save").text("Edit");
            $(".btn-add").addClass("d-none");
        }
    }
});

$("a").click(function (event) {
    event.preventDefault();
    if ($(this).text() == "Edit") {
        if ($(this).data("type") == "editCustomer") {
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

function initFirebaseMessagingRegistration(idform) {
    var action = $("#" + idform).attr("action");
    var dataParam = new FormData($("#" + idform)[0]);
    action = action + "/" + window.location.pathname.split("/")[2];
    dataParam.append("_method", "PATCH");
    messaging
        .requestPermission()
        .then(function () {
            return messaging.getToken();
        })
        .then(function (token) {
            $("#" + idform)
                .find("input, select, textarea")
                .attr("readonly", "readonly");
            $(".btn-save").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true">&nbsp;</span> Loading...'
            );
            $(".btn").prop("disabled", true);
            $("form input").prop("disabled", true);
            dataParam.append("token", token);
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: action,
                data: dataParam,
                type: "post",
                dataType: "json",
                processData: false,
                contentType: false,
                success: function (response) {
                    $("#" + idform)[0].reset();
                    $(".modal").modal("hide");
                    $(".btn-save").removeClass("btn-primary");
                    $(".btn-save").addClass("btn-success");
                    $(".btn-save").html('<i class="fa fa-check"></i> success!');
                    if (response.success == "Error") {
                        $(".alert").addClass("alert-warning");
                    } else {
                        $(".alert").addClass("alert-success");
                    }
                    var message =
                        "<strong>" +
                        response.success +
                        "!</strong> " +
                        response.message +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    $(".alert").html(message);
                    $(".alert").on("closed.bs.alert", function (event) {
                        location.href = response.location;
                    });
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
                        $(".alert").addClass("alert-warning");
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
        })
        .catch(function (err) {
            var message =
                "<strong>User Activated Token Error " +
                err +
                '!</strong> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            $(".alert").addClass("alert-danger");
            $(".alert").html(message);
            $(".alert").on("closed.bs.alert", function (event) {
                location.reload();
            });
        });
}

messaging.onMessage(function (payload) {
    const noteTitle = payload.notification.title;
    const noteOptions = {
        body: payload.notification.body,
        icon: payload.notification.icon,
    };
    new Notification(noteTitle, noteOptions);
});
