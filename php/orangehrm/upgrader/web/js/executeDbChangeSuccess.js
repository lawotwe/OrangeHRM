$(document).ready(function(){

    var count = 0;
    getJsonResponse(count, tasks.length);
    
    function getJsonResponse(count, length) {
        $.get(upgraderControllerUrl+'?task='+tasks[count], function(data) {
            var myObject = JSON.parse(data);
            if((myObject.progress == 100)) {
                displayProgress(((count+1)*100)/length);
                if((count +1 ) < length) {
                    getJsonResponse(count+1, length);
                }
            } else {
                alert('Falid to Update');
            }
        });
    }
});

function displayProgress(percentage) {
    $("#divProgressBarContainer span span").width(percentage+'%');
    $("#spanProgressPercentage").html(percentage+'%');
}