$(document).ready(function(){

    $('.button-checkbox').each(function () {

        // Settings
        var $widget = $(this),
        $button = $widget.find('button'),
        $checkbox = $widget.find('input:checkbox'),
        color = $button.data('color'),
        settings = {
            on: {
                icon: 'glyphicon glyphicon-check'
            },
            off: {
                icon: 'glyphicon glyphicon-unchecked'
            }
        };

        // Event Handlers
        $button.on('click', function () {
            $checkbox.prop('checked', !$checkbox.is(':checked'));
            $checkbox.triggerHandler('change');
            updateDisplay();
        });
        $checkbox.on('change', function () {
            updateDisplay();
        });

        // Actions
        function updateDisplay() {
            var isChecked = $checkbox.is(':checked');

            // Set the button's state
            $button.data('state', (isChecked) ? "on" : "off");

            // Set the button's icon
            $button.find('.state-icon')
            .removeClass()
            .addClass('state-icon ' + settings[$button.data('state')].icon);

            // Update the button's color
            if (isChecked) {
                $button
                .removeClass('btn-default')
                .addClass('btn-' + color + ' active');
            }
            else {
                $button
                .removeClass('btn-' + color + ' active')
                .addClass('btn-default');
            }
        }

        // Initialization
        function init() {

            updateDisplay();

            // Inject the icon if applicable
            if ($button.find('.state-icon').length == 0) {
                $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i>');
            }
        }
        init();
    });


$('#myCarousel').carousel({
  interval: 40000
});

$('#myCarousel .item').each(function(){
  var next = $(this).next();
  if (!next.length) {
    next = $(this).siblings(':first');
}
next.children(':first-child').clone().appendTo($(this));

if (next.next().length>0) {

  next.next().children(':first-child').clone().appendTo($(this)).addClass('rightest');

}
else {
  $(this).siblings(':first').children(':first-child').clone().appendTo($(this));

}
});

var $btnSets = $('#responsive'),
$btnLinks = $btnSets.find('a');

$btnLinks.click(function(e) {
    e.preventDefault();
    $(this).siblings('a.active').removeClass("active");
    $(this).addClass("active");
    var index = $(this).index();
    $("div.user-menu>div.user-menu-content").removeClass("active");
    $("div.user-menu>div.user-menu-content").eq(index).addClass("active");
});

$("[rel='tooltip']").tooltip();    

$('.view').hover(
    function(){
            $(this).find('.caption').slideDown(250); //.fadeIn(250)
        },
        function(){
            $(this).find('.caption').slideUp(250); //.fadeOut(205)
        }
        ); 

var navListItems = $('ul.setup-panel li a'),
allWells = $('.setup-content');

allWells.hide();

navListItems.click(function(e)
{
    e.preventDefault();
    var $target = $($(this).attr('href')),
    $item = $(this).closest('li');

    if (!$item.hasClass('disabled')) {
        navListItems.closest('li').removeClass('active');
        $item.addClass('active');
        allWells.hide();
        $target.show();
    }
});

$('ul.setup-panel li.active a').trigger('click');

    // DEMO ONLY //
    $('#activate-step-2').on('click', function(e) {
        $('ul.setup-panel li:eq(1)').removeClass('disabled');
        $('ul.setup-panel li a[href="#step-2"]').trigger('click');
        $(this).remove();
    });

    $('#activate-step-3').on('click', function(e) {
        $('ul.setup-panel li:eq(2)').removeClass('disabled');
        $('ul.setup-panel li a[href="#step-3"]').trigger('click');
        $(this).remove();
    });

    $('.tnc_register').on('change', function(){
        if($(this).is(':checked')){
            $('#activate-step-3').prop('disabled', false);    
        }else{
            $('#activate-step-3').prop('disabled', true);
        }
    });

    $('body').on('click', 'a.disabled', function(event) {
        event.preventDefault();
    });


    $('.post-rate-button').on('click', function(){
        var $this = $(this);
        if($this.hasClass('disabled')){
            return false;
        }
        var data = $(this).attr('id');
        var rate = data.split('_')[0];
        var id = data.split('_') [1];
        if(rate == 'post-like'){
          rating = 1;
      }else{
          rating = 0;
      }
      $.ajax({
        url: '../../rate',
        data: {rating: rating, id: id},
        success: function(response){
            var response = JSON.parse(response);
            if(response['res'] == "true"){
                $('.post-rate-button').eq(0).removeClass('disabled');
                $('.post-rate-button').eq(1).removeClass('disabled');
                $this.addClass('disabled');
                if(rate == 'post-like'){
                    $this.html('<i class="fa fa-thumbs-up"></i> '+response['likes']);
                    $('#post-dislike_'+id).html('<i class="fa fa-thumbs-down"></i> '+response['dislikes']);
                }else{
                    $('#post-like_'+id).html('<i class="fa fa-thumbs-up"></i> '+response['likes']);
                    $this.html('<i class="fa fa-thumbs-down"></i> '+response['dislikes']);
                }
            }
        }
    });
  });

$('.removeNotific').on('click', function(){
    var id = $(this).attr('href');
    var id = id.split('#'),
    id = id[id.length-1];
    $.ajax({
        url: '../user/clearnotific',
        data: {id: id},
        success:function(response){
            //do sth
        }
    });
    $('.notific-count').hide();
});

$('.reject-order-btn').on('click', function(){
    $(this).parents('.row').eq(0).next().next().toggleClass('hidden-form');
    return false;
});

$('#confirmOrder').on('click', function(){
    var a = confirm('Are you sure? You wont be able to revert it back');
    if(a == false){
        return false;
    }
});

$("#accordion section h1").click(function(e) {
    $(this).parents().siblings("section").addClass("ac_hidden");
    $(this).parents("section").removeClass("ac_hidden");

    e.preventDefault();
});

$('input[name="delete[]"]').on('click', function(){
    var count = 0;
    $('input[name="delete[]"]').each(function(){
        if($(this).is(':checked')){
            count += 1;
        }
    });
    if(count >= 1){
        $('#msg-delete').removeClass('disabled');
    }else{
        $('#msg-delete').addClass('disabled');
    }
});

$('#msg-delete').on('click', function(){


    $('input[name="delete[]"]').each(function(){
        if($(this).is(':checked')){
            var hreff = $(this).parents('a').attr('href');
            var sizee = hreff.length - 1;
            var id = hreff[sizee];
            $.ajax({
                url: 'deletemsg',
                data: {id: id},
                type: 'GET',
                success: function(response){
                //do sth
            }
        });
        }
    });
    location.reload();
});

$('.profile').on('click', 'button[name="report-button"]', function(){
    var type = $('input[name="report"]').val();
    var id = $(this).attr('id');
    $.ajax({
        url: '../reportuser/',
        type: 'GET',
        data: {type: type, id:id},
        success:function(response){
            if(response=='true'){
                $('#report .modal-body').html('<div class="col-md-12 alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><i class="fa fa-info-circle"></i> User Reported. Please wait while we verify the report.</div><div class="clear-fix"></div>');
                $('button[name="report-button"]').hide();
            }
        }
    });
});

$('.profile').on('click', 'button[value="others"]', function(){
    $('.report-other').toggleClass('hidden');
});

$('#dropzone-btn').on('click', function(){
    $('#dropzone-form_1').submit();
});

Dropzone.options.myAwesomeDropzone = {
  paramName: "file", // The name that will be used to transfer the file
  maxFilesize: 2, // MB
  uploadMultiple: false,

};

$('.glyphicon.star').click(function(){
    var id = $(this).attr('id');
    $('.star').removeClass('glyphicon-star');
    $('.star').addClass('glyphicon-star-empty');
    for (var i = 0; i < id; i++) {
        $('.star').eq(i).addClass('glyphicon-star');
        $('.star').eq(i).removeClass('glyphicon-star-empty');
    };
    $('.star-input').val(id);
    
});

$('#post-desc').wysihtml5();

$('.completeAjaxButton').on('click', function(){
    //$(this).children('i').removeClass().addClass('fa fa-refresh fa-spin');
    var button = $(this);
    $(this).html('<i class="fa fa-refresh fa-spin"></i> Please wait');
    var id = $(this).attr('id');
    $.ajax({
        method : 'GET',
        url: '../requestcompletion',
        data: {id: id},
        success:function(response){
            if(response == 'true'){
                button.removeClass().addClass('btn btn-success');
                button.addClass('disabled');
                button.html('<i class="fa fa-check-circle-o"></i> Requested');
            }else{
                button.removeClass().addClass('btn btn-warning');
                buton.html('<i class="fa fa-cross"></i> Failed');
            }
        }
    });
    return false;
});
});
