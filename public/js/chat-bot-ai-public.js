(function( $ ) {
	'use strict';

	var botController = (function () {
  

	})();
	
	var uiController = (function () {
	
	
	})();
	
	
	
	
	var controller = (function (botCntr, uiCntr) {
		var $chatCircle,
			$chatBox,
			$chatBoxClose,
			$chatBoxWelcome,
			$chatWraper,
			$submitBtn,
			$chatInput,
			$msg;
	
		/*toggle*/
		function hideCircle(evt) {
			evt.preventDefault();
			$chatCircle.hide('scale');
			$chatBox.show('scale');
			$chatBoxWelcome.show('scale');
			$chatBoxWelcome.css("display","flex")
		}
	
		function chatBoxCl(evt) {
			evt.preventDefault();
			$chatCircle.show('scale');
			$chatBox.hide('scale');
			$chatBoxWelcome.hide('scale');
			$chatWraper.hide('scale');
		}
	
		function chatOpenMessage(evt) {
			evt.preventDefault();
			$chatBoxWelcome.hide();
			$chatWraper.show();
		}
	
	
		function chatSbmBtn(evt) {
			if (evt.keyCode === 13 || evt.which === 13) {
			}
		}
		/* var input = uiCntr.getInput();*/
		/* $chatSubmitBtn.on("click", hideCircle);*/
	
	
	
		function init() {
			$chatCircle = $("#chat-circle");
			$chatBox = $(".chat-box");
			$chatBoxClose = $(".chat-box-toggle");
			$chatBoxWelcome = $(".chat-box-welcome__header");
			$chatWraper = $("#chat-box__wraper");
			$chatInput = $("#chat-input__text");
			$submitBtn = $("#chat-submit");
	
			//1. call toggle 
			$chatCircle.on("click", hideCircle);
			$chatBoxClose.on("click", chatBoxCl);
			$chatInput.on("click", chatOpenMessage);
	
			//2. call wait message from CRM-human
	
			$submitBtn.on("click", chatSbmBtn);
			$chatInput.on("keypress", chatSbmBtn);

			$(".goBack").on("click",chatBoxCl).on("click", hideCircle)
	
	
			//6. get message from bot controller-back end
			//7. display bot message to ui controller
		}
	
		return {
			init: init
		};
	
	})(botController, uiController);
	
	
	
	
	$(document).ready(controller.init);
	

	

})( jQuery );












