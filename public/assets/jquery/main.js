$(document).ready(function(){
    $('#receiver').val("0");

    $("body").on('keydown','#contenu',function(e){
        if(e.keyCode === 13){
            e.preventDefault();
            if($("#contenu").val().length > 0)
                $(this).closest('form').submit();
        }
    });

    $("connected").on('click', function(){
        $('#receiver').val($this.attr("id"));
    });

    $("body").on('submit','#formMsg',function(e){
       e.preventDefault();
       $this = $(this);
       $.post(
           $this.attr('action'),
           $this.serialize(),
           function(json){
               if(json.code === 1){
                   $("#contenu").val('');
                   refreshMsgList();
               }
               else if(json.code === 0)
                   alert("Une erreur est survenue lors de l'envoie du message !!");
           },
           'JSON'
       ).fail(function(){
           alert('Une erreur s\'est produite dans l\'application !!');
       });
    });

    setInterval(refreshMsgList,5000);

    function refreshMsgList() {
       var lastShown = parseInt($("#msgs").find('p:last').data('id'));
       if(isNaN(lastShown))
           lastShown = 0;
       console.log(lastShown);
       $.get(
           $("#msgs").data('url'),
           {'lastShown':lastShown},
           function(json){
               if(json.code === 1){
                  $.each(json.messages,function(index,msg){
                     var paragraphe = '<p data-id="'+msg['id']+'"><span title="'+msg['date']+'" class="badge badge-secondary username label label-success">'+msg['user']+'</span><span class="msg">'+msg['contenu']+'</span></p>';
                     $("#msgs").append(paragraphe);
                     scrollBottom();
                  });
               }
           },
           'JSON'
       ).fail(function(){
           alert('Une erreur s\'est produite dans l\'application !!');
       });
    }

    function scrollBottom() {
        var elm    = $('#msgs');
        var height = elm[0].scrollHeight;
        elm.scrollTop(height);
    }

    scrollBottom();

    setInterval(getUsersConnected,30000);

    function getUsersConnected(){
        $.get(
            $("#usersConnected").data('url'),
            {},
            function(json){
                $("#usersConnected").empty();
                if (json.code === 1){
                    $.each(json.users,function(index,value){
                        $("#usersConnected").append('<li class="list-group-item list-group-item-info">'+value+'<span class="badge badge-success ml-2 float-right mt-1">Online</span></li>');
                    });
                }
            },
            'JSON'
        ).fail(function(){
            alert('Une erreur s\'est produite dans l\'application !!');
        });
    }
});