

  $('.datatable').dataTable({
    columnDefs: [
      { targets: 'no-sort', orderable: false }
    ],
    "order": [],
    "sScrollX": true,
    language: {
  url: '/backend/plugins/datatables/Italian.json'
}

});

