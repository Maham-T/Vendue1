function Layout() {
}


//Load modal 
Layout.LoadModal = function (url,heading) {
   $("#divDialogPan").load(url, function (response, status, xhr) {
        if (status === "error") {
            window.location.href = window.location.origin + "/admin.php";
        }
        else { 
            $("#DailogPan").modal();  
            $("#headingDialogPan").html(heading);
        }
    });
};


Layout.Select2 = function (show, sender) {
    $(".select2").select2(); 
};
Layout.Select2bs4 = function (show, sender) {
   $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
};
Layout.DataTable = function (show, sender) {
   
   $('.dataTables').DataTable( {
       "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
       "dom": "<'row'<'col-md-6'B><'col-md-3'l><'col-md-3'f>><'row'<'col-md-12't>><'row'<'col-md-3'i><'col-md-6'><'col-md-3'p>>",
        
        buttons: [
            { extend: 'copyHtml5', footer: true },
            { extend: 'excelHtml5', footer: true,  
         className: 'btn btn-info',
         exportOptions: {
          columns: 'th:not(.notexport)' 
         }},
            { extend: 'csvHtml5', footer: true },
            { extend: 'pdfHtml5', footer: true },
            { extend: 'print', footer: true }
        ]
    } );

};
Layout.Summernote = function (show, sender) {
  $('.textarea').summernote();
};