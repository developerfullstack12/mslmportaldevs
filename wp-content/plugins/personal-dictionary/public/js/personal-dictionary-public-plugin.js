(function( $ ) {
	'use strict';
	$.fn.serializeFormJSON = function () {
        let o = {},
            a = this.serializeArray();
        $.each(a, function () {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };

    function AysPDPlugin(element, options){
        this.el = element;
        this.$el = $(element);
        this.htmlClassPrefix = 'ays-pd-';
        this.dbOptionsPrefix = 'pd_';
        this.ajaxAction = 'ays_pd_ajax';
        this.dbOptions = undefined;

        this.init();

        return this;
    }

    AysPDPlugin.prototype.init = function() {
		var _this = this;
		var dataFunction = _this.$el.find('.ays-pd-tab-content').attr('data-function');

		if(dataFunction == 'ays_groups_pd'){

			this.selectGroupsAjax();
		}

		if( typeof window.aysPdOptions != 'undefined' ){
			_this.dbOptions = JSON.parse(atob(window.aysPdOptions));
        }

		this.setup();
        this.setEvents();
		
    }

    AysPDPlugin.prototype.setup = function() {
		var _this = this;

		var linkSearch = location.search;
		
		if(linkSearch != ''){
			var linkUrl = linkSearch.split('?')[1].split('&');
			for(var i = 0; i < linkUrl.length; i++){
				if(linkUrl[i].split("=")[0] == 'ays-pd-tab'){
					_this.goTo();
				}
			}	
		}
		
    }
    
    AysPDPlugin.prototype.setEvents = function(e) {
        var _this = this;
        

		_this.$el.find('.'+_this.htmlClassPrefix+'import-select').select2({
			placeholder: 'Select groups',
			dropdownParent: $('.ays-pd-import-select-group-block')
		});

        _this.$el.on('click', '.'+_this.htmlClassPrefix+'add_group_btn', function(e){
            e.preventDefault();
			_this.$el.find('.'+_this.htmlClassPrefix+'group-edit-layer').hide();
			_this.$el.find('.'+_this.htmlClassPrefix+'group-name-inp').val('');
			_this.$el.find('.'+_this.htmlClassPrefix+'save_group_button').removeAttr('data-catid');
			_this.$el.find('.'+_this.htmlClassPrefix+'save_group_button').removeAttr('data-command');

			var content = '';
			
			content += '<div class="ays-pd-add-group-form">';
			content +='<div class="ays-pd-group-close-button-div ays-pd-add-group-close-button-div"><input type="text" placeholder="Group name" class="ays-pd-group-name-inp ays-pd-group-adding-fields"><span class="ays-pd-box-close-button">'+ aysPersonalDictionaryAjaxPublic.icons.close_icon+'</span></div>';
			content += '<div class="ays-pd-group-delete-button-block "><input type="button" value="'+aysPdLangObj.save+'" class="ays-pd-save_group_button ays-pd-group-adding-fields"><a class="ays-pd-delete-button-icon ays-pd-group-delete-button-item ">' + aysPersonalDictionaryAjaxPublic.icons.delete_icon+'</a></div>';
			content += '</div>';

			_this.$el.find('.'+_this.htmlClassPrefix+'save-groups-block').html(content);

			_this.$el.find('.'+_this.htmlClassPrefix+'save-groups-block').show();
			_this.$el.find('.'+_this.htmlClassPrefix+'group-name-inp').focus();

        });

        _this.$el.on('click','.ays-pd-save_group_button',function(e){
			_this.groupsSaveAjax();
		});

      	_this.$el.on('click','.ays-pd-group-tab .ays-pd-groups-box',function(e){
			var pd_div = _this.$el.find('.'+_this.htmlClassPrefix+'groups_progress_bar_icons');

			if(!pd_div.is(e.target) && pd_div.has(e.target).length === 0){
				_this.$el.find('.'+_this.htmlClassPrefix+'save-groups-block').hide();
				var dataId = $(this).attr('data-id');
				_this.selectWordsAjax(dataId);
				e.preventDefault();
			}
		
        });


		_this.$el.on('click','.'+_this.htmlClassPrefix+'previous-page-btn',function(e){
            e.preventDefault();
            _this.selectGroupsAjax();
             _this.$el.find('#ays-pd-header_id').html('<div class="ays-pd-header_title"><h3>'+aysPdLangObj.groups+'</h3></div><span class="ays-pd-add_group_btn">+</span>');
            _this.$el.find('.'+_this.htmlClassPrefix+'group-tab-add-layer').hide();
        });

		_this.$el.on('click','.'+_this.htmlClassPrefix+'games-type-previous-page-btn',function(e){
            e.preventDefault();
			_this.$el.find('.'+_this.htmlClassPrefix+'games-type-content').hide(200);
			_this.$el.find('.'+_this.htmlClassPrefix+'games-choosing-type').show(200);
             _this.$el.find('#ays-pd-header_id').html('<div class="ays-pd-header_title"><h3>'+aysPdLangObj.games+'</h3></div>');
            _this.$el.find('.'+_this.htmlClassPrefix+'group-tab-add-layer').hide();
        });

		_this.$el.on('click','.'+_this.htmlClassPrefix+'games-settings-previous-page-btn',function(e){
            e.preventDefault();
			_this.$el.find('#ays-pd-header_id .ays-pd-header_title a').removeClass('ays-pd-games-settings-previous-page-btn');
			_this.$el.find('#ays-pd-header_id .ays-pd-header_title a').addClass('ays-pd-games-type-previous-page-btn');
			_this.$el.find('.'+_this.htmlClassPrefix+'games-type-content-game').html('');
			_this.$el.find('.'+_this.htmlClassPrefix+'games-type-content-game').hide();
			_this.$el.find('.'+_this.htmlClassPrefix+'games-select-groups').show(200);
            _this.$el.find('.'+_this.htmlClassPrefix+'group-tab-add-layer').hide();
        });
		
        _this.$el.on('click','.'+_this.htmlClassPrefix+'each_word_item' + ',' + '.'+_this.htmlClassPrefix+'word-edit-btn', function(e){
			e.preventDefault();
			
			// _this.$el.find('.'+_this.htmlClassPrefix+'group-tab-edit-layer').not($(this).parents('.'+_this.htmlClassPrefix+'words-box').next()).html('');
			_this.$el.find('.'+_this.htmlClassPrefix+'group-tab-add-layer').html('');

			_this.$el.find('.'+_this.htmlClassPrefix+'group-tab-add-layer').hide();
			_this.$el.find('.'+_this.htmlClassPrefix+'group-tab-edit-layer').not($(this).parents('.'+_this.htmlClassPrefix+'words-box').next()).hide();


			
			var content = '';
			
			content += '<div class="ays-pd-close-button-div ays-pd-word-translation-fields-parent"><input type="text" class="ays-pd-edit_word_field ays-pd-word_editing_fields" placeholder="'+aysPdLangObj.word+'"><span class="ays-pd-box-close-button">'+ aysPersonalDictionaryAjaxPublic.icons.close_icon+'</span></div>';
			content += '<div class="ays-pd-word-translation-fields-parent"><input type="text" class="ays-pd-edit_translation_field ays-pd-word_editing_fields" placeholder="'+aysPdLangObj.translation+'"></div>';
			content += '<div class="ays-pd-word-delete-button-block "><input type="button" value="'+aysPdLangObj.save+'" class="ays-pd-edit-words-btn ays-pd-words_save_btn"><a class="ays-pd-delete-button-icon ays-pd-word-delete-button-item ">' + aysPersonalDictionaryAjaxPublic.icons.delete_icon+'</a></div>';
			
			$(this).parents('.'+_this.htmlClassPrefix+'words-each-item-block').find('.'+_this.htmlClassPrefix+'group-tab-edit-layer').html(content);
			
			
			_this.$el.find('.'+_this.htmlClassPrefix+'each_word_item').removeAttr('data-command');
			var dataId =	$(this).parents('.'+_this.htmlClassPrefix+'words-box').attr('data-id');	
			_this.$el.find('.'+_this.htmlClassPrefix+'edit-words-btn').attr('data-wordid',dataId);
			_this.$el.find('.'+_this.htmlClassPrefix+'edit-words-btn').attr('data-command','edit');
            var thisWord 			= $(this).parents('.'+_this.htmlClassPrefix+'words-box').find('.ays-pd-each_word_span').text().trim();
            var thisTranslation 	= $(this).parents('.'+_this.htmlClassPrefix+'words-box').find('.ays-pd-each_translation').text().trim();
            _this.$el.find('.'+_this.htmlClassPrefix+'edit_word_field').val(thisWord);
            _this.$el.find('.'+_this.htmlClassPrefix+'edit_translation_field').val(thisTranslation);

			$(this).parents('.'+_this.htmlClassPrefix+'words-box').next().slideToggle(function(){
				$('.'+_this.htmlClassPrefix+'edit_word_field').focus();
			});

        });
	
		_this.$el.on('click','.'+_this.htmlClassPrefix+'group-more-btn',function(e){
			$(this).parents('.'+_this.htmlClassPrefix+'each_group_item').find('.'+_this.htmlClassPrefix+'group-dropdown-menu').toggle();
		});

		_this.$el.on('click','.'+_this.htmlClassPrefix+'word-more-btn',function(e){
			$(this).parents('.'+_this.htmlClassPrefix+'words-each-item-block').find('.'+_this.htmlClassPrefix+'word-dropdown-menu').toggle();
		});	

		$(document).on("mouseup", function(e) {
			var container = _this.$el.find('.'+_this.htmlClassPrefix+'dropdown-buttons');
			if (!container.is(e.target) && container.has(e.target).length === 0){
				container.hide();
			}
		});
		
        _this.$el.on('click','.'+_this.htmlClassPrefix+'group-edit-btn',function(e){
			e.preventDefault();
			
			_this.$el.find('.'+_this.htmlClassPrefix+'save-groups-block').html('');
			// _this.$el.find('.'+_this.htmlClassPrefix+'group-edit-layer').html('');
            _this.$el.find('.'+_this.htmlClassPrefix+'save-groups-block').hide();
			_this.$el.find('.'+_this.htmlClassPrefix+'group-edit-layer').not($(this).parents('.'+_this.htmlClassPrefix+'groups-box').next()).hide();
			
			var content = '';
			
			content += '<div class="ays-pd-add-group-form">';
			content +='<div class="ays-pd-close-button-div"><input type="text" placeholder="Group name" class="ays-pd-group-name-inp ays-pd-group-edit-name"><span class="ays-pd-box-close-button">'+ aysPersonalDictionaryAjaxPublic.icons.close_icon+'</span></div>';
			content += '<div class="ays-pd-group-delete-button-block "><input type="button" value="'+aysPdLangObj.save+'" class="ays-pd-save_group_button"><a class="ays-pd-delete-button-icon ays-pd-group-delete-button-item ">' + aysPersonalDictionaryAjaxPublic.icons.delete_icon+'</a></div>';
			content += '</div>';
			
			$(this).parents('.'+_this.htmlClassPrefix+'each_group_item').find('.'+_this.htmlClassPrefix+'group-edit-layer').html(content);
			_this.$el.find('.'+_this.htmlClassPrefix+'each_group_item').removeAttr('data-command');
			$(this).parents('.'+_this.htmlClassPrefix+'each_group_item').attr('data-command','edit');
			var dataId = $(this).parents('.'+_this.htmlClassPrefix+'each_group_item').attr('data-id');	
			var dataCommand = $(this).parents('.'+_this.htmlClassPrefix+'each_group_item').attr('data-command');
			_this.$el.find('.'+_this.htmlClassPrefix+'save_group_button').attr('data-catid',dataId);
			_this.$el.find('.'+_this.htmlClassPrefix+'save_group_button').attr('data-command',dataCommand);
            var thisGroup = $(this).parents('.'+_this.htmlClassPrefix+'each_group_item').find('.ays-pd_each_group_name').text().trim();
            _this.$el.find('.'+_this.htmlClassPrefix+'group-name-inp').val(thisGroup);
			
			$(this).parents('.'+_this.htmlClassPrefix+'groups-box').next().slideToggle(function(){
				$('.'+_this.htmlClassPrefix+'group-edit-name').focus();
			});

        });

        _this.$el.on('click','.'+_this.htmlClassPrefix+'add-group-form ' + '.'+_this.htmlClassPrefix+'box-close-button' ,function(e){
            e.preventDefault();
			_this.$el.find('.'+_this.htmlClassPrefix+'group-edit-layer').slideUp();
			_this.$el.find('.'+_this.htmlClassPrefix+'group-tab-add-layer').hide();
			_this.$el.find('.'+_this.htmlClassPrefix+'group-edit-layer').html('');
			_this.$el.find('.'+_this.htmlClassPrefix+'group-name-inp').val('');
			_this.$el.find('.'+_this.htmlClassPrefix+'save_group_button').removeAttr('data-catid');
			_this.$el.find('.'+_this.htmlClassPrefix+'save_group_button').removeAttr('data-command');
			_this.$el.find('.'+_this.htmlClassPrefix+'each_group_item').removeAttr('data-command');
        });
		
        _this.$el.on('click','.ays_pd_add_word_button',function(e){
            e.preventDefault();
			_this.$el.find('.'+_this.htmlClassPrefix+'group-tab-edit-layer').hide();
			_this.$el.find('.'+_this.htmlClassPrefix+'word_field').val('');
            _this.$el.find('.'+_this.htmlClassPrefix+'translation_field').val('');
			_this.$el.find('.'+_this.htmlClassPrefix+'add-edit-words-btn').removeAttr('data-wordid');
			_this.$el.find('.'+_this.htmlClassPrefix+'add-edit-words-btn').removeAttr('data-command');
			_this.$el.find('.'+_this.htmlClassPrefix+'each_word_item').removeAttr('data-command');

			var content = '';
			
			content += '<div class="ays-pd-close-button-div ays-pd-word-translation-fields-parent"><input type="text" class="ays-pd-word_field ays-pd-word_saving_fields" placeholder="Word"><span class="ays-pd-box-close-button">'+ aysPersonalDictionaryAjaxPublic.icons.close_icon+'</span></div>';
			content += '<div class="ays-pd-word-translation-fields-parent"><input type="text" class="ays-pd-translation_field ays-pd-word_saving_fields" placeholder="Translation"></div>';

			content += '<div class="ays-pd-word-save-btn-block-div"><input type="button" value="'+aysPdLangObj.save+'" class="ays-pd-add-edit-words-btn ays-pd-words_save_btn ays-pd-word_saving_fields"></div>';
			content += '<div class="ays-pd-word-delete-button-block"><input type="button" value="'+aysPdLangObj.saveAndClose+'" class="ays-pd-add-edit-words-btn ays-pd-words_save_and_close_btn"><a class="ays-pd-delete-button-icon ays-pd-word-delete-button-item ">' + aysPersonalDictionaryAjaxPublic.icons.delete_icon+'</a></div>';

			
			_this.$el.find('.'+_this.htmlClassPrefix+'group-tab-words').html(content);

			_this.$el.find('.'+_this.htmlClassPrefix+'group-tab-words').show();
			$('.'+_this.htmlClassPrefix+'word_field').focus();
        });	

        _this.$el.on('click','.'+_this.htmlClassPrefix+'group-tab-add-layer ' + '.'+_this.htmlClassPrefix+'box-close-button',function(e){
			e.preventDefault();
			_this.$el.find('.'+_this.htmlClassPrefix+'group-tab-add-layer').hide();
			_this.$el.find('.'+_this.htmlClassPrefix+'group-tab-add-layer').html('');
			_this.$el.find('.'+_this.htmlClassPrefix+'word_field').val('');
            _this.$el.find('.'+_this.htmlClassPrefix+'translation_field').val('');
			_this.$el.find('.'+_this.htmlClassPrefix+'each_word_item').removeAttr('data-command');
        });	

        _this.$el.on('click','.'+_this.htmlClassPrefix+'group-tab-edit-layer ' + '.'+_this.htmlClassPrefix+'box-close-button',function(e){
			e.preventDefault();
			_this.$el.find('.'+_this.htmlClassPrefix+'group-tab-edit-layer').slideUp();
			_this.$el.find('.'+_this.htmlClassPrefix+'edit_word_field').val('');
            _this.$el.find('.'+_this.htmlClassPrefix+'edit_translation_field').val('');
			_this.$el.find('.'+_this.htmlClassPrefix+'edit-words-btn').removeAttr('data-wordid');
			_this.$el.find('.'+_this.htmlClassPrefix+'edit-words-btn').removeAttr('data-command');
			_this.$el.find('.'+_this.htmlClassPrefix+'each_word_item').removeAttr('data-command');
			_this.$el.find('.'+_this.htmlClassPrefix+'group-tab-edit-layer').html('');
        });	

        _this.$el.on('click','.'+_this.htmlClassPrefix+'words_save_btn',function(e){
            e.preventDefault();
			if(!_this.$el.find('.'+_this.htmlClassPrefix+'words_save_btn').attr('data-wordid')){
				_this.wordsSaveAjax();
				var word = $('.'+_this.htmlClassPrefix+'word_field').val('');
				var translation = $('.'+_this.htmlClassPrefix+'translation_field').val('');
				$('.'+_this.htmlClassPrefix+'word_field').focus();
			}else{
				_this.wordsSaveAjax();
				$('.'+_this.htmlClassPrefix+'word_field').focus();
			}
		});
		
		_this.$el.on('click','.'+_this.htmlClassPrefix+'words_save_and_close_btn',function(e){
			e.preventDefault();
            _this.wordsSaveAjax();
			_this.$el.find('.'+_this.htmlClassPrefix+'group-tab-words').html('');
			_this.$el.find('.'+_this.htmlClassPrefix+'group-tab-words').hide();
			var word = $('.'+_this.htmlClassPrefix+'word_field').val('');
			var translation = $('.'+_this.htmlClassPrefix+'translation_field').val('');
			$('.'+_this.htmlClassPrefix+'word_field').focus();
			_this.$el.find('.'+_this.htmlClassPrefix+'edit-words-btn').removeAttr('data-wordid');
			_this.$el.find('.'+_this.htmlClassPrefix+'edit-words-btn').removeAttr('data-command');
		});
		
		_this.$el.on('click','.'+_this.htmlClassPrefix+'word-delete-button-item',function(e){
			var confirm = window.confirm( "Are you sure you want to delete the word?" );

            if(confirm == true){
				e.preventDefault();
				var wordId = $(this).parents('.'+_this.htmlClassPrefix+'words-each-item-block').find('.'+_this.htmlClassPrefix+'words-box').attr('data-id');
				_this.wordsDeleteAjax(wordId);
				_this.$el.find('.'+_this.htmlClassPrefix+'word-dropdown-menu').hide();
				_this.$el.find('.'+_this.htmlClassPrefix+'box-close-button').trigger('click');
			}

		});

		_this.$el.on('click','.'+_this.htmlClassPrefix+'group-delete-button-item',function(e){
			var confirm = window.confirm( "Are you sure you want to delete the group?" );

            if(confirm == true){
				e.preventDefault();
				var catId = $(this).parents('.'+_this.htmlClassPrefix+'each_group_item').attr('data-id');
				_this.groupsDeleteAjax(catId);
				_this.$el.find('.'+_this.htmlClassPrefix+'group-dropdown-menu').hide();
				_this.$el.find('.'+_this.htmlClassPrefix+'box-close-button').trigger('click');
			}

		});

		_this.$el.on('click','.'+_this.htmlClassPrefix+'word-reset-btn',function(e){
			var confirm = window.confirm( "Are you sure you want to reset the word?" );

            if(confirm == true){
				e.preventDefault();
				var wordId = $(this).parents('.'+_this.htmlClassPrefix+'words-each-item-block').find('.'+_this.htmlClassPrefix+'words-box').attr('data-id');
				_this.wordResetAjax(wordId);
				_this.$el.find('.'+_this.htmlClassPrefix+'word-dropdown-menu').hide();
			}

		});

		_this.$el.on('click','.'+_this.htmlClassPrefix+'group-reset-btn',function(e){
			var confirm = window.confirm( "Are you sure you want to reset the group?" );

            if(confirm == true){
				e.preventDefault();
				var catId = $(this).parents('.'+_this.htmlClassPrefix+'each_group_item').attr('data-id');
				_this.groupResetAjax(catId);
				_this.$el.find('.'+_this.htmlClassPrefix+'group-dropdown-menu').hide();
			}

		});

		_this.$el.on("keydown" , '.'+_this.htmlClassPrefix+'word_saving_fields', function(event) {
			var $thisValue = $(this).val();
			if (event.keyCode === 13) {
				if($(this).hasClass("ays-pd-translation_field")){
					var saveButton = _this.$el.find(".ays-pd-words_save_btn");
					saveButton.trigger("click");
					event.preventDefault();
				}else{
					var nextInput = _this.$el.find(".ays-pd-translation_field");
					nextInput.focus();
				}
				
			}
		});

		_this.$el.on("keydown" , '.'+_this.htmlClassPrefix+'group-adding-fields', function(event) {
			if (event.keyCode === 13) {
				var saveButton = _this.$el.find(".ays-pd-save_group_button");
				saveButton.trigger("click");
				event.preventDefault();
			}
		});

		_this.$el.on("keydown" , '.'+_this.htmlClassPrefix+'word_editing_fields', function(event) {
			if (event.keyCode === 13) {
				if($(this).hasClass("ays-pd-edit_translation_field")){
					var saveButton = _this.$el.find(".ays-pd-words_save_btn");
					saveButton.trigger("click");
					event.preventDefault();
				}else{
					var nextInput = _this.$el.find(".ays-pd-edit_translation_field");
					nextInput.focus();
				}
				
			}
		});

		_this.$el.on("keydown" , '.'+_this.htmlClassPrefix+'group-edit-name', function(event) {
			if (event.keyCode === 13) {
				var saveButton = _this.$el.find(".ays-pd-save_group_button");
				saveButton.trigger("click");
				event.preventDefault();
			}
		});



		// Games 
		_this.$el.on("click" , '.'+_this.htmlClassPrefix+'game-type-item', function(event) {
			_this.$el.find('.'+_this.htmlClassPrefix+'games-choosing-type').hide(200);
			_this.$el.find('#ays-pd-header_id').html('<div class="ays-pd-header_title"><a class="ays-pd-previous-button ays-pd-games-type-previous-page-btn">'+aysPersonalDictionaryAjaxPublic.icons.back_icon+'</a><h3></h3></div>');
			var gameName= $(this).find('.'+_this.htmlClassPrefix+'game-type-item-title').text();
			_this.$el.find('.'+_this.htmlClassPrefix+'header_title h3').html(gameName);
			_this.selectGroupsAjax();	
			_this.$el.find('.'+_this.htmlClassPrefix+'games-type-content').show(200);
		});
		
		_this.$el.on("click" , '#'+_this.htmlClassPrefix+'games-start-button', function(event) {
			
			_this.$el.find('.'+_this.htmlClassPrefix+'games-type-content-game').show(200);
			var selectedGroupsIds = _this.$el.find('.'+_this.htmlClassPrefix+'games-group-item').val();
			
			var gameType = _this.$el.find('.'+_this.htmlClassPrefix+'game-type-rad:checked').val();
			var groupWordsCount = _this.$el.find('.'+_this.htmlClassPrefix+'games-group-item :selected');
			var count = 0;
			
			groupWordsCount.each(function(i, sel){
				count += parseInt($(sel).attr('data-count'));
				
			});			
			
			var dataIds = new Array();
			if(selectedGroupsIds != ''){
				if(count >= 4){
					_this.$el.find('#ays-pd-header_id .ays-pd-header_title a').removeClass('ays-pd-games-type-previous-page-btn');
					_this.$el.find('#ays-pd-header_id .ays-pd-header_title a').addClass('ays-pd-games-settings-previous-page-btn');

					switch(gameType){
						case 'find_word':
							_this.gameFindWordAjax(selectedGroupsIds,0,dataIds);						
							_this.$el.find('div.ays-pd-preloader').css('display', 'flex');
							break;
						case 'find_translation':
							_this.gameFindTranslationAjax(selectedGroupsIds,0,dataIds);						
							_this.$el.find('div.ays-pd-preloader').css('display', 'flex');
							break;
					}

				}else{
					_this.$el.find('.'+_this.htmlClassPrefix+'game-settings-message').css('color','red');
				}
						
			}
		});

		_this.$el.on("click" , '.'+_this.htmlClassPrefix+'next-button', function(event) {
			
			var gameType = _this.$el.find('.'+_this.htmlClassPrefix+'game-type-rad:checked').val();
			var selectedGroupsIds = _this.$el.find('.'+_this.htmlClassPrefix+'games-group-item').val();
			
			$(this).parents('.ays-pd-games-type-content-game-box').next().addClass('active_step');
			$(this).parents('.ays-pd-games-type-content-game-box').addClass('ays_display_none');
			
			var numberLimit = $(this).attr('data-limit');
			var callAjaxId = $(this).attr('data-next');
			
			var dataIds = new Array();
			var nextButtons = _this.$el.find('.'+_this.htmlClassPrefix+'next-button');
			
			if( parseInt(callAjaxId)  == nextButtons.length - 3 ){
				for(var i = 0; i < nextButtons.length; i++ ){
					
					if($(nextButtons[i]).attr('data-next') == _this.$el.find('.'+_this.htmlClassPrefix+'hidden-words-count').val()){
						$(nextButtons[i]).addClass('ays-pd-finish');
						$(nextButtons[i]).val('Finish');
					} 
					var wordDataId = $(nextButtons[i]).attr('data-id');
					dataIds.push(wordDataId);
				}
				if(selectedGroupsIds != ''){
					switch(gameType){
						case 'find_word':
							_this.$el.find('.'+_this.htmlClassPrefix+'next-button').attr('disabled',true);
							_this.gameFindWordAjax(selectedGroupsIds,numberLimit,dataIds);
							break;
						case 'find_translation':
							_this.$el.find('.'+_this.htmlClassPrefix+'next-button').attr('disabled',true);
							_this.gameFindTranslationAjax(selectedGroupsIds,numberLimit,dataIds);
							break;
					}
				}
			}

			if(selectedGroupsIds != ''){
				switch(gameType){
					case 'find_word':
						var wordId = $(this).attr('data-id');
						var voted = $(this).parents('.'+_this.htmlClassPrefix+'games-type-content-game-box').find('.'+_this.htmlClassPrefix+'translation-'+wordId+':checked').val();
						
						_this.updateWord(wordId,voted);
						break;
					case 'find_translation':
						var wordId = $(this).attr('data-id');
						var voted = $(this).parents('.'+_this.htmlClassPrefix+'games-type-content-game-box').find('.'+_this.htmlClassPrefix+'word-'+wordId+':checked').val();
						
						_this.updateWord(wordId,voted);
						break;
				}
			}
					
				
					
			for(var i = 0; i < nextButtons.length; i++ ){
				
				if($(nextButtons[i]).attr('data-next') == _this.$el.find('.'+_this.htmlClassPrefix+'hidden-words-count').val()){
					$(nextButtons[i]).addClass('ays-pd-finish');
					$(nextButtons[i]).val('Finish');
				} 
				
			}					
		});

		_this.$el.on("click" , '.'+_this.htmlClassPrefix+'finish', function(event) {
			var gameType = _this.$el.find('.'+_this.htmlClassPrefix+'game-type-rad:checked').val();
			var selectedGroupsIds = _this.$el.find('.'+_this.htmlClassPrefix+'games-group-item').val();
			var correct_answer = 0;
			var nextButtons = _this.$el.find('.'+_this.htmlClassPrefix+'next-button');
			var score = 0;
			var wordsCount = _this.$el.find('.'+_this.htmlClassPrefix+'hidden-words-count').val();

			if(selectedGroupsIds != ''){
				switch(gameType){
					case 'find_word':
						for(var i = 0; i < nextButtons.length; i++ ){							
							var wordId = $(nextButtons[i]).attr('data-id');
							var translationVal = _this.$el.find('.'+_this.htmlClassPrefix+'translation-'+wordId+':checked').val();
							var wordVal = _this.$el.find('.'+_this.htmlClassPrefix+'word-'+wordId).val();

							if(translationVal == wordVal){
								correct_answer = correct_answer + 1; 
							}
							
						}
						score = (correct_answer / wordsCount) * 100;
	
						if(score != 0){
							if(Math.round(score) !== score) {
								score = score.toFixed(1);
							}
						}

					break;
					case 'find_translation':
						for(var i = 0; i < nextButtons.length; i++ ){							
							var wordId = $(nextButtons[i]).attr('data-id');
							var wordVal = _this.$el.find('.'+_this.htmlClassPrefix+'word-'+wordId+':checked').val();
							var translationVal = _this.$el.find('.'+_this.htmlClassPrefix+'translation-'+wordId).val();

							if(translationVal == wordVal){
								correct_answer = correct_answer + 1; 
							}
							
						}
						score = (correct_answer / wordsCount) * 100;
	
						if(score != 0){
							if(Math.round(score) !== score) {
								score = score.toFixed(1);
							}
						}
					break;
				}
			}


		

			var content = '';
			content += '<div class="ays-pd-games-type-content-game-box ays-pd-finish-game-message" >';
			content += '<p class="ays-pd-finish-game-message-result-score" >'+aysPdLangObj.result+': '+score+'%</p>';
			content += '<p class="ays-pd-finish-game-message-result-count" >'+correct_answer+' / '+wordsCount+'</p>';
			content += '<div class="ays-pd-finish-game-message-reload" >';
			content += '<input type="button" class="ays-pd-finish-game-message-reload-btn" value="Start Again">';
			content += '</div>';
			content += '</div>';
			$(this).parents('.ays-pd-games-type-content-game').append(content);
			
			var res = $(this).parents('.ays-pd-games-type-content-game').serializeFormJSON();
			_this.addGameResults(res);			
		});	
				
		_this.$el.on("click" , '.'+_this.htmlClassPrefix+'finish-game-message-reload-btn', function(event) {
			window.location.reload();
		});	
		
		_this.$el.on("click" , '.'+_this.htmlClassPrefix+'game-fields', function(event) {
			var checked = _this.$el.find('.'+_this.htmlClassPrefix+'game-fields input:checked');
			_this.$el.find('.'+_this.htmlClassPrefix+'game-fields label').addClass('no_selected');
			_this.$el.find('.'+_this.htmlClassPrefix+'game-fields label').removeClass('checked_answer');
			checked.next().removeClass('no_selected');
			checked.next().addClass('checked_answer');
		});

		// Import

		_this.$el.on('change','#'+_this.htmlClassPrefix+'import_file', function(e){
            var pattern = /(.xlsx|.XLSX)$/g;
            if(pattern.test($(this).val())){
                $(this).parents('form').find('input[name="ays-pd-import-save-btn"]').removeAttr('disabled');
            }
        });	
	}
			
			
	AysPDPlugin.prototype.addGameResults = function(res) {
		var _this = this;
		var gameType = _this.$el.find('.'+_this.htmlClassPrefix+'game-type-rad:checked').val();
		var selectedGroupsIds = _this.$el.find('.'+_this.htmlClassPrefix+'games-group-item').val();
		var data = res;
		data.gameType = gameType;
		data.groupsIds = selectedGroupsIds;
		data.action = _this.ajaxAction;
		data.function = 'ays_pd_add_game_results';
		
		$.ajax({
			url: aysPersonalDictionaryAjaxPublic.ajaxUrl,
			dataType: 'json',
			method:'post',
			data: data,
			success: function(res) {
				if(res.status === true){
					
				}
			}
		});
	}

	AysPDPlugin.prototype.updateWord = function(wordId,voted) {
		var _this = this;
		var data = {};
		data.action = _this.ajaxAction;
		data.wordId = wordId;
		data.voted = voted;
		data.function = 'ays_pd_update_word';
		
		$.ajax({
			url: aysPersonalDictionaryAjaxPublic.ajaxUrl,
			dataType: 'json',
			method:'post',
			data: data,
			success: function(res) {
				if(res.status === true){

				}
			}
		});
	}

	AysPDPlugin.prototype.gameFindWordAjax = function(selectedGroupsIds,numberLimit,dataIds) {
		var _this = this;
		
		var wordsCount = _this.$el.find('.'+_this.htmlClassPrefix+'games-words-count:checked').val();
		var hiddenCount = _this.$el.find('.'+_this.htmlClassPrefix+'hidden-words-count').val();
		var data = {};
		data.groupsIds = selectedGroupsIds;
		data.ids = dataIds;
		data.wordsCount = wordsCount;
		data.number = numberLimit;
		data.hiddenCount = hiddenCount;
		data.action = _this.ajaxAction;
		data.function = 'ays_pd_game_find_word';
		$.ajax({
			url: aysPersonalDictionaryAjaxPublic.ajaxUrl,
			dataType: 'json',
			method:'post',
			data: data,
			success: function(res) {
				if(res.status === true){
					_this.$el.find('.'+_this.htmlClassPrefix+'next-button').attr('disabled',false);
					_this.$el.find('div.ays-pd-preloader').css('display', 'none');
					_this.$el.find('.'+_this.htmlClassPrefix+'games-select-groups').hide(200);
					var words = (res['results']);
					var counter = '';
					var content = '';
					$.each(words,function(index,element){

						if(wordsCount > element.count || wordsCount == 'All'){
							counter = element.count;
						}else{
							counter = wordsCount;
						}
						numberLimit = parseInt(numberLimit) + 1;
						content += '<div class="ays-pd-games-type-content-game-box" data-id="'+element.id+'">';
						content += '<p class="ays-pd-games-type-content-game-counter" value="'+numberLimit+'" >' + numberLimit + '/' +  counter +'</p>';
						content += '<p class="ays-pd-games-find-word" value="'+element.id+'" >' + element.word + '</p>';
						content += '<input type="hidden" class="ays-pd-word-'+element.id+'" name="ays-pd-word['+element.id+']" value="'+element.id+'">';
						for(var i=0;i<element.translations.length;i++){
							var j = i + 1;
							
							content += '<div class="ays-pd-game-fields ays-pd-games-type-find-word-translations" >';
							content += '<input type="radio" class="ays-pd-translation-'+element.id+'" name="ays-pd-translation[' +element.id+ ']" id="ays-pd-games-find-word-translation-rad-'+element.id+'-'+element.translations[i][0]+'" value="'+element.translations[i][0]+'">';
							content += '<label for="ays-pd-games-find-word-translation-rad-'+element.id+'-'+element.translations[i][0]+'" >' + element.translations[i][1] + '</label>';
							content += '</div>';
						}
						content += '<div class="ays-pd-games-find-word-next-btn-block" >';
						content += '<input type="button" value="Next" class="ays-pd-next-button" data-limit="'+ element.limitNumber +'" data-next="'+numberLimit+'" data-id="'+element.id+'">';
						content += '</div>';
						content += '<input type="hidden" class="ays-pd-hidden-words-count" value="'+counter+'">';
						content += '</div>';
					});
					_this.$el.find('.ays-pd-games-type-content-game').append(content);
				}
			}
		});
	}

	AysPDPlugin.prototype.gameFindTranslationAjax = function(selectedGroupsIds,numberLimit,dataIds) {
		var _this = this;
		
		var wordsCount = _this.$el.find('.'+_this.htmlClassPrefix+'games-words-count:checked').val();
		var hiddenCount = _this.$el.find('.'+_this.htmlClassPrefix+'hidden-words-count').val();
		var data = {};
		data.groupsIds = selectedGroupsIds;
		data.ids = dataIds;
		data.wordsCount = wordsCount;
		data.number = numberLimit;
		data.hiddenCount = hiddenCount;
		data.action = _this.ajaxAction;
		data.function = 'ays_pd_game_find_translation';
		$.ajax({
			url: aysPersonalDictionaryAjaxPublic.ajaxUrl,
			dataType: 'json',
			method:'post',
			data: data,
			success: function(res) {
				if(res.status === true){
					_this.$el.find('.'+_this.htmlClassPrefix+'next-button').attr('disabled',false);
					_this.$el.find('div.ays-pd-preloader').css('display', 'none');
					_this.$el.find('.'+_this.htmlClassPrefix+'games-select-groups').hide(200);
					var words = (res['results']);
					var counter = '';
					var content = '';
					$.each(words,function(index,element){

						if(wordsCount > element.count || wordsCount == 'All'){
							counter = element.count;
						}else{
							counter = wordsCount;
						}
						numberLimit = parseInt(numberLimit) + 1;
						content += '<div class="ays-pd-games-type-content-game-box" data-id="'+element.id+'">';
						content += '<p class="ays-pd-games-type-content-game-counter" value="'+numberLimit+'" >' + numberLimit + '/' +  counter +'</p>';
						content += '<p class="ays-pd-games-find-translation" value="'+element.id+'" >' + element.translation + '</p>';
						content += '<input type="hidden" class="ays-pd-translation-'+element.id+'" name="ays-pd-translation['+element.id+']" value="'+element.id+'">';
						for(var i=0;i<element.words.length;i++){
							var j = i + 1;
							
							content += '<div class="ays-pd-game-fields ays-pd-games-type-find-translation-words" >';
							content += '<input type="radio" class="ays-pd-word-'+element.id+'" name="ays-pd-word[' +element.id+ ']" id="ays-pd-games-find-translation-word-rad-'+element.id+'-'+element.words[i][0]+'" value="'+element.words[i][0]+'">';
							content += '<label for="ays-pd-games-find-translation-word-rad-'+element.id+'-'+element.words[i][0]+'" >' + element.words[i][1] + '</label>';
							content += '</div>';
						}
						content += '<div class="ays-pd-games-find-translation-next-btn-block" >';
						content += '<input type="button" value="Next" class="ays-pd-next-button" data-limit="'+ element.limitNumber +'" data-next="'+numberLimit+'" data-id="'+element.id+'">';
						content += '</div>';
						content += '<input type="hidden" class="ays-pd-hidden-words-count" value="'+counter+'">';
						content += '</div>';
					});
					_this.$el.find('.ays-pd-games-type-content-game').append(content);
				}
			}
		});
	}

	AysPDPlugin.prototype.groupsDeleteAjax = function(catId) {
		var _this = this;
		var groupName = $('.'+_this.htmlClassPrefix+'group-name-inp').val();
		var dataCatId = catId;	
		if(catId != undefined){
			_this.$el.find('div.ays-pd-preloader').css('display', 'flex');
			var data = {};
			data.action = _this.ajaxAction;
			data.catId = dataCatId;
			data.function = 'ays_groups_delete_ajax';

			
			$.ajax({
				url: aysPersonalDictionaryAjaxPublic.ajaxUrl,
				dataType: 'json',
				method:'post',
				data: data,
				success: function(res) {
					_this.$el.find('div.ays-pd-preloader').css('display', 'none');
					
					_this.$el.find('.'+_this.htmlClassPrefix+'group-tab').show();
					_this.selectGroupsAjax();
					
				},error: function(err){
					console.log(err);
				}
			});

		}
	}

	AysPDPlugin.prototype.groupResetAjax = function(catId) {
		var _this = this;
		if(catId != undefined){
			_this.$el.find('div.ays-pd-preloader').css('display', 'flex');
			var data = {};
			data.action = _this.ajaxAction;
			data.catId = catId;
			data.function = 'ays_group_reset_ajax';

			
			$.ajax({
				url: aysPersonalDictionaryAjaxPublic.ajaxUrl,
				dataType: 'json',
				method:'post',
				data: data,
				success: function(res) {
					_this.$el.find('div.ays-pd-preloader').css('display', 'none');
					
					_this.$el.find('.'+_this.htmlClassPrefix+'group-tab').show();
					_this.selectGroupsAjax();
					
				},error: function(err){
					console.log(err);
				}
			});

		}
	}

	AysPDPlugin.prototype.wordsDeleteAjax = function(wordId) {
		var _this = this;
		var word = $('.'+_this.htmlClassPrefix+'word_field').val();
		var thisCatId = _this.$el.find('.ays-pd-tab-content').attr('data-catid');
		if(wordId != undefined){
			_this.$el.find('div.ays-pd-preloader').css('display', 'flex');
			var data = {};
			data.action = _this.ajaxAction;
			data.wordId = wordId;
			data.function = 'ays_words_delete_ajax';

			
			$.ajax({
				url: aysPersonalDictionaryAjaxPublic.ajaxUrl,
				dataType: 'json',
				method:'post',
				data: data,
				success: function(res) {
					_this.$el.find('div.ays-pd-preloader').css('display', 'none');
					
					_this.$el.find('.'+_this.htmlClassPrefix+'group-tab').show();
					_this.selectWordsAjax(thisCatId);
					
				},error: function(err){
					console.log(err);
				}
			});

		}
	}

	AysPDPlugin.prototype.wordResetAjax = function(wordId) {
		var _this = this;
		var word = $('.'+_this.htmlClassPrefix+'word_field').val();
		var thisCatId = _this.$el.find('.ays-pd-tab-content').attr('data-catid');
		if(wordId != undefined){
			_this.$el.find('div.ays-pd-preloader').css('display', 'flex');
			var data = {};
			data.action = _this.ajaxAction;
			data.wordId = wordId;
			data.function = 'ays_word_reset_ajax';

			
			$.ajax({
				url: aysPersonalDictionaryAjaxPublic.ajaxUrl,
				dataType: 'json',
				method:'post',
				data: data,
				success: function(res) {
					_this.$el.find('div.ays-pd-preloader').css('display', 'none');
					
					_this.$el.find('.'+_this.htmlClassPrefix+'group-tab').show();
					_this.selectWordsAjax(thisCatId);
					
				},error: function(err){
					console.log(err);
				}
			});

		}
	}

    AysPDPlugin.prototype.selectGroupsAjax = function() {
        var _this = this;
		_this.$el.find('div.ays-pd-preloader').css('display', 'flex');
		var data = {};
		var dataFunction = _this.$el.find('.ays-pd-tab-content').attr('data-function');
		data.action = _this.ajaxAction;
		data.function = dataFunction;
		
		$.ajax({
			url: aysPersonalDictionaryAjaxPublic.ajaxUrl,
			dataType: 'json',
			method:'post',
			data: data,
			success: function(res) {
				if(res.status === true){
					_this.$el.find('div.ays-pd-preloader').css('display', 'none');
					switch ( data.function ) {
						case 'ays_groups_pd':
							var groups = res['results'];
							var content = '';
							content += '<div>';
							if( groups.length > 0 ){
								$.each(groups,function(index,element){
									var percentage = 0;
									var w_count = 0;
									if(element.percentage != 0){
										percentage = element.percentage;
										if(Math.round(percentage) !== percentage) {
											percentage = percentage.toFixed(1);
										}
									}
									if(element.w_count != undefined){
										w_count = element.w_count;
									}
									content += '<div class="ays-pd-each_group_item" data-id="' + element.id + '" >';
									content += '<div class="ays-pd-groups-box" data-id="' + element.id + '">';
									content += '<div class="ays-pd-each-group-title">'
									content += '<p class="ays-pd_each_group_name">' + element.name + '</p>';
									content += '<p class="ays-pd_each_group_title_words_count"> ('+w_count+') </p>';
									content += '</div>';
									content += '<div class="ays-pd-groups_progress_bar_icons">';
									content += '<div class="ays-pd-groups_line_percentage_bar">';
									content += '<div class="ays-pd-groups_line_percentage_bar_size" style="width:'+percentage+'%">';
									content += '<span class="ays-pd-groups_line_percentage_span">'+percentage+'%</span>';
									content += '</div>';
									content += '</div>';
									content += '<div class="ays-pd-icon-buttons ays-pd-each_group_icons">';
									content += '<a class="ays-pd-group-edit-btn">' + aysPersonalDictionaryAjaxPublic.icons.edit_icon + '</a>';
									content += '<a class="ays-pd-group-more-btn">' + aysPersonalDictionaryAjaxPublic.icons.more_icon + '</a>';
									content += '<div class="ays-pd-dropdown-buttons ays-pd-group-dropdown-menu">';
									content += '<div><button class="ays-pd-group-reset-btn">'+aysPdLangObj.reset+'</button>';
									content += '<button class="ays-pd-group-delete-button-item">'+aysPdLangObj.delete+'</button></div>';
									content += '</div>';
									content += '</div>';
									content += '</div>';
									content += '</div>';

									content += '<div class="ays-pd-group-edit-layer" data-function="ays_groups_pd">';
									content += '</div>';

									content += '</div>';
								});
							}else{
								content += '<div class="ays-pd-empty-groups-content">';
									content += '<div><span class="ays-pd-add_group_btn">+</span></div>';
									content += aysPdLangObj.createFirstGroup;
								content += '</div>';
							}
							content += '</div>';
							
                            _this.$el.find('.ays-pd-tab-content').html(content);
						break;
						case 'ays_games_pd':
							var result = res['results'];
							var content = '';
							content += '<div class="ays-pd-games-select-groups">';	
							content += '<select class="ays-pd-games-settings-item ays-pd-games-group-item" multiple>';
							$.each(result,function(index,element){
								var words_count = 0;
								if(element.words_count != 0 && element.words_count != undefined){
									words_count = parseInt(element.words_count);
								}
								content += '<option value="'+ element.id +'" data-count="'+words_count+'">'+element.name+' ('+words_count+')</option>';									
							});
							content += '</select>';
							content += '<div class="ays-pd-game-settings-message" >';
							content += '<p class="ays-pd-game-settings-message-paragraph" >'+aysPdLangObj.settingsMessage+'</p>' ;	
							content += '</div>';
							
							content += '<div class="ays-pd-games-settings-item ays-pd-games-check-words-count" >';	
							
								content += '<label class="' + _this.htmlClassPrefix + 'form-check-label">';
									content += '<input class="ays-pd-games-words-count" type="radio" name="words-count-rad" value="10" checked>';
									content += '<span>10</span>';
								content += '</label>';

								content += '<label class="' + _this.htmlClassPrefix + 'form-check-label">';
									content += '<input class="ays-pd-games-words-count" type="radio" name="words-count-rad" value="30">';
									content += '<span>30</span>';
								content += '</label>';

								content += '<label class="' + _this.htmlClassPrefix + 'form-check-label">';
									content += '<input class="ays-pd-games-words-count" type="radio" name="words-count-rad" value="50">';
									content += '<span>50</span>';
								content += '</label>';

								content += '<label class="' + _this.htmlClassPrefix + 'form-check-label">';
									content += '<input class="ays-pd-games-words-count" type="radio" name="words-count-rad" value="100">';
									content += '<span>100</span>';
								content += '</label>';

								content += '<label class="' + _this.htmlClassPrefix + 'form-check-label">';
									content += '<input class="ays-pd-games-words-count" type="radio" name="words-count-rad" value="All">';
									content += '<span>' + aysPdLangObj.all + '</span>';
								content += '</label>';

							content += '</div>';

							content += '<div class="ays-pd-games-settings-item ays-pd-games-start-btn-block" >';	
							content += '<input type="button" value="Start" id="ays-pd-games-start-button">';	
							content += '</div>';
							content += '</div>';
							_this.$el.find('.ays-pd-games-type-content-settings').html(content);
							_this.$el.find('.'+_this.htmlClassPrefix+'games-group-item').select2({
								placeholder: 'Select groups',
								dropdownParent: $('.ays-pd-games-select-groups')
							});
						break;
					}
				}
			}
		});
    }

    AysPDPlugin.prototype.selectWordsAjax = function(catId) {
        var _this = this;
        _this.$el.find('.ays-pd-add_group_btn').hide(150);
		_this.$el.find('#ays-pd-header_id').html('<div class="ays-pd-header_title"><a class="ays-pd-previous-button ays-pd-previous-page-btn">'+aysPersonalDictionaryAjaxPublic.icons.back_icon+'</a><h3></h3></div><span class="ays_pd_add_word_button">+</span>');
        
 
		_this.$el.find('div.ays-pd-preloader').css('display', 'flex');
        _this.$el.find('.'+_this.htmlClassPrefix+'group-tab').attr('data-catId',catId);
        var data = {};
        data.action = _this.ajaxAction;
        data.catId = catId;
        data.function = 'ays_show_words_ajax';
        
        $.ajax({
            url: aysPersonalDictionaryAjaxPublic.ajaxUrl,
            dataType: 'json',
            method:'post',
            data: data,
            success: function(res) {
				_this.$el.find('div.ays-pd-preloader').css('display', 'none');

                var words = res['results'];

				if( typeof res['results'] != 'undefined' && res['results'].length > 0){
					if( words[1] !== null ){
						_this.$el.find('.'+_this.htmlClassPrefix+'header_title h3').html(words[1] + ' ('+words[0].length+')');
					}
				}
				var content = '';
				var content = '<div>';
				if( typeof res['results'] != 'undefined' && res['results'].length > 0){
					if(words[0].length > 0){
						$.each(words[0],function(index,element){
							var percentage = 0;
							if(parseFloat(element.percentage) != 0 && element.percentage != null){
								percentage = parseFloat(element.percentage);
								if(Math.round(percentage) !== percentage) {
									percentage = percentage.toFixed(1);
								}
							}
							content += '<div class="ays-pd-words-each-item-block">';

							content += '<div class="ays-pd-words-box" data-id="' + element.id + '">';
							content += '<p class="ays-pd-each_word_item" data-id="' + element.id + '" >';	
							content += '<span class="ays-pd-each_word_span"> ' + element.word +  ' </span>';
							content += '<span class="ays-pd-each_translation"> ' + element.translation +  ' </span>';
							content += '</p>';
							content += '<div class="ays-pd-groups_progress_bar_icons">';
							content += '<div class="ays-pd-groups_line_percentage_bar">';
							content += '<div class="ays-pd-groups_line_percentage_bar_size" style="width:'+percentage+'%">';
							content += '<span class="ays-pd-groups_line_percentage_span">'+percentage+'%</span>';
							content += '</div>';
							content += '</div>';
							content += '<div class="ays-pd-icon-buttons ays-pd-each_words_icons">';
							content += '<a class="ays-pd-word-edit-btn">' + aysPersonalDictionaryAjaxPublic.icons.edit_icon + '</a>';
							content += '<a class="ays-pd-word-more-btn">' + aysPersonalDictionaryAjaxPublic.icons.more_icon + '</a>';
							content += '<div class="ays-pd-dropdown-buttons ays-pd-word-dropdown-menu">';
							content += '<div><button class="ays-pd-word-reset-btn">Reset</button>';
							content += '<button class="ays-pd-word-delete-button-item">Delete</button></div>';
							content += '</div>';
							content += '</div>';
							content += '</div>';
							content += '</div>';

							content += '<div class="ays-pd-group-tab-edit-layer" data-function="ays_groups_pd">';
							content += '</div>';

							content += '</div>';

						
						});
					}else{
						content += '<div class="ays-pd-empty-groups-content">';
							content += '<div><span class="ays_pd_add_word_button">+</span></div>';
							content += aysPdLangObj.createFirstWord;
						content += '</div>';
					}
				}
				content += '</div>';
				_this.$el.find('.'+_this.htmlClassPrefix+'tab-content').html(content);
            },error: function(err){
                console.log(err);
            }
        });
    }		
		
    AysPDPlugin.prototype.wordsSaveAjax = function() {
            var _this = this;

			var thisCatId = _this.$el.find('.ays-pd-tab-content').attr('data-catid');
			var dataCommand = _this.$el.find('.'+_this.htmlClassPrefix+'words_save_btn').attr('data-command');	
			var dataWordId =  _this.$el.find('.'+_this.htmlClassPrefix+'words_save_btn').attr('data-wordid');	
			var word = $('.'+_this.htmlClassPrefix+'word_field').val();
			var translation = $('.'+_this.htmlClassPrefix+'translation_field').val();

			if(dataCommand == 'edit'){
				word =  _this.$el.find('.'+_this.htmlClassPrefix+'edit_word_field').val();
				translation =  _this.$el.find('.'+_this.htmlClassPrefix+'edit_translation_field').val();
			}



			if(word != ''){
				_this.$el.find('div.ays-pd-preloader').css('display', 'flex');
				var catId = parseInt(_this.$el.find('.'+_this.htmlClassPrefix+'group-tab').attr('data-catId'));
				var data = {};
				data.action = _this.ajaxAction;
				data.word = word;
				data.command = dataCommand;
				data.wordId = dataWordId;
				data.translation = translation;
				data.category_id = catId;
				data.function = 'ays_words_add_ajax';

				
				$.ajax({
					url: aysPersonalDictionaryAjaxPublic.ajaxUrl,
					dataType: 'json',
					method:'post',
					data: data,
					success: function(res) {
						_this.$el.find('div.ays-pd-preloader').css('display', 'none');
						
						_this.$el.find('.'+_this.htmlClassPrefix+'group-tab').show();
						_this.selectWordsAjax(thisCatId);
						
					},error: function(err){
						console.log(err);
					}
				});

			}
    }

	AysPDPlugin.prototype.groupsSaveAjax = function() {
		var _this = this;

		var groupName = $('.'+_this.htmlClassPrefix+'group-name-inp').val();
		var dataCommand = _this.$el.find('.'+_this.htmlClassPrefix+'save_group_button').attr('data-command');	
		var dataCatId =  _this.$el.find('.'+_this.htmlClassPrefix+'save_group_button').attr('data-catid');	

		if(groupName != ''){
			_this.$el.find('div.ays-pd-preloader').css('display', 'flex');
			var data = {};
			data.action = _this.ajaxAction;
			data.value = groupName;
			data.command = dataCommand;
			data.catId = dataCatId;
			data.function = 'ays_groups_add_ajax';
			
			$.ajax({
				url: aysPersonalDictionaryAjaxPublic.ajaxUrl,
				dataType: 'json',
				method:'post',
				data: data,
				success: function(res) {
					_this.$el.find('div.ays-pd-preloader').css('display', 'none');
					_this.selectGroupsAjax();
					_this.$el.find('.'+_this.htmlClassPrefix+'save-groups-block').hide(250);
					
				},error: function(err){
					console.log(err);
				}
			});
		}
	}

	AysPDPlugin.prototype.goTo = function() {
        $('html, body').animate({
            scrollTop: this.$el.offset().top - 110 + 'px'
        }, 'fast');
        return this; // for chaining...
    }


    $.fn.AysPersonalDictionary = function(options) {
        return this.each(function() {
            if (!$.data(this, 'AysPersonalDictionary')) {
                $.data(this, 'AysPersonalDictionary', new AysPDPlugin(this, options));
            } else {
                try {
                    $(this).data('AysPersonalDictionary').init();
                } catch (err) {
                    console.error('AysPersonalDictionary has not initiated properly');
                }
            }
        });
    };

})( jQuery );
