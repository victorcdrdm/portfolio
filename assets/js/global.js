$(document).ready(function () {
    $('select').formSelect();
})

$(document).ready(function(){
    $("#action-timeline").bind("click", function(){
        $("#timeline").slideToggle('slow');
        $("#toggle").toggleClass('flip');
        return false;
    })


});

