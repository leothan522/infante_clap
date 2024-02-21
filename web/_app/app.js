function irDashboard() {
    ajaxRequest({url: 'procesar.php', data: {opcion: 'ir_dashboard'}}, function (data) {
        if (data.result) {
            window.location.href = "../admin/";
        }
    });
}