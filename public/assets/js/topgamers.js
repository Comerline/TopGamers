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

    $('.collapse').on('shown.bs.collapse', function (event) {
        var that = $(this);
        $('.masonry-wrap').masonry(masoptions);
        $(event.target).parent().find('.arrow').first().addClass('rotated');
        
        var tplayer = $(event.target).find('.twplayer');
        var playerid = tplayer.data('pid');
        var gameid = tplayer.data('game');
        var playerlnk = tplayer.data('player');
        
        var embed = new Twitch.Embed("twitch-embed"+gameid+playerid, {
            width: '100%',
            height: '100%',
            channel: playerlnk,
            allowfullscreen: true,
            layout: 'video'
        });
        
        
        embed.addEventListener('Twitch.Player.ONLINE', function () {
            that.parent().find('.twitchbadge').first().append('<i class="fas fa-certificate tg-twitch-color"></i>');
        });
        
        embed.addEventListener('Twitch.Player.OFFLINE', function () {
            that.parent().find('.twitchbadge').first().append('<i class="fas fa-certificate tg-twitch-color"></i>');
        });
        
    });

    $('.collapse').on('hidden.bs.collapse', function (event) {
        $('.masonry-wrap').masonry(masoptions);
        $(event.target).parent().find('.arrow').first().removeClass('rotated');
    });

});




