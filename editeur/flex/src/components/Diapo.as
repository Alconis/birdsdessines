package components
{
	import flash.events.MouseEvent;
	
	import mx.containers.VBox;
	import mx.controls.Image;
	import mx.controls.Label;
	import mx.core.DragSource;
	import mx.managers.DragManager;

	public class Diapo extends VBox
	{
		private var _img : Image;
		private var _imgId : String;
		private var _icon : Image;
		private var _iconId : String;
		private var _type : String;
		private var _isNew : Boolean;
		
		public function Diapo( type : String, imgPath : String)
		{
			super();
			horizontalScrollPolicy = "off";
			verticalScrollPolicy = "off";
			width = 120;
			height = 135;
			
			_type = type;
			_imgId = imgPath;
			_img = new Image();
			_img.source = imgPath;
			
			_icon = new Image();
			_iconId = _imgId;
			_icon.source = _img.source;
		}
		
		public function get image() : Image {
			return _img;
		}
		public function get type() : String {
			return _type;
		}
		
		override protected function createChildren():void{
			super.createChildren();
			
			if (null != _img){
				_img.visible = false;
				_img.includeInLayout = false;
				
				addChild(_img);
			}
			
			if (null != _icon){
				_icon.addEventListener(MouseEvent.MOUSE_MOVE, dragIt);
				_icon.percentWidth = 100;
				_icon.percentHeight = 100;
				_icon.maintainAspectRatio = true;
				addChild(_icon);
			}
			
		}
			
		 private function dragIt(event:MouseEvent):void{
            // Get the drag initiator component from the event object.
            var dragInitiator:Image = event.currentTarget as Image;

            // Create a DragSource object.
            var dragSource : DragSource = new DragSource();            
            
            // Create a copy of the image to use as dragged data.
            var draggedImage:Image = new Image();
            draggedImage.source = _img.source;
            draggedImage.width = _img.width;
            draggedImage.height = _img.height;
            dragSource.addData(draggedImage, "image");
            dragSource.addData(_type, "type");
            dragSource.addData(_imgId, "id");

            // Create a copy of the image to use as a drag proxy.
            var dragProxy:Image = new Image();
            dragProxy.source = _img.source;
            dragProxy.width = _img.width;
            dragProxy.height = _img.height;

            // Call the DragManager doDrag() method to start the drag. 
            DragManager.doDrag(dragInitiator, dragSource, event, dragProxy);
        }
		
	}
}