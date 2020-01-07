// Datatables
$(document).ready(function() {
	var handleDataTableButtons = function() {
		if ($(".datatable-buttons").length) {
			$("#table").DataTable({
				destroy: true,
				processing: false,
				serverSide: false,
				lengthChange: false,
				responsive: true,
				pageLength: 10,
				ajax: {
					url: $('#table').data('url'),
					type: 'POST',
					dataType: 'json'
				},
				columns: [
					{ data: 'Campanha', name: 'Campanha' },
					{ data: 'CodiUsuario', name: 'CodiUsuario' },
					{ data: 'CodiSupervisor', name: 'CodiSupervisor' },
					{ data: 'CodiCoordenador', name: 'CodiCoordenador' }
				],
				columnDefs: [
					{ orderable: false, className: 'select-checkbox', targets: 0 }
				],
				select: {
					style: "multi",
					selector: "td:first-child"
				},
				order: [[ 0, 'asc' ]],
				rowCallback: function(row, data) {
					// $(row).data('id', data.id).css('cursor', 'pointer');
					// var btnDelete = $(`<a href="${url_delete}${data.id}" class="text-danger"><i class="fas fa-trash"></i></a>`);

					// btnDelete.showConfirm({
					//     title: 'Deseja Excluir esse Registro?',
					//     closeOnConfirm: true,
					//     ajax: {
					//         type: 'post',
					//         url: btnDelete.attr('href'),
					//         dataType: 'json',
					//         success: function(xhr) {
					//             formWarning(xhr);
					//             table.ajax.reload();
					//         }
					//     }
					// });

					// $('td:eq(4)', row).html(btnDelete);

					$('td:not(:first-child):not(:last-child)', row).each(function() {
						$(this).on('click', function() {
							window.location.href = `${url_update}/${data.id}`
						});
					});
				},
				drawCallback: function() {

					$('[data-toggle="tooltip"]').tooltip();
				},

				"language": {
					"sProcessing":    "Procesando...",
					"sLengthMenu":    "Mostrar _MENU_ registros",
					"sZeroRecords":   "Nenhum registro encontrado",
					"sEmptyTable":    "Nenhum registro encontrado",
					"sInfo":          "Mostrando registros de _START_ à _END_ de um total de _TOTAL_ registros",
					"sInfoEmpty":     "Mostrando registros de 0 à 0 de um total de 0 registros",
					"sInfoFiltered":  "(filtrado de um total de _MAX_ registros)",
					"sInfoPostFix":   "",
					"sSearch":        "Buscar:",
					"sUrl":           "",
					"sInfoThousands":  ",",
					"sLoadingRecords": "Cargando...",
					"oPaginate": {
						"sFirst":    "Primero",
						"sLast":    "Último",
						"sNext":    "Próximo",
						"sPrevious": "Anterior"
					},
					"oAria": {
						"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
						"sSortDescending": ": Activar para ordenar la columna de manera descendente"
					}
				},

				buttons: [
					{
						extend: 'copy',
						text: 'Copiar',
						// className: 'btn-theme',
						exportOptions: {
							modifier: {
								page: 'current'
							}
						},
					},
					{
						extend: 'excel',
						text: 'Excel',
						// className: 'btn-theme',
						exportOptions: {
							modifier: {
								page: 'current'
							}
						},
					},
					{
						extend: 'pdf',
						text: 'PDF',
						// className: 'btn-theme',
						exportOptions: {
							modifier: {
								page: 'current'
							}
						},
					}
				],
				dom: "Bfrtip",
				deferRender: true,
				responsive: true,
				"pageLength": 15
			});
		}
	};

	TableManageButtons = function() {
		"use strict";
		return {
			init: function() {
				handleDataTableButtons();
			}
		};
	}();

	TableManageButtons.init();
});
// Datatables
