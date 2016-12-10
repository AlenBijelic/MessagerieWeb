/**
 * Created by bijelical on 07.06.2016.
 */


/*
    Create and display new message
 */
$('#messagebutton').click(function(e){
    e.preventDefault(); //Do not send form to the php page

    //Get the message
    var message = encodeURIComponent( $('#message').val() );
    //Get the group name in $_GET
    var group = $_GET('g');
    //Get the last message by id
    var lastID = $('#newMessage').children().last().attr('id'); //Get the most recently message id

    //Clear the textbox
    $('#message').val("");

    var sendTime = new Date(),
        time = sendTime.getHours() + ":" + sendTime.getMinutes();

    //Check if it's the first message of the group
    if(lastID != null)
    {
        //Increment the id of the new message
        lastID = parseInt(lastID) + 1;
    }
    else
    {
        //Put the id of the new message at 1
        lastID = 1;
    }

    //Include all character with french accent
    message = decodeURIComponent(message);

    //Check if data are not null
    if(message != ""){
        $.ajax({
            url : "addMessage.php?g=" + group, //The url of the php file
            type : "POST", //Post method of data
            data : "&message=" + message //Data
        });

        //Display the new message directly on the message div
        $('#newMessage').append('<div id="' + lastID + '"><div style="text-align: right"><div class="chip blue white-text">' + message + ' <span style="font-size: 9px">' + time + '</span></div></div></div></div>'); //Add the message in the html
    }

    //Scroll the scrollbar to display the new message
    $('#scrollBar').scrollTop($('#scrollBar')[0].scrollHeight);
});

/*
    Method to display $_GET[] in jQuery
 */
function $_GET(param) {
    var vars = {};
    window.location.href.replace( location.hash, '' ).replace(
        /[?&]+([^=&]+)=?([^&]*)?/gi,
        function( m, key, value ) {
            vars[key] = value !== undefined ? value : '';
        }
    );

    if ( param ) {
        return vars[param] ? vars[param] : null;
    }
    return vars;
}

/*
    Display new message all 1.5 seconds (1500 ms)
 */
function updateMessage(){

    setTimeout( function(){

        //Set all id in the array
        var arrayIDs = $('#newMessage').children().map(function() {
            return parseInt(this.id);
        }).get();

        //Get the bigger value in the array
        var lastID = Math.max.apply(Math, arrayIDs);

        //Get $_GET value
        var group = $_GET('g');

        //Ajax query to charge new message
        $.ajax({
            url : "getMessage.php?id=" + lastID + "&g=" + group,//Url of the page to get message
            type : "GET", //The type of sending data
            success : function(html){
                $('#newMessage').append(html);
            }
        });

        updateMessage();

    }, 1500);

}

updateMessage();

