$(document).ready(function(){
    
    if($("#employee").val() != typeForHints) {
        $("#employee").removeClass("inputFormatHint");
    }
    if($("#employee").val() == '') {
        $("#employee").val(typeForHints);
        $("#employee").addClass("inputFormatHint");
    }
    
    if(employeeId != '') {
    $('#employeeRecordsForm').append($('.actionbar > .formbuttons').html());
    $('.actionbar > .formbuttons').html('');
    $('.actionbar > .formbuttons').html($('#formbuttons').html());
    $('#formbuttons').html('');
    }
    
    if(trigger){

        var isValidEmployee= validateEmployee();
        
        if(isValidEmployee) {
            $("#reportForm").submit();
        }
        
        $("#employee").removeClass("inputFormatHint");    
    
        $("#employee").autocomplete(employees, {

            formatItem: function(item) {

                return $("<div/>").html(item.name).text();
            }
            ,
            matchContains:true
        }).result(function(event, item) {
            });

        var rDate = trim($("#attendance_date").val());
        if (rDate == '') {
            $("#attendance_date").val(datepickerDateFormat);
        }

        //Bind date picker
        daymarker.bindElement("#attendance_date",
        {
            onSelect: function(date){
              
                $("#attendance_date").trigger('change');            

            },
            dateFormat:datepickerDateFormat
        });

        $('#DateBtn').click(function(){
            daymarker.show("#attendance_date");
        });
    
        $("#employee").click(function(){
            if($("#employee").hasClass("inputFormatHint")){
                $("#employee").removeClass("inputFormatHint");
                $("#employee").val("");
            }

        });
    
        $('#btView').click(function() {
            $('#validationMsg').removeAttr('class');
            $('#validationMsg').html("");

            var isValidEmployee= validateEmployee();
                
            if(!isValidEmployee) {
				
                $('#validationMsg').attr('class', "messageBalloon_failure");
                $('#validationMsg').html(errorMsge);
				
            }
            else{
                
                var isValidDate= validateInputDate();
                
                if(isValidDate){
                    $("#reportForm").submit();
                }
            }
        });      
    }

    $("#employee").autocomplete(employees, {

        formatItem: function(item) {

            return $("<div/>").html(item.name).text();
        }
        ,
        matchContains:true
    }).result(function(event, item) {
        });

    var rDate = trim($("#attendance_date").val());
    if (rDate == '') {
        $("#attendance_date").val(datepickerDateFormat);
    }

    //Bind date picker
    daymarker.bindElement("#attendance_date",
    {
        onSelect: function(date){            
            $("#attendance_date").trigger('change');            
        },
        dateFormat:datepickerDateFormat
    });

    $('#DateBtn').click(function(){
        daymarker.show("#attendance_date");
    });
    
    $("#employee").click(function(){
        if($("#employee").hasClass("inputFormatHint")){
            $("#employee").removeClass("inputFormatHint");
            $("#employee").val("");
        }
    });
    
    $('#btView').click(function() {
        $('#validationMsg').removeAttr('class');
        $('#validationMsg').html("");        
                
        var isValidEmployee= validateEmployee();
        
        if(!isValidEmployee) {
				
            $('#validationMsg').attr('class', "messageBalloon_failure");
            $('#validationMsg').html(errorMsge);
				
        }
        else{
                
            var isValidDate= validateInputDate();
                
            if(isValidDate){
                $("#reportForm").submit();                 
            }
        }
    });
    
}); //ready

function validateInputDate(){

    errFlag = false;
    $(".messageBalloon_success").remove();
    $('#validationMsg').removeAttr('class');
    $('#validationMsg').html("");
    $(".date").removeAttr('style');

    var errorStyle = "background-color:#FFDFDF;";
          
    if((!validateDate($(".date").val(), datepickerDateFormat))){

        $('#validationMsg').attr('class', "messageBalloon_failure");
        $('#validationMsg').html(errorForInvalidFormat);
        $("#attendance_date").attr('style', errorStyle);
        errFlag = true;
    }  
    return !errFlag ;
    
}

function validateEmployee(){
		
    var empCount = employeesArray.length;
        
    var temp = false;
    var i;
        
    if(empCount==0){
            
        errorMsge = noEmployees;
        return false;
    }
    for (i=0; i < empCount; i++) {
        empName = $.trim($('#employee').val()).toLowerCase();
        arrayName = employeesArray[i].name.toLowerCase();
        arrayName= $("<div/>").html(arrayName).text();
        if (empName == arrayName) {
            $('#attendance_employeeId').val(employeesArray[i].id);
            temp = true
            break;
        }
    }
    if(temp){
        return true;
    }else if(empName == "" || empName == $.trim(typeForHints).toLowerCase()){
        $('#attendance_employeeId').val('');
        return true;
    }else{
        errorMsge = invalidEmpName;
        return false;
    }
}
    
function getRelatedAttendanceRecords(employeeId, date, actionRecorder){
      
    $.post(
        linkForGetRecords,
        {
            employeeId: employeeId,
            date: date,
            actionRecorder: actionRecorder
        },
        
        function(data, textStatus) {
                      
            if( data != ''){
                $("#recordsTable").show();
                $('#recordsTable1').html(data);    
            }
                    
        });
                    
    return false;
        
}