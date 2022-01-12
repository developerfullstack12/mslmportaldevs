(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(document).ready(function(){
		// $('[data-toggle="popover"]').popover();
		$('[data-toggle="tooltip"]').tooltip();

		// $(document).find("#ays_pd_default_sorting_points").not('.ays-select-search').select2({
		// 	minimumResultsForSearch: -1
		// });

		// WP color picker start
		$(document).find('#ays_pd_bg_color').wpColorPicker();
		$(document).find('#ays_pd_main_color').wpColorPicker();
		$(document).find('#ays_pd_text_color').wpColorPicker();
		// WP color picker end



		// Code Mirror
			
		setTimeout(function(){
			if($(document).find('#ays_custom_css').length > 0){
				let CodeEditor = null;
				if(wp.codeEditor){
					CodeEditor = wp.codeEditor.initialize($(document).find('#ays_custom_css'), cm_settings);
				}
				if(CodeEditor !== null){
					CodeEditor.codemirror.on('change', function(e, ev){
						$(CodeEditor.codemirror.display.input.div).find('.CodeMirror-linenumber').remove();
						$(document).find('#ays_custom_css').val(CodeEditor.codemirror.display.input.div.innerText);
							
					});
				}
			

			}
        }, 500);
       
		// $(document).find('#adminmenu li.toplevel_page_personal-dictionary ul.wp-submenu.wp-submenu-wrap li a[href*="dictionary-settings"] ').on('click', function (e) {     
		// console.log('1111');   
  //           setTimeout(function(){
  //               if($(document).find('#ays_custom_css').length > 0){
  //                   var ays_custom_css = $(document).find('#ays_custom_css').html();
  //                   if(wp.codeEditor){
  //                       $(document).find('#ays_custom_css').next('.CodeMirror').remove();
  //                       var CodeEditor = wp.codeEditor.initialize($(document).find('#ays_custom_css'), cm_settings);

  //                       CodeEditor.codemirror.on('change', function(e, ev){
  //                           $(CodeEditor.codemirror.display.input.div).find('.CodeMirror-linenumber').remove();
  //                           $(document).find('#ays_custom_css').val(CodeEditor.codemirror.display.input.div.innerText);
  //                       });
  //                       ays_custom_css = CodeEditor.codemirror.getValue();
  //                       $(document).find('#ays_custom_css').html(ays_custom_css);
  //                   }
  //               }
  //           }, 500);
           
  //       });


		
		$('#ays-pd-lb-table').dataTable( { 
			
		} );


		//Reports count per day

		if(typeof(PdChartData) !== 'undefined'){

			var perData = PdChartData.gamesCountPerDayData;           

			for (var i = 0; i < perData.length; i++) {
				perData[i] = new Array(
					new Date(
						perData[i][0]
					),
					perData[i][1]
				);
			}
			google.charts.load('current', {
				packages: ['corechart']
			}).then(function () {
				var data = new google.visualization.DataTable();
				data.addColumn('date', 'Date');
				data.addColumn('number', 'Count');
				
				data.addRows(perData);

				var populationRange = data.getColumnRange(1);

				var logOptions = {

					width: 800,
					height: 300,
					fontSize: 14,
					hAxis: {
						title: 'Date',
						format: 'MMM d',
						gridlines: {count: 15}
					},
					vAxis: {
						title: 'Count'
					}
				};

				var logChart = new google.visualization.LineChart(document.getElementById('pd_games_chart_div'));
				logChart.draw(data, logOptions);
			});



			var perDataWords = PdChartData.wordsCountPerDayData;           

			for (var i = 0; i < perDataWords.length; i++) {
				perDataWords[i] = new Array(
					new Date(
						perDataWords[i][0]
					),
					perDataWords[i][1]
				);
			}
			google.charts.load('current', {
				packages: ['corechart']
			}).then(function () {
				var data = new google.visualization.DataTable();
				data.addColumn('date', 'Date');
				data.addColumn('number', 'Count');
				
				data.addRows(perDataWords);

				var populationRange = data.getColumnRange(1);

				var logOptions = {

					width: 800,
					height: 300,
					fontSize: 14,
					hAxis: {
						title: 'Date',
						format: 'MMM d',
						gridlines: {count: 15}
					},
					vAxis: {
						title: 'Count'
					}
				};

				var logChart = new google.visualization.LineChart(document.getElementById('pd_words_chart_div'));
				logChart.draw(data, logOptions);
			});

			var perDataUsers = PdChartData.usersCountPerDayData;           

			for (var i = 0; i < perDataUsers.length; i++) {
				perDataUsers[i] = new Array(
					new Date(
						perDataUsers[i][0]
					),
					perDataUsers[i][1]
				);
			}
			google.charts.load('current', {
				packages: ['corechart']
			}).then(function () {
				var data = new google.visualization.DataTable();
				data.addColumn('date', 'Date');
				data.addColumn('number', 'Count');
				
				data.addRows(perDataUsers);

				var populationRange = data.getColumnRange(1);

				var logOptions = {

					width: 800,
					height: 300,
					fontSize: 14,
					hAxis: {
						title: 'Date',
						format: 'MMM d',
						gridlines: {count: 15}
					},
					vAxis: {
						title: 'Count'
					}
				};

				var logChart = new google.visualization.LineChart(document.getElementById('pd_users_chart_div'));
				logChart.draw(data, logOptions);
			});
		}
		
	});

})( jQuery );
