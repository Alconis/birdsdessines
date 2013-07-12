package components
{
	import flash.events.Event;
	import flash.events.KeyboardEvent;
	import flash.events.TextEvent;
	
	import mx.controls.TextArea;
	
	public class LimitedTextArea extends TextArea
	{
		private var lastTextEvent : TextEvent;
		
		public function LimitedTextArea()
		{
			super();
			addEventListener(TextEvent.TEXT_INPUT,onTextInput);
			addEventListener(Event.CHANGE,onChange);
		}
		
		private var _maxLineCount : int = -1;
		
		public function get maxLineCount():int
		{
			return _maxLineCount;
		}
		
		public function set maxLineCount(value:int):void
		{
			_maxLineCount = value;
		}
		
		protected function onChange( event : Event) : void {
			if(maxLineCount > 0 && this.textField.numLines > maxLineCount){
				var insertedChars : String = lastTextEvent.text;
				text = text.substr(0,text.length - insertedChars.length);
			}
		}
		
		protected function onTextInput( event : TextEvent ) : void {
			lastTextEvent = event;
		}
	}
}