$(document).ready(function () {
  
    $(".wsf-text-space").on('keyup',function(e){
  
        e.preventDefault()
  
        var jqthis = $(".wsf-text-space"),
        html = jqthis.html()
  
        if ( html != "" ){
            $(".wsf-placeholder-text").hide()
        } else {
            $(".wsf-placeholder-text").show()
        }
  
    })

    /**
     * to load with ajax after installing to disable cache systems.
     */
    $.ajax({
        type: 'POST',
        dataType: 'html',
        url: url.ajaxurl,
        data: {
            'action'  : 'wsf_load_post_list'
        },
        success: function(data){
            $('.wsf-general-space').html(data)
        },
        error  : function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR + " :: " + textStatus + " :: " + errorThrown)
        }
    })

    // get new nonce
    $.ajax({
        type: 'POST',
        dataType: 'html',
        url: url.ajaxurl,
        data: {
            'action'  : 'wsf_new_nonce'
        },
        success: function(data){
            $('.wsf-post-send').attr('data-nonce',data)
            $('.wsf-load-more-post').attr('data-nonce',data)
        },
        error  : function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR + " :: " + textStatus + " :: " + errorThrown)
        }
    })

    // send new post
    $('body').delegate(".wsf-post-send",'submit', function(e){

        e.preventDefault()
    
        var jqthis = $(this)

        var text_space = $(".wsf-send-content")
        var null_msg = text_space.attr("data-null-msg")
        var post = text_space.val()

        if ( post == "" ) {
            alert(null_msg)
        } else {
    
            form_data = new FormData(this)
            form_data.append('action', 'wsf_send_post')
            form_data.append('nonce', jqthis.data( 'nonce' ))
    
            var default_text = $(".wsf-sending").html()
            var text = $(".wsf-sending").attr("data-text")
            var content_div = $(".wsf-general-space .wsf-posts-list")

            var li_length = content_div.children("li").length

            var btn_status = jqthis.children(".wsf-btn-status")
            var btn_sending = btn_status.children(".wsf-sending")
            
            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: url.ajaxurl,
                contentType: false,
                processData: false,
                data: form_data,
                beforeSend : function(data,settings){
                    btn_sending.html(text)
                    btn_status.addClass("wsf-btn-disabled")
                },
                success: function(data){
                    if ( li_length == 0 ) {
                        content_div.html(data)
                    } else {
                        content_div.prepend(data)
                    }
                    text_space.val("")
                    btn_sending.html(default_text)
                    btn_status.removeClass("wsf-btn-disabled")
                },
                error  : function(jqXHR, textStatus, errorThrown) {
                    alert(jqXHR + " :: " + textStatus + " :: " + errorThrown)
                }
            })
            
        }
        
    })

    // ajax load more post
    $('body').delegate(".wsf-load-more-post",'click', function(e){

        e.preventDefault()
    
        jqthis = $(this)

        var default_text = jqthis.html()
        var please_wait = jqthis.attr("data-text")

        var btn_status = jqthis.parent(".wsf-btn-status")

        var paged = jqthis.attr("data-paged")
        var count = jqthis.attr("data-count")
        var nonce = jqthis.attr("data-nonce")
        var max_page = jqthis.attr('data-max-page')
        var content_div = $(".wsf-general-space .wsf-posts-list")

        paged++
            
        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: url.ajaxurl,
            data: { 
                'action': 'wsf_load_more_post', 
                'paged': paged,
                'count': count,
                'nonce': nonce
            },
            beforeSend : function(data,settings){
                jqthis.html(please_wait)
                btn_status.addClass("wsf-btn-disabled")
            },
            success: function(data){
                content_div.append(data)
                jqthis.html(default_text)
                jqthis.attr('data-paged',paged)
                btn_status.removeClass("wsf-btn-disabled")
                if ( max_page <= paged ) {
                    jqthis.remove()
                }
            },
            error  : function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR + " :: " + textStatus + " :: " + errorThrown)
            }
        })
        
    })

    var wsf_space = $(".wsf-space")
    var window_width = window.innerWidth
    if ( window_width < 550 ) {        
        var difference = window_width - wsf_space.outerWidth()
        ml_mr = difference / 2
        wsf_space.css({
            'margin-left': '-'+ml_mr+'px', 
            'margin-right': '-'+ml_mr+'px', 
            'width': 'calc(100% + '+difference+'px)',
        }) 
    } 

})
