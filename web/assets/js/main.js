
function Main() {
}

Main.prototype.form = function() {

    var that = this;

    var checkbox    = $('.ui.checkbox'),
        toggle      = $('.ui.toggle.button'),
        buttons     = $('.ui.buttons .button');

    checkbox.checkbox({
        onChange: function() {
            if ($(this).hasClass('update-other-input')) {
                that.updateOtherInput($(this));
            }
        }
    });

    toggle.filter('.composer').state({
        text: {
            active: 'Enabled',
            inactive: 'Disabled'
        },
        onActivate: function() {
            $('input#composer').val(1);
        },
        onDeactivate: function() {
            $('input#composer').val(0);
        }
    });

    toggle.filter('.database').state({
        text: {
            active: 'Enabled',
            inactive: 'Disabled'
        },
        onActivate: function() {
            $('input#database-status').val(1);
        },
        onDeactivate: function() {
            $('input#database-status').val(0);
        }
    });

    toggle.filter('.xdebug').state({
        text: {
            active: 'Enabled',
            inactive: 'Disabled'
        },
        onActivate: function() {
            $('input#xdebug').val(1);
        },
        onDeactivate: function() {
            $('input#xdebug').val(0);
        }
    });

    buttons.filter('.phpversion').on('click', function(){
        $(this)
            .addClass('active')
            .addClass('green')
            .siblings()
            .removeClass('active')
            .removeClass('green')
            .addClass('black');

        $('input[name=phpppa]').val($(this)
            .data('value'));
    });

    buttons.filter('.webserver').on('click', function(){
        $(this)
            .addClass('active')
            .addClass('green')
            .siblings()
            .removeClass('active')
            .removeClass('green')
            .addClass('black');

        $('input[name=webserver]').val($(this)
            .data('value'));
    });

    buttons.filter('.database').on('click', function(){
        $(this)
            .addClass('active')
            .addClass('green')
            .siblings()
            .removeClass('active')
            .removeClass('green')
            .addClass('black');

        $('input[name=dbserver]').val($(this)
            .data('value'));
    });

    $('select.selectized').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        maxItems: null,
        valueField: 'value',
        labelField: 'text',
        searchField: 'value'
    });

    $('select.select-one').selectize({
        maxItems: 1,
        persist: false,
        labelField: "item",
        valueField: "value",
        sortField: 'item',
        searchField: 'item'
    });
}

Main.prototype.waypoints = function(){

    //Sticky menu
    var menu = $('.ui.secondary.vertical.pointing.menu');
    menu.waypoint('sticky', {
        offset: 50 // Apply "stuck" when element 50px from top
    });

    //Activate menu items if passed on scroll
    $('h2').waypoint(function() {
        menu.find('a').removeClass('active teal');
        menu.find('a[href="#'+$(this).attr('id')+'"]').addClass('active teal');
    }, { offset: 250 });
}

Main.prototype.updateOtherInput = function(input) {
    var $parent = input;
    $.each(input.data(), function(key, value) {
        // jQuery changed "data-foo-bar" to "dataFooBar". Change them back.
        key = key.replace(/([a-z])([A-Z])/g, '$1-$2').toLowerCase();
        // Only work with data attributes that have "update-"
        if (key.search('update-') !== 0) {
            return true;
        }
        key = key.replace('update-', '');
        var $target = $('#' + key);
        // If target element is not defined as #foo, maybe it is an input,name,value target
        if (!$target.length) {
            var selector = 'input[name="' + key + '"]';
            if (value.length) {
                selector = selector + '[value="'+ value +'"]'
            }
            $target = $(selector)
        }
        // If target is a radio element, check it, no need to uncheck in future
        if ($target.is(':radio')) {
            $target.prop('checked', true);
            return true;
        }
        /**
         * If target is checkbox element, check if clicked element was checked or unchecked.
         *
         * If unchecked, do not update target. We only want to handle positive actions
         */
        if ($target.is(':checkbox')) {
            var checked;
            // Element gets checked, wants target to be checked
            if (value && $parent.is(':checked')) {
                checked = true;
            }
            // Element gets checked, wants target to be unchecked
            else if (!value && $parent.is(':checked')) {
                checked = false;
            }
            // Element gets unchecked
            else {
                return 1;
            }
            $target.prop('checked', checked);
            return true;
        }
        if (!$target.is(':radio') && !$target.is(':checkbox')) {
            $target.val(value);
        }
    });
}

$(document).ready(function(){
    var main = new Main();

    main.form();

    main.waypoints();

    $('.ui.accordion')
        .accordion()
    ;

    $('.ui.dropdown')
        .dropdown()
    ;

    $('.webservers.tabs .item').tab(
        {
            context: 'section.webservers-tabs'
        }
    );
    $('.databases.tabs .item').tab(
        {
            context: 'section.databases-tabs'
        }
    );
    $('.languages.tabs .item').tab(
        {
            context: 'section.languages-tabs'
        }
    );
});
