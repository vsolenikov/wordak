/*!
 * Page Title Splitter
 * version: 1.0
 * Requires jQuery v1.5 or later
 * Copyright (c) 2016 Chris Steman
 */

jQuery(document).ready(function($) {
	if($('#titlewrap input[name="post_title"]').length > 0) {
		var _ptsInput = $('#titlewrap input[name="post_title"]');
		var _ptsgwWidths = new Array();
		var _ptsPad = parseInt(_ptsInput.css('padding-left').replace('px', ''));
		var _ptsStatus = new Array();
		var _ptsActive, _ptsFieldActive, _ptsMouseCheck, _ptsPrevious;
		var _ptsSel = {start: null, end: null, text: '', count: 0};
		
		$(window).load(function() {
			_ptsInput.wrap($('<div>', {class: 'pt-splitter-wrap'})).after($('<div>', {class: 'pt-splitter-content-wrap'}).append($('<div>', {class: 'pt-splitter-content'})));
			$('.pt-splitter-wrap').after($('<a>', {href: '#', html: '', class: 'pt-splitter-button-add'})).after($('<input>', {type: 'hidden', name: 'pt-splitter-output', value: ''}));
			$('.pt-splitter-content').css({'font-family': _ptsInput.css('font-family'), 'font-size': _ptsInput.css('font-size')});
			_ptsInput.wrap($('<div>', {class: 'pt-splitter-input'}));
			
			prePopulate(_pts_output);
			
			$('.pt-splitter-button-add').click(function(e) {
				e.preventDefault();
				if(_ptsActive == null) {
					$('.pt-splitter-button-add').addClass('pt-splitter-button-remove');
					var _c = _ptsStatus.length;
					ptsAddMarker(_c, true);
				}
				else {
					if($(this).hasClass('pt-splitter-button-remove')) {
						ptsRemoveMarker(_ptsActive);
						$(this).removeClass('pt-splitter-button-remove');
						_ptsActive = null;
						ptsUpdate();
					}
				}
			});
			
			_ptsInput.bind('mousedown', function(e) {
				_ptsPrevious = _ptsInput.val();
			});
			
			_ptsInput.bind('mouseup', function(e) {
				ptsSetSel();
				if(parseInt(_ptsActive) >= 0) {
					$('.pt-splitter-marker-'+_ptsActive).removeClass('pts-new').removeClass('pts-active');
					if($(this)[0].selectionStart == 0)
						_ptsMouseCheck = true;
					else {
						_ptsStatus[_ptsActive] = new Array($(this)[0].selectionStart, false, false);
						_ptsActive = null;
						$('.pt-splitter-button-add').removeClass('pt-splitter-button-remove');
						ptsUpdate();
					}
				}
			});
			
			_ptsInput.bind('mousemove', function(e) {
				if(_ptsPrevious != null && _ptsPrevious != _ptsInput.val()) {
					var _update = false;
					if(_ptsStatus.length > 0) {
						for(var i=0; i<_ptsStatus.length; i++) {
							if(!_ptsStatus[i][2]) {
								var _dif = _ptsSel.count;
								var _pos = _ptsInput[0].selectionStart;
								if(_pos <= (_ptsStatus[i][0]+1)) {
									_update = true;
									_ptsStatus[i][0] = _ptsStatus[i][0] + _dif;
								}
							}
						}
					}
					ptsSetWidth();
					if(_update)
						ptsUpdate();
					_ptsPrevious = null;
				}		
				if(_ptsMouseCheck) {
					_ptsStatus[_ptsActive] = new Array(_ptsInput[0].selectionStart, false, false);
					_ptsActive = null;
					_ptsMouseCheck = false;
				}
				ptsUpdate();
			});
	
			ptsSetWidth();
			_ptsInput.bind('keyup', function(e) {
				ptsClearSel();
				var _update = false;
				if(_ptsStatus.length > 0) {
					for(var i=0; i<_ptsStatus.length; i++) {
						if(!_ptsStatus[i][2]) {
							var _dif = ($(this)[0].textLength+1) - _ptsgwWidths.length;
							var _pos = $(this)[0].selectionStart - (_dif-1);
							if(_pos <= (_ptsStatus[i][0]+1)) {
								_update = true;
								_ptsStatus[i][0] = _ptsStatus[i][0] + _dif;
							}
						}
					}
				}
				ptsSetWidth();
				if(_update)
					ptsUpdate();
			});
			
		});
	}
	
	var ptsAddMarker = function(id, isNew) {
		var _newClasses = (isNew) ? ' pts-new pts-active' : '';
		$('.pt-splitter-wrap').append($('<a>', {href: '#', class: 'pt-splitter-marker pt-splitter-marker-'+id+_newClasses, 'data-id': id}));
		if(isNew) {
			_ptsStatus[id] = new Array(0, true, true);
			_ptsActive = id;
		}
		
		$('.pt-splitter-marker-'+id).bind('mouseup', function(e) {
			e.preventDefault();
			var _ptsid = $(this).attr('data-id');
			if(_ptsActive == null) {
				_ptsActive = _ptsid;
				$(this).addClass('pts-active');
				_ptsStatus[_ptsid][1] = true;
				$('.pt-splitter-button-add').addClass('pt-splitter-button-remove');
			}
			else if(_ptsActive == _ptsid && _ptsStatus[_ptsid][0] > 0) {
				_ptsStatus[_ptsid] = new Array(_ptsStatus[_ptsid][0], false, false);
				_ptsActive = null;
				$(this).removeClass('pts-active');
				$('.pt-splitter-button-add').removeClass('pt-splitter-button-remove');
			}
		});
	};
	
	var ptsRemoveMarker = function(id) {
		_ptsStatus.splice(id, 1);
		$('.pt-splitter-marker-'+id).remove();	
	};
	
	var ptsUpdate = function() {
		if(_ptsStatus.length > 0) {
			for(var i=0; i<_ptsStatus.length; i++) {
				if(!_ptsStatus[i][2])
					$('.pt-splitter-marker-'+i).css('left', (_ptsgwWidths[_ptsStatus[i][0]] - _ptsInput[0].scrollLeft));
			}
		}
		$('input[name="pt-splitter-output"]').val(JSON.stringify(_ptsStatus));
	};
	
	var ptsSetWidth = function() {
		var _ptsgwText = _ptsInput.val().split('');
		_ptsgwWidths = new Array(''+_ptsPad+'');
		for(var i=0; i<_ptsgwText.length; i++) {
			$('.pt-splitter-content').text('');
			for(var b=0; b<=i; b++) {
				var _char = (_ptsgwText[b] == ' ') ? 'j' : _ptsgwText[b];
				$('.pt-splitter-content').text($('.pt-splitter-content').text() + _char);
			}
			_ptsgwWidths.push($('.pt-splitter-content').width()+_ptsPad);
		}
	};
	
	var ptsSetSel = function() {
		var _start = _ptsInput[0].selectionStart;
		var _end = _ptsInput[0].selectionEnd;
		var _content = _ptsInput.val().split('');
		var _text = '';
		for(var i=_start; i<_end; i++) {
			_text += _content[i];
		}
		_ptsSel = {start: _start, end: _end, text: _text, count: Math.abs(_end-_start)};
	};
	
	var ptsClearSel = function() {
		_ptsPrevious = null;
		_ptsSel = {start: null, end: null, text: '', count: 0};
	};
	
	var prePopulate = function(string) {
		if($.trim(string) != '') {
			_ptsStatus = JSON.parse(string);
			for(var i=0; i<_ptsStatus.length; i++) {
				ptsAddMarker(i, false);
			}
			ptsSetWidth();
			ptsUpdate();
		}
	}
});