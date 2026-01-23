<input type="text" class="input-append date" id="datepicker" data-date="02-2012" 
     data-date-format="mm-yyyy">

     
     
<script>

$('#datepicker').datepicker({
    autoclose: true,
    minViewMode: 1,
    format: 'mm/yyyy'
}).on('changeDate', function(selected){
        startDate = new Date(selected.date.valueOf());
        startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
        $('.to').datepicker('setStartDate', startDate);
    }); 
    
</script>