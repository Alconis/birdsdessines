package components
{
	import flash.display.DisplayObject;
	import flash.events.MouseEvent;
	import flash.events.TextEvent;
	import flash.geom.Point;
	
	import mx.containers.Canvas;
	import mx.controls.Image;
	import mx.controls.Label;
	import mx.controls.TextArea;
	import mx.core.ScrollPolicy;
	import mx.core.UIComponent;
	import mx.events.DragEvent;
	import mx.managers.DragManager;

	public class Dropper extends Canvas
	{
		private var _img : Image;
		private var _oldWidth : int = -1;
		private var _oldHeight : int = -1;
		private var _type : String;
		private var _xOffest : int = 0;
		private var _yOffset : int = 0;
		
		public static const BIRD : String = "bird";
		public static const BUBBLE : String = "bubble";
		public static const BONUS : String = "bonus";
		
		public static const EMPTY_BUBBLE_TXT : String = "Cliquer pour éditer le texte.";
		
		private var _helpLabel : Label;
		
		public function Dropper()
		{
			super();
			
			horizontalScrollPolicy = "off";
			verticalScrollPolicy = "off";
			
			addEventListener(MouseEvent.MOUSE_OVER, onMouseOver);
			addEventListener(MouseEvent.MOUSE_OUT, onMouseOut);
			
			doubleClickEnabled = true;
			addEventListener(MouseEvent.DOUBLE_CLICK, onMouseDoubleClick);
			
			addEventListener(DragEvent.DRAG_ENTER, onDragEnter);
			addEventListener(DragEvent.DRAG_DROP, onDragDrop);
			addEventListener(DragEvent.DRAG_OVER, onDragOver);
		}
		
		public function set image( data : Image ) : void {
			_img = data;
			addImage();
		}
		
		public function get image() : Image {
			return _img;
		}
		public function set type( data : String ) : void {
			_type = data;
			
			createHelpLabel();
			addChild(_helpLabel);
		}
		
		public function get type() : String {
			return _type;
		}
		
		private function addImage() : void {
			// Removing old image child.
			removeAllChildren();
			
			// Resetting dropper size.
			if(_oldWidth != -1){
				width = _oldWidth;
			}
			if(_oldHeight != -1){
				height = _oldHeight;
			}
			
			// If image is null, changing style name to "".
			if (null == _img){
				styleName = "";
				addChild(_helpLabel);
				return;
			}
			
			// Setting style name to "img".
			styleName = "img";
			
			// Adapting dropper size according image size
			if (_img.width > width){
				_oldWidth = width;
				width = _img.width + 4;
			}
			if (_img.height > height){
				_oldHeight = height;
				height = _img.height + 4;
			}
			
			var center : Point = new Point(width/2, height/2);
			var imgCenter : Point = new Point(_img.width/2, _img.height/2);
			
			_img.x = center.x - imgCenter.x;
			_img.y = center.y - imgCenter.y;
			
			// Finally, adding the image as dropper child.
			addChild(_img);
		}
		
		private function removeImage() : void {
			removeAllChildren();
			_img = null;
			styleName = "";
			
			if(_oldWidth != -1 && _oldWidth != width){
				width = _oldWidth;
			}
			if(_oldHeight != -1 && _oldHeight != height){
				height = _oldHeight;
			}
			addChild(_helpLabel);
		}
		
		private function onMouseOver( event : MouseEvent ) : void {
			if (!hasImage()){
				styleName = "over";
			}
		}
		
		private function onMouseOut( event : MouseEvent ) : void {
			styleName = hasImage() ? "img" : "";
		}
		
		private function onMouseDoubleClick( event : MouseEvent ) : void {
			removeImage();
		}
		
		private function onDragEnter( event : DragEvent ) : void {
        	DragManager.acceptDragDrop(this);
		}
		private function onDragOver( event : DragEvent ) : void {
			var sourceType : String = event.dragSource.dataForFormat("type") as String;
			
			if ((_type == BIRD && (sourceType == BIRD || sourceType == BONUS))
			 || (_type == BUBBLE && sourceType == BUBBLE)){
				DragManager.showFeedback(DragManager.MOVE);
			}else{
				DragManager.showFeedback(DragManager.NONE);
			}
		}	
		private function onDragDrop( event : DragEvent ) : void {
			var sourceType : String = event.dragSource.dataForFormat("type") as String;
			var sourceImage : Image = event.dragSource.dataForFormat("image") as Image;
			var sourceId : String = event.dragSource.dataForFormat("id") as String;
			
			
	        image = sourceImage;
			
			if (Dropper.BIRD == sourceType){
				correctBirdPosition(sourceId);
   			}else if (Dropper.BONUS == sourceType){
				correctBonusPosition(sourceId);
			}else if (Dropper.BUBBLE == sourceType){
	        	addBubbleTextEditors(sourceId);
   			}
		}
		
		public function hasImage() : Boolean {
			return _img != null;
		}
		
		private function createHelpLabel() : void {
			if (null != _helpLabel) return;
			
			_helpLabel = new Label();
			_helpLabel.styleName = "help";
			if (_type == Dropper.BIRD){
				_helpLabel.text = "Mettre un Bird ici.";
			}else{
				_helpLabel.text = "Mettre une bulle ici.";
			}
			
			_helpLabel.x = 0;
			_helpLabel.y = height/2 - 8;
		}
		
		private function correctBirdPosition( birdTitle : String ) : void {
			switch (birdTitle){
				case "flap" : {
					_img.x += -7;
					_img.y += -12;
					break;
				}
				case "laughing-turning-left" : {
					_img.y += 10;
					break;
				}
				case "laughing-turning-right" : {
					_img.y += 10;
					break;
				}
				case "amused-looking-left" : {
					_img.y += 3;
					break;
				}
				case "amused-looking-right" : {
					_img.y += 3;
					break;
				}
				case "crazy-right" : {
					_img.y -= 10;
					break;
				}
				case "crazy-left" : {
					_img.y -= 10;
					break;
				}
				case "whispering-right" : {
					_img.y += 12;
					break;
				}
				case "whispering-left" : {
					_img.y += 12;
					break;
				}
			}
		}
		
		private function correctBonusPosition( birdTitle : String ) : void {
			
			_img.y -= 10;
			switch (birdTitle){
				case "test" : {
					_img.x += 0;
					_img.y += 0;
					break;
				}
			}
		}
		
		private function onBubbleTextAreaClick( event : MouseEvent ) : void {
			if (event.currentTarget is TextArea){
				var area : TextArea = TextArea(event.currentTarget);
				
				if (area.text == Dropper.EMPTY_BUBBLE_TXT){
					area.text = "";
				}
			}
		}
		
		private function addBubbleTextEditors( bubbleTitle : String ) : void {
			var editor1 : LimitedTextArea = new LimitedTextArea();
			editor1.styleName = "bubble";
			editor1.text = Dropper.EMPTY_BUBBLE_TXT;
			editor1.verticalScrollPolicy = ScrollPolicy.OFF;
			editor1.addEventListener(MouseEvent.CLICK, onBubbleTextAreaClick);
			var editor2 : LimitedTextArea = new LimitedTextArea();
			editor2.styleName = "bubble";
			editor2.text = Dropper.EMPTY_BUBBLE_TXT;
			editor2.verticalScrollPolicy = ScrollPolicy.OFF;
			editor2.addEventListener(MouseEvent.CLICK, onBubbleTextAreaClick);
			
			switch (bubbleTitle){
				case "bubble-big-left" : {
					editor1.x = 20;
					editor1.y = 10;
					editor1.width = 205;
					editor1.height = 100;
					editor1.maxLineCount = 4;
					addChild(editor1);
					break;
				}
				case "bubble-big-right" : {
					editor1.x = 20;
					editor1.y = 10;
					editor1.width = 205;
					editor1.height = 100;
					editor1.maxLineCount = 4;
					addChild(editor1);
					break;
				}
				case "bubble-single-left" : {
					editor1.x = 20;
					editor1.y = 30;
					editor1.width = 205;
					editor1.height = 50;
					editor1.maxLineCount = 2;
					addChild(editor1);
					break;
				}
				case "bubble-single-right" : {
					editor1.x = 20;
					editor1.y = 30;
					editor1.width = 205;
					editor1.height = 50;
					editor1.maxLineCount = 2;
					addChild(editor1);
					break;
				}
				case "bubble-double-left-right" : {
					editor1.x = 5;
					editor1.y = 5;
					editor1.width = 205;
					editor1.height = 50;
					editor1.maxLineCount = 2;
					addChild(editor1);
					editor2.x = 35;
					editor2.y = 60;
					editor2.width = 205;
					editor2.height = 50;
					editor2.maxLineCount = 2;
					addChild(editor2);
					break;
				}
				case "bubble-double-right-left" : {
					editor1.x = 35;
					editor1.y = 5;
					editor1.width = 205;
					editor1.height = 50;
					editor1.maxLineCount = 2;
					addChild(editor1);
					editor2.x = 5;
					editor2.y = 60;
					editor2.width = 205;
					editor2.height = 50;
					editor2.maxLineCount = 2;
					addChild(editor2);
					break;
				}
				case "thought-bubble-right" : {
					editor1.x = 25;
					editor1.y = 30;
					editor1.width = 205;
					editor1.height = 50;
					editor1.maxLineCount = 2;
					addChild(editor1);
					break;
				}
				case "thought-bubble-left" : {
					editor1.x = 25;
					editor1.y = 30;
					editor1.width = 205;
					editor1.height = 50;
					editor1.maxLineCount = 2;
					addChild(editor1);
					break;
				}
			}
		}		

		public function getBubbleText () : String {
			var result : String = "";
			var children : Array = getChildren();
			for each (var elt : DisplayObject in children){
				if( elt == _helpLabel ){
					result = "Aucun bird ne parle.";
				}else if( elt is LimitedTextArea ) {
					result += (result == "") ? "Bird 1: " : "Bird 2: ";
					result += LimitedTextArea(elt).text;
				}
			}
			
			return result;
		}
	}
}