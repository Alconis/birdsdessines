var BirdsEditor = angular.module('birdseditor', ['ui.bootstrap']);

(function( ng, editor ){
  'use strict';

  editor.controller(
    'EditorCtrl',
    function ($scope) {
    	$scope.currentBucket = 'birds';


    	$scope.removeContent = function(id){
    		var dropper = $('.dropper#' + id);

			dropper.removeClass('with-content');
			dropper.addClass('no-content');
			if( dropper.data('contentClass') != undefined ){
				var contentClass = dropper.data('contentClass');
				dropper.removeClass(contentClass);
			}
			dropper.data('contentClass', undefined);
    	};


    }
  )
})( angular, BirdsEditor );

/** TEMPORARY JQUERY CODE **/

// add the dataTransfer property for use with the native `drop` event
// to capture information about files dropped into the browser window
jQuery.event.props.push('dataTransfer');

$('.bucket img').attr('draggable','true');

$('.bucket img').on('dragstart',function(ev){
		var clazz = $(ev.target).attr("class");
		var type = 'bird';
		if(clazz.indexOf('bird') == -1){
			type = 'bubble';
		}
		ev.dataTransfer.setData("class", clazz);
		ev.dataTransfer.setData("type", type);
	});

$('.dropper').on('drop',function(ev){
		var dropperClass = $(ev.target).attr('id');
		var dropperType = 'bird';
		if(dropperClass.indexOf('bird') == -1){
			dropperType = 'bubble';
		}
		var dragType = ev.dataTransfer.getData("type");
		var dragClass = ev.dataTransfer.getData("class");

		if(dragType == dropperType){
			ev.preventDefault();

			$(this).removeClass('no-content');
			$(this).addClass('with-content');
			if( $(this).data('contentClass') != undefined ){
				var contentClass = $(this).data('contentClass');
				$(this).removeClass(contentClass);
			}
			$(this).addClass(dragClass);
			$(this).data('contentClass', dragClass);
		}
	});

$('.dropper').on('dragover',function(ev){
		ev.preventDefault();
	});