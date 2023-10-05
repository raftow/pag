        <div class="date-time-picker">
            <input type="text" id="<?=$input_name?>" class="datepickerval <?=$class_inputText.$data_loaded_class.$data_length_class?>" name="<?=$col_name?>" value="<?=$valaff?>" >
        </div>
        <script>
                $(function () {
                    $("#<?=$input_name?>").datepicker({
                        changeMonth: true,
                        changeYear: true,
                    });
                });
        </script>
	