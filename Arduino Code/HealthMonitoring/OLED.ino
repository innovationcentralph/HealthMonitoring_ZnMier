void displayMessage(String s, byte _size){
   display.clearDisplay();
   display.setTextSize(_size);                    
   display.setTextColor(WHITE);             
   display.setCursor(15,10);                
   display.println(s);  
   display.display();
}
