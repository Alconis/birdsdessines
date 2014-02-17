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
		
		public function Diapo( type : String, imgId : String, titl : String=null, iconId : String=null, isNew : Boolean=false)
		{
			super();
			horizontalScrollPolicy = "off";
			verticalScrollPolicy = "off";
			width = 120;
			height = 135;
			
			_type = type;
			_imgId = imgId;
			_img = new Image();
			if (Dropper.BIRD == _type){
				_img.source = "assets/birds/" + imgId + ".png";
			}else if(Dropper.BUBBLE == _type){
				_img.source = "assets/bubbles/" + imgId + ".png";
			}else if(Dropper.NEW_BIRDS == _type){
				_img.source = "assets/new_birds/" + imgId + ".png";
			}else if(Dropper.NEW_CHOUETTE == _type){
				_img.source = "assets/new_chouette/" + imgId + ".png";
			}else if(Dropper.BONUS == _type){
				//_img.source = "assets/newspaper/" + imgId + ".png";
				//_img.source = "assets/saintvalentin/" + imgId + ".png";
				_img.source = "assets/election/" + imgId + ".png";
			}
			
			_icon = new Image();
			if (null == iconId){
				_iconId = _imgId;
				_icon.source = _img.source;
			}else{
				_iconId = iconId;
				_icon.source = "assets/icons/" + _iconId + ".png";
			}
			
			//title = titl == null ? _imgId : titl;
			//toolTip = titl;
			_isNew = isNew;
			
			if(_type == Dropper.BIRD)
				styleName = "diapoBird";
			if(_type == Dropper.BUBBLE)
				styleName = "diapoBubble";
			if(_type == Dropper.NEW_BIRDS)
				styleName = "diapoNewBird";
			if(_type == Dropper.NEW_CHOUETTE)
				styleName = "diapoNewChouette";
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
			
			if (_isNew){
				var newLbl : Label = new Label();
				newLbl.styleName = "new";
				newLbl.text = "New!"
				addChild(newLbl);
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