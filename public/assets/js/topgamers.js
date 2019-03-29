/* 
 * Requires jQuery
 */

$(document).ready( function () {
    var masoptions = {
        itemSelector: '.masonry-item',
        columnWidth: '.masonry-sizer',
        //percentPosition: true,
        transitionDuration: 250
    };

    $('.masonry-wrap').masonry(masoptions);

    /*
     * Show and hide refresh the chevron
     */
    $('.collapse').on('show.bs.collapse', function (event) {
        $(event.target).parent().find('.arrow').first().addClass('rotated');
    });
    
    $('.collapse').on('hide.bs.collapse', function (event) {
        $(event.target).parent().find('.arrow').first().removeClass('rotated');
    });
    
    /*
     * Once shown, refresh masonry
     */
    $('.collapse').on('shown.bs.collapse', function (event) {
        $('.masonry-wrap').masonry(masoptions);
    });
    
    $('.collapse').on('hidden.bs.collapse', function (event) {
        $('.masonry-wrap').masonry(masoptions);
    });
    
    /*
     * Only on player accordions, render twitch player
     */
    $('.collapse-player').on('shown.bs.collapse', function (event) {
        event.stopImmediatePropagation(); //Prevents twithc from adding a player each frame of the event
        twitchInit(event.target);
    });
    
    $('.collapse-player').on('hidden.bs.collapse', function (event) {
        $(event.target).find('.twitch-vars').empty();
        $('.masonry-wrap').masonry(masoptions);
    });
    
    function twitchInit(target) {
        var tplayer = $(target).find('.twitch-vars');
        if ($.isEmptyObject(tplayer)==false) {
            var playerid = tplayer.data('pid');
            var gameid = tplayer.data('game');
            var playerlnk = tplayer.data('player');

            if ((playerlnk != null && playerlnk != '' && playerlnk.length != 0) &&
                (playerid != null && playerid != '' && playerid.length != 0) &&
                (gameid != null && gameid != '' && gameid.length != 0 )) {
            
                createTwitchElement(tplayer, gameid, playerid);
                loadTwitchPlayer(gameid, playerid, playerlnk);
            }
        }
    }

    function createTwitchElement(parent, gameid, playerid) {
        var htmlContent = '<div id="twitch-embed'+gameid+''+playerid+'"></div>';
        parent.append(htmlContent);
    }

    function loadTwitchPlayer(gameid, playerid, playerlnk) {
        new Twitch.Embed("twitch-embed"+gameid+playerid, {
            width: '100%',
            height: '100%',
            channel: playerlnk,
            layout: 'video',
            allowfullscreen: true,
            autoplay: false
        });
        
        //Refresh masonry if player created
        $('.masonry-wrap').masonry(masoptions);
       
    }
    
});




