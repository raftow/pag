        <div class="date-time-picker">
            <input type="text" id="<?php echo $input_name?>" class="datepickerval <?php echo $class_inputText.$data_loaded_class.$data_length_class?>" name="<?php echo $col_name?>" value="<?php echo $valaff?>" >
        </div>
        <script>
                $(function () {
                    $("#<?php echo $input_name?>").datepicker({
                        changeMonth: true,
                        changeYear: true,
                    });
                });
        </script>
	