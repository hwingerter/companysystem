$(document).ready(function() {

		$('#datepicker').each(function() {

			var minDate = new Date();
			minDate.setHours(0);
			minDate.setMinutes(0);
			minDate.setSeconds(0,0);
			
			var $picker = $(this);
			$picker.datepicker({
				format: 'dd/mm/yyyy'
			});
			
			var pickerObject = $picker.data('datepicker');
			
			$picker.on('changeDate', function(ev){
				$picker.datepicker('hide');
			});
		});
		
		
		//Color Picker
		$('#cpicker').colorpicker();

});