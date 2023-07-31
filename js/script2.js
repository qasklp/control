$(function () {
    // Initialise the switches
    $(".switch").enhancedSwitch(); 
    // Set the second switch to be active after it has been initialised
    $("#activeFirst").enhancedSwitch('setTrue');
    
    // Set the text of the paragraph tag
    $("p").text("State: ");
    
    /*
     *  Code for when the switch is clicked.
     */
    
    $(".switch").click(function() {
        var selectedSwitch = $(this);
        selectedSwitch.enhancedSwitch('toggle'); 
        $("p").text("State: " + selectedSwitch.enhancedSwitch('state'));


           if(selectedSwitch.enhancedSwitch('state')){
                $('#code').css('backgroundColor', 'green');
           }else{
                $('#code').css('backgroundColor', 'yellow');
           }
           $('#code').focus();
    });
    
    /*
     *  Code for the different links
     */
    
});