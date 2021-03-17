/*  Name:       app.js
 *  Version:    1.0 beta   
 *  Date:       2016.03.09 11:43  
 */

(function(global, $){
    
    /*  Settings
        For easy migrating or changing the use of the application
    */
    
    global.settings = {
        refresh: 1000,
        postUri: 'https://project.mesic.nl/site',
        getUri: 'https://project.mesic.nl/site'
    };
    
    /*  Define a jquery extend
        1. ajax.Post
        2. ajax.Get
        With a callback function
    */        
    $.extend({
        
        Post: function(page, actions, async, callback){
            $.ajax({
                method: 'POST',
                url: settings.postUri + page,
                data: actions,
                dataType: 'json',
                async: async,
                success: function(data) {
                    callback(data);   
                },
                error: function(data) {
                console.log('AJAX post request failed: ' + page);
                }
            });
        },
        Get: function(page, actions, async, callback) {
            $.ajax({
                url: settings.getUri + page,
                data: actions,
                dataType: 'json',
                async: async,
                success: function(data) {
                    callback(data);   
                },
                error: function(data) {
                    console.log('AJAX get request failed.' + page)
                }
            });
        } 
        
    });
    
    
})(window, jQuery);