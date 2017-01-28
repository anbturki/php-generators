$(document).ready(function(){

    $('.page-loading').hide();
    $('body').css('overflow','auto');

    callAfterReady();

    // Generator search handelr

    var searchResult        = $(".search-result"),
        searchField         = $('.g-search-field'),
    	gTable              = $('.generators-table'),
        doneTypingInterval  = 100,
        deleteData          = [],
        typingTimer         = null;

        if(searchField.val() == ''){
           btnDisable();
        }
        $(document).on('keyup','.g-search-field',function(){
            $('.search-result').html('<h4>Waiting until getting result...</h4>');
                var searchTrigger = $(this);
                if(searchTrigger.val() != ''){
                    searchResult.fadeIn(1000).show();
                    btnDisable(false);
                    gTable.fadeOut().hide();
                    clearTimeout(typingTimer);
                    typingTimer     = setTimeout(searchHandler, doneTypingInterval);

                }else{
                    // gSearchContainer.addClass('form-inline');
                    searchResult.hide();
                    gTable.show();
                    btnDisable();

                }
        });

    

        searchField.on('kedown',function(){

                clearTimeout(typingTimer);

        });


    function searchHandler(){
        $.ajax({
            url:searchURI,
            data:{'query':searchField.val()},
            success:function(data){
                if(!data.hasOwnProperty('msg')){
                    $('.search-result').html(data);
                }else {
                    $('.search-result').html('<h4>'+data.msg+'</h4>');
                }

                // searchResult.html('<ul>' + searchValue + '</ul>');

            }

    });
}

    function btnDisable(prop = true){
        $("#g-search-container button").prop('disabled',prop);
    }


    $('ul.nav li.dropdown').hover(function() {
          $(this).find('.dropdown-menu').stop(true, true).fadeIn('fast');
        }, function() {
          $(this).find('.dropdown-menu').stop(true, true).fadeOut('fast');
    });





    $('.modal-btn').on('click',function(e){
        e.preventDefault();
        var modalSize = "modal-lg";
        if($(this).attr('data-modal-size')){
            modalSize = $(this).data('modal-size');
        }
        $('.modal-dialog').addClass(modalSize);
        $('#edit-generator').modal('show');
        $('.modal-body').html('<h1 class="text-center">Waiting....</h1>');
        var url = $(this).attr('href');
        $.ajax({
            url:url,
            success:function(data){
                $('.modal-body').html(data);
                callAfterReady();
            }
        });

    });


    $(document).on('submit','#generator-update',function(e){
        e.preventDefault();
        $('.modal-body').html('<h1 class="text-center">Updating....</h1>');
        var data = $(this).serialize(),
            url  = $(this).attr('action');
        $.ajax({
            url:url,
            method:'put',
            data:data,
            success:function(data){
                $('#msg').html('<div class="alert alert-success"><strong>This page will be reloaded after 2 second ..</strong>'+data+'</div>');
                $('#edit-generator').modal('hide');
                setTimeout(function(){
                    location.reload();
                },3000);
            },
            error:function(error){
                if(error.status == 422){
                $('#generator-update').find('.help-block').remove();
                $('#generator-update').find('.form-group').removeClass('has-warning');
                    var res = JSON.stringify(error);
                    res = JSON.parse(res);
                    var valdiation = JSON.parse(res.responseText);
                    $.each(valdiation,function(key,value){
                        $('#'+key).after('<div class="help-block">'+value+'</div>');
                        $('#'+key).closest('.form-group').addClass('has-warning');
                    });
                }
            }

        });
    });

    var gAlert  = $('.g-alert');

    $(document).on('click','.alert-link',function(e){
        e.preventDefault();
        var trigger = $(this);

        var heading = trigger.data('heading'),
            msg     = trigger.data('msg');
        gAlert.show();
        $('.alert-heading').html(heading);
        $('.alert-body').html(msg);


        gAlert.on('click',function(e){
            if(e.target.className == 'g-alert'){
                $(this).hide();
            }else{
                return false;
            }
        });


        $('.action-btn').on('click',function(){
            var action = $(this).data('action');
            if(action == 'yes'){
                var a = $('.alert-link').data('do');
                var func = eval(a);
                func;              
            }else if(action == 'no'){
                
                gAlert.hide();
                return false;

            }
        });

    });


    function fillDiesel(url){
        $('.alert-heading').html('Filling Up...');

        $.ajax({
            method:'POST',
            url:url,
            success:function(res){
                $('#msg').html('<div class="alert alert-success"><strong>This page will be reloaded after 2 second ..</strong> The tank have filled with diesel</div>');
                gAlert.hide();
                setTimeout(function(){
                    location.reload();
                },3000);
            }
        });
    }

    function callAfterReady(){
        tinymce.remove();
        $(document).on('focusin', function(e) {
            if ($(e.target).closest(".mce-window").length) {
                e.stopImmediatePropagation();
            }
        });
        $('textarea').show();
        tinymce.init({
            selector:'textarea',
            plugins: "link,style",
            link_assume_external_targets: true
        });

        $.ajaxSetup({
            headers:{'X-CSRF-TOKEN':Laravel.csrfToken}
        });



    }




    $(document).on('submit','#create-m',function(e){
        e.preventDefault();
        var data = $(this).serialize(),
            url  = $(this).attr('action');
            $('.modal-body').html('<h1 class="text-center">Waiting....</h1>');

        $.ajax({
            method:'POST',
            url:url,
            data:data,
            success:function(data){
                console.log(data);
                $('#edit-generator').modal('hide');
                $('#msg').html('<div class="alert alert-success"><strong>This page will be reloaded after 2 second ..</strong> Done</div>');
                setTimeout(function(){
                    location.reload();
                },3000);

            }
        });
    });



    $('.remove-btn').on('click',function(e){
        e.preventDefault();
    });



        $("#mainChekbox").click(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
            removableBtn();

    });


$(document).on('click','.removing',function(){
    removableBtn();
})



function removeHock(url){
    $('.removing:checkbox:checked').each(function(val){
        deleteData[val] = $(this).val();
        $(this).hide();
    });

    $('.alert-heading').html('Deleting...');
    $.ajax({
        url:url,
        method:'DELETE',
        data:{deleteData},
        success:function(data){
            gAlert.hide();
                $('#msg').html('<div class="alert alert-success"><strong>This page will be reloaded after 2 second ..</strong> Removed</div>');
                setTimeout(function(){
                    location.reload();
                },3000);

        },
        error:function(error){console.log(error)}
    });
    }


function removableBtn(){
    var removeBtn = $('.remove-btn');
    $('.removing').each(function(){
    var items = $('.removing[name="remove[]"]:checked').length;
    if(items > 0){
        removeBtn.fadeIn(600);

    }else{
        removeBtn.fadeOut(600).hide();
    }
    var countItem = removeBtn.find('span');
    countItem.text(items + ' Seletced');
    });

}


//print function
    $(document).on('click','.printable',function(e){
        e.preventDefault();
        console.log('hell');
        var trigger = $(this);
        var url = trigger.attr('href');
        var pageContent = trigger.closest('.page-content');
        var originalContent = pageContent.html();
        pageLoading();
        $.ajax({
            url:url,
            data:{printable:true},
            dataType:'HTML',
            success:function (data) {
                pageLoaded();
                pageContent.html(data);
                window.print();
                pageContent.html(originalContent);
            }
        });

    });
    var absVal = 0,newVal = 0,oldVal = 0;
    $(".diff-val").on('keyup  mouseup',function () {
        newVal = $('#diff-form').find('#new');
        oldVal = $('#diff-form').find('#old');
        absVal = newVal.val() - oldVal.val();
        $('#diff-label').text(absVal.toLocaleString());
    });

    $("#diff-btn").on('click',function (e) {
        e.preventDefault();
        var diffUrl = $(this).data('url');
        var newValCheck = $('#diff-form').find('#new');
        var oldValCheck = $('#diff-form').find('#old');
        if(absVal === 0){
            $('#diff-label').text('No value for insert');
            return false;
        }
        pageLoading();
        $.ajax({
            type:'POST',
            url:diffUrl,
            data:{'diff':absVal},
            success:function (data) {
                pageLoaded();
                newValCheck.val(0);
                oldValCheck.val(0);
                absVal = 0;
                $('#diff-label').text(absVal);
                location.reload();
            }
        });
    });
    function pageLoading(){
        $('.page-loading').show();
        $('body').css('overflow','hidden');

    }
    function pageLoaded(){
        $('.page-loading').hide();
        $('body').css('overflow','auto');

    }
});