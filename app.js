(function($) {
	$(document).ready(function() {
		$('.no-results, .no-text, .no-category').hide();

		var data_keys = [];
		var obj_result = [];

		//Подгрузка api
		var my_vpi_data = fetch('http://jsonplaceholder.typicode.com/posts')
		.then((response) => {
			return response.json();
		})
		.then((data) => {
			my_vpi_data = data;
			//Добавление в Select, Вывод первых 5 элементов для примера
			var select_template = '';
			let i = 0;
			my_vpi_data.forEach((item, index) => {
				for (let value of Object.keys(item)) {
					if (!data_keys.includes(value)) {
						data_keys.push(value);
						select_template += '<option value="'+ value +'">'+ value +'</option>'
					}
				}
				if (i < 6) {
					i++;
					var start_template = '<ul class="api-search-result api-search-result-' + index + '">';
					$.each(item, (elem) => {
						start_template += '<li><b>' + elem + '</b>: ' + item[elem] + '</li>';
					})
					start_template += '</ul>';
					$('#main-api-search').append(start_template);
				}
			});
			
			$('#api-search-category-select').append(select_template);
		});
		$('.preloader').hide();
		
		$('body').on('click', '#api-search-submit', (e) => {
			e.preventDefault();
			$('.preloader').show();
			$('.preloader, .no-results, .no-text, .no-category').hide();			
			$('.api-search-result').remove();
			//Сортировка даннных
			let searchText = String($('.api-search-input').val().trim()).toLowerCase();
			let selectValue = $('#api-search-category-select').val();
			if (selectValue !== 'empty' && searchText !== '') {
				obj_result = my_vpi_data.filter((item) => {
					let item_select = String(item[selectValue]).toLowerCase();
					if (item_select && item_select.includes(searchText)) {
						return true;
					} else return false;
				});
				// Вывод списка
				if (obj_result.length !== 0) {
					obj_result.map((item, index) => {
						var template = '<ul class="api-search-result api-search-result-' + index + '">';
						$.each(item, (elem) => {
							template += '<li><b>' + elem + '</b>: ' + item[elem] + '</li>';
						})
						template += '</ul>';

						$('#main-api-search').append(template);
					});
					
					$('.preloader').hide();
				} else {
					$('.no-results').show();
				}
			} else if (selectValue == 'empty') {
				$('.no-category').show();
			} else if (searchText == '') {
				$('.no-text').show();
			}
			
			
			
			
		});
	});
	
})(jQuery);