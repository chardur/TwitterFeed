$(function (){

    var $feedTable = $('#feedTable')
    $.ajax({
        type: 'GET',
        url: '/feed',
        success: function (feeds) {
            $.each(feeds, function(i, feedItem) {
                $feedTable.append('<tr><th>'+feedItem.name +'</th><th>'+feedItem.time +'</th><th>'+feedItem.message +'</th></tr>')
                document.write(5 + 6);
            });
        }
    });
});