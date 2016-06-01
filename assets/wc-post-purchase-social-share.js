var wcPPSS = {};
wcPPSS.clickChangeFn = function(elem){
    jQuery(elem).hide();
    jQuery(elem).next().show();
};

wcPPSS.changeOptFn = function(elem){
    jQuery(elem).parent().hide();
    jQuery(elem).parent().prev().show();
    var jsnOptsData = jQuery('#wc-pp-ss-box-data').html();
    var jsnOpt = JSON.parse(jsnOptsData);
    var optVal = jQuery(elem).val() -0;
    if(optVal>=0){
        //Options selected.
        if(typeof jsnOpt[optVal]['title']!="undefined"){
            var selData = jsnOpt[optVal];
            jQuery(elem).parent().parent().parent().find('.wc-pp-ss-s-img img').attr('src',selData['image']);
            jQuery(elem).parent().parent().parent().find('.wc-pp-ss-s-img img').attr('alt',selData['ori_title']);
            jQuery(elem).parent().parent().find('.wc-pp-ss-s-desc-ttl').html(selData['title']);
            jQuery(elem).parent().parent().find('.wc-pp-ss-s-desc-txt').html(urldecodeTh(selData['desc']));
            jQuery(elem).parent().parent().find('.wc-pp-ss-s-desc-btn-fbk a').attr('href','https://www.facebook.com/sharer/sharer.php?u='+selData['url']);
            jQuery(elem).parent().parent().find('.wc-pp-ss-s-desc-btn-twt a').attr('href','https://twitter.com/share?text='+selData['title']+'&url='+selData['url']);
        }
    }
};

function urldecodeTh(str) {
    return decodeURIComponent((str+'').replace(/\+/g, '%20'));
}

jQuery(document).ready(function(){
    jQuery( "#wc-pp-ss-box-holder" ).tabs();
});